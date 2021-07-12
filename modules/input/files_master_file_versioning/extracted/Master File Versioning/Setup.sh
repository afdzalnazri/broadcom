#!/bin/bash

BNXTMT_DIR="$1"

base_dir=$PWD
bnxtmt="$(ls bnxtmt*.tar.gz)"
echo 
echo "*************** Untarring the bnxtmt pkg: $bnxtmt"
echo 
tar -xvf $bnxtmt
dir="${bnxtmt%.tar.gz}"

echo "Changing directory to $PWD/$dir"
cd $dir
echo 
echo "*************** Building bnxtmt ***************"
echo 
make

# copy BNXTMT files & folders to Linux Wrapper working folder
if [ ! -d "$BNXTMT_DIR/diagfw" ]; then
    echo mkdir -p $BNXTMT_DIR/diagfw	 
	mkdir -p $BNXTMT_DIR/diagfw	 
fi

echo "Coping BNXTMT files..."
echo cp -r -v $PWD/. $BNXTMT_DIR/.
cp -r -v $PWD/. $BNXTMT_DIR/.

cd $base_dir

bnxt_en="$(ls bnxt_en*.tar.gz)"
echo 
echo "*************** Untarring the bnxt_en pkg: $bnxt_en"
echo 
tar -xvf $bnxt_en
dir="${bnxt_en%.tar.gz}"

echo "Changing directory to $PWD/$dir"
cd $dir
echo 
echo "*************** Building bnxt_en ***************"
echo 
make

echo "Coping BNXT_EN driver..."
echo cp -r -v $PWD/bnxt_en.ko $BNXTMT_DIR/bnxt_en.ko
cp -r -v $PWD/bnxt_en.ko $BNXTMT_DIR/bnxt_en.ko

# return val
ret_val=0
exit $ret_val

