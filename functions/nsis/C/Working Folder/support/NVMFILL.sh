#!/bin/bash
card_num=$1
output_file=$2
success_string='Result = PASS'

#obtains directory of this script (useful when caller is in another directory
# so relative paths work correctly)
DIR="${BASH_SOURCE%/*}"
if [[ ! -d "$DIR" ]]; then DIR="$PWD"; fi
cd $DIR

if [ -s $output_file ]; then
	rm $output_file
fi

echo "-------------------------------------------------------------------------"
echo "this is unable to handle more than one card at a time. Specify a "
echo "device/function actually prevents the card from programming correctly."
echo "there is currently no fix for this, perhaps we will only have one slot"
echo "on at a time in the final version"
echo "-------------------------------------------------------------------------"
#echo ./mfgload.sh -dev $(($card_num + 1)) -none -rc NVMFILL.tcl -log $output_file
echo ./mfgload.sh -none -rc NVMFILL.TCL -log $output_file
./mfgload.sh -sysop -none -no_swap -rc NVMFILL.TCL -log $output_file
echo "NVMFILL completed"

#in retrospect, i don't see this in runNVRAM function... mean for FCT Prog?
#search output file for pass/fail
if grep -Fq "$success_string" "$output_file" ; then
	echo "NVM Erase Pass"
	ret_val=0
else
	echo "NVM Erase Fail"
	ret_val=1
fi

exit $ret_val
