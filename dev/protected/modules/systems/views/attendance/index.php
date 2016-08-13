<?php
/* @var $this AttendanceController */

$this->breadcrumbs = array(
    'Attendance',
);
?>
<link href="<?php echo Yii::app()->baseUrl; ?>/weixin_css/marketing.css" rel="stylesheet" type="text/css" />
<link href="<?php echo Yii::app()->baseUrl; ?>/weixin_css/member_home.css" rel="stylesheet" type="text/css" /><!-- 后续删除 -->

<div class="right content-main">
    <h2 class="content-main-title">活动签到</h2>
    <div>
        <div class="tabhost">
            <div class="tabhost-title">
                <div class="clear"></div>
            </div>
            <?php
            $form = $this->beginWidget('CActiveForm', array(
                'id' => 'attendance-form',
                // Please note: When you enable ajax validation, make sure the corresponding
                // controller action is handling ajax validation correctly.
                // There is a call to performAjaxValidation() commented in generated controller code.
                // See class documentation of CActiveForm for details on this.
                'enableAjaxValidation' => false,
            ));
            ?>
            <div class="padding30 tabhost-center">
                <div class="padding10 font-14 color-9 sign-in-explain">

                    说明：这是签到活动页面的说明，也就是签到的说明，签到有什么好处呢？签到后能干嘛！得到积分，积分又能做什么呢？这是签到活动页面的说明，也就是签到的说明，签到有什么好处呢？签到后能干嘛！得到积分，积分又能做什么呢？
                </div> 
                <div class="margin-top-15 sign-in">
                    <?php
                    echo '当前时间';
                    echo date('y-m-d h:i:s', time());
                    echo strtotime('2015-8-23');
                    echo '<br/>';
                    echo date('Y-m-d', strtotime('-1 day'));
                    ?>
                    <?php
                    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
                    $url = "$protocol$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";//Yii::app()->createUrl('moneytree'); //
                    ?>


                    <a href="https://open.weixin.qq.com/connect/oauth2/authorize?appid=<?php echo $appId; ?>&redirect_uri=<?php echo $url; ?>&response_type=code&scope=snsapi_userinfo&state=2#wechat_redirect"  title="启动签到功能">
                        <span id='getopenid' style="display: none"></span>
                    </a>
                    <a href="<?php echo Yii::app()->createUrl('systems/attendance/validate'); ?>" >绑定手机</a>
                    <a href="<?php echo Yii::app()->createUrl('systems/attendance/index', array('openid' => @$model->openid)) ?>">签到</a>
                    <!-- 后续删除 -->
                    <div class="user-information" style="margin-top: 10px;">
                        <table id="user-grid" class="detail-view">
                            <tbody>
                                <tr class="odd"><th>昵称</th><td><?php echo @$model->nickname; ?></td></tr>
                                <tr class="even"><th>积分</th><td>      <?php echo @$model->integral; ?></td></tr>
                                <tr class="odd"><th>分组</th><td><span class="group-value"></span><?php echo @$model->group_id; ?></td></tr>
                                <tr class="even"><th>备注名</th><td><span class="remark-value"></span><a href="/users/user/remark/id/36.html" title="修改备注名" class="right none remark-item"><i class="icon icon-text"></i></a></td></tr>
                                <tr class="odd"><th>头像</th><td><?php echo ($model->subscribe ? "<span class=\"subscribe\">" . CHtml::image(Yii::app()->baseUrl . "/images/subscribe.png", "关注中", array("class" => "sub_image")) . CHtml::image(substr($model->headimgurl, 0, -1) . "64") . "</span>" : "<span class=\"unsubscribe\">" . CHtml::image(Yii::app()->baseUrl . "/images/unsubscribe.png", "已取消关注", array("class" => "sub_image")) . CHtml::image(substr($model->headimgurl, 0, -1) . "64") . "</span>"); ?></td></tr>
                                <tr class="even"><th>手机号码</th><td><span class="mobile-value"><?php echo $model->mobile; ?></span><a href="/users/user/mobile/id/36.html" title="手机号码" class="right none mobile-item"><i class="icon icon-text"></i></a></td></tr>
                                <tr class="odd"><th>性别</th><td><?php echo '<span class="sex-value">' . @Yii::app()->params->SEX[$model->sex] . '</span>' . CHtml::link('<i class="icon icon-text"></i>', array('sex', 'id' => $model->id), array('class' => 'right none sex-item', 'title' => '性别')); ?></td></tr>
                                <tr class="even"><th>年龄</th><td><?php echo '<span class="age-value">' . $model->age . '</span>' . CHtml::link('<i class="icon icon-text"></i>', array('age', 'id' => $model->id), array('class' => 'right none age-item', 'title' => '年龄')); ?></td></tr>
                                <tr class="odd"><th>语言</th><td><?php echo '<span class="language-value">' . @Yii::app()->params->LANGUAGE[$model->language] . '</span>' . CHtml::link('<i class="icon icon-text"></i>', array('language', 'id' => $model->id), array('class' => 'right none language-item', 'title' => '语言')); ?></td></tr>
                                <tr class="odd"><th>关注时间</th><td><?php echo date('Y-m-d H:i:s', $model->subscribe_time); ?></td></tr>
                                <tr class="even"><th>用户唯一ID</th><td><?php echo $model->openid; ?></td></tr>
                            </tbody>
                        </table>
                    </div>
                    <!-- 后续删除 -->
                </div>
            </div>
            <?php $this->endWidget(); ?>
        </div>
    </div>
</div>

<script language="javascript" type="text/javascript">
<?php
$openid = @Yii::app()->cache->get('openid');
if (Yii::app()->request->getparam('state') == '2' && !empty($openid)) {
    ?>
<?php } else { ?>
        function getopenid()
        {
            $("#getopenid").click();
        }
        getopenid();
<?php } ?>
</script>
