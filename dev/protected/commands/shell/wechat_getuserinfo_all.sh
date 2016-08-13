date_time=`date`
folder_date=`date +%Y%m%d`

echo "start ${date_time}"  >> "/apps/log/cron/wechat_getuserinfo_${folder_date}.log"

source /apps/shell/web_env.sh


###############for start on here
for i in {1..50}
do

#数据库开始同步数据用户表ID
startId=$[48454+(i-1)*200]
endId=$[48454+i*200]

info=`php /apps/web/working/oppeincn/wechat/protected/commands/crons.php process ${startId} ${endId}` &

echo -e "${info}" >> "/apps/log/cron/wechat_getuserinfo_${folder_date}.log"

done
################for end on here

echo "end"  >> "/apps/log/cron/wechat_getuserinfo_${folder_date}.log"
