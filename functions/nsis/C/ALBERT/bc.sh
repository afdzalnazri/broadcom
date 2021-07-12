#!/bin/bash

# This script is used for performing manufacturing/BC operations on Thor boards.
# The group of arrays form a matrix for board specific test/operation/parameter.
# The current table contains 9 columns descibed in the table header. Each array/
# row represents a board with unique requirements.
#
# The script must be called with 3 parameters:
#   1. board:       P2100G/P2100GD/P2100GH/P2100GLC/...
#   2. operation:   program/test/log/nvmfill/promote
#   3. BC_number:   BC number ("." replaced with "_")
#
# Note: Be carefull while using promote operation. CRID promotion is irriversible
# operation.
#
# Example:
#   To program (and run the pre program test) on the P2100G board for BC-12345.6, run
#   ./bc.sh P2100G program BC-12345_6
#
# The script expects all the input files to be named as BC_number.ext:
#   Image file:     BC-12345_6.img
#   Mac file:       BC-12345_6.mac
#   MAC profile:    BC-12345_6.mpf
#
# All the output files would be named with the same convention:
#   Cfg file:       BC-12345_6.cfg


# Note: The current implementation requires a mac profile and does not support
# the stride argument.



if [ -z "$3" ]; then
    echo "Error: Wrong parameters"
    echo "Usage: bc.sh <board> <operation> <BC_number>"
    echo "       board = P2100G/P2100GD/P2100GH/P2100GLC"
    echo "       operation = program/test/log/nvmfill/insertion"
    echo "       BC_number = BC number (\".\" replaced with \"_\")"
    echo ""
    exit
fi

board_type=$1
op=$2
bc_num=$3
output_file=${bc_num}.log
success_string='Result = PASS'
l2_dir=../bnxt_en
l2_drv=bnxt_en.ko
crid=1

cfgchk_file=CFGCHK.TXT.IN

# Test arrays (Table) for each board. This contains board specific parameters
# Each line specifies parameters for a board. Add a new line for a new board.
# ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
# THOR BOARDS
# -------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
#            1:Board             2:cfgchk_opt_dev1  3:cfhckh_opt_dev2   4:cfhckh_opt_dev3   5:cfhckh_opt_dev4   6:Test1 - Thor pretest                                                                  7:nvram options                 8:Test2                                                                                       9:Test3 - PRBS Test                                              10:Test4 - Fru unlock                               11:Test5 - Fru lock                                  12:Test6 - 2nd insertion test                                          13:Test 7 - CRID check  
# -------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

