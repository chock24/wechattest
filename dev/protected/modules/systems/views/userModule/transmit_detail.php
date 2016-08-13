<title><?php echo $model->title; ?></title>
<body>
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'user-form',
        // Please note: When you enable ajax validation, make sure the corresponding
        // controller action is handling ajax validation correctly.
        // There is a call to performAjaxValidation() commented in generated controller code.
        // See class documentation of CActiveForm for details on this.
        'enableAjaxValidation' => false,
    ));
    ?>

    <?php
    $openid = @Yii::app()->request->getParam('openid');
    if (empty($openid)) {
        $openid = Yii::app()->session['openid'];
    }
    if (!empty($openid)) {
        echo $form->hiddenField($model, 'openid', array('value' => @$openid));
    }
    ?>
    <?php
    if (!empty($model)) {
        echo $form->hiddenField($model, 'transmit_id', array('value' => @$model->id));
        echo $form->hiddenField($model, 'type_id', array('value' => @$model->type_id));
    }
    ?>
    <?php
    if (!empty($openid)) {
        require_once "jssdk.php";
        $appId = $publicmodel->appid;
        $appSecret = $publicmodel->appsecret;
        $jssdk = new JSSDK($appId, $appSecret);
        $signPackage = $jssdk->GetSignPackage();
    }
    ?>
    <?php
    $this->endWidget();
    ?>
    <section class="wrap">
        <?php
        if (!empty($model->transmit_type->name)) {
            if ($model->transmit_type->name == '下线活动') {
                ?>
                <div class="details_columns_head">

                    <ul>
                        <li><a href="javascript:;" class="cur">下线活动</a></li>
                        <li><a href="<?php echo Yii::app()->createUrl('systems/userModule/winning') ?>">中奖名单</a></li>
                    </ul>
                </div>
                <?php
            }
        }
        ?>

        <div id="js_article" class="rich_media">
            <div class="top_banner" id="js_top_ad_area"></div>
            <div class="rich_media_inner">
                <div id="page-content">
                    <div id="img-content" class="rich_media_area_primary">
                        <h2 id="activity-name" class="rich_media_title"><?php echo $model->title; ?></h2>
                        <div class="rich_media_meta_list">
                            <em class="rich_media_meta rich_media_meta_text" id="post-date"><?php echo date('m.d', $model->time_start); ?>-<?php echo date('m.d', $model->time_end); ?></em>
                            <!--<em class="rich_media_meta rich_media_meta_text">欧派家居商城</em>-->
                            <a id="post-user" href="javascript:;" class="rich_media_meta rich_media_meta_link rich_media_meta_nickname">欧派家居商城</a>
                        </div>
                        <div id="js_content" class="rich_media_content ">
                            <?php if ($model->show_cover_pic == 1) { ?>
                                <p>
                                    <img src="<?php echo Yii::app()->params->WEBROOT . Yii::app()->params->FILEFOLDER . Yii::app()->params->FILEPATH['sourcefile']['image']['medium'] . $model->image_src; ?>" />
                                </p>
                            <?php } ?>
                            <?php echo $model->content; ?>
                        </div>
                        <div id="js_toobar2" class="rich_media_tool">
                            <a href="<?php echo @$model->content_source_url ?>" id="js_view_source" class="media_tool_meta meta_primary">阅读原文</a>
                            <a href="javascript:;">阅读:<?php echo $model->number + 1; ?></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="popup_bj">
            <div class="popup">
                <!-- 获得积分窗口 -->
                <div class="popup_con">
                    <a href="javascript:;" class="popup_x"></a>
                    <div class="pop_icon">
                        <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/font/popup/popup_jf.png" />
                    </div>
                    <h4></h4>
                </div>
            </div>
        </div>
    </section>
</body>
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script type="text/javascript">
    $(function () {
        $('.rich_media_content ').find('a').each(function () {
            $(this).attr('href', decodeURIComponent($(this).attr('href')));
        });
    })
