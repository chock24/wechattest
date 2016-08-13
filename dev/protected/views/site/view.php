<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta charset="utf-8"/>
        <meta name="viewport" content="initial-scale=1.0, minimum-scale=1.0, user-scalable=0, width=device-width"/>
        <meta name="format-detection" content="telephone=no"/>
        <title><?php echo @CHtml::encode($model->title); ?></title>
        <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/font/zepto.min.js"></script>
        <?php Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . "/css/sourcefile/article_view.css"); ?>
    </head>

    <body>
    <script type="text/javascript">

    </script>
        <div class="rich_media" id="obj_wh">
            <div class="rich_whole">
                <h1 class="rich_media_title"><?php echo @CHtml::encode($model->title); ?></h1>
                <div class="rich_media_meta_list">
                    <em class="rich_media_meta text"><?php echo @Yii::app()->format->formatDate($model->time_created); ?></em>
                    <em class="rich_media_meta text"><?php echo CHtml::encode($model->author); ?></em>
                    <?php
                    echo @CHtml::link(
                            ($model->public_name ? $model->public_name : $model->public->title), $model->public_url, array('class' => 'rich_media_meta',)
                    );
                    ?>
                </div>
                <div class="img-content" id="gallery">
                    <?php if (@$model->show_content)://如果选择了要显示封面的话 ?>
                        <div class="rich_media_thumb">
                            <?php echo CHtml::image(PublicStaticMethod::returnSourceFile($model->filename, $model->ext, 'image', 'source'), $model->filename, array('title' => $model->filename)); ?>
                        </div>
                    <?php endif; ?>

                    <div class="rich_media_content">
                        <?php echo @nl2br($model->content); ?>
                    </div>
                </div>
                <div class="caller_info">
                    <?php echo CHtml::link('阅读原文', $model->content_source_url, array('class' => 'read-source')); ?>
                    <!--<a href="javascript:;">阅读数(0)</a>
                    <a href="javascript:;">赞(0)</a>-->
                </div>
            </div>
        </div>
        <?php
        if (!empty($publicmodel)) {
            require_once "jssdk.php";
            $appId = $publicmodel->appid;
            $appSecret = $publicmodel->appsecret;
            $jssdk = new JSSDK($appId, $appSecret);
            $signPackage = $jssdk->GetSignPackage();
        }
        ?>
    <script>
        $(function() {
            var pattern = /^http:\/\/mmbiz/;
            var prefix = 'http://img01.store.sogou.com/net/a/04/link?appid=0&w=710&url=';
            $("img").each(function(){
                var src = $(this).attr('src');
                if(pattern.test(src)){
                    var newsrc = prefix+src;
                    $(this).attr('src',newsrc);
                }
            });
        });
        $(function() {
            var pattern = /^https:\/\/mmbiz/;
            var prefix = 'http://img01.store.sogou.com/net/a/04/link?appid=0&w=710&url=';
            $("img").each(function(){
                var src = $(this).attr('src');
                if(pattern.test(src)){
                    var newsrc = prefix+src;
                    $(this).attr('src',newsrc);
                }

            });
        });
    </script>

    </body>
    <script type="text/javascript">
        var get = function () {
            var imgs = document.getElementById('gallery').getElementsByTagName('a');
            for (var i = 0; i < imgs.length; i++) {
                if (imgs[i].href.indexOf("site/") != -1) {
                    var kt = imgs[i].href.indexOf("site/") + 5;
                } else {
                    var kt = 0;
                }
                var href = imgs[i].href.substring(kt, imgs[i].href.length);
                imgs[i].setAttribute("href", decodeURIComponent(href));
            }
        }
        //处理文章宽度太宽问题和line-height太小问题
        var $thot = document.getElementById("obj_wh").getElementsByTagName("*");
        function zresize() {
            for (i = 0; i < $thot.length; i++) {
                if ($thot[i].offsetWidth > document.getElementById("obj_wh").offsetWidth) {
                    $thot[i].style.width = (document.getElementById("obj_wh").offsetWidth - 40) + 'px';
                }
                $thot[i].style.lineHeight = "normal";
            }
        }
        window.onload = function () {
            get();
            zresize();
            window.onresize = function () {
                zresize();
            }
        }