TEST_P2100G=(P2100G             "dev1 = GEN3 x16"   "dev2 = GEN3 x16"   ""                  ""                  "./mfgload2.sh -sysop -no_swap -t ACDE1 -T A3A4 -log $output_file"                      "-noidcheck -sn4 sn4.txt -vpd"  "./mfgload2.sh -sysop -no_swap -none -T A1D3E1 -cfgchk $cfgchk_file -log $output_file"        "./mfgload2.sh -sysop -no_swap -none -T C2 -log $output_file"   ""                                                  ""                                                   ""                                                                      "./mfgload2.sh -sysop -none -no_swap -rc GET_CRID.TCL -log $output_file")
TEST_P2100GD=(P2100GD           "dev1 = GEN3 x16"   "dev2 = GEN3 x16"   ""                  ""                  "./mfgload2.sh -sysop -no_swap -t ACDE1 -T A3A4 -log $output_file"                      "-noidcheck"                    "./mfgload2.sh -sysop -no_swap -none -T A1D3E1 -cfgchk $cfgchk_file -log $output_file"        "./mfgload2.sh -sysop -no_swap -none -T C2 -log $output_file"   ""                                                  ""                                                   ""                                                                      "./mfgload2.sh -sysop -none -no_swap -rc GET_CRID.TCL -log $output_file")
TEST_P2100GH=(P2100GH           "dev1 = GEN3 x16"   "dev2 = GEN3 x16"   ""                  ""                  "./mfgload2.sh -sysop -no_swap -t ACDE1 -T A3A4 -log $output_file"                      "-sn sn.txt -vpd -noidcheck"    "./mfgload2.sh -sysop -no_swap -none -T A1D3E1 -cfgchk $cfgchk_file -log $output_file"        "./mfgload2.sh -sysop -no_swap -none -T C2 -log $output_file"   ""                                                  ""                                                   ""                                                                      "./mfgload2.sh -sysop -none -no_swap -rc GET_CRID.TCL -log $output_file")
TEST_P2100L=(P2100L             "dev1 = GEN3 x16"   "dev2 = GEN3 x16"   ""                  ""                  "./mfgload2.sh -sysop -no_swap -t ACDE1 -T A3A4 -log $output_file"                      "-sn2 sn2.txt -vpd -noidcheck"  "./mfgload2.sh -sysop -no_swap -none -T A1D3E1 -cfgchk $cfgchk_file -log $output_file"        "./mfgload2.sh -sysop -no_swap -none -T C2 -log $output_file"   ""                                                  ""                                                   ""                                                                      "./mfgload2.sh -sysop -none -no_swap -rc GET_CRID.TCL -log $output_file")
TEST_P2200G=(P2200G             "dev1 = GEN3 x16"   "dev2 = GEN3 x16"   ""                  ""                  "./mfgload2.sh -sysop -no_swap -t ACDE1 -T A3A4 -log $output_file"                      "-sn2 sn2.txt -vpd -noidcheck"  "./mfgload2.sh -sysop -no_swap -none -T A1D3E1 -cfgchk $cfgchk_file -log $output_file"        "./mfgload2.sh -sysop -no_swap -none -T C2 -log $output_file"   ""                                                  ""                                                   ""                                                                      "./mfgload2.sh -sysop -none -no_swap -rc GET_CRID.TCL -log $output_file")
TEST_N2100G=(N2100G             "dev1 = GEN3 x16"   "dev2 = GEN3 x16"   ""                  ""                  "./mfgload2.sh -sysop -no_swap -t ACDE1 -T A3A4 -log $output_file"                      "-noidcheck -sn4 sn4.txt -vpd"  "./mfgload2.sh -sysop -no_swap -none -T A1D3E1 -cfgchk $cfgchk_file -log $output_file"        "./mfgload2.sh -sysop -no_swap -none -T C2 -log $output_file"   "./mfgload2.sh -none -fru unlock -log $output_file" "./mfgload2.sh -none -fru lock -log $output_file"    ""                                                                      "./mfgload2.sh -sysop -none -no_swap -rc GET_CRID.TCL -log $output_file")
TEST_N1100G=(N1100G             "dev1 = GEN3 x16"   ""                  ""                  ""                  "./mfgload2.sh -sysop -no_swap -t ACDE1 -T A3A4 -log $output_file"                      "-noidcheck -sn4 sn4.txt -vpd"  "./mfgload2.sh -sysop -no_swap -none -T A1D3E1 -cfgchk $cfgchk_file -log $output_file"        "./mfgload2.sh -sysop -no_swap -none -T C2 -log $output_file"   "./mfgload2.sh -none -fru unlock -log $output_file" "./mfgload2.sh -none -fru lock -log $output_file"    ""                                                                      "./mfgload2.sh -sysop -none -no_swap -rc GET_CRID.TCL -log $output_file")
TEST_N1100FS=(N1100FS           "dev1 = GEN3 x16"   ""                  ""                  ""                  "./mfgload2.sh -sysop -no_swap -t ACDE1 -T A3A4 -log $output_file"                      "-noidcheck -sn4 sn4.txt -vpd"  "./mfgload2.sh -sysop -no_swap -none -T A1D3E1 -cfgchk $cfgchk_file -log $output_file"        "./mfgload2.sh -sysop -no_swap -none -T C2 -log $output_file"   "./mfgload2.sh -none -fru unlock -log $output_file" "./mfgload2.sh -none -fru lock -log $output_file"    ""                                                                      "./mfgload2.sh -sysop -none -no_swap -rc GET_CRID.TCL -log $output_file")
TEST_N1100FX=(N1100FX           "dev1 = GEN3 x16"   ""                  ""                  ""                  "./mfgload2.sh -sysop -no_swap -t ACDE1 -T A3A4 -log $output_file"                      "-noidcheck -sn4 sn4.txt -vpd"  "./mfgload2.sh -sysop -no_swap -none -T A1D3E1 -cfgchk $cfgchk_file -log $output_file"        "./mfgload2.sh -sysop -no_swap -none -T C2 -log $output_file"   "./mfgload2.sh -none -fru unlock -log $output_file" "./mfgload2.sh -none -fru lock -log $output_file"    ""                                                                      "./mfgload2.sh -sysop -none -no_swap -rc GET_CRID.TCL -log $output_file")
TEST_N1100FY=(N1100FY           "dev1 = GEN3 x4"    "dev2 = GEN3 x4"    "dev3 = GEN3 x4"    "dev4 = GEN3 x4"    "./mfgload2.sh -sysop -no_swap -t ACDE1 -T A3A4 -log $output_file"                      "-noidcheck -sn4 sn4.txt -vpd"  "./mfgload2.sh -sysop -no_swap -none -T A1D3E1 -cfgchk $cfgchk_file -log $output_file"        "./mfgload2.sh -sysop -no_swap -none -T C2 -log $output_file"   "./mfgload2.sh -none -fru unlock -log $output_file" "./mfgload2.sh -none -fru lock -log $output_file"    "./mfgload2.sh -no_swap -none -T a11 -sysop -c 1 -log $output_file"     "./mfgload2.sh -sysop -none -no_swap -rc GET_CRID.TCL -log $output_file")
TEST_N1100FZ=(N1100FZ           "dev1 = GEN3 x16"   ""                  ""                  ""                  "./mfgload2.sh -sysop -no_swap -t ACDE1 -T A3A4 -log $output_file"                      "-noidcheck -sn4 sn4.txt -vpd"  "./mfgload2.sh -sysop -no_swap -none -T A1D3E1 -cfgchk $cfgchk_file -log $output_file"        "./mfgload2.sh -sysop -no_swap -none -T C2 -log $output_file"   "./mfgload2.sh -none -fru unlock -log $output_file" "./mfgload2.sh -none -fru lock -log $output_file"    ""                                                                      "./mfgload2.sh -sysop -none -no_swap -rc GET_CRID.TCL -log $output_file")
TEST_N150FG=(N150FG             "dev1 = GEN3 x8"    ""                  ""                  ""                  "./mfgload2.sh -sysop -no_swap -t ACDE1 -T A3A4 -log $output_file"                      "-noidcheck -sn4 sn4.txt -vpd"  "./mfgload2.sh -sysop -no_swap -none -T A1D3E1 -cfgchk $cfgchk_file -log $output_file"        "./mfgload2.sh -sysop -no_swap -none -T C2 -log $output_file"   "./mfgload2.sh -none -fru unlock -log $output_file" "./mfgload2.sh -none -fru lock -log $output_file"    ""                                                                      "./mfgload2.sh -sysop -none -no_swap -rc GET_CRID.TCL -log $output_file")
TEST_N150FZ=(N150FZ             "dev1 = GEN3 x2"    ""                  ""                  ""                  "./mfgload2.sh -sysop -no_swap -t ACDE1 -T A3A4 -log $output_file"                      "-noidcheck -sn4 sn4.txt -vpd"  "./mfgload2.sh -sysop -no_swap -none -T A1D3E1 -cfgchk $cfgchk_file -log $output_file"        "./mfgload2.sh -sysop -no_swap -none -T C2 -log $output_file"   "./mfgload2.sh -none -fru unlock -log $output_file" "./mfgload2.sh -none -fru lock -log $output_file"    ""                                                                      "./mfgload2.sh -sysop -none -no_swap -rc GET_CRID.TCL -log $output_file")
TEST_N150FS=(N150FS             "dev1 = GEN3 x8"    ""                  ""                  ""                  "./mfgload2.sh -sysop -no_swap -t ACDE1 -T A3A4 -log $output_file"                      "-noidcheck -sn4 sn4.txt -vpd"  "./mfgload2.sh -sysop -no_swap -none -T A1D3E1 -cfgchk $cfgchk_file -log $output_file"        "./mfgload2.sh -sysop -no_swap -none -T C2 -log $output_file"   "./mfgload2.sh -none -fru unlock -log $output_file" "./mfgload2.sh -none -fru lock -log $output_file"    ""                                                                      "./mfgload2.sh -sysop -none -no_swap -rc GET_CRID.TCL -log $output_file")
TEST_N150FY=(N150FY             "dev1 = GEN3 x2"    "dev2 = GEN3 x2"    ""                  ""                  "./mfgload2.sh -sysop -no_swap -t ACDE1 -T A3A4 -log $output_file"                      "-noidcheck -sn4 sn4.txt -vpd"  "./mfgload2.sh -sysop -no_swap -none -T A1D3E1 -cfgchk $cfgchk_file -log $output_file"        "./mfgload2.sh -sysop -no_swap -none -T C2 -log $output_file"   "./mfgload2.sh -none -fru unlock -log $output_file" "./mfgload2.sh -none -fru lock -log $output_file"    "./mfgload2.sh -no_swap -none -T a10 -sysop -c 1 -log $output_file"     "./mfgload2.sh -sysop -none -no_swap -rc GET_CRID.TCL -log $output_file")
TEST_M150G=(M150G               "dev1 = GEN3 x4"    "dev2 = GEN3 x4"    "dev3 = GEN3 x4"    "dev4 = GEN3 x4"    "./mfgload2.sh -sysop -no_swap -t ACDE1 -T A3A4 -log $output_file"                      "-noidcheck -sn4 sn4.txt -vpd"  "./mfgload2.sh -sysop -no_swap -none -T A1D3E1 -cfgchk $cfgchk_file -log $output_file"        "./mfgload2.sh -sysop -no_swap -none -T C2 -log $output_file"   ""                                                  ""                                                   "./mfgload2.sh -no_swap -none -T a11 -sysop -c 1 -log $output_file"     "./mfgload2.sh -sysop -none -no_swap -rc GET_CRID.TCL -log $output_file")
TEST_NGM250D=(NGM250D           "dev1 = GEN3 x16"   "dev2 = GEN3 x16"   "dev3 = GEN3 x16"   "dev4 = GEN3 x16"   "./mfgload2.sh -sysop -no_swap -t ACDE1 -T A3A4 -log $output_file"                      "-noidcheck"                    "./mfgload2.sh -sysop -no_swap -none -T A1D3E1 -cfgchk $cfgchk_file -log $output_file"        "./mfgload2.sh -sysop -no_swap -none -T C2 -log $output_file"   ""                                                  ""                                                   ""                                                                      "./mfgload2.sh -sysop -none -no_swap -rc GET_CRID.TCL -log $output_file")
TEST_M1100G8=(M1100G8           "dev1 = GEN3 x8"    "dev2 = GEN3 x8"    ""                  ""                  "./mfgload2.sh -sysop -no_swap -t ACDE1 -T A3A4 -log $output_file"                      "-noidcheck -sn4 sn4.txt -vpd"  "./mfgload2.sh -sysop -no_swap -none -T A1D3E1 -cfgchk $cfgchk_file -log $output_file"        "./mfgload2.sh -sysop -no_swap -none -T C2 -log $output_file"   ""                                                  ""                                                   "./mfgload2.sh -no_swap -none -T a9 -sysop -c 1 -log $output_file"      "./mfgload2.sh -sysop -none -no_swap -rc GET_CRID.TCL -log $output_file")
TEST_M1100G16=(M1100G16         "dev1 = GEN3 x16"   ""                  ""                  ""                  "./mfgload2.sh -sysop -no_swap -t ACDE1 -T A3A4 -log $output_file"                      "-noidcheck -sn4 sn4.txt -vpd"  "./mfgload2.sh -sysop -no_swap -none -T A1D3E1 -cfgchk $cfgchk_file -log $output_file"        "./mfgload2.sh -sysop -no_swap -none -T C2 -log $output_file"   ""                                                  ""                                                   ""                                                                      "./mfgload2.sh -sysop -none -no_swap -rc GET_CRID.TCL -log $output_file")
TEST_N425G=(N425G               "dev1 = GEN3 x16"   "dev2 = GEN3 x16"   "dev3 = GEN3 x16"   "dev4 = GEN3 x16"   "./mfgload2.sh -sysop -no_swap -t ACDE1 -T A3A4 -log $output_file"                      "-noidcheck -sn4 sn4.txt -vpd"  "./mfgload2.sh -sysop -no_swap -none -T A1D3E1 -cfgchk $cfgchk_file -log $output_file"        "./mfgload2.sh -sysop -no_swap -none -T C2 -log $output_file"   "./mfgload2.sh -none -fru unlock -log $output_file" "./mfgload2.sh -none -fru lock -log $output_file"    ""                                                                      "./mfgload2.sh -sysop -none -no_swap -rc GET_CRID.TCL -log $output_file")
TEST_N425D=(N425D               "dev1 = GEN3 x16"   "dev2 = GEN3 x16"   "dev3 = GEN3 x16"   "dev4 = GEN3 x16"   "./mfgload2.sh -sysop -no_swap -t ACDE1 -T A3A4 -log $output_file"                      "-noidcheck"                    "./mfgload2.sh -sysop -no_swap -none -T A1D3E1 -cfgchk $cfgchk_file -log $output_file"        "./mfgload2.sh -sysop -no_swap -none -T C2 -log $output_file"   "./mfgload2.sh -none -fru unlock -log $output_file" "./mfgload2.sh -none -fru lock -log $output_file"    ""                                                                      "./mfgload2.sh -sysop -none -no_swap -rc GET_CRID.TCL -log $output_file")
TEST_P425G=(P425G               "dev1 = GEN3 x16"   "dev2 = GEN3 x16"   "dev3 = GEN3 x16"   "dev4 = GEN3 x16"   "./mfgload2.sh -sysop -no_swap -t ACDE1 -T A3A4 -log $output_file"                      "-noidcheck -sn4 sn4.txt -vpd"  "./mfgload2.sh -sysop -no_swap -none -T A1D3E1 -cfgchk $cfgchk_file -log $output_file"        "./mfgload2.sh -sysop -no_swap -none -T C2 -log $output_file"   ""                                                  ""                                                   ""                                                                      "./mfgload2.sh -sysop -none -no_swap -rc GET_CRID.TCL -log $output_file")

