# What commands to execute
# if the command contains (), call that function from this python file
# else, execute the command on the SUT through SSH
_SETUP_COMMANDS = [
    "power_on_if_off()",
    "setup_mgmt_working_directory()",
    "setup_bnxtmt_bnxt_en()",
    "find_and_set_bnxtmt_folder_path()",
    "create_mac_id()",
    "copy_bc_stuff_to_bnxtmt_folder()",
    "nvmfill_and_detect_chip_type()",
    "reboot()"
]

# THOR COMMANDS
CRID0_COMMANDS = [
    "bcsh('program', ['PASS', 'PASS'], attempts=2)"
]

CRID1FAST_COMMANDS = [
    "bcsh('promote', ['SKIP'])",
    "bcsh('program', ['PASS', 'PASS'])",
    "reboot()",
    "bcsh('test', all_expect='PASS')"
]

WHPLUSFAST_COMMANDS = [
    "bcsh('program', ['PASS'])",
    "reboot()",
    "bcsh('test', attempts=2, all_expect='PASS')"
]

_CRID1WITHNVMFILL_COMMANDS = CRID1FAST_COMMANDS + ["bcsh('nvmfill')", "reboot()"]

_WHPLUSWITHNVMFILL_COMMANDS = WHPLUSFAST_COMMANDS + ["bcsh('nvmfill')", "reboot()"]

CRID1FULLSUITE_COMMANDS = _CRID1WITHNVMFILL_COMMANDS * 4 + CRID1FAST_COMMANDS + ["reboot()", "bcsh('log')"]

CRID0WITHPROMOTEFULLSUITE_COMMANDS = CRID0_COMMANDS + ["bcsh('promote', ['PASS'])", "reboot()"] + CRID1FULLSUITE_COMMANDS

CRID0WITHPROMOTEFAST_COMMANDS = CRID0_COMMANDS + ["bcsh('promote', ['PASS'])", "reboot()"] + CRID1FAST_COMMANDS + \
                                ["reboot()", "bcsh('log')"]

WHPLUSFULLSUITE_COMMANDS = _WHPLUSWITHNVMFILL_COMMANDS * 4 + WHPLUSFAST_COMMANDS + ["reboot()", "bcsh('log')"]

# Store thor tests in dictionary
from collections import defaultdict
THOR_TESTLIST = defaultdict(list)
for name in dir():
    if name.startswith("CRID") and name.endswith("_COMMANDS") and isinstance(globals().get(name), list):
        THOR_TESTLIST[name[:5]].append(name.replace("_COMMANDS", "").lower())
# End THOR COMMANDS

import argparse
import config as conf
import logging
import time
import os
import re
import socket
import sys
import platform

# Create help text
AVAILABLE_TESTS = []
for name in dir():
    if not name.startswith("_") and name.endswith("_COMMANDS") and isinstance(globals().get(name), list):
        AVAILABLE_TESTS.append(name.replace("_COMMANDS", ""))

# Constants
SSH_CONNECT_TIMEOUT = 10
CHIP_TYPE_THOR = "thor"
SSH_OUTPUT_LOGLEVEL = logging.DEBUG - 1
logging.addLevelName(SSH_OUTPUT_LOGLEVEL, "SSH_OUTPUT")

# Global var
main_working_directory = None


def ask_question(question):
    return conf.y or str(raw_input(question)).lower().strip() == 'y'


def exit_with_error(message="Exiting...", rc=-1):
    print(message)
    exit(rc)


# In order to make script as portable as possible, offer to install missing Python modules for the user
# Requested by Albert
try:
    try:
        from pip import main as pipmain
    except:
        from pip._internal import main as pipmain
except ImportError:
    if ask_question("Python module pip not installed. Would you like me to install it for you? [y/n] "):
        os.system("curl https://bootstrap.pypa.io/get-pip.py -o get-pip.py")
        os.system("python get-pip.py")
        os.system("rm get-pip.py")
        try:
            from pip import main as pipmain
        except:
            try:
                from pip._internal import main as pipmain
            except:
                exit_with_error(message="Please restart script.")
    else:
        exit_with_error()

try:
    import wakeonlan
except ImportError:
    if ask_question("Python module wakeonlan not installed. Would you like me to install it for you? [y/n] "):
        import pip
        pipmain(['install', '--user', 'wakeonlan'])
        try:
            import wakeonlan
        except ImportError:
            exit_with_error(message="Please restart script.")
    else:
        exit_with_error()

try:
    import paramiko
