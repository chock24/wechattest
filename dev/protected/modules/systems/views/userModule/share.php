<title>邀请好友</title>
<body class="bj_fff">

    <section class="wrap">

        <div class="invitation">
            <div class="user_level">
                <div class="user_avatar invitation_user"><img src="<?php echo $user->headimgurl; ?>"></div>
                <div class="invitation_tit">
                    <h3><span><?php echo $user->nickname; ?></span>，您好！</h3>
                    <div class="invitation_nav">
                        <div class="inv_gray">
                            <div class="inv_red" style="width: <?php
                            $zz = $user->integral;
                            if ($zz == 0) {
                                echo 0;
                            } else if ($zz > 0 && $zz <= 2000) {
                                echo ($zz / 20000 * 3 * 100) . '%';
                            } else if ($zz > 2000 && $zz <= 10000) {
                                echo ($zz / 20000 * 100 + 15) . '%';
                            } else if ($zz > 10000 && $zz <= 15000) {
                                echo ($zz / 20000 * 100 + 10) . '%';
                            } else if ($zz > 15000 && $zz <= 20000) {
                                echo ($zz / 20000 * 100) . '%';
                            }if ($zz > 20000) {
                                echo '100%';
                            }
                            ?>;">
                                <a class="inv_v1 inv_box inv_cur">V1</a>
                                <a class="inv_v2 inv_box <?php
                                if ($user->integral > 2000) {
                                    echo 'inv_cur';
                                }
                                ?>">V2</a>
                                <a class="inv_v3 inv_box <?php
                                if ($user->integral > 10000) {
                                    echo 'inv_cur';
                                }
                                ?>">V3</a>
                                <a class="inv_v4 inv_box <?php
                                if ($user->integral > 20000) {
                                    echo 'inv_cur';
                                }
                                ?>">V4</a>
                                <div class="inv_num">
                                    <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/font/icon/kuang.png">
                                    <span class="inv_shu"><?php echo $user->integral; ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="clear"></div>
            <div class="invitation_wz">
                邀请好友关注欧派家居商城公众号，<br>即可获得10积分/人奖励哦！
                <p>还等神马，<span>马上邀请吧！</span></p>
            </div>
            <div class="invitation_erweima">
                <?php if (!empty($quickmoark)) { ?>
                    <img alt="" src="<?php echo Yii::app()->request->hostInfo . '/' . $quickmoark->path; ?>">
                <?php }
                ?>
            </div>
            <div class="invitation_character">扫一扫，即刻关注成功！积分到手！</div>
            <!--<div class="invitation_character"><a href="<?php /* echo Yii::app()->createUrl('systems/userModule/friend_relation') */ ?>">跳转关系页面</a></div>-->
        </div>
        <div class="invitation_bottom_but">
            <a href="<?php echo Yii::app()->createUrl('systems/userModule/friend_relation', array('id' => $user->id)) ?>">
                我的关系
                <span></span>
            </a>
        </div>
        <!-- 提示分享按钮 -->
        <div class="none invite_friends">
            <div class="invite_friends_pic"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/font/icon/arrows.png"></div>
            <div class="invite_friends_share">点击右上角<br>分享您的二维码,邀请好友吧</div>
        </div>
    </section>
    <!--获取浏览者 openid-->

    <!--获取结束-->
    <script language="javascript" type="text/javascript">
<?php
if (Yii::app()->request->getparam('state') == '1') {
    
} else {
    ?>
            function getopenid()
            {
                //$("#getopenid").click();
            }
            getopenid();
<?php } ?>
    </script>
    <?php
    require_once "jssdk.php";
    $appId = $publicmodel->appid;
    $appSecret = $publicmodel->appsecret;
    $jssdk = new JSSDK($appId, $appSecret);
    $signPackage = $jssdk->GetSignPackage();
    $requesturl = Yii::app()->request->hostInfo;
    if (!empty($user_id)) {
        $url = Yii::app()->createUrl('systems/userModule/sharefriend', array('user_id' => $user_id));
    } else {
        $url = Yii::app()->createUrl('systems/userModule/sharefriend');
    }
    $to_url = $requesturl . $url;
    $img_url = $requesturl . '/images/font/wx_logo.jpg';
    ?>
</body>
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
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
                        alert(false);
                        obj.removeNode()
                    }
                });
                obj.src = me.Url;
                obj.style.display = 'none';
                document.body.appendChild(obj);
            }
        }



        wx.config({
            debug: false,
            appId: '<?php echo $signPackage["appId"]; ?>',
            timestamp: <?php echo $signPackage["timestamp"]; ?>,
            nonceStr: '<?php echo $signPackage["nonceStr"]; ?>',
            signature: '<?php echo $signPackage["signature"]; ?>',
            jsApiList: [
                'checkJsApi',
                'onMenuShareTimeline',
                'onMenuShareAppMessage',
            ]
        });
        wx.ready(function () {
            // 2.2 监听“分享到朋友圈”按钮点击、自定义分享内容及分享结果接口 
            wx.onMenuShareTimeline({
                desc: document.title, // 分享描述
                title: document.title,
                link: '<?php echo $to_url; ?>',
                imgUrl: '<?php echo $img_url; ?>',
                type: '', // 分享类型,music、video或link，不填默认为link
                dataUrl: '', // 如果type是music或video，则要提供数据链接，默认为空
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
                    // alert(JSON.stringify(res));
                }
            });
            //发送给朋友
            wx.onMenuShareAppMessage({
                desc: document.title, // 分享描述
                title: document.title,
                link: '<?php echo $to_url; ?>',
                imgUrl: '<?php echo $img_url; ?>',
                type: '', // 分享类型,music、video或link，不填默认为link
                dataUrl: '', // 如果type是music或video，则要提供数据链接，默认为空
                success: function () {
                    alert('已分享');
                },
                cancel: function () {
                    alert('转发好友失败');
                }
            });
        });
        wx.error(function (res) {
            alert('处理失败');
        });
        $(function () {
            capture_c($('.invitation_tit h3 span'), 4);//控制用户名字字数
            //写cookie
            function setCookie(name, value) {
                var Days = 30;
                var exp = new Date();
                exp.setTime(exp.getTime() + Days * 24 * 60 * 60 * 1000);
                document.cookie = name + "=" + escape(value) + ";expires=" + exp.toGMTString();
            }
            //读取cookie
            function getCookie(name) {
                var arr, reg = new RegExp("(^| )" + name + "=([^;]*)(;|$)");
                if (arr = document.cookie.match(reg))
                    return unescape(arr[2]);
                else
                    return null;
            }
            //判断是第一次点击进来就显示分享提示
            var invite_friends = 'show';
            if (getCookie(invite_friends) != 'hide') {
                $('.invite_friends').show();
                $('.invite_friends').click(function () {
                    $(this).hide();
                });
            }
            setCookie(invite_friends, 'hide');
        })
</script>