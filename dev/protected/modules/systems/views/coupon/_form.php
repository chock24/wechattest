<?php
/* @var $this CouponController */
/* @var $model Coupon */
/* @var $form CActiveForm */
?>
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/weixin_css/marketing_tool.css" />

<div class="right content-main">
    <div class="margin-top-10 tabhost">
        <div class="tabhost-title">
            <ul>
                <?php $sta = Yii::app()->request->getParam('status'); ?>
                <li><a href="<?php echo Yii::app()->createUrl('systems/coupon/index'); ?>">优惠劵</a></li>
                <li><a href="<?php echo Yii::app()->createUrl('systems/coupon/index', array('status' => 0)); ?>">未过期优惠劵</a></li>
                <li><a href="<?php echo Yii::app()->createUrl('systems/coupon/index', array('status' => 1)); ?>">过期优惠劵</a></li>
                <li class="active"><a href="<?php echo Yii::app()->createUrl('systems/coupon/create'); ?>">新建优惠劵</a></li>
            </ul>
            <div class="clear"></div>
        </div>
        <div class="padding20 tabhost-center">
            <div class="form marketing_add_article">
                <?php
                $form = $this->beginWidget('CActiveForm', array(
                    'id' => 'coupon-form',
                    // Please note: When you enable ajax validation, make sure the corresponding
                    // controller action is handling ajax validation correctly.
                    // There is a call to performAjaxValidation() commented in generated controller code.
                    // See class documentation of CActiveForm for details on this.
                    'enableAjaxValidation' => false,
                    'htmlOptions' => array('enctype' => 'multipart/form-data',),
                ));
                ?>
                <?php echo $form->errorSummary($model); ?>
                <div class="row add_article_list">
                    <?php echo $form->labelEx($model, 'number'); ?>
                    <?php echo $form->textField($model, 'number'); ?>
                    <?php echo $form->error($model, 'number'); ?>
                </div>

                <div class="row add_article_list">
                    <?php echo $form->labelEx($model, 'title'); ?>
                    <?php echo $form->textField($model, 'title', array('size' => 60, 'maxlength' => 255)); ?>
                    <?php echo $form->error($model, 'title'); ?>
                </div>

                <div class="row add_article_list">
                    <?php echo $form->labelEx($model, 'description'); ?>
                    <?php echo $form->textField($model, 'description', array('size' => 60, 'maxlength' => 255)); ?>
                    <?php echo $form->error($model, 'description'); ?>
                </div>
                <!--<div class="add_article_list">
                    <div class="add_article_list_img">
                        <img src="<?php /*echo Yii::app()->params->WEBROOT . Yii::app()->params->FILEFOLDER . Yii::app()->params->FILEPATH['sourcefile']['image']['medium'] . $model->image_src; */?>"  class="none" />
                    </div>
                    <?php /*echo CHtml::activeFileField($model, 'files', array('class' => "none add-image-preview", 'style' => 'display:none')); */?>
                    <a onclick="$(this).prev().click();" class="margin-top-15 button button-white" href="javascript:;">上传</a><br/>
                    <?php
/*                    if (Yii::app()->user->hasFlash('alert')) {
                        echo '<br/>' . Yii::app()->user->getFlash('alert');
                    }
                    */?>
                    <a onclick="js:return popup($(this), '从图库中选择图文', 880, 590);" class="margin-top-15 button button-white" href="<?php /*echo Yii::app()->createUrl('basis/sourcefile/sourcefile', array('type' => 2)); */?>">从图片库选择</a>
                    <span class="margin-left-20">（图片大小：<i class="color-red">宽：px；高：px</i>）</span>
                </div>-->
                <div class="row add_article_list">
                    <div class="left">
                        <?php echo $form->labelEx($model, 'integral'); ?>
                        <?php echo $form->textField($model, 'integral', array('size' => '22')); ?>
                        <?php echo $form->error($model, 'integral'); ?>
                    </div>
                    <div class="left">
                        <?php echo $form->labelEx($model, 'price'); ?>
                        <?php echo $form->textField($model, 'price', array('size' => '22')); ?>
                        <?php echo $form->error($model, 'price'); ?>
                    </div>
                </div>

                <div class="row add_article_list">
                    <div class="left">
                        <?php echo $form->labelEx($model, 'time_start'); ?>
                        <?php echo $form->textField($model, 'time_start', array('class' => 'laydate-icon', 'value' => date('Y-m-d', $model->time_start))); ?>
                        <?php echo $form->error($model, 'time_start'); ?>
                    </div>
                    <div class="left">
                        <?php echo $form->labelEx($model, 'time_end'); ?>
                        <?php echo $form->textField($model, 'time_end', array('class' => 'laydate-icon', 'value' => date('Y-m-d', $model->time_end))); ?>
                        <?php echo $form->error($model, 'time_end'); ?>
                    </div>
                </div>
                <div class="row add_article_list">
                    <?php echo $form->labelEx($model, 'status'); ?>
                    <?php
                    $status = array();
                    $status[0] = '未过期';
                    $status[1] = '已过期';
                    echo $form->dropDownList($model, 'status', $status);
                    ?>
                    <?php echo $form->error($model, 'status'); ?>
                </div>
                <div class="row add_article_list">
                    <?php echo $form->labelEx($model, 'order_by'); ?>
                    <?php echo $form->textField($model, 'order_by'); ?>
                    <?php echo $form->error($model, 'order_by'); ?>
                </div>
                <div class="row buttons text-center add_article_list">
                    <?php echo $form->hiddenField($model, 'image_src', array('id' => 'result-id')); ?>
                    <?php echo CHtml::submitButton($model->isNewRecord ? '创建' : '保存', array('class' => 'margin-top-15 button button-green')); ?>
                </div>

                <?php $this->endWidget(); ?>

            </div><!-- form -->

        </div>
    </div>
</div>
<script type="text/javascript">
    $(function () {
        if ($(".add_article_list_img img").attr('src') != '')
            $(".add_article_list_img img").show();
        //获取file的地址赋值给img
        $(".add-image-preview").on("change", function () {
            var objUrl = getObjectURL(this.files[0]);
            console.log("objUrl = " + objUrl);
            if (objUrl) {
                $(".add_article_list_img img").attr("src", objUrl).show();
                $(".add_article_list_img img").next().hide();
            }
        });
        //建立一個可存取到該file的url
        function getObjectURL(file) {
            var url = null;
            if (window.createObjectURL != undefined) { // basic
                url = window.createObjectURL(file);
            } else if (window.URL != undefined) { // mozilla(firefox)
                url = window.URL.createObjectURL(file);
            } else if (window.webkitURL != undefined) { // webkit or chrome
                url = window.webkitURL.createObjectURL(file);
            }
            return url;
        }
        time_sorter("#Coupon_time_start", "#Coupon_time_end", "YYYY-MM-DD");//时间选择器
    })
</script>


