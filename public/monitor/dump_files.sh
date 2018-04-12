#!/bin/bash
echo 'Dump files start...';
#nowTime=`date +%Y%m%d_%H%M%S`;
#echo 'Compress files start...';
#fileName="mblock_cc_${nowTime}.zip"; 
#zip -r /mnt/resource/backup/${fileName} /home/wwwroot/www.mblock.cc
gzFileName='mblock_cc.tar.gz';
tar -zcf /mnt/resource/backup/${gzFileName} /home/wwwroot/www.mblock.cc
#echo 'Compress files end!!!!';
echo 'Dump files end!!';