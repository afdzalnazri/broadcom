# Can also use command line to set these. Command line arguments will take priority

# Board Config options
bc_number = "10451.1"
#test_type = "crid0"
test_type = "crid1fullsuite"
board_type = "N1100FX"
mac_address = "000af7314300"  # used for MAC ID

# Files copied from local to remote
bnxtmt_bnxt_en_bundle_path = "../source/BC.gz"
mac_profile_path = "../source/BC.mpf"
full_nvm_image_path = "../source/BC.img"
overwrite_path = "overwrite/"  # files in this folder will be copied to the remote bnxtmt folder and overwrite anything

sit_version = "216.2.299.9"  # copy MFG_scripts from this SIT release
chip_type = "thor"  # thor, whplus, stratus, sr
check_log = None  # name of file to diff log against if it exists
check_cfg = None  # name of file to diff cfg against if it exists

# Remote machine details
mgmt_username = "root"
mgmt_password = "admin"
mgmt_ip = "10.13.253.168"
mgmt_mac_address = "00:1f:bc:11:fe:3a"
mgmt_working_directory = "/home/alvin"
mgmt_bnxtmt_folder_path = None  # set this to use custom bnxtmt folder path, else set None to use one that is copied

# Etc
y = False  # if True, answer y to every question
shortlog = False