# ----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
# WH+ BOARDS
# ----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
#            1:Board             2:cfgchk_opt_dev1  3:cfhckh_opt_dev2   4:cfhckh_opt_dev3   5:cfhckh_opt_dev4   6:Test1                                                                                 7:nvram options                 8:Test2                                                                                        9:Test3                                                         10:Test4                                            11:Test5
# ----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
TEST_57412A4120A=(412A4120A     "dev1 = GEN3 x8"    "dev2 = GEN3 x8"    ""                  ""                  ""                                                                                      "-sn4 sn4.txt -vpd"             "./mfgload2.sh -sysop -no_swap -cfgchk $cfgchk_file -log $output_file"                       ""                                                              ""                                                  "")
TEST_57412M4122=(412M4122       "dev1 = GEN3 x8"    "dev2 = GEN3 x8"    ""                  ""                  ""                                                                                      "-sn4 sn4.txt -vpd"             "./mfgload2.sh -sysop -no_swap -cfgchk $cfgchk_file -log $output_file"                       ""                                                              ""                                                  "")
TEST_57412M4123C=(412M4123C     "dev1 = GEN3 x8"    "dev2 = GEN3 x8"    ""                  ""                  ""                                                                                      "-sn4 sn4.txt -vpd"             "./mfgload2.sh -sysop -no_swap -cfgchk $cfgchk_file -log $output_file"                       ""                                                              ""                                                  "")
TEST_57412M4123C=(412M4123C     "dev1 = GEN3 x8"    "dev2 = GEN3 x8"    ""                  ""                  ""                                                                                      "-sn4 sn4.txt -vpd"             "./mfgload2.sh -sysop -no_swap -cfgchk $cfgchk_file -log $output_file"                       ""                                                              ""                                                  "")
TEST_57412N4120C=(412N4120C     "dev1 = GEN3 x8"    "dev2 = GEN3 x8"    ""                  ""                  ""                                                                                      "-sn4 sn4.txt -vpd"             "./mfgload2.sh -sysop -no_swap -cfgchk $cfgchk_file -log $output_file"                       ""                                                              "./mfgload2.sh -none -fru unlock -log $output_file" "./mfgload2.sh -none -fru lock -log $output_file")
TEST_57414A4140=(414A4140       "dev1 = GEN3 x8"    "dev2 = GEN3 x8"    ""                  ""                  ""                                                                                      "-sn4 sn4.txt -vpd"             "./mfgload2.sh -sysop -no_swap -cfgchk $cfgchk_file -log $output_file"                       ""                                                              ""                                                  "")
TEST_57414A4142C=(414A4142C     "dev1 = GEN3 x8"    "dev2 = GEN3 x8"    ""                  ""                  ""                                                                                      "-sn4 sn4.txt -vpd"             "./mfgload2.sh -sysop -no_swap -cfgchk $cfgchk_file -log $output_file"                       ""                                                              ""                                                  "")
TEST_57414M4142=(414M4142       "dev1 = GEN3 x8"    "dev2 = GEN3 x8"    ""                  ""                  ""                                                                                      "-sn4 sn4.txt -vpd"             "./mfgload2.sh -sysop -no_swap -cfgchk $cfgchk_file -log $output_file"                       ""                                                              ""                                                  "")
TEST_57414M4143C=(414M4143C     "dev1 = GEN3 x8"    ""                  ""                  ""                  ""                                                                                      "-sn4 sn4.txt -vpd"             "./mfgload2.sh -sysop -no_swap -cfgchk $cfgchk_file -log $output_file"                       ""                                                              ""                                                  "")
TEST_57414M4145C=(414M4145C     "dev1 = GEN3 x8"    "dev2 = GEN3 x8"    ""                  ""                  ""                                                                                      "-sn4 sn4.txt -vpd"             "./mfgload2.sh -sysop -no_swap -cfgchk $cfgchk_file -log $output_file"                       ""                                                              ""                                                  "")
TEST_57414N4140C=(414N4140C     "dev1 = GEN3 x8"    "dev2 = GEN3 x8"    ""                  ""                  ""                                                                                      "-sn4 sn4.txt -vpd"             "./mfgload2.sh -sysop -no_swap -cfgchk $cfgchk_file -log $output_file"                       ""                                                              "./mfgload2.sh -none -fru unlock -log $output_file" "./mfgload2.sh -none -fru lock -log $output_file")
TEST_57416A4160C=(416A4160C     "dev1 = GEN3 x8"    "dev2 = GEN3 x8"    ""                  ""                  ""                                                                                      "-sn4 sn4.txt -vpd"             "./mfgload2.sh -sysop -no_swap -cfgchk $cfgchk_file -log $output_file"                       ""                                                              ""                                                  "")
TEST_57416N4160=(416N4160       "dev1 = GEN3 x8"    "dev2 = GEN3 x8"    ""                  ""                  ""                                                                                      "-sn4 sn4.txt -vpd"             "./mfgload2.sh -sysop -no_swap -cfgchk $cfgchk_file -log $output_file"                        ""                                                              "./mfgload2.sh -none -fru unlock -log $output_file" "./mfgload2.sh -none -fru lock -log $output_file")
TEST_57416M4163=(416M4163       "dev1 = GEN3 x8"    "dev2 = GEN3 x8"    ""                  ""                  ""                                                                                      "-sn4 sn4.txt -vpd"             "./mfgload2.sh -sysop -no_swap -cfgchk $cfgchk_file -log $output_file"                        ""                                                              ""                                                  "")
TEST_57416N4160LC=(416N4160LC   "dev1 = GEN3 x8"    "dev2 = GEN3 x8"    ""                  ""                  ""                                                                                      "-sn2 sn2.txt -vpd"             "./mfgload2.sh -sysop -no_swap -cfgchk $cfgchk_file -log $output_file"                        ""                                                              "./mfgload2.sh -none -fru unlock -log $output_file" "./mfgload2.sh -none -fru lock -log $output_file")
TEST_57416N4161LC=(416N4161LC   "dev1 = GEN3 x8"    "dev2 = GEN3 x8"    ""                  ""                  ""                                                                                      "-sn2 sn2.txt -vpd"             "./mfgload2.sh -sysop -no_swap -cfgchk $cfgchk_file -log $output_file"                        ""                                                              "./mfgload2.sh -none -fru unlock -log $output_file" "./mfgload2.sh -none -fru lock -log $output_file")
TEST_57416A4160L=(416A4160L     "dev1 = GEN3 x8"    "dev2 = GEN3 x8"    ""                  ""                  ""                                                                                      "-sn2 sn2.txt -vpd"             "./mfgload2.sh -sysop -no_swap -cfgchk $cfgchk_file -log $output_file"                        ""                                                              "" "")
TEST_57416M4161L=(416M4161L     "dev1 = GEN3 x8"    "dev2 = GEN3 x8"    ""                  ""                  ""                                                                                      "-sn2 sn2.txt -vpd"             "./mfgload2.sh -sysop -no_swap -cfgchk $cfgchk_file -log $output_file"                        ""                                                              "" "")
TEST_57416N4160DC=(416N4160DC   "dev1 = GEN3 x8"    "dev2 = GEN3 x8"    ""                  ""                  ""                                                                                      ""                              "./mfgload2.sh -sysop -no_swap -cfgchk $cfgchk_file -log $output_file"                        ""                                                              "./mfgload2.sh -none -fru unlock -log $output_file" "./mfgload2.sh -none -fru lock -log $output_file")
TEST_57416N4160HC=(416N4160HC   "dev1 = GEN3 x8"    "dev2 = GEN3 x8"    ""                  ""                  ""                                                                                      "-sn sn.txt -vpd"               "./mfgload2.sh -sysop -no_swap -cfgchk $cfgchk_file -log $output_file"                        ""                                                              "./mfgload2.sh -none -fru unlock -log $output_file" "./mfgload2.sh -none -fru lock -log $output_file")
TEST_57416A4162HC=(416A4162HC   "dev1 = GEN3 x8"    "dev2 = GEN3 x8"    ""                  ""                  ""                                                                                      "-sn sn.txt -vpd"               "./mfgload2.sh -sysop -no_swap -cfgchk $cfgchk_file -log $output_file"                        ""                                                              "" "")
TEST_57414A4142HC=(414A4142HC   "dev1 = GEN3 x8"    "dev2 = GEN3 x8"    ""                  ""                  ""                                                                                      "-sn sn.txt -vpd"               "./mfgload2.sh -sysop -no_swap -cfgchk $cfgchk_file -log $output_file"                        ""                                                              ""                                                  "")
TEST_57414N4140HC=(414N4140HC   "dev1 = GEN3 x8"    "dev2 = GEN3 x8"    ""                  ""                  ""                                                                                      "-sn sn.txt -vpd"               "./mfgload2.sh -sysop -no_swap -cfgchk $cfgchk_file -log $output_file"                        ""                                                              "./mfgload2.sh -none -fru unlock -log $output_file" "./mfgload2.sh -none -fru lock -log $output_file")
TEST_57412N4120HC=(412N4120HC   "dev1 = GEN3 x8"    "dev2 = GEN3 x8"    ""                  ""                  ""                                                                                      "-sn sn.txt -vpd"               "./mfgload2.sh -sysop -no_swap -cfgchk $cfgchk_file -log $output_file"                        ""                                                              "./mfgload2.sh -none -fru unlock -log $output_file" "./mfgload2.sh -none -fru lock -log $output_file")
TEST_57412A4121HC=(412A4121HC   "dev1 = GEN3 x8"    "dev2 = GEN3 x8"    ""                  ""                  ""                                                                                      "-sn sn.txt -vpd"               "./mfgload2.sh -sysop -no_swap -cfgchk $cfgchk_file -log $output_file"                        ""                                                              ""                                                  "")

