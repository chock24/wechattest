<title>有奖活动</title>
<body>
    <section class="wrap">
        <!--<div class="gtbio_bg"><img src="<?php /*echo Yii::app()->request->baseUrl; */?>/images/font/header/transmit_hed.jpg"></div>-->
        <div class="gtbio_bg banner">
            <div class="banner_com">
                <ul>
                    <?php if(!empty($dataProvider)){foreach($dataProvider as $k=>$v){?>
                    <li><a href="<?php echo $v['url'];?>"><img src="<?php echo Yii::app()->params->WEBROOT . Yii::app()->params->FILEFOLDER . Yii::app()->params->FILEPATH['sourcefile']['image']['poster'].$v['img_url']; ?>"></a></li>
                    <?php }}else{?>
                    <li><a href="javascript:;"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/font/header/transmit_hed.jpg"></a></li>
                    <?php }?>
                </ul>
            </div>
            <div class="banner_li"><?php /* 滚动图片数量原点 */ ?></div>
        </div>
        <div class="gtbio_nav">
            <ul>
                <?php
                if (!empty($transmit_type)) {
                    foreach ($transmit_type->childrens as $key => $t) {
                        ?>
                        <li><a href="<?php echo Yii::app()->createUrl('systems/userModule/transmit', array('type' => $t->id)) ?>" class="<?php
                            if (@$_GET['type'] == $t->id) {
                                echo 'cur';
                            } elseif ($key == 0 && @$_GET['type'] == 0) {
                                // echo 'cur';
                            }
                            ?>"><?php echo $t->name; ?></a></li>    
                            <?php
                        }
                    }
                    ?>
<!--<li><a href="<?php /* echo Yii::app()->createUrl('systems/userModule/winning', array('type' => 'winning')) */ ?>" class='<?php /*                    if (@$_GET['type'] == 'winning') {
                      echo 'cur';
                      }
                     */ ?>'>查看中奖</a></li>-->
            </ul>
        </div>
        <div class="gtbio_con">
            <ul>
                <?php
                if (!empty($transmit)) {
                    foreach ($transmit as $tr) {
                        ?>
                        <li>
                            <a href="<?php echo Yii::app()->createUrl('systems/userModule/transmit_detail', array('id' => $tr->id, 'openid' => Yii::app()->session['openid'])); ?>">
                                <div class="pic"><img src="<?php echo Yii::app()->params->WEBROOT . Yii::app()->params->FILEFOLDER . Yii::app()->params->FILEPATH['sourcefile']['image']['medium'] . $tr->image_src; ?>" /></div>
                                <div class="box">
                                    <div class="tit" data-id="<?php echo $tr->status; ?>"><?php echo $tr->title; ?></div>
                                    <div class="timer"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/font/icon/iconfont-androidalarmclock2.png"><span><?php echo date('m.d', $tr->time_start); ?>-<?php echo date('m.d', $tr->time_end); ?></span></div>
                                    <div class="different">
                                        <span class="star">
                                            <span>难度</span>
                                            <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/font/icon/iconfont-xingxing%203.png">
                                            <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/font/icon/iconfont-xingxing%203.png">
                                            <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/font/icon/iconfont-xingxing%203.png">
                                            <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/font/icon/iconfont-xingxing%203.png">
                                        </span>
                                        <span class="person"><?php echo $tr->number; ?>人参加活动</span>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <?php
                    }
                }
                ?>

            </ul>
        </div>
        <div class="popup_bj">
            <div class="popup">
                <div class="none popup_con">
                    <a href="javascript:;" class="popup_x"></a>
                    <div class="pop_icon"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/font/popup/popup_wks.png" /></div>
                    <h4>活动尚未开始!</h4>
                    <h4>敬请关注!</h4>
                </div>
                <div class="none popup_con">
                    <a href="javascript:;" class="popup_x"></a>
                    <div class="pop_icon"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/font/popup/popup_hdjs.png" /></div>
                    <h4>该活动已经结束!</h4>
                    <em>精彩活动将不断更新，<br>亲，请持续关注!</em>
                </div>
            </div>
        </div>
    </section>
    <!--下面代码 判断活动尚未开始的 -->
<!--    <script type="text/javascript">
        $(function () {
            capture_c($('.gtbio_con .tit'),18);
            $('.gtbio_con').find('li').each(function () {
                if ($(this).find('.tit').attr('data-id') == 0) {
                    $(this).find('.person').html('活动尚未开始');
                    /*$(this).find('a').click(function () {
                        $('.popup_bj').show().find('.popup_con').eq(0).show();
                        return false;
                    });*/
                } else if ($(this).find('.tit').attr('data-id') == 2) {
                    $(this).find('.person').html('活动已经结束');
                    /*$(this).find('a').click(function () {
                        $('.popup_bj').show().find('.popup_con').eq(1).show();
                        return false;
                    });*/
                }
            });
        })
    </script>-->
</body>