
<?php
require_once "jssdk.php";
$jssdk = new JSSDK($appId, $appSecret);
$signPackage = $jssdk->GetSignPackage();
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>分享title</title>
    </head>
    <body>
        分享测试
    </body>
    <script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
    <script>

        wx.config({
            debug: true,
            appId: '<?php echo $signPackage["appId"]; ?>',
            timestamp: <?php echo $signPackage["timestamp"]; ?>,
            nonceStr: '<?php echo $signPackage["nonceStr"]; ?>',
            signature: '<?php echo $signPackage["signature"]; ?>',
            jsApiList: [
                'checkJsApi',
                'onMenuShareTimeline',
                'onMenuShareAppMessage',
                'onMenuShareQQ',
                'onMenuShareWeibo',
                'hideMenuItems',
                'showMenuItems',
                'hideAllNonBaseMenuItem',
                'showAllNonBaseMenuItem',
                'translateVoice',
                'startRecord',
                'stopRecord',
                'onRecordEnd',
                'playVoice',
                'pauseVoice',
                'stopVoice',
                'uploadVoice',
                'downloadVoice',
                'chooseImage',
                'previewImage',
                'uploadImage',
                'downloadImage',
                'getNetworkType',
                'openLocation',
                'getLocation',
                'hideOptionMenu',
                'showOptionMenu',
                'closeWindow',
                'scanQRCode',
                'chooseWXPay',
                'openProductSpecificView',
                'addCard',
                'chooseCard',
                'openCard'
            ]
        });
        wx.ready(function () {
        
            // 2.2 监听“分享到朋友圈”按钮点击、自定义分享内容及分享结果接口 
            wx.onMenuShareTimeline({
                title: document.title,
                link: window.location,
                imgUrl: 'http://img.oppein.cn/updata/todayhot/source/2014101611221829216400131812.jpg',
                trigger: function (res) {
                    alert('用户点击分享到朋友圈');
                },
                success: function (res) {
                    alert('已分享');
                },
                cancel: function (res) {
                    alert('已取消');
                },
                fail: function (res) {
                    alert(JSON.stringify(res));
                }
            });
            wx.onMenuShareAppMessage({
                desc: '', // 分享描述
                title:document.title ,
                link: window.location,
                imgUrl: 'http://img.oppein.cn/updata/todayhot/source/2014101611221829216400131812.jpg',
                type: '', // 分享类型,music、video或link，不填默认为link
                dataUrl: '', // 如果type是music或video，则要提供数据链接，默认为空
                success: function () {
                    alert('转发好友成功');
                },
                cancel: function () {
                    alert('转发好友失败');
                }
            });
        });

        wx.error(function (res) {
            laert('处理失败');
        });
    </script>
</html>