# ----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
# STRATUS BOARDS
# ----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
#            1:Board             2:cfgchk_opt_dev1  3:cfhckh_opt_dev2   4:cfhckh_opt_dev3   5:cfhckh_opt_dev4   6:Test1                                                                                 7:nvram options                 8:Test2                                                                                        9:Test3                                                         10:Test4                                            11:Test5
# ----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
TEST_57454N425SNL=(454N425SNL   "dev1 = GEN3 x16"   "dev2 = GEN3 x16"   "dev3 = GEN3 x16"   "dev3 = GEN3 x16"   ""                                                                                      "-sn2 sn2.txt -vpd -noidcheck"  "./mfgload2.sh -sysop -no_swap -cfgchk $cfgchk_file -log $output_file"                      ""                                                              "./mfgload2.sh -none -fru unlock -log $output_file" "./mfgload2.sh -none -fru lock -log $output_file")
TEST_57454P410SLBT=(454P410SLBT "dev1 = GEN3 x8"    "dev2 = GEN3 x8"    "dev3 = GEN3 x8"    "dev3 = GEN3 x8"    ""                                                                                      "-sn2 sn2.txt -vpd -noidcheck"  "./mfgload2.sh -sysop -no_swap -t C1C2C3E3E4 -cfgchk $cfgchk_file -log $output_file"          "./mfgload2.sh -sysop -no_swap -none -T C3 -log $output_file"   ""                                                  "")