except ImportError:
    if ask_question("Python module paramiko not installed. Would you like me to install it for you? [y/n] "):
        import pip
        pipmain(['install', '--user', 'paramiko==2.1.1'])
        try:
            import paramiko
        except ImportError:
            exit_with_error(message="Please restart script.")
    else:
        exit_with_error()


def ping(host):
    # Option for the number of packets as a function of
    param = '-n' if platform.system().lower() == 'windows' else '-c'

    # Building the command. Ex: "ping -c 1 google.com"
    command = " ".join(['ping', param, '1', host])

    return os.system(command) == 0


def setup_config():
    help_text = 'Run BC verification \nExample: python bc_verify.py -test_type CRID0 \nAvailable tests: {}'.format(", ".join(AVAILABLE_TESTS))
    arg_help_text = {
        "y": "Always answer yes to any prompts",
        "bc_number": "Board Config number Ex. 12345.1",
        "bnxtmt_bnxt_en_bundle_path": "Local path to bnxtmt bnxt_en bundle",
        "board_type": "Ex. P2100G",
        "chip_type": "(thor, whplus, stratus, sr)",
        "full_nvm_image_path": "Local path to full nvm image",
        "mac_address": "Used to create MACID",
        "mac_profile_path": "Local path to MAC profile",
        "mgmt_bnxtmt_folder_path": "Use specified bnxtmt on the SUT, else use the one from bundle",
        "mgmt_ip": "MGMT IP used to access SUT",
        "mgmt_mac_address": "MGMT MAC address used to send WoL",
        "mgmt_password": "SSH password for login",
        "mgmt_username": "SSH username for login",
        "mgmt_working_directory": "Path on SUT to copy files to",
        "overwrite_path": "Local path to folder where everything in it will get copied to SUT's bnxtmt directory and overwrite",
        "sit_version": "SIT version to grab MFG_scripts from",
        "test_type": "The test to run. See available above.",
        "shortlog": "Non-debug logging"
    }
    parser = argparse.ArgumentParser(description=help_text, formatter_class=argparse.RawTextHelpFormatter)
    for var in dir(conf):
        if not var.startswith("__"):
            if var in ("y", "shortlog"):
                parser.add_argument('-{}'.format(var[0]), '--{}'.format(var), action='store_true', help=arg_help_text.get(var, ''))
            else:
                parser.add_argument('--{}'.format(var), action='store', help=arg_help_text.get(var, ''))

    args = parser.parse_args()

    for arg in vars(args):
        if getattr(args, arg):
            value = getattr(args, arg)
            if arg in ["test_type", "chip_type"]:
                value = value.lower()
            conf.__dict__[arg] = value

    global logger
    logger = logging.getLogger('bc_verify')
    logger.setLevel(SSH_OUTPUT_LOGLEVEL)
    ch = logging.StreamHandler()
    if conf.shortlog:
        ch.setLevel(logging.INFO)
    else:
        ch.setLevel(logging.DEBUG)
    formatter = logging.Formatter('%(asctime)s - %(name)s - %(levelname)s - %(message)s')
    ch.setFormatter(formatter)
    logger.addHandler(ch)

    fh = logging.FileHandler('{}_{}.log'.format(conf.test_type, conf.bc_number.replace(".","_")))
    fh.setFormatter(formatter)
    if conf.shortlog:
        fh.setLevel(logging.INFO)
    else:
        fh.setLevel(SSH_OUTPUT_LOGLEVEL)  # 1 below DEBUG in order to be able to write to file only
    logger.addHandler(fh)

    # Validate Arguments
    if conf.chip_type.lower() == CHIP_TYPE_THOR:
        commands_name = conf.test_type.upper() + "_COMMANDS"
        commands = globals().get(commands_name, None)
        for command in commands:
            if "promote" in command.lower():
                if not ask_question("WARNING: Running this test on a Thor CRID0000 board will promote it to CRID0001. Continue? [y/n] "):
                    exit_with_error()
                else:
                    break


def print_config():
    logger.debug("Printing loaded config...")
    for var in dir(conf):
        if not var.startswith("__"):
            logger.debug("{} = {}".format(var, conf.__dict__[var]))


def wait_for_system_down():
    logger.debug("Waiting for system to go down...")
    while True:
        if not ping(conf.mgmt_ip):
            logger.debug("System is down.")
            break
        time.sleep(SSH_CONNECT_TIMEOUT)


