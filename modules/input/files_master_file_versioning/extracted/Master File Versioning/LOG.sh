#!/bin/bash
card_num=$1

#obtains directory of this script (useful when caller is in another directory
# so relative paths work correctly)
DIR="${BASH_SOURCE%/*}"
if [[ ! -d "$DIR" ]]; then DIR="$PWD"; fi

#these file names match those in NVRAM.tcl
nvcfg=NVRAMCFG.cfg
nvimg=NVRAMIMG.img
nvlog=NVRAMLOG.log
#creates filenames that incorperate the card number
printf -v cardcfg "NVRAMCFG%02d.cfg" $card_num
printf -v cardimg "NVRAMIMG%02d.img" $card_num
printf -v cardlog "NVRAMLOG%02d.log" $card_num

if [ -s $nvcfg ]; then
    rm $nvcfg
fi

if [ -s $nvimg ]; then
    rm $nvimg
fi

if [ -s $nvlog ]; then
    rm $nvlog
fi

if [ -s $cardcfg ]; then
    rm $cardcfg
fi

if [ -s $cardimg ]; then
    rm $cardimg
fi

if [ -s $cardlog ]; then
    rm $cardlog
fi

echo "-------------------------------------------------------------------------"
echo "this is unable to handle more than one card at a time. Specifying a "
echo "device/function prevents the card from running diagnostics correctly."
echo "there is currently no fix for this, perhaps we will only have one slot"
echo "on at a time in the final version"
echo "-------------------------------------------------------------------------"
#runs TCL script
echo ./mfgload.sh -dev $(($card_num + 1)) -cof -none -rc NVRAMLOG.TCL
./mfgload.sh -sysop -none -no_swap -rc NVRAMLOG.TCL

echo ./mfgload.sh -dev $(($card_num + 1)) -cof -none -eval "source NVRAMCFG.TCL"
./mfgload.sh -sysop -none -no_swap -eval "source NVRAMCFG.TCL"

#renames the tcl output to incorperate card number
#-f overwirtes the file without prompting
if [ -s $nvcfg ]; then
    mv -f $nvcfg $cardcfg
fi

if [ -s $nvimg ]; then
    mv -f $nvimg $cardimg
fi

if [ -s $nvlog ]; then
    mv -f $nvlog $cardlog
fi


