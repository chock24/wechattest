
<?php
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
$url = "$protocol$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"; //Yii::app()->createUrl('moneytree'); //
?>
<a href="https://open.weixin.qq.com/connect/oauth2/authorize?appid=<?php echo $appId; ?>&redirect_uri=<?php echo $url; ?>&response_type=code&scope=snsapi_userinfo&state=2#wechat_redirect"  title="启动签到功能">
    <span id='get_openid' style="display:"></span>
</a>
<?php
if (!empty($dataProvider3)) {
    var_dump($dataProvider3);
}
?>

<script language="javascript" type="text/javascript">
<?php
$openid = @Yii::app()->cache->get('openid');

if (Yii::app()->request->getparam('state') == '2' && !empty($openid)) {
    ?>
<?php } else { ?>
        function getopenid()
        {
            document.getElementById('get_openid').click()
        }
        getopenid();
<?php } ?>
</script>
