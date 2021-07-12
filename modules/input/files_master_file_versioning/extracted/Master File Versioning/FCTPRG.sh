#!/bin/bash
#FCTPRG is identical to STRESPRG
card_num=$1         #this is ignored for now, LCDiag will program incorrectly if this is used
firmware_file=$2    #this should be a FULL PATH or the img file should reside in lcdiag dir
stride=$3           #stride is the spacing between consecutive mac addresses
output_file=$4
success_string='Result = PASS'
fail_string='Result = FAIL'
fail_clockcrystal_string='ErrorDescription = Clock crystal test fails'

#obtains directory of this script (useful when caller is in another directory
# so relative paths work correctly)
DIR="${BASH_SOURCE%/*}"
if [[ ! -d "$DIR" ]]; then DIR="$PWD"; fi
cd $DIR

if [ -s $output_file ]; then
	rm $output_file
fi

#sets the card specific MACID file
mac_file=MACID$(printf "%02d" $card_num).txt
sn_file=SN$(printf "%02d" $card_num).txt
revdev_file=REVDEV$(printf "%02d" $card_num).txt
tmplog_file=TMPLOG$(printf "%02d" $card_num).txt


if [ -s $tmplog_file ]; then
	rm $tmplog_file
fi

#creates new file, "copy DIAG.txt" is for the parser and must be present, the end
#of this "copy" is in FCTTEST.sh
echo "copy DIAG.txt" > $output_file

#./mfgload.sh -dev $card_num -none -no_swap -cof -fnvm 3042CV00.img -stride 2 -fmac macid.txt -log
echo "-------------------------------------------------------------------------"
echo "this is unable to handle more than one card at a time. Specify a "
echo "device/function actually prevents the card from programming correctly."
echo "there is currently no fix for this, perhaps we will only have one slot"
echo "on at a time in the final version"
echo "-------------------------------------------------------------------------"

echo "Checking for CRID value..." >> $output_file
echo ./mfgload.sh -none -rc GET_CRID.TCL -log $output_file
./mfgload.sh -none -rc GET_CRID.TCL -log $output_file
crid=$(cat CRID.log)
echo "Current CRID = $crid" >> $output_file

if [ $crid = 0 ]; then
	# Step 1: Run basic board level tests.
    echo "Running FCT Pre-Test..." >> $output_file
	echo ./mfgload.sh -sysop -no_swap -none -T A3A4 -log $tmplog_file
	./mfgload.sh -sysop -no_swap -none -T A3A4 -log $tmplog_file

    #search output file for pass/fail
    #rerun pre-tests if the clock crystal test failed the first time
    if grep -Fq "$fail_clockcrystal_string" "$tmplog_file" ; then
    	echo ./mfgload.sh -sysop -no_swap -none -T A3A4 -log $output_file
	    ./mfgload.sh -sysop -no_swap -none -T A3A4 -log $output_file
    else
        cat $tmplog_file >> $output_file
    fi

	#search output file for pass/fail
    if grep -Fq "$fail_string" "$output_file" ; then
	    echo "FCT Pre-Test Fail" >> $output_file
	    # Pre-Test failed, stop here!
	    ret_val=1
	    exit $ret_val
    fi
	
	# Step 2: Promote chip from CRID0 to CRID1.
    echo "Promoting chip from CRID0 to CRID1..." >> $output_file
	echo ./mfgload.sh -promote -none -log $output_file
	./mfgload.sh -promote -none -log $output_file
	
	#search output file for pass/fail
    if grep -Fq "$fail_string" "$output_file" ; then
	    echo "FCT Promote chip from CRID0 to CRID1 Fail" >> $output_file
	    # Chip Promotion failed, stop here!
	    ret_val=1
	    exit $ret_val
    fi

else
    echo "The board has already been promoted to CRID 1..." >> $output_file
	echo "Skipping Test A3, A4 and CRID promotion" >> $output_file
fi

# Step 3: Program NVRAM
echo ./mfgload.sh -sysop -none -no_swap -noreset -noidcheck -gen1 -fnvm $firmware_file -fmac $mac_file -mac_prof BCM57504B1KFSBG_1_Macprofile_10212020152253BC10385_6.mpf -sn4 $sn_file -devnrev $revdev_file -vpd -log $output_file
./mfgload.sh -sysop -none -no_swap -noreset -noidcheck -gen1 -fnvm $firmware_file -fmac $mac_file -mac_prof BCM57504B1KFSBG_1_Macprofile_10212020152253BC10385_6.mpf -sn4 $sn_file -devnrev $revdev_file -vpd -log $output_file
echo "FCT NVRAM program completed"


if [ ! -s $output_file ]; then
    echo "FCT NVRAM program Fail incomplete test"
	ret_val=2
else
    #search output file for pass/fail
    if grep -Fq "$fail_string" "$output_file" ; then
	    echo "FCT NVRAM program Fail"
	    ret_val=1
    else
	    echo "FCT NVRAM program Pass"
	    ret_val=0
    fi
fi

#rm $output_file

exit $ret_val
