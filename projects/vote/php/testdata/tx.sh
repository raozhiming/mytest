#!/bin/bash

#用户注册接口
php /data/www/vote/public/index.php /api/member/userReg

#创建投票主题接口
php /data/www/vote/public/index.php /api/topic/genTopic

#添加投票选项接口
php /data/www/vote/public/index.php /api/topic/addTopicOpt

#设置投票答案接口
php /data/www/vote/public/index.php /api/topic/submitTopicResult

#投票接口
php /data/www/vote/public/index.php /api/vote/vote
