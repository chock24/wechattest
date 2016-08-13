<title>个人中心</title>
<body class="bj_fff">
    <section class="wrap">
        <div class="opp_header">
            <h2><?php
                if (!empty($appId)) {
                    if ($appId == 'wx0cd263ec9a49f194') {
                        echo '欧派家居商城'; 
                    } else if ($appId == 'wx2846a5047326ce12') {
                        echo '欧派定制';
                    }
                }
                ?></h2>
            <div class="user_info">
                <a href="<?php echo Yii::app()->createUrl('systems/userModule/user', array('openid' => @$model->openid)) ?>"> 
                    <div class="user_avatar user_info_avatar">
                        <img src="<?php echo @$model->headimgurl; ?>"></div></a>
                <div class="user_info_tet">
                    <p><?php echo @$model->nickname; ?>，您好！</p>
                    <p><a href="<?php echo Yii::app()->createUrl('systems/userModule/userlevel', array('id' => @$model->id)) ?>">会员等级：
                            <?php
                            $integral = @$model->integral;
                            if ($integral < 2000) {
                                echo 'V1';
                            } else if ($integral > 2000 && $integral < 10000) {
                                echo 'V2';
                            } else if ($integral > 10000 && $integral < 20000) {
                                echo 'V3';
                            } else {
                                echo 'V4';
                            }
                            ?></a></p>
                    <p>积分：<?php echo $integral; ?>分</p>
                    <p>优惠券：<?php
                        $number = 0;
                        if (!empty($couponexchange)) {
                            foreach ($couponexchange as $c) {
                                $number += $c->number;
                            }
                        }
                        echo $number;
                        ?>张</p>
                </div>
            </div>
        </div>
        <nav class="opp_nav">
            <ul>
                <li>
                    <a href="<?php echo Yii::app()->createUrl('systems/userModule/attendance', array('id' => @$model->id)) ?>">
                        <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/font/icon/nav/opp_nav_01.jpg" />
                        <span>签到</span>
                    </a>
                </li>
                <li>
                    <a href="<?php echo Yii::app()->createUrl('systems/userModule/integral', array('id' => @$model->id)) ?>">
                        <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/font/icon/nav/opp_nav_02.jpg" />
                        <span>赚积分</span>
                    </a>
                </li>
                <li>
                    <a href="<?php echo Yii::app()->createUrl('systems/userModule/share', array('id' => @$model->id)) ?>">
                        <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/font/icon/nav/opp_nav_03.jpg" />
                        <span>邀请好友</span>
                    </a>
                </li>
                <li>
                    <a href="<?php echo Yii::app()->createUrl('systems/userModule/transmit', array('type' => '9')) ?>">
                        <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/font/icon/nav/opp_nav_04.jpg" />
                        <span>有奖活动</span>
                    </a>
                </li>
                <li>
                    <a href="<?php echo Yii::app()->createUrl('systems/userModule/memberdeals', array('id' => @$model->id)) ?>">
                        <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/font/icon/nav/opp_nav_05.jpg" />
                        <span>会员尊享</span>
                    </a>
                </li>
                <li>
                    <a href="http://www.oppein.cn/oppein/edmsys/index.php?r=site/mapp&c=wxbm141010">
                        <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/font/icon/nav/opp_nav_06.jpg" />
                        <span>在线免费咨询</span>
                    </a>
                </li>
                <li>
                    <a href="<?php echo Yii::app()->createUrl('systems/userModule/gift') ?>">
                        <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/font/icon/nav/opp_nav_07.jpg" />
                        <span>礼品商城</span>
                    </a>
                </li>
                <li>
                    <a href="<?php echo Yii::app()->createUrl('systems/userModule/news', array('type' => '7')) ?>">
                        <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/font/icon/nav/opp_nav_08.png" />
                        <span>家装前沿</span>
                    </a>
                </li>
                <li>
                    <a href="<?php echo Yii::app()->createUrl('systems/userModule/allhouse', array('id' => @$model->id)) ?>">
                        <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/font/icon/nav/opp_nav_09.jpg" />
                        <span>全屋家居</span>
                    </a>
                </li>
            </ul>
        </nav>
        <footer class="opp_footer">
            <a href="<?php echo Yii::app()->createUrl('systems/userModule/gift') ?>">全部礼品</a>
        </footer>
    </section>
</body>
<?php
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
$url = "$protocol$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
?>


<a href="https://open.weixin.qq.com/connect/oauth2/authorize?appId=<?php echo $appId; ?>&redirect_uri=<?php echo $url; ?>&response_type=code&scope=snsapi_base&state=1#wechat_redirect"  title="启动签到功能">
    <span id='getopenid' style="display: none"></span>
</a>
<script language="javascript" type="text/javascript">
<?php
$openid = @Yii::app()->session['openid'];

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