<?php if (!empty($signPackage)) { ?>
            wx.config({
                debug: false,
                appId: '<?php echo $signPackage["appId"]; ?>',
                timestamp: <?php echo $signPackage["timestamp"]; ?>,
                nonceStr: '<?php echo $signPackage["nonceStr"]; ?>',
                signature: '<?php echo $signPackage["signature"]; ?>',
                jsApiList: [
                    'checkJsApi',
                    'onMenuShareTimeline',
                    'onMenuShareAppMessage'
                ]
            });
            wx.ready(function () {

                // 2.2 监听“分享到朋友圈”按钮点击、自定义分享内容及分享结果接口 
                wx.onMenuShareTimeline({
                    desc: document.title, // 分享描述
                    title: document.title,
                    link: window.location.href,
                    imgUrl: '<?php echo Yii::app()->params->WEBROOT . Yii::app()->params->FILEFOLDER . Yii::app()->params->FILEPATH['sourcefile']['image']['medium'] . $model->filename . '.' . $model->ext; ?>',
                    type: '', // 分享类型,music、video或link，不填默认为link
                    dataUrl: '', // 如果type是music或video，则要提供数据链接，默认为空
                    trigger: function (res) {
                        alert('用户点击分享到朋友圈');
                    },
                    success: function (res) {
                        // alert('已分享到朋友圈');
                        var openid = $("#Transmit_openid").val();
                        var transmit_id = $("#Transmit_transmit_id").val();
                        var Ajax = new AjaxClass();         // 创建AJAX对象  
                        Ajax.Method = "POST";               // 设置请求方式为POST  
                        Ajax.Url = "<?php echo Yii::app()->createURL('systems/userModule/transmitmsg'); ?>";            // URL为default.asp  
                        Ajax.Async = true;                  // 是否异步  
                        Ajax.Arg = "openid=" + openid + "&transmit_id=" + transmit_id;               // POST的参数  
                        Ajax.CallBack = function (str)       // 回调函数  
                        {
                            //alert(str);
                            $('.popup_bj').show().find('.popup_con').show().find('h4').html(str);
                            // location.reload();
                        }
                        Ajax.Send();                        // 发送请求  
                    },
                    cancel: function (res) {
                        alert('已取消');
                    },
                    fail: function (res) {
                        // alert(JSON.stringify(res));
                    }
                });
                //发送给朋友
                wx.onMenuShareAppMessage({
                    desc: document.title, // 分享描述
                    title: document.title,
                    link: window.location.href,
                    imgUrl: '<?php echo Yii::app()->params->WEBROOT . Yii::app()->params->FILEFOLDER . Yii::app()->params->FILEPATH['sourcefile']['image']['medium'] . $model->filename . '.' . $model->ext; ?>',
                    type: '', // 分享类型,music、video或link，不填默认为link
                    dataUrl: '', // 如果type是music或video，则要提供数据链接，默认为空
                    success: function () {
                        // alert('已发送给朋友');
                        var openid = $("#Transmit_openid").val();
                        var transmit_id = $("#Transmit_transmit_id").val();
                        var Ajax = new AjaxClass();         // 创建AJAX对象  
                        Ajax.Method = "POST";               // 设置请求方式为POST  
                        Ajax.Url = "<?php echo Yii::app()->createURL('systems/userModule/transmitmsg'); ?>";            // URL为default.asp  
                        Ajax.Async = true;                  // 是否异步  
                        Ajax.Arg = "openid=" + openid + "&transmit_id=" + transmit_id;               // POST的参数  
                        Ajax.CallBack = function (str)       // 回调函数  
                        {
                            $('.popup_bj').show().find('.popup_con').show().find('h4').html(str);
                            //location.reload();
                        }
                        Ajax.Send();                        // 发送请求  
                    },
                    cancel: function () {
                        alert('转发好友失败');
                    }
                });
            });
            wx.error(function (res) {
                alert('处理失败');
            });
<?php } ?>

        
    </script>
</html>
