<title>礼品商城</title>
<body>
    <section class="wrap">
        <div class="gift_shop_head">
            <div class="head_wd">
                <div class="op_logo"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/font/op_logo.jpg"></div>
                <h2>欧派礼品商城 </h2>
            </div>
        </div>
        <section class="gift_shop_cont">
            <div class="type_name">

                <?php foreach ($gift_type as $key => $t) { ?>
                    <a href="<?php echo Yii::app()->createUrl('systems/userModule/gift', array('type_id' => $t->id)) ?>" class="<?php
                    if (@$_GET['type_id'] == $t->id) {
                        echo 'type_bg';
                    }
                    ?>"><?php echo $t->name; ?></a>
                   <?php } ?>
                <a href="<?php echo Yii::app()->createUrl('systems/userModule/gift') ?>" class="<?php
                if (@$_GET['type_id'] == 0) {
                    echo 'type_bg';
                }
                ?>">全部商品</a>
            </div>
            <nav class="gift_list_out">
                <div class="gift_list_out_con">
                    <?php
                    if (!empty($gift)) {
                        foreach ($gift as $g) {
                            ?>
                            <div class="gift_list">
                                <a href="<?php echo Yii::app()->createUrl('systems/userModule/gift_detail', array('gift_id' => $g->id)) ?>">
                                    <div class="gift_img">
                                        <img src="<?php echo Yii::app()->params->WEBROOT . Yii::app()->params->FILEFOLDER . Yii::app()->params->FILEPATH['sourcefile']['image']['medium'] . $g->image_src; ?>" />
                                    </div>
                                    <div class="gift_txt">
                                        <span><?php echo $g->name; ?> </span>
                                        <span>会员价：<em><i><?php echo $g->integral; ?></i>分</em></span>
                                        <!--<span>库存:<i><?php /*echo $g->count_stock; */?></i></span>-->
                                        <em class="gift_list_del">原价：<?php echo $g->prizevalue;?>元</em>
                                    </div>
                                </a>
                                <div data-href="<?php echo Yii::app()->createUrl('systems/userModule/address_list', array('gift_id' => $g->id)) ?>" class="exchange">兑换</div><!-- 用户兑换地址 -->
                            </div>
                            <?php
                        }
                    }
                    ?>
                    <?php
                    if (!empty($gift_null)) {
                        foreach ($gift_null as $gn) {
                            ?>

                            <div class="gift_list">
                                <a href="<?php echo Yii::app()->createUrl('systems/userModule/gift_detail', array('gift_id' => $gn->id)) ?>">
                                    <div class="gift_img">
                                        <img src="<?php echo Yii::app()->params->WEBROOT . Yii::app()->params->FILEFOLDER . Yii::app()->params->FILEPATH['sourcefile']['image']['medium'] . $gn->image_src; ?>" />
                                    </div>
                                    <div class="gift_txt">
                                        <span><?php echo $gn->name; ?> </span>
                                        <span>会员价：<em><i><?php echo $gn->integral; ?></i>分</em></span>
<!--                                        <span>库存:<i><?php //echo $gn->count_stock; ?></i></span>-->
                                        <em class="gift_list_del">原价：<?php echo $gn->prizevalue;?>元</em>
                                    </div>
                                </a>
                                <div data-href="<?php echo Yii::app()->createUrl('systems/userModule/address_list', array('gift_id' => $gn->id)) ?>" class="exchange">兑换</div><!-- 用户兑换地址 -->
                            </div>
                            <?php
                        }
                    }
                    ?>
                </div>
            </nav>
        </section>
        <div class="none popup_bj">
            <div class="popup">

                <div class="none popup_con">
                    <a href="javascript:;" class="popup_x"></a>
                    <div class="pop_icon"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/font/popup/popup_yebz.png" /></div>
                    <h4>积分余额不足!</h4>
                    <em>您本次最多可用积分<?php echo $user->integral; ?>分!</em>
                </div>

                <div class="none popup_con popup_bu_int">
                    <a href="javascript:;" class="popup_x"></a>
                    <h5>将扣除积分<span>785分</span>，确定兑换</h5>
                    <div class="popup_bu_int_but">
                        <a class="left pop_but" href="javascript:;">是</a>
                        <a class="right pop_but bad" href="javascript:;">否</a>
                    </div>
                </div>

                <div class="none popup_con">
                    <a href="javascript:;" class="popup_x"></a>
                    <div class="pop_icon"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/font/popup/popup_cg.png" /></div>
                    <h3>兑换成功</h3>
                </div>
            </div>
        </div>
    </section>
</body>
<script type="text/javascript">
    $(function () {
        $('.exchange').click(function () {
            var total = <?php echo $user->integral; ?>;//用户多少积分
            var tex = $(this).prev().find('em').find('i').text();
            $('.popup_bj').show();
            if (tex <= total) {//显示兑换不成功
                $('.popup_bj').find('.popup_bu_int').show().find('h5 span').html(tex);
                $('.popup_bj').find('.popup_bu_int').find('.left.pop_but').attr('href', $(this).attr('data-href'));
                $('.pop_but.bad').unbind().click(function () {
                    $('.popup_bj').hide().find('.popup_con').hide();
                });
            } else {//显示兑换成功
                $('.popup_bj').find('.popup_con').eq(0).show().find('h5 span').html(tex);
                setTimeout(function () {
                    location.href = '<?php echo Yii::app()->createUrl('systems/userModule/homepage') ?>'
                }, 2000);
            }
        });
        if ('<?php echo Yii::app()->user->hasFlash('success') ?>') {//兑换成功提示
            $('.popup_bj').show().find('.popup_con').eq(2).show();
            setTimeout(function () {
                location.href = '<?php echo Yii::app()->createUrl('systems/userModule/homepage') ?>'
            }, 2000);
        }
        $('.gift_list').each(function () {//查看库存是否为0，为0不给于兑换
            var tex = $(this).find('i').eq(1).text();
            if (tex <= 0) {
                $(this).find('.exchange').unbind().css('background', '#c2c2c2');
            }
        });
    })
</script>