b=

if [ $1 == P2100G ]; then
    b=("${TEST_P2100G[@]}")
elif [ $1 == P2100GD ]; then
    b=("${TEST_P2100GD[@]}")
elif [ $1 == P2100GH ]; then
    b=("${TEST_P2100GH[@]}")
elif [ $1 == P2100L ]; then
    b=("${TEST_P2100L[@]}")
elif [ $1 == P2200G ]; then
    b=("${TEST_P2200G[@]}")
elif [ $1 == N2100G ]; then
    b=("${TEST_N2100G[@]}")
elif [ $1 == N1100G ]; then
    b=("${TEST_N1100G[@]}")
elif [ $1 == N1100FS ]; then
    b=("${TEST_N1100FS[@]}")
elif [ $1 == N1100FX ]; then
    b=("${TEST_N1100FX[@]}")
elif [ $1 == N1100FY ]; then
    b=("${TEST_N1100FY[@]}")
elif [ $1 == N1100FZ ]; then
    b=("${TEST_N1100FZ[@]}")
elif [ $1 == N150FG ]; then
    b=("${TEST_N150FG[@]}")
elif [ $1 == N150FZ ]; then
    b=("${TEST_N150FZ[@]}")
elif [ $1 == N150FS ]; then
    b=("${TEST_N150FS[@]}")
