<?php
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
$url = "$protocol$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
?>
<a href="https://open.weixin.qq.com/connect/oauth2/authorize?appId=<?php echo $appId; ?>&redirect_uri=<?php echo $url; ?>&response_type=code&scope=snsapi_base&state=1#wechat_redirect"  title="启动签到功能">
    <span id='getopenid' style="display: none"></span>
</a>
<script language="javascript" type="text/javascript">
    <?php
    if (Yii::app()->user->hasflash('openid')) {
        $openid = @Yii::app()->user->getflash('openid');
    }

    if (Yii::app()->request->getparam('state') == '1' && !empty($openid)) {
        ?>
    <?php } else { ?>
    function getopenid()
    {
        $("#getopenid").click();
    }
    getopenid();
    <?php } ?>
</script>