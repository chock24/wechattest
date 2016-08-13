date_time=`date`
folder_date=`date +%Y%m%d`

echo "start ${date_time}"  >> "/apps/log/wechat_download/wechat_download_${folder_date}.log"

source /apps/shell/web_env.sh

#微信公众号APPID
appid=`wx1a3894d32ea4fb42`
appsecret=`280b9b0f0455434b4e557f68decb42bd`
public_id=6
#从日志中获取
next_openid=``

info=`php /apps/web/working/oppeincn/wechat/protected/commands/download.php download ${appid} ${appsecret} ${public_id} ${next_openid}`

echo -e "${info}" >> "/apps/log/wechat_download/wechat_download_${folder_date}.log"

echo "end"  >> "/apps/log/wechat_download/wechat_download_${folder_date}.log"