elif [ $1 == N150FY ]; then
    b=("${TEST_N150FY[@]}")
elif [ $1 == M150G ]; then
    b=("${TEST_M150G[@]}")
elif [ $1 == NGM250D ]; then
    b=("${TEST_NGM250D[@]}")
elif [ $1 == M1100G8 ]; then
    b=("${TEST_M1100G8[@]}")
elif [ $1 == M1100G16 ]; then
    b=("${TEST_M1100G16[@]}")
elif [ $1 == N425G ]; then
    b=("${TEST_N425G[@]}")
elif [ $1 == N425D ]; then
    b=("${TEST_N425D[@]}")
elif [ $1 == P425G ]; then
    b=("${TEST_P425G[@]}")
elif [ $1 == 412A4120A ]; then
    b=("${TEST_57412A4120A[@]}")
elif [ $1 == 412M4122 ]; then
    b=("${TEST_57412M4122[@]}")
elif [ $1 == 412M4123C ]; then
    b=("${TEST_57412M4123C[@]}")
elif [ $1 == 412N4120C ]; then
    b=("${TEST_57412N4120C[@]}")
elif [ $1 == 414M4142 ]; then
    b=("${TEST_57414M4142[@]}")
elif [ $1 == 414A4140 ]; then
    b=("${TEST_57414A4140[@]}")
