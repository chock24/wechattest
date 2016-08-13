<title>礼品 详情</title>

<body>
    <section class="wrap">
        <div class="description">
            <div class="goods_top">

                <div class="goods_top_img">
                    <div class="goods_top_img_com">
                        <ul>

                            <?php if(!empty($gift->image_src)){
                                    $imgsrc=trim($gift->image_src,',');
                                    $imgarr=explode(',',$imgsrc);
                            foreach($imgarr as $k=>$v){
                            ?>
                                 <li>
                                    <img src="<?php echo Yii::app()->params->WEBROOT . Yii::app()->params->FILEFOLDER . Yii::app()->params->FILEPATH['sourcefile']['image']['source'] .$v; ?>" />
                                </li>
                                <?PHP }}?>
                        </ul>
                    </div>
                </div>

                <div class="goods_top_cont">
                    <div class="goods_txt">
                        <span class="goods_tit"><?php echo $gift->name; ?></span>
                        <span class="goods_price">会员价：<em><?php echo $gift->integral; ?>分</em><i>原价：<?php echo $gift->prizevalue; ?>元</i></span>
                    </div>
                    <div class="discont_img">
                        <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/font/icon/iconfont-hui1.png">
                    </div>
                </div>
                <div class="clear"></div>
                <div class="goods_change">
                    <a href="<?php echo Yii::app()->createUrl('systems/userModule/address_list', array('gift_id' => $gift->id, 'status' => '1')) ?>">兑换</a>
                </div>
            </div>
            <section class="goods_next">
                <nav>
                    <div class="goods_detail">
                        <a class="goods_detail_tit" href="javascript:;">
                            <span>商品详情</span>
                            <div class="next_img"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/font/icon/sonar_map_icon.png"></div>
                        </a>
                        <div class="none goods_detail_con">
                            <?php echo $gift->content; ?><!--显示内容-->
                        </div>
                    </div>
<!--                    <div class="goods_detail">-->
<!--                        <a class="goods_detail_tit" class="goods_detail_tit" href="javascript:;">-->
<!--                            <span>商品图片</span>-->
<!--                            <div class="next_img"><img src="--><?php //echo Yii::app()->request->baseUrl; ?><!--/images/font/icon/sonar_map_icon.png"></div>-->
<!--                        </a>-->
<!--                        <div class="none goods_detail_con">     --><?php
//
//                            if (!empty($gift->image_arr)) {
//                                $images = explode(',', $gift->image_arr);
//                                foreach ($images as $i) {
//                                    ?>
<!--                                    <img alt="" src="--><?php //echo Yii::app()->params->WEBROOT . Yii::app()->params->FILEFOLDER . Yii::app()->params->FILEPATH['sourcefile']['image']['source'] . $i; ?><!--">-->
<!---->
<!--                                    --><?php
//                                }
//                            }
//                            ?><!--</div>-->
<!--                    </div>-->
                    <div class="goods_detail">
                        <a class="goods_detail_tit" href="javascript:;">
                            <span>商品参数</span>
                            <div class="next_img"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/font/icon/sonar_map_icon.png"></div>
                                               </a>
                        <div class="none goods_detail_con">
                            <p><?php echo $gift->remark; ?></p>

                        </div>

                    </div>
                </nav>
            </section>
        </div>
        <div class="popup_bj">
            <div class="popup">
                <div class="popup_con">
                    <a href="javascript:;" class="popup_x"></a>
                    <div class="pop_icon"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/font/popup/popup_yebz.png" /></div>
                    <h4>库存不足</h4>
                    <em>该礼品库存不足，不能兑换。</em>
                </div>
            </div>
        </div>
    </section>
</body>
<script type="text/javascript">
    $(function () {
        $('.goods_detail a').click(function () {
            if ($(this).attr('data-disp') == 'hide') {
                $(this).attr('data-disp', '');
                $(this).find('.next_img').removeClass('rotate_90');
                $(this).parent().find('.goods_detail_con').hide();
            } else {
                $(this).attr('data-disp', 'hide');
                $(this).find('.next_img').addClass('rotate_90');
                $(this).parent().find('.goods_detail_con').show();
            }
        });
    });
    //判断是否有库存能否兑换
    if (<?php echo $gift->count_stock; ?> == 0) {
        $('.goods_change a').unbind().css('background', '#c2c2c2').click(function () {
            $('.popup_bj').show().find('.popup_con').show();
            return false;
        });
    }

<?php if (Yii::app()->user->hasFlash('success')) { ?>
        var mess = "<?php echo Yii::app()->user->getFlash('success'); ?>";
        alert(mess);

<?php }
?>
</script>