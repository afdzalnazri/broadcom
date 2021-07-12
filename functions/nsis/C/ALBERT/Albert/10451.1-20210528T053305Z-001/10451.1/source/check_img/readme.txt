Description

  The script is help to compare log files that generated from AE and QA/GO state. QA/GO will check the results to detemine where the BC pass to next state or assign back to AE if see failed.

Usage

  log_check.sh <check_img file> <log_cfg file>

  Example: QA/GO generated 2 log files "BC_xx_yy_crc_vpd.log and BC_xx_yy.cfg"

    log_check.sh BC_xx_yy_crc_vpd.log BC_xx_yy.cfg


Checking points

  From BC checking log, there was 2 logs called BC_xx_yy_crc_vpd.log and BC_xx_yy.cfg.
  Here descript what checking points on this script
    On BC_xx_yy_crc_vpd.log,
      NVM component: version, index ordering, start address, length and CRC result.
      VPD section: SN length, strings of all VPD options 
    On BC_xx_yy.cfg,
      NVM options: all NVM options settings excepted MAC address (#1 and #601).
      MAC address ordering: see MAC assignment if match with mac profile

Results

  There is 2 parts of the results.
  One is called “Log auto-comparison” that included above checking points.
  The checking are all good if see all “PASSED”. If not, it will show what errors message on debug string. 
  Another is “data manual checking ” and it needs to check by QA/GO manaually for PCIE width, SN and MAC address.


  e.g. 
  1. SN length mismatch
  ====== Logs Auto-Comparison ======
    NVM DIR/CRC and VPD: FAILED
      DEBUG STRING:
         SN LENGTH MISMATCH!!
    NVM CFG: PASSED 
  ====== Data Manual Checking ======
    PCIE SPEED/WIDTH: GEN 3x8
    Serial Number: A412143C200232CQ
    EP  0 MAC: 00:0a:f7:31:43:10
    EP  1 MAC: 00:0a:f7:31:43:11
    EP  2 MAC: 00:0a:f7:31:43:12
    EP  3 MAC: 00:0a:f7:31:43:13
    EP  4 MAC: 00:0a:f7:31:43:14
    EP  5 MAC: 00:0a:f7:31:43:15
    EP  6 MAC: 00:0a:f7:31:43:16
    EP  7 MAC: 00:0a:f7:31:43:17
    EP  8 MAC: 00:0a:f7:31:43:18
    EP  9 MAC: 00:0a:f7:31:43:19
    EP 10 MAC: 00:0a:f7:31:43:1a
    EP 11 MAC: 00:0a:f7:31:43:1b
    EP 12 MAC: 00:0a:f7:31:43:1c
    EP 13 MAC: 00:0a:f7:31:43:1d
    EP 14 MAC: 00:0a:f7:31:43:1e
    EP 15 MAC: 00:0a:f7:31:43:1f
  ========= END =========
 

  2. NVM CFG mismatch
  ====== Logs Auto-Comparison ======
    NVM DIR/CRC and VPD: PASSED
    NVM CFG: FAILED
      DEBUG STRING:
         < #259: [S] SMBus ARP {Disabled(0), Enabled(1)}             : 1
        > #259: [S] SMBus ARP {Disabled(0), Enabled(1)}             : 0
        < {259=1}\
        > {259=0}\

  ====== Data Manual Checking ======
    PCIE SPEED/WIDTH: GEN 3x8
    Serial Number: A412143C200232CQ
    EP  0 MAC: 00:0a:f7:31:43:10
    EP  1 MAC: 00:0a:f7:31:43:11
    EP  2 MAC: 00:0a:f7:31:43:12
    EP  3 MAC: 00:0a:f7:31:43:13
    EP  4 MAC: 00:0a:f7:31:43:14
    EP  5 MAC: 00:0a:f7:31:43:15
    EP  6 MAC: 00:0a:f7:31:43:16
    EP  7 MAC: 00:0a:f7:31:43:17
    EP  8 MAC: 00:0a:f7:31:43:18
    EP  9 MAC: 00:0a:f7:31:43:19
    EP 10 MAC: 00:0a:f7:31:43:1a
    EP 11 MAC: 00:0a:f7:31:43:1b
    EP 12 MAC: 00:0a:f7:31:43:1c
    EP 13 MAC: 00:0a:f7:31:43:1d
    EP 14 MAC: 00:0a:f7:31:43:1e
    EP 15 MAC: 00:0a:f7:31:43:1f
  ========= END =========


Maintainers
  Far Huang - far.huang@broadcom.com


