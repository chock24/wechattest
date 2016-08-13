
<?php $public_id = Yii::app()->user->getstate('public_id'); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . "/js/jquery.timeRange.js"); ?>
<link href="<?php echo Yii::app()->baseUrl; ?>/weixin_css/reply.css" rel="stylesheet" type="text/css" />
<link href="<?php echo Yii::app()->baseUrl; ?>/weixin_css/member_home.css" rel="stylesheet" type="text/css" />

<div class="right content-main">
    <!--<h2 class="content-main-title">自动回复</h2>-->
    <div>
        <div class="margin-top-10 tabhost">
            <div class="tabhost-title">
                <ul>
                    <li><a href="<?php echo Yii::app()->createUrl('/basis/welcome/index'); ?>">欢迎语</a></li>
                    <li class="active"><a href="<?php echo Yii::app()->createUrl('/basis/auto/index') ?>">自动回复</a></li>
                    <li><a href="<?php echo Yii::app()->createUrl('/basis/rule/index') ?>">关键字回复</a></li>
                </ul>
                <div class="clear"></div>
            </div>
            <div class="tabhost-center">

                <div class="newsmanagement-seek">
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
                    <?php
                    $form = $this->beginWidget('CActiveForm', array(
                        'id' => 'auto-form',
                        'action' => array('update', 'id' => $model->id),
                        'enableClientValidation' => true,
                        'clientOptions' => array(
                            'validateOnSubmit' => true,
                        ),
                    ));
                    ?>
                    <?php echo $form->hiddenField($model, 'type'); ?>
                    <div class="row left">
                        是否开启自动回复功能 :
                        <?php echo $form->checkbox($model, 'status'); ?>
                        <?php echo $form->error($model, 'status'); ?>
                    </div>
                    <div class="row left" style="margin-left: 20px; margin-right: 20px;">
                        定时开启 :
                        <?php echo $form->checkbox($model, 'timing'); ?>
                        <?php echo $form->error($model, 'timing'); ?>
                    </div>
                    <div class="row left" style="margin-left: 20px; margin-right: 20px;">
                        定时区间 :
                        <?php echo $form->textField($model, 'time_start', array('class' => 'timeRange', 'value' => date('H:i:s', $model->time_start) . '-' . date('H:i:s', $model->time_end))); ?>
                        <?php echo $form->error($model, 'time_start'); ?>
                    </div>
                    <?php if (Yii::app()->request->getParam('type')): ?>
                        <div class="row buttons">
                            <?php echo $form->hiddenField($model, 'source_file_id', array('class' => 'source_file_id')); ?>
                            <?php echo CHtml::submitButton('保存设置', array('class' => 'button web-menu-btn')); ?>
                        </div>
                    <?php endif; ?>
                </div>

                <?php if ($model->type == 5)://如果是图文 ?>
                    <div class="padding10 menu-preview">
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

                        <div class="clear"></div>
                        <div class="padding-top-30">
                            <?php echo CHtml::link('修改', 'javascript:;', array('class' => 'button button-green', 'onclick' => 'js:$(".menu-edit").show();$(".menu-preview").hide();')); ?>
                            <?php
                            if ($public_id == '1') {
                                if ($model->template == 0) {
                                    echo CHtml::link('设置为模板', Yii::app()->createUrl('basis/auto/index', array('id' => $model->id, 'template' => '1')), array('class' => 'button button-white'));
                                } else {
                                    echo CHtml::link('取消为模板', Yii::app()->createUrl('basis/auto/index', array('id' => $model->id, 'template' => '0')), array('class' => 'button button-dc'));
                                }
                            }
                            ?>

                        </div>
                    </div>
                <?php endif; ?>
                <!--文字预览-->
                <div class="none text-preview">
                    <div class="padding10 text-preview-text">

                        <?php if ($model->type == 1) { ?>
                            <!--文字预览-->
                            <?php echo PublicStaticMethod::replaceQqFace($model->content); ?>
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
                    <div class="margin-top-15">
                        <?php echo CHtml::link('修改', 'javascript:;', array('class' => 'button button-green', 'onclick' => 'js:$(".menu-edit").show();$(".text-preview").hide();')); ?>
                        <?php
                        if ($public_id == '1') {
                            if ($model->template == 0) {
                                echo CHtml::link('设置为模板', Yii::app()->createUrl('basis/welcome/index', array('id' => $model->id, 'template' => '1')), array('class' => 'button button-white'));
                            } else {
                                echo CHtml::link('取消为模板', Yii::app()->createUrl('basis/welcome/index', array('id' => $model->id, 'template' => '0')), array('class' => 'button button-dc'));
                            }
                        }
                        ?>
                    </div>
                </div>

                <div class="padding10 tabhost-center menu-edit <?php if ($model->type != 1 && $model->type): ?> none <?php endif; ?>">
                    <div class="margin-top-15 editing">
                        <div class="editing-tab">
                            <ul class="editing-tab-nav">
                                <li>
                                    <?php echo CHtml::link('<i class="icon icon-text"></i>', array('index', 'type' => 1), array('title' => '文本', 'onclick' => 'js:$("#news-section").hide();$("#text-section").show();$("#text-section").find("textarea").val("");return false;')); ?>
                                </li>
                                <li>
                                    <?php echo CHtml::link('<i class="icon icon-img"></i>', array('sourcefile', 'type' => 2), array('title' => '图片', 'onclick' => 'js:return popup($(this),"图片库",850,500);')); ?>
                                </li>
                                <li>
                                    <?php echo CHtml::link('<i class="icon icon-single-graphic"></i>', array('sourcefile', 'type' => 5, 'multi' => 0), array('title' => '单图文', 'onclick' => 'js:return popup($(this),"单图文库",850,500);')); ?>
                                </li>
                                <li>
                                    <?php echo CHtml::link('<i class="icon icon-more-graphic"></i>', array('sourcefile', 'type' => 5, 'multi' => 1), array('title' => '多图文', 'onclick' => 'js:return popup($(this),"多图文库",850,500);')); ?>
                                </li>
                                <li>
                                    <?php echo CHtml::link('<i class="icon icon-voice"></i>', array('sourcefile', 'type' => 3), array('title' => '音频','onclick' => 'js:return popup($(this),"音频库",850,500);')); ?>
                                </li>
                                <li>
                                    <?php echo CHtml::link('<i class="icon icon-video"></i>', array('sourcefile', 'type' => 4), array('title' => '视频','onclick' => 'js:return popup($(this),"视频库",850,500);')); ?>
                                </li>
                            </ul>
                            <div id="news-section" class="none fodder mage-text"></div>
                            <div class="clear"></div>
                            <div id="text-section">
                                <div class="editing-tab-input">
                                    <?php echo $form->textArea($model, 'content', array('id' => 'operationText', 'data-id' => 0, 'data-multi' => 0, 'data-type' => 1, 'onchange' => 'js:return popupConfirm($(this),$("#result-id"),$("#result-multi"),$("#result-type"),1)')); ?>
                                    <?php echo $form->error($model, 'content'); ?>
                                </div>
                                <div class="editing_toolbar">
                                    <a class="left emotion" href="javascript:;"><i class="icon icon-face"></i></a>
                                    <p class="right">还可以输入<em>500</em>字</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php echo $form->hiddenField($model, 'type', array('id' => 'result-type')); ?>
                    <?php echo $form->hiddenField($model, 'source_file_id', array('id' => 'result-id')); ?>
                    <?php echo $form->hiddenField($model, 'multi', array('id' => 'result-multi')); ?>
                    <?php echo CHtml::submitButton('保存', array('class' => 'button button-green')); ?>
                    <?php $this->endWidget(); ?>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(function () {
        $('.text-section').text_count($('.editing-tab-input').find('textarea'), $('.editing_toolbar').find('em'));
        if ($('.text-preview-text').html() != '') {
            $('.menu-edit').hide();
            $('.text-preview').show();
        }
        if($('.fodder-date').html()){
            $('.text-preview').hide();
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