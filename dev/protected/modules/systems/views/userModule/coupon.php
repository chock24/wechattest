<head>
    <title>我的优惠劵</title>
</head>
<body>
    <section class="wrap">
        <div class="privilege">
            <h3 class="privilege_tit"><i></i>我的优惠券：</h3>
            <?php
            if (!empty($couponexchange)) {
                foreach ($couponexchange as $c) {
                    ?>
                    <dl class="privilege_li">
                        <dt>券编号：<?php echo $c->coupon->number; ?></dt>
                        <dd>
                            <span>￥<em><?php echo $c->coupon->price; ?></em></span>
                            <p>有效时间：<?php echo date('Y年m月d日', $c->coupon->time_start).'-'. date('Y年m月d日', $c->coupon->time_end); ?></p>
                            <p>使用条件：<?php echo $c->coupon->description; ?></p>
                            <p><?php echo $c->number;?>张</p>
                            <?php
                            //已过期
                            if (time() > $c->coupon->time_end) {
                                ?>
                                <i class="expire">过期</i>
                            <?php }
                            ?>
                        </dd>
                    </dl>
                    <?php
                }
            }
            ?>
        </div>
        <div class="expire_privilege">
            <h3><i></i>优惠券规则：</h3>
            <p><i>1、</i><span>优惠券不可兑现成现金，不找零；</span></p>
            <p><i>2、</i><span>活动获得的优惠券使用，侍每次活动情况而定，参考具体活动策划方案。</span></p>
        </div>  
    </section>
</body>