elif [ $1 == 414M4143C ]; then
    b=("${TEST_57414M4143C[@]}")
elif [ $1 == 414A4142C ]; then
    b=("${TEST_57414A4142C[@]}")
elif [ $1 == 414M4145C ]; then
    b=("${TEST_57414M4145C[@]}")
elif [ $1 == 414N4140C ]; then
    b=("${TEST_57414N4140C[@]}")
elif [ $1 == 416A4160C ]; then
    b=("${TEST_57416A4160C[@]}")
elif [ $1 == 416N4160 ]; then
    b=("${TEST_57416N4160[@]}")
elif [ $1 == 416M4163 ]; then
    b=("${TEST_57416M4163[@]}")
elif [ $1 == 416N4160LC ]; then
    b=("${TEST_57416N4160LC[@]}")
elif [ $1 == 416N4161LC ]; then
    b=("${TEST_57416N4161LC[@]}")
elif [ $1 == 416A4160L ]; then
    b=("${TEST_57416A4160L[@]}")
elif [ $1 == 416M4161L ]; then
    b=("${TEST_57416M4161L[@]}")
elif [ $1 == 416N4160DC ]; then
    b=("${TEST_57416N4160DC[@]}")
elif [ $1 == 416N4160HC ]; then
    b=("${TEST_57416N4160HC[@]}")
elif [ $1 == 416A4162HC ]; then
    b=("${TEST_57416A4162HC[@]}")
elif [ $1 == 414A4142HC ]; then
    b=("${TEST_57414A4142HC[@]}")
elif [ $1 == 414N4140HC ]; then
    b=("${TEST_57414N4140HC[@]}")
elif [ $1 == 412N4120HC ]; then
    b=("${TEST_57412N4120HC[@]}")
elif [ $1 == 412A4121HC ]; then
    b=("${TEST_57412A4121HC[@]}")
elif [ $1 == 454N425SNL ]; then
    b=("${TEST_57454N425SNL[@]}")
elif [ $1 == 454P410SLBT ]; then
    b=("${TEST_57454P410SLBT[@]}")
else
    b=
fi

echo "================================================="
echo "Board: ${b[0]}"

