#!/bin/bash

base_dir=$PWD
bnxt_en_dir=bnxt_en
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
cd $base_dir
echo "Renaming $dir to $bnxt_en_dir"
mv $dir $bnxt_en_dir



