#!/bin/bash
card_num=$1
filename=$2

#obtains directory of this script (useful when caller is in another directory
# so relative paths work correctly)
DIR="${BASH_SOURCE%/*}"
if [[ ! -d "$DIR" ]]; then DIR="$PWD"; fi
cd $DIR

#this is hardcoded in the tcl file, we cannot change this
output_from_tcl=READMAC.txt

#filename was originally READMAC.txt
if [ -s $output_from_tcl ]; then
    rm $output_from_tcl
fi

if [ -s $filename ]; then
    rm $filename
fi

#this line is needed for the parser
echo "copy READMAC.txt" > $output_from_tcl

echo "-------------------------------------------------------------------------"
echo "this is unable to handle more than one card at a time. Specifying a "
echo "device/function prevents the card from running diagnostics correctly."
echo "there is currently no fix for this, perhaps we will only have one slot"
echo "on at a time in the final version"
echo "-------------------------------------------------------------------------"
echo "Starting NVRAM verification..."
echo ./mfgload.sh -sysop -none -no_swap -eval "source READMAC.TCL"
#./mfgload.sh -dev $(($card_nulm + 1)) -none -cof -rc READMAC.tcl
#./mfgload.sh -sysop -none -no_swap -eval -rc READMAC.TCL
./mfgload.sh -sysop -none -no_swap -eval "source READMAC.TCL"
echo "NVRAM verify test completed"

#this line is needed for the parser
echo "file(s) copied" >> $output_from_tcl

#renames tcl file to the user provided name
#f forces overwrite if file exists for some reason, no prompt
mv -f $output_from_tcl $filename
