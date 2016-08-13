<title>管理收货地址</title>

<body>
    <section class="wrap">
        <div class="shipping_address">
            <h3>管理收货地址</h3>
            <?php
            $gift_id = 0;
            if (!empty($_GET['gift_id'])) {
                $gift_id = @$_GET['gift_id'];
            }
            $status = @$_GET['status'];
            ?>
            <ul>
                <?php foreach ($model as $m) { ?>
                    <li data-href="<?php echo!empty($status) ? Yii::app()->createUrl('systems/userModule/gift_detail', array('id' => @$gift_id, 'address_id' => $m->id)) : Yii::app()->createUrl('systems/userModule/gift', array('id' => @$gift_id, 'address_id' => $m->id)); ?>">
                        <span><em><?php echo $m->name; ?></em></span><span><?php echo $m->tel; ?></span>
                        <p><i><?php echo $m->sheng->name . $m->shi->name . $m->qu->name . $m->address_other; ?></i>    <i><?php echo $m->postcode; ?></i></p>
                        <?php if (!empty($gift_id)) { ?>
                            <a class="shipping_address_inp" href="<?php echo Yii::app()->createUrl('systems/userModule/address', array('id' => $m->id, 'gift_id' => $gift_id)) ?>"></a>
                        <?php } else { ?>
                            <a class="shipping_address_inp" href="<?php echo Yii::app()->createUrl('systems/userModule/address', array('id' => $m->id)) ?>"></a>
                        <?php } ?>
                    </li>
                <?php } ?>
            </ul>

            <a class="add_address" href="<?php echo Yii::app()->createUrl('systems/userModule/address', array('user_id' => @$model->user_id, 'gift_id' => $gift_id)) ?>">新增收货地址</a>    


        </div>
        <div class="popup_bj">
            <div class="popup">
                <div class="popup_con popup_site">
                    <a href="javascript:;" class="popup_x"></a>
                    <em>亲，您的收货地址为：</em>
                    <h5></h5>
                    <h5></h5>
                    <div class="popup_site_but">
                        <a class="pop_but confirm" href="javascript:;">确定</a>
                        <a class="pop_but" href="javascript:;">修改地址</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script type="text/javascript">
        $(function () {
            if ('<?php echo $gift_id; ?>' != 0) {
                $('.shipping_address').find('li').click(function () {
                    var $this = $(this);
                    $('.popup_bj').show().find('.popup_site').show().find('h5').eq(0).html($(this).find('p').find('i').eq(0).html() + '<br/>' + $(this).find('p').find('i').eq(1).html());
                    $('.popup_site').find('h5').eq(1).html($(this).find('em').html() + ' ' + $(this).find('span').eq(1).html());
                    $('.popup_site').find('.pop_but').eq(1).attr('href', $(this).find('.shipping_address_inp').attr('href'));
                    $('.popup_site').find('.confirm').unbind().click(function () {
                        window.location.href = $this.attr('data-href');
                    });
                });
            }
        })
    </script>
</body>