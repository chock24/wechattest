<title>
    <?php
    $type = Yii::app()->request->getParam('type');
    if (empty($type)) {
        echo '家装前沿';
    } else if ($type == 11) {
        echo '定制攻略';
    } else if ($type == 12) {
        echo '家居资讯';
    } else if ($type == 13) {
        echo '晒家分享';
    } else if ($type == 7) {
        echo '精选文章';
    }
    ?>
</title>
<body>
    <section class="wrap">
        <div class="invitation day_read_user">
            <div class="user_level">
                <div class="user_avatar invitation_user"><img src="<?php echo $user->headimgurl; ?>"></div>
                <div class="invitation_tit">
                    <h3><span><?php echo $user->nickname; ?></span>，您好！</h3>
                    <div class="invitation_nav">
                        <div class="inv_gray">
                            <div class="inv_red" style="width:<?php
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
        </div>
        <div class="the_house_out day_read_con">
            <div class="gtbio_nav day_read_tit">
                <ul>
                    <?php
                    if (!empty($transmit_type)) {
                        foreach ($transmit_type->childrens as $key => $t) {
                            ?>
                            <li><a href="<?php echo Yii::app()->createUrl('systems/userModule/news', array('type' => $t->id)) ?>" class="<?php
                                if (@$_GET['type'] == $t->id) {
                                    echo 'cur';
                                } elseif ($key == 0 && @$_GET['type'] == 0) {
                                    echo 'cur';
                                }
                                ?>"><?php echo $t->name; ?></a></li>
                                <?php
                            }
                        }
                        ?>
                </ul>
            </div>

                <div class="the_house_center adaily_reading_header banner">
                    <div class="banner_com">
                        <ul>
                            <?php if(!empty($dataProvider)){foreach($dataProvider as $k=>$v){?>
                                <li><a href="<?php echo $v['url'];?>"><img src="<?php echo Yii::app()->params->WEBROOT . Yii::app()->params->FILEFOLDER . Yii::app()->params->FILEPATH['sourcefile']['image']['poster'].$v['img_url']; ?>"></a></li>
                            <?php }}else{?>
                                <li><a href="javascript:;"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/font/header/news_hed.jpg"></a></li>
                            <?php }?>
                            <!--<li><a href="javascript:;"><img src="images/img/head.jpg"></a></li>
                            <li><a href="javascript:;"><img src="images/personal_data_hea.jpg"></a></li>-->
                        </ul>
                    </div>
                    <div class="banner_li"><?php /* 滚动图片数量原点 */ ?></div>
                </div>

<!--            <div class="the_house_center adaily_reading_header" ><a href="--><?php //echo $v['url']; ?><!--"><img src="--><?php //echo Yii::app()->params->WEBROOT . Yii::app()->params->FILEFOLDER . Yii::app()->params->FILEPATH['sourcefile']['image']['poster'].$v['img_url']; ?><!--"></a></div>-->

<!--             <div class="the_house_center adaily_reading_header"><img src="--><?php //echo Yii::app()->request->baseUrl; ?><!--/images/font/header/news_hed.jpg"></div>-->

            <?php
            if (!empty($transmit)) {
                foreach ($transmit as $tr) {
                    ?>
                    <div class="the_house_list">
                        <a href="<?php echo Yii::app()->createUrl('systems/userModule/transmit_detail', array('id' => $tr->id,'openid' => Yii::app()->session['openid'])); ?>">
                            <div class="the_house_cont">
                                <h3><?php echo $tr->title; ?></h3>
                                <!--<p class="the_house_txt"><i><?php /* echo $tr->description; */ ?></i><em>查看详细 >></em></p>-->
                            </div>
                            <div class="the_house_img"><img src="<?php echo Yii::app()->params->WEBROOT . Yii::app()->params->FILEFOLDER . Yii::app()->params->FILEPATH['sourcefile']['image']['medium'] . $tr->image_src; ?>" /></div>
                        </a>
                    </div>
                    <?php
                }
            }
            ?>
        </div>
    </section>
    <script>
        $(function () {
            //截取字符串
            capture_c($('.invitation_tit h3 span'), 4);//控制用户名字字数
            capture_c($('.the_house_cont h3'), 36);
            capture_c($('.the_house_txt i'), 55);
        })
    </script>
</body>