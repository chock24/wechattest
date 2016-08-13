
<title>个人中心</title>

<body>
    <section class="wrap">
        <div class="member_core_header">
            <div class="user_avatar"><img src="<?php echo @$model->headimgurl; ?>"></div>
            <h3><a href="<?php echo Yii::app()->createUrl('systems/userModule/userlevel', array('id' => @$model->id)) ?>"><?php echo $model->nickname; ?>，会员等级：  <?php
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
                    ?></a></h3>
        </div>
        <div class="organizing_data">
            <ul>
                <li>
                    <a href="<?php echo Yii::app()->createUrl('systems/userModule/userdata', array('openid' => @$model->openid)) ?>">
                        <i><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/font/icon/iconfont-wodeziliao.png" /></i>
                        完善个人资料
                    </a>
                </li>
                <li>
                    <a href="<?php echo Yii::app()->createUrl('systems/userModule/userlevel', array('id' => @$model->id)) ?>">
                        <i><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/font/icon/iconfont-44444.png" /></i>
                        会员政策
                    </a>
                </li>
                <li>
                    <a href="<?php echo Yii::app()->createUrl('systems/userModule/aboutintegral') ?>">
                        <i><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/font/icon/iconfont-pingfenjilu.png" /></i>
                        积分规则
                    </a>
                </li>
            </ul>
        </div>

        <div class="member_core_tit">我的钱包</div>
        <div class="member_core_con">
            <ul>
                <li>
                    <a href="<?php echo Yii::app()->createUrl('systems/userModule/coupon', array('openid' => @$model->openid)) ?>">
                        <i><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/font/icon/iconfont-quan1.png" /></i>
                        <h4>优惠券</h4>
                        <span class="right"><?php
                            $number = 0;
                            foreach ($couponexchange as $c) {
                                $number += $c->number;
                            }
                            echo $number;
                            ?>张<em></em></span>
                    </a>
                </li>
                <li>
                    <a href="<?php echo Yii::app()->createUrl('systems/userModule/integraluser', array('user_id' => @$model->id,'num'=>10)) ?>">
                        <i><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/font/icon/iconfont-jifen.png" /></i>
                        <h4>积分</h4>
                        <span class="right"><?php echo @$model->integral; ?>分<em></em></span>
                    </a>
                </li>
                <li>
                    <a href="<?php echo Yii::app()->createUrl('systems/userModule/giftexchange') ?>">
                        <i><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/font/icon/iconfont-pingfenjilu.png" /></i>
                        <h4>礼品兑换记录</h4>
                    </a>
                </li>
                <li>
                    <a href="<?php echo Yii::app()->createUrl('systems/userModule/address_list', array('id' => @$model->id)) ?>">
                        <i><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/font/icon/iconfont-dizhi.png" /></i>
                        <h4>管理收货地址</h4>
                    </a>
                </li>
                <li>
                    <a href="<?php echo Yii::app()->createUrl('systems/userModule/transmituser') ?>">
                        <i><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/font/icon/iconfont-fenxiang.png" /></i>
                        <h4>我的分享</h4>
                    </a>
                </li>
            </ul>
        </div>
    </section>
</body>
