

    <title>会员等级说明</title>
 
<body>
<section class="wrap">
    <div class="member_core_header">
                
        <a href="<?php echo Yii::app()->createUrl('systems/userModule/user', array('openid' => @$model->openid)) ?>">  <div class="user_avatar"><img src="<?php echo $model->headimgurl; ?>"></div></a>
        <h3><?php echo $model->nickname; ?>，会员等级：<?php
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
                ?></h3>
    </div>
    <div class="membership_grade">
        <dl>
            <dt><i><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/font/icon/iconfont-lingdai1.png" /></i>会员级别：</dt>
            <dd>V1：0——2000积分</dd>
            <dd>V2：2001——10000积分</dd>
            <dd>V3：10001——20000积分</dd>
            <dd>V4：20001积分以上</dd>
        </dl>
        <dl>
            <dt><i><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/font/icon/iconfont-3333333.png" /></i>会员级别：</dt>
            <dd><em>1、</em><p>参与每日签到，可根据签到时长，获取不同分值；</p></dd>
            <dd><em>2、</em><p>会员完善个人资料，获得30个积分奖励；</p></dd>
            <dd><em>3、</em><p>分享文章或活动消息至朋友圈，每条首次分享可积2分（重复分享不再获得分值）；</p></dd>
            <dd><em>4、</em><p>邀请好友关注欧派家居商城公众号，成功关注会员可获得10个积分；</p></dd>
            <dd><em>5、</em><p>不定期推出产品超低价秒杀活动，会员享有优先参与权；</p></dd>
            <dd><em>6、</em><p>欧派家居商城开展会员积分兑换活动，会员可使用积分在指定礼品区进行兑换；</p></dd>
        </dl>
    </div>
</section>
</body>