def power_on_if_off():
    logger.debug("Checking if system up...")
    while True:
        try:
            ssh_execute("ls", log=False)
            logger.debug("System is up.")
            break
        except (socket.error, paramiko.ssh_exception.NoValidConnectionsError, paramiko.ssh_exception.SSHException):
            logger.debug("System still not up...")
            send_wake_on_lan()
            time.sleep(SSH_CONNECT_TIMEOUT)
            pass


def reboot():
    ssh_execute("shutdown now")
    wait_for_system_down()
    power_on_if_off()


def send_wake_on_lan():
    logger.debug("Sending magic packet to {}".format(conf.mgmt_mac_address))
    wakeonlan.send_magic_packet(conf.mgmt_mac_address)


def get_ssh_client():
    client = paramiko.SSHClient()
    client.set_missing_host_key_policy(paramiko.AutoAddPolicy())
    client.connect(conf.mgmt_ip, username=conf.mgmt_username, password=conf.mgmt_password, timeout=SSH_CONNECT_TIMEOUT,
                   allow_agent=False, look_for_keys=False)
    return client


class ReturnCodeException(Exception):
    pass


def ssh_execute(cmd, log=True, cwd=None, redirectstderr=True, loginshell=False):
    if cwd:
        cmd = "cd {} && ".format(cwd) + cmd
    if redirectstderr:
        cmd = "(" + cmd + ")" + " 2>&1"
    if log:
        logger.info("Attempting to execute cmd on mgmt through SSH: {}".format(cmd))
    client = get_ssh_client()
    if loginshell:
        channel = client.invoke_shell()
        stdin = channel.makefile('wb')
        stdout = channel.makefile('rb')
        stdin.write('''
{}
exit
'''.format(cmd))
        stdin.close()
    else:
        stdin, stdout, stderr = client.exec_command(cmd)
    stdout_read = ""
    for l in stdout:
        stdout_read += l
        if log:
            sys.stdout.write(l)
    return_code = stdout.channel.recv_exit_status()
    stdout.close()
    client.close()
    if log:
        logger.log(SSH_OUTPUT_LOGLEVEL, "output:\n" + stdout_read)
    if not loginshell and return_code != 0 and "shutdown" not in cmd:
        raise ReturnCodeException('cmd: {} exited with return code: {}'.format(cmd, return_code))
    return stdout_read


def ssh_copy(localfilepath, remotefilepath):
    logger.info("Attempting to copy {} to {} on mgmt through SFTP".format(localfilepath, remotefilepath))
    client = get_ssh_client()
    ftp_client = client.open_sftp()
    ftp_client.put(localfilepath, remotefilepath)
    ftp_client.close()
    client.close()


def ssh_download(remotefilepath, localfilepath):
    logger.info("Attempting to download {} from mgmt through SFTP".format(remotefilepath))
    client = get_ssh_client()
    ftp_client = client.open_sftp()
    ftp_client.get(remotefilepath, localfilepath)
    ftp_client.close()
    client.close()


def get_dst_path(dst_folder, file_to_copy):
    return dst_folder + "/" + os.path.basename(file_to_copy)


def remote_dos2unix(remote_filepath_src):
    ssh_execute("sed -i 's/\r//' {}".format(remote_filepath_src))


def setup_bnxtmt_bnxt_en():
    ssh_copy(conf.bnxtmt_bnxt_en_bundle_path, get_dst_path(main_working_directory,
                                                           conf.bnxtmt_bnxt_en_bundle_path))

    ssh_execute("tar -xf {}".format(os.path.basename(conf.bnxtmt_bnxt_en_bundle_path)), cwd=main_working_directory)
    # dos2unix install.sh
    install_sh_full_path = main_working_directory + "/install.sh"
    remote_dos2unix(install_sh_full_path)

    ssh_execute("./install.sh", cwd=main_working_directory)


def get_release_stream(version):
    abc_check = re.findall("[a-zA-z]+", version)

    # set release stream
    split_version = version.split(".") if not abc_check else version.strip(abc_check[0]).split(".")

    if int(split_version[-1]) > 0:  # patch version
        rls_stream = ".".join(split_version[:-1])
    else:
        rls_stream = ".".join(split_version[:2])

    return rls_stream


def find_and_set_bnxtmt_folder_path():
    if not conf.mgmt_bnxtmt_folder_path:
        conf.mgmt_bnxtmt_folder_path = get_dst_path(main_working_directory,
                                                    ssh_execute("find . -type d -name 'bnxtmt*'",
                                                                cwd=main_working_directory).strip())


