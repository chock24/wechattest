<head>
    <title>赚积分</title>
</head>
<body class="bj_fff">
    <section class="wrap">
        <div class="toearn_points">

                <div class="toearn_points_bg banner">
                    <div class="banner_com">
                        <ul>
                            <?php if(!empty($dataProvider)){foreach($dataProvider as $k=>$v){?>
                                <li><a href="<?php echo $v['url'];?>"><img src="<?php echo Yii::app()->params->WEBROOT . Yii::app()->params->FILEFOLDER . Yii::app()->params->FILEPATH['sourcefile']['image']['poster'].$v['img_url']; ?>"></a></li>
                            <?php }}else{ ?>
                               <li><a href="javascript:" <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/font/header/transmit_hed.jpg"></a></li>
                            <?php }?>
                        </ul>
                    </div>
                    <div class="banner_li"><?php /* 滚动图片数量原点 */ ?></div>
                </div>
            <div class="toearn_points_con">
                <ul>
                    <li>
                        <a href="<?php echo Yii::app()->createUrl('systems/userModule/share') ?>">
                            <div class="pic"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/font/integral/ask_hy.jpg"></div>
                            <div class="tit">
                                <div>邀请好友</div>
                                <div class="person"><?php echo(rand(700, 10000)); ?> 人参加活动</div>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo Yii::app()->createUrl('systems/userModule/attendance') ?>">
                            <div class="pic"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/font/integral/qiand.jpg"></div>
                            <div class="tit">
                                <div>每日签到</div>
                                <div class="person"><?php echo(rand(2000, 10000)); ?> 人参加活动</div>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo Yii::app()->createUrl('systems/userModule/news') ?>">
                            <div class="pic"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/font/integral/fenxyj.jpg"></div>
                            <div class="tit">
                                <div>分享有奖</div>
                                <div class="person"><?php echo(rand(500, 10000)); ?> 人参加活动</div>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo Yii::app()->createUrl('systems/userModule/transmit', array('type' => 9)) ?>">
                            <div class="pic"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/font/integral/zxhd.jpg"></div>
                            <div class="tit">
                                <div>最新活动</div>
                                <div class="person"><?php echo(rand(600, 10000)); ?> 人参加活动</div>
                            </div>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </section>
</body>
