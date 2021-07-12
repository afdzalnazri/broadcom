#!/bin/bash
card_num=$1
num_ports=$2
output_file=$3
success_string='Result = PASS'
fail_string='Result = FAIL'

#obtains directory of this script (useful when caller is in another directory
# so relative paths work correctly)
DIR="${BASH_SOURCE%/*}"
if [[ ! -d "$DIR" ]]; then DIR="$PWD"; fi
cd $DIR

if [ -s $output_file ]; then
	rm $output_file
fi


#CFGCHK.TXT.IN was originally named CFGCHK.TXT The .in was added to indicate the
# file is for input rather than output

echo "-------------------------------------------------------------------------"
echo "this is unable to handle more than one card at a time. Specify a "
echo "device/function actually prevents the card from programming correctly."
echo "there is currently no fix for this, perhaps we will only have one slot"
echo "on at a time in the final version"
echo "-------------------------------------------------------------------------"
#for (( i=$card_num; i<($card_num+$num_ports); i++ ))
#    do
#        echo ./mfgload.sh -dev $(($i + 1)) -sysop -no_swap -cof -cfgchk CFGCHK.TXT.IN -log $output_file
#        ./mfgload.sh -dev $(($i + 1)) -sysop -no_swap -cof -cfgchk CFGCHK.TXT.IN |& tee $output_file
#    done

echo ./mfgload.sh -sysop -no_swap -none -T A1D3E1 -cfgchk CFGCHK.TXT.IN -log $output_file
./mfgload.sh -sysop -no_swap -none -T A1D3E1 -cfgchk CFGCHK.TXT.IN -log $output_file

#search output file for pass/fail
#continue to run external loopback test if previous tests passed, otherwise stop here!
if grep -Fq "$success_string" "$output_file" ; then
    # External loopback test requires L2 driver to be loaded.
    insmod bnxt_en.ko
    
    # Work around for CTRL-34559 - Force max speed on all devices
    file="/proc/net/dev"
    while IFS= read -r line
    do
        dev="$(echo $line | cut -f 1 -d " ")"
        dev=${dev%?}
        drv="$(ethtool -i $dev 2> /dev/null| grep driver|awk {'print $2'})"
        if [ "$drv" == "bnxt_en" ]; then
            ethtool -s $dev speed 100000 autoneg off
        fi
    done <"$file"

    echo ./mfgload.sh -sysop -no_swap -none -T C2 -log $output_file
    ./mfgload.sh -sysop -no_swap -none -T C2 -log $output_file
    
    # Revert to auto neg
    while IFS= read -r line
    do
        dev="$(echo $line | cut -f 1 -d " ")"
        dev=${dev%?}
        drv="$(ethtool -i $dev 2> /dev/null| grep driver|awk {'print $2'})"
        if [ "$drv" == "bnxt_en" ]; then
            ethtool -s $dev autoneg on
        fi
    done <"$file"

    rmmod bnxt_en.ko
fi

echo "FCT test completed" >> $output_file

#"file(s) copied" is for the parser and must be present. The begining of "files 
#copied" is in FCTPrg.sh
echo "file(s) copied" >> $output_file

