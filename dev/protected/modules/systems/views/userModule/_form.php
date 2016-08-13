<?php
/* @var $this UserModuleController */
/* @var $model UserModule */
/* @var $form CActiveForm */
?>
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/weixin_css/marketing_tool.css" />

<div class="right content-main">
    <div class="margin-top-10 tabhost">
        <div class="tabhost-title">
            <ul>
                <li><a href="<?php echo Yii::app()->createUrl('systems/userModule/index');?>">会员中心模块</a></li>
                <li class="active"><a href="<?php echo Yii::app()->createUrl('systems/userModule/create') ?>">新增会员</a></li>
            </ul>
            <div class="clear"></div>
        </div>
        <div class="padding20 tabhost-center">


            <div class="form marketing_add_article">

                <?php
                $form = $this->beginWidget('CActiveForm', array(
                    'id' => 'user-module-form',
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
                    <?php echo $form->labelEx($model, 'title'); ?>
                    <?php echo $form->textField($model, 'title', array('size' => 50, 'maxlength' => 50)); ?>
                    <?php echo $form->error($model, 'title'); ?>
                </div>
                <div class="add_article_list">
                    <label class="left">设置封面</label>
                    <div class="add_article_list_img">
                        <img src="<?php echo Yii::app()->params->WEBROOT . Yii::app()->params->FILEFOLDER . Yii::app()->params->FILEPATH['sourcefile']['image']['medium'] . $model->bg_img; ?>"  class="none" />
                        <i>封面<br/>图片</i>
                    </div>
                    <?php echo CHtml::activeFileField($model, 'files', array('class' => "none add-image-preview", 'style' => 'display:none')); ?>
                    <a onclick="$(this).prev().click();" class="margin-top-15 button button-white" href="javascript:;">上传</a><br/>
                    <?php
                    if (Yii::app()->user->hasFlash('alert')) {
                        echo '<br/>' . Yii::app()->user->getFlash('alert');
                    }
                    ?>
                    <a onclick="js:return popup($(this), '从图库中选择图文', 880, 590);" class="margin-top-15 button button-white" href="<?php echo Yii::app()->createUrl('basis/sourcefile/sourcefile', array('type' => 2)); ?>">从图片库选择</a>
                    <span class="margin-left-20">（图片大小：<i class="color-red">宽：58px；高：66px</i>）</span>
                </div>
                <div class="row add_article_list">
                    <?php echo $form->labelEx($model, 'url'); ?>
                    <?php echo $form->textField($model, 'url', array('size' => 60, 'maxlength' => 255)); ?>
                    <?php echo $form->error($model, 'url'); ?>
                </div>
                <div class="row add_article_list">
                    <?php echo $form->labelEx($model, 'order_by'); ?>
                    <?php echo $form->textField($model, 'order_by'); ?>
                    <?php echo $form->error($model, 'order_by'); ?>
                </div>
                <div class="row buttons text-center add_article_list">
                    <?php echo $form->hiddenField($model, 'bg_img', array('id' => 'result-id')); ?>
                    <?php echo CHtml::submitButton($model->isNewRecord ? '创建' : '保存',array('class'=>'margin-top-15 button button-green')); ?>
                </div>

                <?php $this->endWidget(); ?>

            </div><!-- form -->


        </div>
    </div>
</div>

<script>
    $(function () {
        if ($(".add_article_list_img img").attr('src') != 'http://wechat.oppein.cn/upload/sourcefile/image/medium/') $(".add_article_list_img img").show();
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
        $('.add-mage-text-mask-add-icon').live('click', function () {
            var obj = $(this).parent().prev().find('.popup-content-fodder-content').find('.items').find('.selected');
            if (obj.html() != undefined) {
                var url = obj.find('img').attr('src');
                $('.add_article_list_img').find('img').attr('src', url).show();
                $(".add_article_list_img img").next().hide();
            } else {
                alert('对不起！你没有选择素材，请选择素材！！');
            }
        });
        var Gift_count_stock = parseInt($('#Gift_count_stock').val());
        $('#Gift_count_stock').change(function () {
            var tel = parseInt($(this).val()) - Gift_count_stock;
            if (tel > 0) {
                // alert('增加了' + tel);
                $('#Gift_score').attr('value', tel);
                $('#Gift_genre').attr('value', 1);//增加
            } else if (tel != 0) {
                // alert('减少了' + tel.toString().substr(1));
                $('#Gift_score').attr('value', tel.toString().substr(1));
                $('#Gift_genre').attr('value', 2);//减少
            }
        });
    })
</script>