<?php
/* @var $this AttendanceController */

$this->breadcrumbs = array(
    'Attendance',
);
?>
<link href="<?php echo Yii::app()->baseUrl; ?>/weixin_css/marketing.css" rel="stylesheet" type="text/css" />
<link href="<?php echo Yii::app()->baseUrl; ?>/weixin_css/member_home.css" rel="stylesheet" type="text/css" /><!-- 后续删除 -->
<?php
$strings = '<p>safsdfasdf<a href="http%3A%2F%2Fwechat.demo.cn%2Fbasis%2Fsourcefile%2Fnews.html" target="_self" _href="http%3A%2F%2Fwechat.demo.cn%2Fbasis%2Fsourcefile%2Fnews.html">'
        . '</a><a href="http%3A%2F%2Fwechat.demo.cn%2Fbasis%2Fsourcefile%2Fnews.html" target="_self" _href="http%3A%2F%2Fwechat.demo.cn%2Fbasis%2Fsourcefile%2Fnews.html">0000<img src="http://wechat.demo.cn/upload/sourcefile/image/source/20150803120003730450.jpg" style="float:none;" title="OOOPIC_SHIJUNHONG_20090805326b1a80e6c6aa6a.jpg" border="0" hspace="0" vspace="0" />'
        . '</a><a href="http%3A%2F%2Fwechat.demo.cn%2Fbasis%2Fsourcefile%2Fnews.html" target="_self" _href="http%3A%2F%2Fwechat.demo.cn%2Fbasis%2Fsourcefile%2Fnews.html">1111<img src="http://wechat.demo.cn/upload/sourcefile/image/source/20150803120003730450.jpg" style="float:none;" title="OOOPIC_SHIJUNHONG_20090805326b1a80e6c6aa6a.jpg" border="0" hspace="0" vspace="0" />'
        . '</a><a href="http%3A%2F%2Fwechat.demo.cn%2Fbasis%2Fsourcefile%2Fnews.html" target="_self" _href="http%3A%2F%2Fwechat.demo.cn%2Fbasis%2Fsourcefile%2Fnews.html">2222<img src="http://wechat.demo.cn/upload/sourcefile/image/source/20150803120003730450.jpg" style="float:none;" title="OOOPIC_SHIJUNHONG_20090805326b1a80e6c6aa6a.jpg" border="0" hspace="0" vspace="0" />'
        . '</a></p>';
$src = explode('src=', $strings);
$strt = null;
var_dump($src);
$countnum = count($src);
if ($countnum > 1) {
    for ($i = 0; $i < $countnum; $i++) {
        $img = explode('.jpg', $src[$i]);
        if (count($img) > 1) {
            $beireplace = substr($img[0], 1) . '.jpg';
            //得到 替换后的图片地址
            $tihuanstr = '333tup';
//            $publicArr = array(
//                'appid' => Yii::app()->user->getState('public_appid'),
//                'appsecret' => Yii::app()->user->getState('public_appsecret'),
//            );
//            $access_token = WechatStaticMethod::getAccessToken($publicArr);
//            $url = "https://api.weixin.qq.com/cgi-bin/media/uploadimg?access_token=" . $access_token;
//            $postArr = array();
//            if (class_exists('\CURLFile', FALSE)) {
//                $postArr['media'] = new CURLFile($beireplace);
//            } else {
//                $postArr['media'] = '@' . $beireplace;
//            }
//            var_dump($postArr['media']);
//            $result = WechatStaticMethod::https_request($url, $postArr);
//            var_dump($result);
//            exit;
            $tihuanhou = str_replace($beireplace, $tihuanstr, 'src=' . $src[$i]);
            $strt = $strt . $tihuanhou;
        } else {
            $strt = $strt . $src[$i];
        }
    }
   // var_dump($strt);
  //  var_dump($strings);
} else {
    $strt = $strings;
}

//exit;
?>
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
                    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
                    $url = "$protocol$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
              
                    ?>
                    <a href="https://open.weixin.qq.com/connect/oauth2/authorize?appid=<?php echo $appId; ?>&redirect_uri=<?php echo $url; ?>&response_type=code&scope=snsapi_userinfo#wechat_redirect" class="button button-red" title="启动签到功能">启动</a>
                    <a href="https://open.weixin.qq.com/connect/oauth2/authorize?appid=<?php echo $appId; ?>&redirect_uri=<?php echo $url; ?>&response_type=code&scope=snsapi_base&state=1#wechat_redirect"  title="启动签到功能">自动获取openid</a>
                    <a href="<?php echo Yii::app()->createUrl('systems/attendance/validate'); ?>" >绑定手机</a>

                    <?php //echo CHtml::submitButton($model->isNewRecord ? '签到' : 'Save', array('class' => 'button button-red'));        ?> 
                    <a href="<?php echo Yii::app()->createUrl('systems/attendance/index', array('openid' => @$model->openid)) ?>">签到</a>
                    <!--<a href="javascript:;" class="button button-white" title="关闭签到功能">关闭</a>-->

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