def copy_bc_stuff_to_bnxtmt_folder():
    bc_number = conf.bc_number.replace(".", "_")
    mac_profile_dst_path = get_dst_path(conf.mgmt_bnxtmt_folder_path, bc_number + ".mpf")
    ssh_copy(conf.mac_profile_path, mac_profile_dst_path)
    remote_dos2unix(mac_profile_dst_path)
    ssh_copy(conf.full_nvm_image_path, get_dst_path(conf.mgmt_bnxtmt_folder_path, bc_number + ".img"))
    # download from SIT folder MFG_scripts
    ssh_execute(
        'wget -r -np -nH --cut-dirs=6 --reject-regex "(.*)\?(.*)" -R html http://eca-ccxsw.lvn.broadcom.net/releases/nxe/SIT/{}/{}/MFG_scripts/'
        .format(get_release_stream(conf.sit_version), conf.sit_version),
        cwd=conf.mgmt_bnxtmt_folder_path, log=False
    )
    # copy mfgload2.sh to base directory and dos2unix it
    mfgload2_sh_full_path_src = conf.mgmt_bnxtmt_folder_path + \
                                ("/TH_A" if conf.chip_type.lower() == CHIP_TYPE_THOR else "/CR_A") + "/mfgload2.sh"
    mfgload2_sh_full_path_dst = conf.mgmt_bnxtmt_folder_path + "/mfgload2.sh"
    ssh_execute("cp {} {}".format(mfgload2_sh_full_path_src, mfgload2_sh_full_path_dst))
    remote_dos2unix(mfgload2_sh_full_path_dst)

    # add fastboot to NVMFILL.TCL
    ssh_execute("sed -i '1i fwutil' NVMFILL.TCL", cwd=conf.mgmt_bnxtmt_folder_path)

    # overwrite path
    if len(os.listdir(conf.overwrite_path)) > 0:
        logger.info("Copying files from overwrite folder...")
        for filename in os.listdir(conf.overwrite_path):
            ssh_copy(os.path.join(conf.overwrite_path, filename), get_dst_path(conf.mgmt_bnxtmt_folder_path, filename))

    # extra modifications
    ssh_execute("chmod 755 *.sh", cwd=conf.mgmt_bnxtmt_folder_path)


def setup_mgmt_working_directory():
    import datetime
    ts = time.time()
    st = datetime.datetime.fromtimestamp(ts).strftime('%Y_%m_%d_%H_%M_%S-%f')
    new_working_directory = conf.mgmt_working_directory + '/' + conf.bc_number + "/" + st
    ssh_execute("mkdir -p {}".format(new_working_directory))
    global main_working_directory
    main_working_directory = new_working_directory


def create_mac_id():
    mac_address_straight = conf.mac_address.replace(":", "").replace("-", "").upper()
    pref = mac_address_straight[:6]
    start = mac_address_straight[6:12]
    end = "FFFFFF"
    ssh_execute("echo 'mac_addr_pref  =  {}\nmac_addr_start =  {}\nmac_addr_end   =  {}\n' > {}.mac"
                .format(pref, start, end, conf.bc_number.replace(".", "_")),
                cwd=conf.mgmt_bnxtmt_folder_path)


def bcsh(task, expected_list=tuple(), attempts=1, all_expect=False):
    output = ''
    for i in range(attempts):
        this_output = ssh_execute("./bc.sh {} {} {}".format(conf.board_type, task, conf.bc_number.replace(".", "_")),
                                  cwd=conf.mgmt_bnxtmt_folder_path, loginshell=True)

        output += this_output
        if expected_list or all_expect:
            if check_bnxtmt_test_passed(this_output, expected_list, all_expect):
                break
            else:
                logger.warning("bnxtmt test failed on attempt: {}".format(i + 1))
                if i != attempts-1:
                    logger.info("trying again...")
        else:
            break
    else:  # no break
        logger.error("Since bnxtmt command failed, exiting...")
        exit(-1)

    if task == 'log':
        download_bcsh_logs()

    return output


