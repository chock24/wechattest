<?php
/* @var $this AttendanceController */

$this->breadcrumbs = array(
    'Attendance',
);
?>
<link href="<?php echo Yii::app()->baseUrl; ?>/weixin_css/marketing.css" rel="stylesheet" type="text/css" />
<div class="right content-main">
    <h2 class="content-main-title">绑定手机号</h2>
    <div>
        <div class="tabhost">
            <div class="tabhost-title">
                <div class="clear"></div>
            </div>
            <?php
            $form = $this->beginWidget('CActiveForm', array(
                'id' => 'validate-form',
                'enableAjaxValidation' => false,
            ));
            ?>
            <div class="padding30 tabhost-center">

                <div class="margin-top-15 sign-in">


                    </br>  </br> 请先绑定真实手机号 否则无法签到</br>

                    </br>
                    <?php echo $form->labelEx($model, 'mobile'); ?>

                    <?php echo $form->textField($model, 'mobile', array('value' => Yii::app()->request->getParam('mobile'))); ?>
                    <?php echo $form->error($model, 'mobile'); ?>
                    <?php
                    if (Yii::app()->user->hasFlash('mobileerrors')) {
                        echo Yii::app()->user->getFlash('mobileerrors');
                    }
                    ?>

                    <a data-id="<?php echo Yii::app()->createUrl('systems/attendance/validate', array('mobile' => '')); ?>" class="ted-mobile">发送验证码</a>
                    </br>
                    </br>
                    <?php echo $form->labelEx($model, 'openid'); ?>
                    <?php echo $form->textField($model, 'openid', array('value' => Yii::app()->cache->get('openid'))); ?>
                    <?php echo $form->labelEx($model, 'code'); ?>
                    <?php echo $form->textField($model, 'code'); ?>
                    <a class="ted-opein">绑定手机</a>
                    </br>
                    <?php
                    if (Yii::app()->user->hasFlash('mobilemessage')) {
                        echo Yii::app()->user->getFlash('mobilemessage');
                    }
                    ?>
                </div>
            </div>
            <?php echo Yii::app()->cache->get('openid'); ?>
            <?php $this->endWidget(); ?>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(function () {
        $('.ted-mobile').click(function () {
            var mobile = $('#User_mobile').val();
            if (mobile!=null && mobile != 0) {
                var url = "<?php echo Yii::app()->createUrl('systems/attendance/validate'); ?>";
                $.post(url, {queryString: "" + mobile + ""},
                function (data) {
                    alert(data);
                });
            } else {
                alert('请正确填写手机号');
            }
        });
        $('.ted-opein').click(function () {
            var tex1 = $('#User_openid').val();
            var tex2 = $('#User_code').val();
            var mobile = $('#User_mobile').val();
            var url = "<?php echo Yii::app()->createUrl('systems/attendance/validate'); ?>";
            $.post(url, {openid: "" + tex1 + "", code: "" + tex2 + "", queryString: "" + mobile + ""},
            function (data) {
                alert(data);
            });
        });
    })
</script>