</script>
<script>
    function AjaxClass()
    {
        var XmlHttp = false;
        try
        {
            XmlHttp = new XMLHttpRequest();        //FireFox专有  
        }
        catch (e)
        {
            try
            {
                XmlHttp = new ActiveXObject("MSXML2.XMLHTTP");
            }
            catch (e2)
            {
                try
                {
                    XmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
                }
                catch (e3)
                {
                    alert("你的浏览器不支持XMLHTTP对象，请升级到IE6以上版本！");
                    XmlHttp = false;
                }
            }
        }

        var me = this;
        this.Method = "POST";
        this.Url = "";
        this.Async = true;
        this.Arg = "";
        this.CallBack = function () {
        };
        this.Loading = function () {
        };

        this.Send = function ()
        {
            if (this.Url == "")
            {
                return false;
            }
            if (!XmlHttp)
            {
                return IframePost();
            }

            XmlHttp.open(this.Method, this.Url, this.Async);
            if (this.Method == "POST")
            {
                XmlHttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            }
            XmlHttp.onreadystatechange = function ()
            {
                if (XmlHttp.readyState == 4)
                {
                    var Result = false;
                    if (XmlHttp.status == 200)
                    {
                        Result = XmlHttp.responseText;
                    }
                    XmlHttp = null;

                    me.CallBack(Result);
                }
                else
                {
                    me.Loading();
                }
            }
            if (this.Method == "POST")
            {
                XmlHttp.send(this.Arg);
            }
            else
            {
                XmlHttp.send(null);
            }
        }

        //Iframe方式提交  
        function IframePost()
        {
            var Num = 0;
            var obj = document.createElement("iframe");
            obj.attachEvent("onload", function () {
                me.CallBack(obj.contentWindow.document.body.innerHTML);
                obj.removeNode()
            });
            obj.attachEvent("onreadystatechange", function () {
                if (Num >= 5) {
                    obj.removeNode()
                }
            });
            obj.src = me.Url;
            obj.style.display = 'none';
            document.body.appendChild(obj);
        }
    }


<?php if (!empty($openid)) { ?>
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
                imgUrl: '<?php echo Yii::app()->params->WEBROOT . Yii::app()->params->FILEFOLDER . Yii::app()->params->FILEPATH['sourcefile']['image']['medium'] . $model->image_src; ?>',
                type: '', // 分享类型,music、video或link，不填默认为link
                dataUrl: '', // 如果type是music或video，则要提供数据链接，默认为空
                trigger: function (res) {
                    alert('用户点击分享到朋友圈');
                },
                success: function (res) {
                    // alert('已分享到朋友圈');
                    var openid = $("#Transmit_openid").val();
                    var type_id = $("#Transmit_type_id").val();
                    var transmit_id = $("#Transmit_transmit_id").val();
                    var Ajax = new AjaxClass();         // 创建AJAX对象  
                    Ajax.Method = "POST";               // 设置请求方式为POST  
                    Ajax.Url = "<?php echo Yii::app()->createURL('systems/userModule/transmitmsg'); ?>";            // URL为default.asp  
                    Ajax.Async = true;                  // 是否异步  
                    Ajax.Arg = "openid=" + openid + "&transmit_id=" + transmit_id + "&type_id=" + type_id;               // POST的参数  
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
                imgUrl: '<?php echo Yii::app()->params->WEBROOT . Yii::app()->params->FILEFOLDER . Yii::app()->params->FILEPATH['sourcefile']['image']['medium'] . $model->image_src; ?>',
                type: '', // 分享类型,music、video或link，不填默认为link
                dataUrl: '', // 如果type是music或video，则要提供数据链接，默认为空
                success: function () {
                    // alert('已发送给朋友');
                    var openid = $("#Transmit_openid").val();
                    var type_id = $("#Transmit_type_id").val();
                    var transmit_id = $("#Transmit_transmit_id").val();
                    var Ajax = new AjaxClass();         // 创建AJAX对象  
                    Ajax.Method = "POST";               // 设置请求方式为POST  
                    Ajax.Url = "<?php echo Yii::app()->createURL('systems/userModule/transmitmsg'); ?>";            // URL为default.asp  
                    Ajax.Async = true;                  // 是否异步  
                    Ajax.Arg = "openid=" + openid + "&transmit_id=" + transmit_id + "&type_id=" + type_id;               // POST的参数  
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

    $(function () {
        //处理文章宽度太宽问题
        $('#js_content').find('*').each(function () {
            if ($(this).width() > $(window).width()) {
                $(this).css('width', $(window).width() - 40);
            }
            var lHei = parseInt($(this).css('line-height'));
            var fSize = parseInt($(this).css('font-size'));
            if (lHei < fSize) {
                $(this).css('line-height', /*parseInt($(this).css('fontSize'))+ 4 + $(this).css('line-height').replace(/[^a-z]+/g,"")*/'normal');
            }
        });
    })

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
