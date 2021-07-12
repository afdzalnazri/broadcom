#!/bin/bash


if [ $# -ne 2 ] ; then
        echo "Usage: $0 <check_img file> <log_cfg file>"
        exit 1
fi

if [[ ! -f "check_img.txt" || ! -f "log_cfg.txt" || ! -f "check_mac.txt" ]] ; then
  echo "The check_img.txt, log_cfg.txt or check_mac.txt do not exist"
  exit
fi
CHK_IMG_1="check_img.txt"
CHK_IMG_2=$1
LOG_CFG_1="log_cfg.txt"
LOG_CFG_2=$2
MAC_CFG="check_mac.txt"

# always skip filter1
filter1_array=( "Log open time:" "Duration:" "Log close time:" "PCIE-")
filter1_count=${#filter1_array[@]}

# check NVM content filter2
filter2_array=( "PKG_LOG" "FCFG" "PCFG" "SCFG" "VPD" "SN =" "VB =" "FAC_CFG" "SYS_CFG" "FACT_CFG" "QOS_PRF" "CFG_TBL" "IB_CFG")
filter2_count=${#filter2_array[@]}

# check NVM content filter3
filter3_array=( "Creation Date" "\[F\] MAC address" "\[P\] BMC MAC Address")
filter3_count=${#filter3_array[@]}

NVM_STRING1="Computed"

NVM_CRC_START=0
NVM_CRC_RESULT=0
NVM_CRC_OFFSET=0
MT_VER_RESULT=0

while read -r line; do
    if echo $line | grep -q "==" ; then
        continue;
    fi
    if echo $line | grep -q "bnxtmt version" ; then
        TOOL_VER=${line}
        if ! cat $CHK_IMG_1 | grep -q "$line" ; then
            MT_VER_RESULT=1
        fi
    elif echo $line | grep -q "PCIE-" ; then
        BRD_RV=`echo $line | awk '{printf $3}'`
        PCI_WIDTH=`echo $line | awk '{printf $5}'`
        PCI_SPD=`echo $line | awk '{printf $6}'`
        FAM_VER=`echo $line | awk '{printf $10}'`
    elif echo $line | grep -q "SN =" ; then
        SER_NUM=`echo $line | awk '{printf $3}'`
    else
        if echo $line | grep -q "$NVM_STRING1" ; then
            NVM_CRC_START=1
            continue;
	fi
    fi
    if [ $NVM_CRC_START == "1" ] ; then
        item_idx=`echo $line | awk '{printf $1}'`
        if echo $item_idx | grep -q "^[0-9]*$" ; then
            # echo "item index $item_idx"
            # check result
            if ! echo $line | grep -q "OK" ; then
                #echo "CRC result ERROR"
                NVM_CRC_RESULT=1
                #echo $line
            fi
        else
            NVM_CRC_START=0
        fi
    fi
done < $CHK_IMG_2



# comprasion NVM DIR and NVM CRC and VPD sections.

CMP_L_LINE=`cat $CHK_IMG_1 | grep -in "NVM Offset" -m1 `
CMP_R_LINE=`cat $CHK_IMG_2 | grep -in "NVM Offset" -m1 `
CMP_L_LINE=${CMP_L_LINE%:*}
CMP_R_LINE=${CMP_R_LINE%:*}
TOTAL_L_LINE=`cat $CHK_IMG_1 | wc -l`
TOTAL_R_LINE=`cat $CHK_IMG_2 | wc -l`
(( TAIL_L = TOTAL_L_LINE - CMP_L_LINE))
(( TAIL_R = TOTAL_R_LINE - CMP_R_LINE))

PKG_LOG_VER_L=0
PKG_LOG_VER_R=0
SER_NUM_L=0
SER_NUM_R=0
NVM_CRC_STR=" "
VPD_V2=0
VPD_V4=0
VPD_VB=0
while read -r line; do
    filter1_index=0
    filter1_flag=0
    filter2_index=0
    filter2_flag=0
    while [ "$filter1_index" -lt "$filter1_count" ]
    do    
        if echo $line | grep -q "${filter1_array[$filter1_index]}" ; then
            #echo $line
            filter1_flag=1
            break;
        fi
        ((filter1_index++))
    done
    if [ $filter1_flag == 1 ] ; then
        continue;
    fi

    while [ "$filter2_index" -lt "$filter2_count" ]
    do
        if echo $line | grep -q "${filter2_array[$filter2_index]}" ; then
            #echo $line
            words=`wc -w <<< "$line"`
            if [ "${filter2_array[$filter2_index]}" == "PKG_LOG" ] ; then
                if [ $words == "6" ] ; then
                    # echo "PKG LOG NVM DIR"
                    if echo $line | grep -q "<" ; then
                      PKG_LOG_VER_L="${line#*)}"
                    fi
                    if echo $line | grep -q ">" ; then
                      PKG_LOG_VER_R="${line#*)}"
                    fi
                    filter2_flag=1
                    break;
                fi
            fi 
            if [ "${filter2_array[$filter2_index]}" == "SN =" ] ; then
                    if echo $line | grep -q "<" ; then
                        SER_NUM_L=`echo $line | awk '{printf $4}'`
                        SER_NUM_L=${#SER_NUM_L}
                    fi
                    if echo $line | grep -q ">" ; then
                        SER_NUM_R=`echo $line | awk '{printf $4}'`
                        SER_NUM_R=${#SER_NUM_R}
                    fi
            fi
            filter2_flag=1

            break;
        fi
        ((filter2_index++))
    done
    # special for VPD V2 and V4. If not equal, it's dynamic data and show on manaul checking.
    if echo $line | grep -q "V2 =" ; then
        VPD_V2=1
        filter2_flag=1
    elif  echo $line | grep -q "V4 =" ; then 
        VPD_V4=1
        filter2_flag=1
    elif  echo $line | grep -iq "VB =" ; then 
        VPD_VB=1
        filter2_flag=1
    fi
    # skip empty
    if [ "${line}" == "<" ] || [ "${line}" == ">" ]; then
        filter2_flag=1
    fi
    
    if [ $filter2_flag == 1 ] ; then
        continue;
    fi

    # Special for CHDMP Type, it connected togother with type and ordianl dumped from bnxtmt.
    # SKIP chashdump checking 
    # CHDMP_D00
    # CHDMP_D01
    if echo $line | grep -q "CHDMP_D0" ; then
        continue;
    fi

    # Skip temp
    if  echo $line | grep -iq "reading temperature"; then
        break;
    fi
 
    NVM_CRC_STR+=$line"\n\t"
done < <(diff -bwB <(cat $CHK_IMG_1 | sed 's/^[ \t]*//' | tr -s ' ' | cut -d' ' -f4 --complement | tail -n $TAIL_L) <(cat $CHK_IMG_2 | sed 's/^[ \t]*//' | tr -s ' ' | cut -d' ' -f4 --complement | tail -n $TAIL_R) | grep ">\|<")

# pkg version was checking on VPD, skip it
#if [[ $PKG_LOG_VER_L != $PKG_LOG_VER_R ]]; then
#    NVM_CRC_STR+="PKG LOG VERISION MISMATCH!!"
#fi

# Skip serial number checking, it needs to check with manaul review
#if [[ $SER_NUM_L != $SER_NUM_R ]]; then
#    NVM_CRC_STR+="SN LENGTH MISMATCH!!"
#fi
if [[ $NVM_CRC_RESULT == "1" ]]; then
    NVM_CRC_STR+="NVM CRC ERROR or OFFSET MISMATCH!!"
fi
if [[ $MT_VER_RESULT == "1" ]]; then
    NVM_CRC_STR+="BNXTMT Version MISMATCH!!"
fi
# comparsion NVM CFG 
NVM_CFG_STR=" "

while read -r line; do

    filter3_index=0
    filter3_flag=0

    while [ "$filter3_index" -lt "$filter3_count" ]
    do
        if echo $line | grep -q "${filter3_array[$filter3_index]}" ; then
            filter3_flag=1
            break;
        fi
        ((filter3_index++))
    done
    if [ $filter3_flag == 1 ] ; then
        continue;
    fi


    NVM_CFG_STR+=$line' \n\t'
done < <(diff -bwB $LOG_CFG_1 $LOG_CFG_2 | grep ">\|<" )

# Display MAC Address

ep_index=0

while read -r line; do
    MAC_ADDR=`echo $line | awk '{printf $7}'`
    if [[ $MAC_ADDR != "00:00:00:00:00:00" ]]; then
        if [ $ep_index == "0" ]; then
            BASE_MAC=${MAC_ADDR}
            read A B C D E F <<<"${MAC_ADDR//:/ }"
            MAC_VAL=$((0x${E}*256+0x${F}))
            #echo "$BASE_MAC $E $F $MAC_VAL"
        else
            read A B C D E F <<<"${MAC_ADDR//:/ }"
            DIFF_VAL=$((0x${E}*256+0x${F} - MAC_VAL))

            # look for MPF file
            inc_index=`cat $MAC_CFG | grep -v '^#' | grep -w "ordinal = $ep_index" -A 2 | grep "mac_type = primary" -A 1 | grep "increment" | awk '{printf "%d", $3}'`
            # echo "$BASE_MAC $E $F ${DIFF_VAL} ${inc_index}"
            if [[ $inc_index ]]; then
                if [ "$inc_index" != "$DIFF_VAL" ] ; then
                    NVM_CFG_STR+="EP $ep_index MAC rule not match with MPF file\n\t"
                fi
            else
                NVM_CFG_STR+="EP $ep_index MAC rule not in MPF file\n\t"
            fi
        fi
    fi
    ((ep_index++))
done < <(cat $LOG_CFG_2 | grep "\[F\] MAC address")

ep_index=0
while read -r line; do
    MAC_ADDR=`echo $line | awk '{printf $7}'`
    if [[ $MAC_ADDR != "00:00:00:00:00:00" ]]; then
        read A B C D E F <<<"${MAC_ADDR//:/ }"
        DIFF_VAL=$((0x${E}*256+0x${F} - MAC_VAL))

    # look for MPF file
        inc_index=`cat $MAC_CFG | grep -v '^#' |  grep -w "ordinal = $ep_index" -A 2 | grep "mac_type = BMC" -A 1 |grep "increment"  | awk '{printf "%d", $3}'`
    #echo "$BASE_MAC $E $F $DIFF_VAL $inc_index"
        if [[ $inc_index ]]; then
            if [ $inc_index != $DIFF_VAL ]; then
                NVM_CFG_STR+="BMC $ep_index MAC rule not match with MPF file\n\t"
            fi
        else
            NVM_CFG_STR+="BMC $ep_index MAC rule not in MPF file\n\t"
        fi
    fi 

    ((ep_index++))
done < <(cat $LOG_CFG_2 | grep "\[P\] BMC MAC Address")






RED='\033[0;31m'
GREEN='\033[0;32m'
NC='\033[0m'

echo "====== Logs Auto-Comparison ======"
if [[ $NVM_CRC_STR == " " ]]; then
    echo -e "    NVM DIR/CRC and VPD: ${GREEN}PASSED${NC}"
else
    echo -e "    NVM DIR/CRC and VPD: ${RED}FAILED${NC}"
    echo -e "      DEBUG STRING:"
    echo -e "\t$NVM_CRC_STR"
fi
if [[ $NVM_CFG_STR == " " ]]; then
    echo -e "    NVM CFG: ${GREEN}PASSED${NC}"
else
    echo -e "    NVM CFG: ${RED}FAILED${NC}"

    echo -e "      DEBUG STRING:"
    echo -e "\t$NVM_CFG_STR"
fi



echo "====== Data Manual Checking ======"

#echo -e "    $TOOL_VER"
#echo -e "    CHIP VERSION: $BRD_RV"
if [[ $PCI_SPD == "5.0" ]]; then
echo -e "    PCIE SPEED/WIDTH: GEN 2x${PCI_WIDTH#*-}"
elif [[ $PCI_SPD == "8.0" ]]; then
echo -e "    PCIE SPEED/WIDTH: GEN 3x${PCI_WIDTH#*-}"
elif [[ $PCI_SPD == "16.0" ]]; then
echo -e "    PCIE SPEED/WIDTH: GEN 4x${PCI_WIDTH#*-}"
fi
#echo -e "    FAMILY VERSION: $FAM_VER"
echo -e "    Serial Number: $SER_NUM (${#SER_NUM})"


# Display Dynamic VPD

while read -r line; do
      if [ $VPD_V2 == 1 ]; then
          echo -e "    VPD $line"
      fi
done < <(cat $CHK_IMG_2 | grep "V2 =")
while read -r line; do
      if [ $VPD_V4 == 1 ]; then
          echo -e "    VPD $line"
      fi
done < <(cat $CHK_IMG_2 | grep "V4 =")
while read -r line; do
      if [ $VPD_VB == 1 ]; then
          echo -e "    VPD $line"
      fi
done < <(cat $CHK_IMG_2 | grep -i "VB =")


# Display temp
# Temperature: 33 øC
#   AVS_TMON1: 31 øC
#   AVS_TMON2: 33 øC


while read -r line; do
          echo -e "    $line"
done < <(cat $CHK_IMG_2 | grep -i "Temperature:")
while read -r line; do
          echo -e "    $line"
done < <(cat $CHK_IMG_2 | grep -i "AVS_TMON")

 
# Display MAC Address 

ep_index=0

while read -r line; do
    MAC_ADDR=`echo $line | awk '{printf $7}'`
    if cat $MAC_CFG | grep -v '^#' | grep -w "ordinal = $ep_index" -A 2 | grep -q "mac_type = primary" ; then
        if (( $ep_index >= 10 )); then
            echo -e "    EP $ep_index MAC: $MAC_ADDR"
        else
            echo -e "    EP  $ep_index MAC: $MAC_ADDR"
        fi
    fi
    ((ep_index++))
done < <(cat $LOG_CFG_2 | grep "\[F\] MAC address")

ep_index=0
while read -r line; do
    MAC_ADDR=`echo $line | awk '{printf $7}'`
    if cat $MAC_CFG | grep -v '^#' | grep -w "ordinal = $ep_index" -A 2 | grep -q "mac_type = BMC" ; then
        echo -e "    BMC $ep_index MAC: $MAC_ADDR"
    fi
    ((ep_index++))
done < <(cat $LOG_CFG_2 | grep "\[P\] BMC MAC Address")

echo "========= END ========="
