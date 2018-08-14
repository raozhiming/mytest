#! /bin/bash

process=$1
pidArray=`adb shell ps -e | grep $process | awk '{print $2}'`
echo $pidArray

# $new=${pidArray/ / -e /g }
echo ${pidArray/ / -e }

# echo $new