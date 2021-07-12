#!/bin/bash

#obtains directory of this script (useful when caller is in another directory
# so relative paths work correctly)
DIR="${BASH_SOURCE%/*}"
if [[ ! -d "$DIR" ]]; then DIR="$PWD"; fi
cd $DIR

#if ps ax | grep -v grep | grep lcdiag > /dev/null
#then
#    echo "lcdiag is running, cannot run bnxtmt!"
#    exit 1
#fi

#if lsmod | grep cdrv > /dev/null; then
#    echo "cdrv kernel module from lcdiag is loaded. Please unload the module"
#    exit 1
#fi

if ps ax | grep -v grep | grep bnxtmt > /dev/null
then
    echo "bnxtmt is already running, cannot start another instance of the same!"
    exit 1
fi

ctl_c_hdlr()
{
    # Kill the children
    pkill -P $$

    # unload bnxtmt-drv kernel driver
    rmmod $MOD_NAME

    # delete device node
    rm -f /dev/bnxtmt-dev

    # Restore terminal parameters
    stty $term_cap

    # Suicide
    kill -9 $$
}

MOD_NAME=bnxtmtdrv
LEDIAG_PID=0
USE_INTA=0
DBG=1
extra_arg=""

if lsmod | grep $MOD_NAME > /dev/null; then
    rmmod $MOD_NAME
fi

#if lsmod | grep bnxt_en > /dev/null; then
#    rmmod bnxt_en
#fi

if uname -a | grep xen; then
   echo "Use INTA in XEN kernel"
   USE_INTA=1
fi 

if ! insmod bnxtmtdrv.ko use_inta=$USE_INTA dbg_trace_level_mparam=$DBG; then
	echo "Failed to load the module (insmod bnxtmtdrv.ko)"
	exit 1
fi


major=`cat /proc/devices | grep bnxtmt-dev | cut -d" " -f1`

rm -f /dev/bnxtmt-dev

if ! mknod /dev/bnxtmt-dev c $major 0; then
	echo "Failed to create a device file (mknod /dev/bnxtmt-dev c $major 0)"
	exit 1
fi

if [ $# -eq 0 ] || [ "$1" = "-eng" ]; then
echo "Running in engineering mode..."
extra_arg="-eng"
else
echo "Running in MFG mode..."
fi

# Save terminal session parameters
term_cap=`stty -g`

trap ctl_c_hdlr TERM INT

./bnxtmt "$@"
ret=$?

# delete device node
rm -f /dev/bnxtmt-dev

# unload bnxtmtdrv kernel driver
rmmod $MOD_NAME

# Restore terminal parameters (needed if the application has been killed)
stty $term_cap

exit $ret