if [ $op == program ]; then
    # Program the board
    firmware_file=${bc_num}.img
    mac_file=${bc_num}.mac
    mac_prof=${bc_num}.mpf

    echo "Operation: program (pre-test and program)"
    echo "================================================="

    if [ ! -f "$firmware_file" ]; then
        echo "Error: File $firmware_file does not exist"
        echo ""
        exit 1
    fi
    if [ ! -f "$mac_file" ]; then
        echo "Error: File $mac_file does not exist"
        echo ""
        exit 1
    fi
    if [ ! -f "$mac_prof" ]; then
        echo "Error: File $mac_prof does not exist"
        echo ""
        exit 1
    fi

    # Delete existing file. The file may be stale. This is the first test and should start with a fresh output file.
    if [ -s $output_file ]; then
        rm $output_file
    fi

    if [ "${b[12]}" != "" ]; then
        echo "Check CRID value for Thor cmd: ${b[12]}"
        ${b[12]}
        crid=$(cat CRID.log)
    fi
    if [ $crid == 0 ]; then
        echo "Pre-test cmd: ${b[5]}"
        ${b[5]}
    else
        echo "Program cmd: ./mfgload2.sh -sysop -none -no_swap -fnvm $firmware_file -fmac $mac_file -mac_prof $mac_prof -noreset -log $output_file ${b[6]} -gen1 -devnrev sample.devnrev"
        ./mfgload2.sh -sysop -none -no_swap -fnvm $firmware_file -fmac $mac_file -mac_prof $mac_prof -noreset -log $output_file ${b[6]} -gen1 -devnrev sample.devnrev
    fi

    #echo "Program cmd: ./mfgload2.sh -sysop -none -no_swap -fnvm $firmware_file -fmac $mac_file -mac_prof $mac_prof -noreset -log $output_file ${b[6]} -gen1 -devnrev sample.devnrev"
    #/mfgload2.sh -sysop -none -no_swap -fnvm $firmware_file -fmac $mac_file -mac_prof $mac_prof -noreset -log $output_file ${b[6]} -gen1 -devnrev sample.devnrev
elif [ $op == log ]; then
    # Log operation
    echo "Operation: log (eval NVRAM.TCL)"
    echo "================================================="
    echo "Log cmd: ./mfgload2.sh -sysop -none -no_swap -rc NVRAM.TCL -eval \"nvram_log $bc_num\""
    ./mfgload2.sh -sysop -none -no_swap -rc NVRAM.TCL -eval "nvram_log $bc_num"
elif [ $op == nvmfill ]; then
    # NVMFILL operation
    echo "Operation: nvmfill (eval NVMFILL.TCL)"
    echo "================================================="
    #echo "Nvmfill cmd: ./mfgload2.sh -sysop -none -no_swap -eval \"source NVMFILL.TCL\""
    #./mfgload2.sh -sysop -none -no_swap -eval "source NVMFILL.TCL" -log $output_file
    echo "Nvmfill cmd: ./mfgload2.sh -sysop -none -no_swap -blank"
    ./mfgload2.sh -sysop -none -no_swap -blank -log $output_file
elif [ $op == test ]; then
    echo "Creating $cfgchk_file"
    echo "#" > $cfgchk_file
    echo "# usage:  <DEV> = <PCIE_SETTING>" >> $cfgchk_file
    echo "#         DEV : dev1 | dev2  | dev3 | ...." >> $cfgchk_file
    echo "#         PCIE_SETTING: GEN1 x1 | GEN1 x2 | GEN1 x4 | GEN1 x8 | GEN1 x16 |" >> $cfgchk_file
    echo "#                       GEN2 x1 | GEN2 x2 | GEN2 x4 | GEN2 x8 | GEN2 x16 |" >> $cfgchk_file
    echo "#                       GEN3 x1 | GEN3 x2 | GEN3 x4 | GEN3 x8 | GEN3 x16" >> $cfgchk_file
    echo "#" >> $cfgchk_file
    echo "${b[1]}" >> $cfgchk_file
    echo "${b[2]}" >> $cfgchk_file
    echo "${b[3]}" >> $cfgchk_file
    echo "${b[4]}" >> $cfgchk_file

    sed -i '/^$/d' $cfgchk_file
    # Test operation
    echo "Operation: test (test2 and test3)"
    echo "================================================="

    if [ "${b[8]}" != "" ]; then
        if [ ! -f "$l2_dir/$l2_drv" ]; then
            echo "Error: bnxt_en driver not found: $l2_dir/$l2_drv"
            echo ""
            exit 1
        fi
    fi

    # Run tests
    echo "test2 cmd: ${b[7]}"
    ${b[7]}

    # Run traffic test
    # Load L2 driver for traffic test
    if [ "${b[8]}" != "" ]; then
        insmod $l2_dir/$l2_drv
        echo "test3 cmd: ${b[8]}"
        ${b[8]}
        rmmod $l2_drv
    fi

    # Run FRU unlock/lock test
    if [ "${b[9]}" != "" ]; then
        echo "Run FRU unlock/lock test"
        echo "FRU unlock cmd: ${b[9]}"
        ${b[9]}
        echo "FRU lock cmd: ${b[10]}"
        ${b[10]}
    fi

elif [ $op == promote ]; then
    echo "Promote command: ./mfgload2.sh -none -promote -log $output_file"
    ./mfgload2.sh -none -promote -log $output_file

elif [ $op == insertion ]; then
    # Test operation
    echo "Operation: 2nd insertion test"
    echo "================================================="
    echo "test cmd: ${b[11]}"
    ${b[11]}
else
    echo "Operation $op not supported"
    echo "================================================="
    echo ""
fi


if [ ! -s $output_file ]; then
    ret_val=2
else
    #search output file for pass/fail
    if grep -Fq "$success_string" "$output_file" ; then
        ret_val=0
    else
        ret_val=1
    fi
fi

exit $ret_val