def download_bcsh_logs():
    def exists_on_sut(filename, cwd=None):
        if cwd is None:
            cwd = conf.mgmt_bnxtmt_folder_path
        try:
            ssh_execute("[[ -f {} ]]".format(filename), cwd=cwd, log=False)
            return True
        except ReturnCodeException:
            return False
    # for log task, download the files from remote to local
    bc_number = conf.bc_number.replace(".", "_")
    bc_prefix = "BC_"
    log_filename = "{}_crc_vpd.log".format(bc_number)
    # if BC_{}_crc_vpd.log exists, assume BC_ exists as prefix to other files
    prefix = bc_prefix if exists_on_sut(bc_prefix + log_filename) else ""
    log_filename = prefix + log_filename
    #img_filename = prefix + bc_number + ".img"
    cfg_filename = prefix + bc_number + ".cfg"

    files_to_copy = [log_filename, cfg_filename]

    # if conf.check_log and conf.check_cfg files exist, then diff with the new logs and copy these diffs too
    #log_diff_filename = "{}_log_diff.txt".format(bc_number)
    #cfg_diff_filename = "{}_cfg_diff.txt".format(bc_number)
    #if exists_on_sut(conf.check_log):
    #    remote_dos2unix(get_dst_path(conf.mgmt_bnxtmt_folder_path, conf.check_log))
    #    try:
    #        ssh_execute("diff -ruNP {} {} > {}".format(conf.check_log, log_filename, log_diff_filename),
    #                    cwd=conf.mgmt_bnxtmt_folder_path)
    #    except ReturnCodeException:
    #        logger.warning("Detected difference in logs! Saved to {}".format(log_diff_filename))

    #    files_to_copy.append(log_diff_filename)

    #if exists_on_sut(conf.check_cfg):
    #    remote_dos2unix(get_dst_path(conf.mgmt_bnxtmt_folder_path, conf.check_cfg))
    #    try:
    #        ssh_execute("diff -ruNP {} {} > {}".format(conf.check_cfg, cfg_filename, cfg_diff_filename),
    #                    cwd=conf.mgmt_bnxtmt_folder_path)
    #    except ReturnCodeException:
    #        logger.warning("Detected difference in cfgs! Saved to {}".format(cfg_diff_filename))
    #    files_to_copy.append(cfg_diff_filename)

    for filename in files_to_copy:
        filename = filename
        ssh_download(conf.mgmt_bnxtmt_folder_path + "/{}".format(filename), filename)


def check_bnxtmt_test_passed(output, expected_list=("PASS",), all_expect=False):
    result_line_indicator = "Result = "
    result_list = []
    for line in output.splitlines():
        if result_line_indicator in line:
            result = line.split('=')[-1].strip()
            result_list.append(result)

    if not result_list:
        logger.error("Could not find any results after running bnxtmt command!")
        return False

    if all_expect:
        expected_list = [all_expect] * len(result_list)

    if result_list[:len(expected_list)] != expected_list:
        logger.error("bnxtmt command failed with unexpected results! Expected: {} Results: {}"
                     .format(expected_list, result_list))
        return False

    return True


def nvmfill_and_detect_chip_type():
    output = bcsh('nvmfill').splitlines()
    if conf.chip_type.lower() == CHIP_TYPE_THOR:
        for i in range(len(output)):
            if output[i].startswith("GRCP already unlocked") and "CRID " in output[i+1]:
                crid_line = output[i+1]
                crid = crid_line[crid_line.find("CRID "):].split()[-1].rstrip()
                logger.info("Detected CRID: {}".format(crid))
                if conf.test_type in THOR_TESTLIST["CRID" + str(int(crid))]:
                    logger.info("CRID matches test_type: {}".format(conf.test_type))
                else:
                    if not ask_question("DUT's CRID: {} does not match test_type: {} Would you like to continue anyway? [y/n] ".format(crid, conf.test_type)):
                        exit_with_error()
                break
        else:  # no break
            if not ask_question("Could not detect CRID. Make sure you are using a thor board. Would you like to continue with test: {} anyway? [y/n] ".format(conf.test_type)):
                exit_with_error()


def execute(cmd):
    cmd_name = cmd.split('(')[0]
    if cmd_name in globals() and callable(globals()[cmd_name]):
        return eval(cmd)
    else:
        return ssh_execute(cmd)


def execute_commands(commands):
    for command in commands:
        logger.info("Executing {}".format(command))
        execute(command)


if __name__ == "__main__":
    setup_config()
    print_config()
    logger.info("Starting BC verification process...")
    logger.info("Executing SETUP_COMMANDS...")
    execute_commands(_SETUP_COMMANDS)
    commands_list_name = conf.test_type.upper() + "_COMMANDS"
    commands_to_execute = globals().get(commands_list_name, None)
    if not commands_to_execute or not isinstance(commands_to_execute, list):
        logger.error("Invalid test_type: {}".format(conf.test_type))
        exit_with_error()
    logger.info("Executing {}".format(commands_list_name))
    execute_commands(commands_to_execute)
    logger.info("BC Verified!")
