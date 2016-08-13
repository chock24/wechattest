<?php
/* @var $this QuickmarkController */
/* @var $model Quickmark */
/* @var $form CActiveForm */
?>

<div class="padding10 form form-compile">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'quickmark-form',
        // Please note: When you enable ajax validation, make sure the corresponding
        // controller action is handling ajax validation correctly.
        // There is a call to performAjaxValidation() commented in generated controller code.
        // See class documentation of CActiveForm for details on this.
        'enableAjaxValidation' => false,
    ));
    ?>

    <?php
    Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . "/css/reset.css");
    Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . "/js/jquery.qqFace.js");
    Yii::app()->clientScript->registerScript('qqfaceInput', "
                                        $('.emotion').qqFace({
                                            id: 'facebox',
                                            assign: 'operationText',
                                            path: '" . Yii::app()->baseUrl . "/images/arclist/',
                                        });
                                    ");
    ?>
    <?php echo $form->errorSummary($model); ?>

    <div class="row form-compile-list">
        <?php echo $form->labelEx($model, 'action_name'); ?>
        <?php echo $form->dropDownList($model, 'action_name', Yii::app()->params->QUICKMARKTYPE, array('class' => 'scene margin-top-5')); ?>
        <?php echo $form->error($model, 'action_name'); ?>
    </div>

    <div class="row form-compile-list">
        <?php echo $form->labelEx($model, 'group_id'); ?>
        <?php echo $form->dropDownList($model, 'group_id', $this->userGroup(), array('class' => 'margin-top-5')); ?>
        <?php echo $form->error($model, 'group_id'); ?>
    </div>

    <div class="row form-compile-list">
        <?php echo $form->labelEx($model, 'title'); ?>
        <?php echo $form->textField($model, 'title', array('size' => 60, 'maxlength' => 200)); ?>
        <?php echo $form->error($model, 'title'); ?>
    </div>

    <div class="row form-compile-list">
        <?php echo $form->labelEx($model, 'description'); ?>

        <div class="left width-60 editing">
            <div class="editing-tab">
                <ul class="editing-tab-nav">
                    <li>
                        <?php /* echo CHtml::link('<i class="icon icon-text"></i>', array('update', 'id' => $model->id, 'type' => 1), array('title' => '文本')); */ ?>
                        <a href="javascript:;"><i class="icon icon-text"></i></a>
                    </li>
                    <li>
                        <?php echo CHtml::link('<i class="icon icon-img"></i>', array('/users/user/sourcefile', 'type' => 2), array('title' => '图片', 'onclick' => 'js:return popup($(this),"图片库",850,500);')); ?>
                    </li>
                    <li>
                        <?php echo CHtml::link('<i class="icon icon-single-graphic"></i>', array('/users/user/sourcefile', 'type' => 5, 'multi' => 0), array('title' => '单图文', 'onclick' => 'js:return popup($(this),"单图文库",850,500);')); ?>
                    </li>
                    <li>
                        <?php echo CHtml::link('<i class="icon icon-more-graphic"></i>', array('/users/user/sourcefile', 'type' => 5, 'multi' => 1), array('title' => '多图文', 'onclick' => 'js:return popup($(this),"多图文库",850,500);')); ?>
                    </li>
                    <li>
                        <?php echo CHtml::link('<i class="icon icon-voice"></i>', array('/users/user/sourcefile', 'type' => 3), array('title' => '音频', 'onclick' => 'js:return popup($(this),"音频库",850,500);')); ?>
                    </li>
                    <li>
                        <?php echo CHtml::link('<i class="icon icon-video"></i>', array('/users/user/sourcefile', 'type' => 4), array('title' => '视频', 'onclick' => 'js:return popup($(this),"视频库",850,500);')); ?>
                    </li>
                </ul>
                <!--<div class="relative popup-fodder popup-fodder-teletext" id="news-section"></div>-->
                <div id="news-section" class="fodder mage-text"></div>
                <div class="clear"></div>
                <div class="editing-tab-input" id="text-section">
                    <!--<textarea cols="100" rows="10" id="operationText"><?php /*echo PublicStaticMethod::replaceQqFace($model->description); */?></textarea>-->
                    <?php echo $form->textArea($model, 'description', array('id' => 'operationText', 'data-id' => 0, 'data-multi' => 0, 'data-type' => 1)); ?>
                    <div>
                        <?php if ($model->type == 5)://如果是图文 ?>
                            <div class="menu-preview">
                                <?php if ($model->multi == 1)://如果是多图文?>
                                    <?php if (isset($model->sourceFileGroup->sourceDetail))://如果存在素材细节 ?>
                                        <div class="fodder mage-text">
                                            <?php foreach (@$model->sourceFileGroup->sourceDetail as $key => $value)://循环素材细节 ?>
                                                <?php if ($key == 0)://如果是第一个单图文 ?>
                                                    <div class="fodder-center">
                                                        <em class="fodder-date"><?php echo @Yii::app()->format->formatDate($model->sourceFileGroup->time_created); ?></em>
                                                        <div class="relative fodder-img mage-text-img">
                                                            <?php echo @CHtml::link(CHtml::image(PublicStaticMethod::returnSourceFile($value->sourceFile->filename, $value->sourceFile->ext, 'image', 'medium')), array('/site/view', 'id' => $value->sourceFile->id), array('target' => '_blank')); ?>
                                                            <div class="mage-text-img-title">
                                                                <?php echo @CHtml::link(PublicStaticMethod::truncate_utf8_string($model->sourceFileGroup->title, 10), array('/site/view', 'id' => $value->sourceFile->id), array('target' => '_blank', 'title' => $model->sourceFileGroup->title)); ?>

                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php else://如果不是第一个单图文 ?>
                                                    <div class="mage-text-more border-bottom-width">
                                                        <h4 class="left">
                                                            <?php echo @CHtml::link(PublicStaticMethod::truncate_utf8_string($value->sourceFile->title, 10), array('/site/view', 'id' => $value->sourceFile->id), array('title' => $value->sourceFile->title, 'target' => '_blank')); ?>
                                                        </h4>
                                                        <div class="right mage-text-more-img">
                                                            <?php
                                                            echo @CHtml::link(CHtml::image(PublicStaticMethod::returnSourceFile($value->sourceFile->filename, $value->sourceFile->ext, 'image', 'medium')), array('/site/view', 'id' => $value->sourceFile->id), array('target' => '_blank'));
                                                            ?>
                                                        </div>
                                                    </div>
                                                <?php endif; ?>
                                            <?php endforeach; //结束素材细节循环 ?>
                                        </div>
                                    <?php endif; ?>

                                <?php else: ?>
                                    <div class="fodder mage-text">
                                        <div class="fodder-center border-bottom-width">
                                            <h4>
                                                <?php echo @CHtml::link(PublicStaticMethod::truncate_utf8_string($model->sourceFile->title, 10), array('/site/view', 'id' => $model->sourceFile->id), array('target' => '_blank', 'title' => $model->sourceFile->title)); ?>
                                            </h4>
                                            <em class="fodder-date"><?php echo @Yii::app()->format->formatDate($model->sourceFile->time_created); ?></em>
                                            <div class="fodder-img mage-text-img">
                                                <?php echo @CHtml::link(CHtml::image(PublicStaticMethod::returnFile('sourcefile', $model->sourceFile->filename, $model->sourceFile->ext, 'image', 'medium')), array('/site/view', 'id' => $model->sourceFile->id), array('target' => '_blank')); ?>
                                            </div>
                                            <p class="fodder-introduce">
                                                <?php echo @CHtml::encode(PublicStaticMethod::truncate_utf8_string($model->sourceFile->description, 15), array('title' => $model->sourceFile->description)); ?>
                                            </p>
                                        </div>
                                    </div>
                                <?php endif; ?>
                                <!--<div class="clear"></div>
                                <div class="padding-top-30">
                                    <?php /*echo CHtml::link('修改', 'javascript:;', array('class' => 'button button-green', 'onclick' => 'js:$(".menu-edit").show();$(".menu-preview").hide();')); */?>

                                </div>-->
                            </div>
                        <?php endif; ?>
                        <!--文字预览-->
                        <div class="none text-preview">
                            <div class="text-preview-text">
                                <?php if ($model->type == 1) { ?>
                                    <!--文字预览-->
                                    <div class="text-preview-text-size" style="min-height: 120px;">
                                        <?php echo PublicStaticMethod::replaceQqFace($model->description); ?>
                                    </div>
                                <?php } else if ($model->type == 2) { ?>
                                    <div class="fodder mage-img">
                                        <div class="fodder-center mage-img-center border-bottom-width">
                                            <div class="fodder-img mage-img-img">
                                                <img alt="" src="<?php echo PublicStaticMethod::returnFile('sourcefile', $model->sourceFile->filename, $model->sourceFile->ext, 'image', 'medium'); ?>">
                                            </div>
                                            <div class="mage-img-label"><?php echo $model->sourceFile->title; ?></div>
                                        </div>
                                    </div>
                                    <div class="clear"></div>
                                <?php } else if ($model->type == 3) { ?>
                                    <div class="audio-message-list">
                            <span class="margin-right-5 right color-9">
                                <?php
                                $titsa = $model->sourceFile->length;
                                $hour = floor($titsa / 3600);
                                $minute = floor(($titsa - 3600 * $hour) / 60);
                                $second = floor((($titsa - 3600 * $hour) - 60 * $minute) % 60);
                                //echo $hour.':'.$minute.':'.$second;
                                echo $minute . ':' . $second;
                                ?>
                            </span>
                                        <embed class="none" src="<?php echo PublicStaticMethod::returnFile('sourcefile', $model->sourceFile->filename, $model->sourceFile->ext, 'voice', 'medium'); ?>" autostart="false" name="voi"></embed>
                                    </div>
                                <?php } else if ($model->type == 4) { ?>
                                    <div class="margin-left-5">
                                        <span class="padding-left-5"><?php echo @$value->sourceFile->title; ?></span>
                                        <div class="video-messaging-list">
                                            <video  src="<?php echo PublicStaticMethod::returnFile('sourcefile', $model->sourceFile->filename, $model->sourceFile->ext, 'video', 'medium'); ?>" controls="controls">您的浏览器不支持 video 标签。</video>
                                            <a href="<?php echo PublicStaticMethod::returnFile('sourcefile', $model->sourceFile->filename, $model->sourceFile->ext, 'video', 'medium'); ?>" target="_blank">点击放大查看</a>
                                        </div>
                                    </div>
                                    <div class="clear"></div>
                                <?php } ?>
                            </div>
                            <!--<div class="margin-top-15">
                                <?php /*echo CHtml::link('修改', 'javascript:;', array('class' => 'button button-green', 'onclick' => 'js:$(".menu-edit").show();$(".text-preview").hide();')); */?>
                            </div>-->
                        </div>
                        <div class="clear"></div>
                    </div>

                </div>
                <div class="editing_toolbar">
                    <a class="left emotion" href="javascript:;"><i class="icon icon-face"></i></a>
                </div>
            </div>
        </div>
        <div class="clear"></div>
    </div>

    <div class="row temp-section form-compile-list">
        <?php echo $form->labelEx($model, 'expire_seconds'); ?>
        <?php echo $form->textField($model, 'expire_seconds'); ?>
        <span>*以秒为单位，最大不能超过1800秒(30分钟)</span>
        <?php echo $form->error($model, 'expire_seconds'); ?>
    </div>

    <!--   <div class="row form-compile-list">
    <?php echo $form->labelEx($model, 'scene_id'); ?>
    <?php echo $form->textField($model, 'scene_id', array('size' => 32, 'maxlength' => 32)); ?>
            <span>临时二维码(32位非0整数),永久二维码(100000以内)，不能重复</span>
    <?php echo $form->error($model, 'scene_id'); ?>
        </div>-->

    <!--<div class="row">
    <?php echo $form->labelEx($model, 'action_info'); ?>
    <?php echo $form->textField($model, 'action_info', array('size' => 60, 'maxlength' => 200)); ?>
    <?php echo $form->error($model, 'action_info'); ?>
    </div>

    <div class="row">
    <?php echo $form->labelEx($model, 'ticket'); ?>
    <?php echo $form->textField($model, 'ticket', array('size' => 60, 'maxlength' => 200)); ?>
    <?php echo $form->error($model, 'ticket'); ?>
    </div>

    <div class="row">
    <?php echo $form->labelEx($model, 'url'); ?>
    <?php echo $form->textField($model, 'url', array('size' => 60, 'maxlength' => 200)); ?>
    <?php echo $form->error($model, 'url'); ?>
    </div>-->

    <div class="row form-compile-list buttons">
        <?php echo $form->hiddenField($model, 'description'); ?>
        <?php echo $form->hiddenField($model, 'type'); ?>
        <?php echo $form->hiddenField($model, 'multi'); ?>
        <?php echo CHtml::submitButton($model->isNewRecord ? '创建二维码' : '保存修改', array('class' => 'button')); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->

<?php
Yii::app()->clientScript->registerScript('scene', "
    scenechange($('.scene').val());
    $('.scene').change(function(){
        scenechange($(this).val());
    })
    function scenechange(scene){
        $('.temp-section').hide();
        if(scene=='QR_SCENE'){
            $('.temp-section').show();
        }
    }
");
?>
<script type="text/javascript">
    $(function () {
        $('.icon-text').parent().click(function () {
            $('#news-section').hide();
            $('#text-section,.emotion').show();
            $('#Quickmark_description').val($(this).val());
            $('#Quickmark_type').val('1');
            $('.text-preview,.menu-preview').hide();
            $('#operationText').show();
        });
        $('#operationText').blur(function () {
            $('#Quickmark_description').val($(this).val());
            $('#Quickmark_type').val('1');
        });
        $('#select-result').live('click', function () {
            $('#Quickmark_description').val($('.selected').attr('data-id'));
            $('#Quickmark_type').val($('.selected').attr('data-type'));
            $('#Quickmark_multi').val($('.selected').attr('data-multi'));
            $('.emotion').hide();
        });

        if($.trim($('.text-preview-text,.menu-preview').html())==''|| $('.text-preview-text,.menu-preview').html() == ''){
            $('.text-preview').hide();
            $('#operationText,.emotion').show();
        }else {
            $('.text-preview').show();
            $('#operationText,.emotion').hide();
        }


        //音频点击播放
        if(isIE = navigator.userAgent.indexOf("MSIE")!=-1) {
            voice($('.audio-message-list'),'embed');
        }else{
            //不是ie浏览器将embed替换成audio
            $('.audio-message-list').each(function(){
                var src = $(this).find('embed').attr('src');
                var audio = $(this).find('embed');
                audio.replaceWith("<audio src = "+ src + " autostart='false' name='voi'></audio>");
            });
            voice($('.audio-message-list'),'audio');
        }
        //判断视频格式做修改
        if(navigator.appName == "Microsoft Internet Explorer" && (navigator.appVersion .split(";")[1].replace(/[ ]/g,"")=="MSIE6.0" || navigator.appVersion .split(";")[1].replace(/[ ]/g,"")=="MSIE7.0" || navigator.appVersion .split(";")[1].replace(/[ ]/g,"")=="MSIE8.0")){
            $('.video-messaging-list').each(function(){
                var src = $(this).find('video').attr('src');
                var video = $(this).find('video');
                video.replaceWith("<embed src="+ src +" autostart='false'></embed>");
            });
        }
    })
</script>