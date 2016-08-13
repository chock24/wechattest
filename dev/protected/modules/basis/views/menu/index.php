<?php $public_id = Yii::app()->user->getState('public_id'); ?>
<link href="<?php echo Yii::app()->baseUrl; ?>/weixin_css/reply.css" rel="stylesheet" type="text/css" />
<link href="<?php echo Yii::app()->baseUrl; ?>/weixin_css/member_home.css" rel="stylesheet" type="text/css" />
<div class="right content-main">
    <h2 class="content-main-title">自定义菜单</h2>

    <div class="padding10 reply">
        <div class="padding10 color-9">本地创建自定义菜单后，需要提交到微信服务器才能生效，因为微信客户端存在缓存，24小时内生效，如需即时查看效果，可取消关注后再关注即可。</div>

        <div class="create-menu">
            <div class="left create-menu-nav">
                <div class="create-menu-title">
                    <h4 class="left">菜单管理</h4>
                    <div class="right margin-right-5 create-menu-title-event">
                        <?php echo CHtml::link('', array('create'), array('class' => 'icon-16 icon-16-add', 'title' => '添加一级菜单', 'onclick' => 'js:return popup($(this),"创建一级菜单",700,417);')); ?>
                        <a class="icon-16 icon-16-sort" href="javascript:;" title="排序(暂无)"></a>
                        <!--<a class="none button button-white" href="javascript:;">完成</a>
                        <a class="none button button-white" href="javascript:;">取消</a>-->
                    </div>
                </div>
                <?php
                $this->widget('zii.widgets.CListView', array(
                    'id' => 'menu-listview',
                    'dataProvider' => $dataProvider,
                    'itemView' => '_view',
                    'template' => '{items}',
                ));
                ?>

            </div>
            <div class="left create-menu-edit">
                <div class="create-menu-title">
                    <h4>
                        <span class="left">设置动作 - <?php echo @CHtml::encode($model->title); ?></span>
                        <?php
                        if (@$model->public_id == 1) {
                            if (@$model->template == 0) {
                                ?>
                                <a href="<?php echo Yii::app()->createUrl('basis/menu/index', array('template' => '1')); ?>" class="right button button-white create-menu-title-input">设置为模板</a>
                            <?php } else { ?>
                                <a href="<?php echo Yii::app()->createUrl('basis/menu/index', array('template' => '0')); ?>" class="right button button-white create-menu-title-input">取消模板</a>
                                <?php
                            }
                        }
                        ?>
                    </h4>
                </div>
                <div class="create-menu-edit-content">
                    <?php if ($model)://如果点击了自定义菜单  ?>
                        <?php if ($model->type || Yii::app()->request->getParam('type'))://如果有选择发送类型?>
                            <?php if ($model->type == 1 || Yii::app()->request->getParam('type') == 1): ?>
                                <?php if ($model->category == 5) {//如果是图文   ?>
                                    <div class="padding10 menu-preview">
                                        <?php if ($model->multi == 1)://如果是多图文  ?>
                                            <?php if (isset($model->sourceFileGroup->sourceDetail))://如果存在素材细节   ?>
                                                <div class="fodder mage-text">
                                                    <?php foreach (@$model->sourceFileGroup->sourceDetail as $key => $value)://循环素材细节   ?>
                                                        <?php if ($key == 0)://如果是第一个单图文    ?>
                                                            <div class="fodder-center">
                                                                <em class="fodder-date"><?php echo @Yii::app()->format->formatDate($model->sourceFileGroup->time_created); ?></em>
                                                                <div class="relative fodder-img mage-text-img">
                                                                    <?php echo @CHtml::link(CHtml::image(PublicStaticMethod::returnSourceFile($value->sourceFile->filename, $value->sourceFile->ext, 'image', 'medium')), array('/site/view', 'id' => $value->sourceFile->id), array('target' => '_blank')); ?>
                                                                    <div class="mage-text-img-title">
                                                                        <?php echo @CHtml::link(PublicStaticMethod::truncate_utf8_string($model->sourceFileGroup->title, 10), array('/site/view', 'id' => $value->sourceFile->id), array('target' => '_blank', 'title' => $model->sourceFileGroup->title)); ?>

                                                                    </div>
                                                                </div>
                                                            </div>
                                                        <?php else://如果不是第一个单图文     ?>
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
                                                    <?php endforeach; //结束素材细节循环   ?>
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
                                            <?php
                                            if ($model->status > 0 && $public_id != '1') {
                                                
                                            } else {
                                                echo CHtml::link('修改', 'javascript:;', array('class' => 'button button-green', 'onclick' => 'js:$(".menu-edit").show();$(".menu-preview").hide();'));
                                            }
                                            ?>
                                        </div>
                                    </div>
                                <?php } else if ($model->category == 2) {//如果是图片
                                    ?>

                                    <!--图片预览-->
                                    <div class="padding10 border-none none text-preview">
                                        <div class="padding10 text-preview-text">
                                            <div class="fodder mage-img">
                                                <div class="fodder-center mage-img-center border-bottom-width">
                                                    <div class="fodder-img mage-img-img">
                                                        <img alt="" src="<?php echo PublicStaticMethod::returnFile('sourcefile', $model->sourceFile->filename, $model->sourceFile->ext, 'image', 'medium'); ?>">
                                                    </div>
                                                    <div class="mage-img-label"><?php echo $model->sourceFile->title; ?></div>
                                                </div>
                                            </div>
                                            <div class="clear"></div>
                                            <?php /*echo $model->sourceFile->filename; */?>
                                        </div>
                                        <div class="margin-top-15">

                                            <?php
                                            if ($model->status > 0 && $public_id != '1') {
                                                
                                            } else {
                                                echo CHtml::link('修改', 'javascript:;', array('class' => 'button button-green', 'onclick' => 'js:$(".menu-edit").show();$(".text-preview").hide();'));
                                            }
                                            ?>
                                        </div>
                                    </div>
                                <?php } else if ($model->category == 3) {//如果是 音频 
                                    ?>
                                    <!--音频预览-->
                                    <div class="padding10 border-none none text-preview">
                                        <div class="padding10 text-preview-text">

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
                                            <?php /*echo $model->sourceFile->filename; */?>
                                        </div>
                                        <div class="margin-top-15">
                                            <?php
                                            if ($model->status > 0 && $public_id != '1') {
                                                
                                            } else {
                                                echo CHtml::link('修改', 'javascript:;', array('class' => 'button button-green', 'onclick' => 'js:$(".menu-edit").show();$(".text-preview").hide();'));
                                            }
                                            ?>
                                        </div>
                                    </div>
                                    <?php
                                } else if ($model->category == 4) {//如果是 视频
                                    ?>
                                    <!--视频预览-->
                                    <div class="padding10 border-none none text-preview">
                                        <div class="padding10 text-preview-text">
                                            <div class="margin-left-5">
                                                <span class="padding-left-5"><?php echo @$value->sourceFile->title; ?></span>
                                                <div class="video-messaging-list">
                                                    <video  src="<?php echo PublicStaticMethod::returnFile('sourcefile', $model->sourceFile->filename, $model->sourceFile->ext, 'video', 'medium'); ?>" controls="controls">您的浏览器不支持 video 标签。</video>
                                                    <a href="<?php echo PublicStaticMethod::returnFile('sourcefile', $model->sourceFile->filename, $model->sourceFile->ext, 'video', 'medium'); ?>" target="_blank">点击放大查看</a>
                                                </div>
                                            </div>
                                            <div class="clear"></div>
                                            <?php /*echo $model->sourceFile->filename; */?>
                                        </div>
                                        <div class="margin-top-15">

                                            <?php
                                            if ($model->status > 0 && $public_id != '1') {
                                                
                                            } else {
                                                echo CHtml::link('修改', 'javascript:;', array('class' => 'button button-green', 'onclick' => 'js:$(".menu-edit").show();$(".text-preview").hide();'));
                                            }
                                            ?>
                                        </div>
                                    </div><?php
                                } else {
                                    ?>
                                    <!--文字预览-->
                                    <div class="padding10 border-none none text-preview">
                                        <div class="padding10 text-preview-text"><?php echo PublicStaticMethod::replaceQqFace($model->description); ?></div>
                                        <div class="margin-top-15">
                                            <?php
                                            if ($model->status > 0 && $public_id != '1') {
                                                
                                            } else {
                                                echo CHtml::link('修改', 'javascript:;', array('class' => 'button button-green', 'onclick' => 'js:$(".menu-edit").show();$(".text-preview").hide();'));
                                            }
                                            ?>
                                        </div>
                                    </div>
                                <?php } ?>
                                <!--当编辑有内容的时候，调用的以下布局模块-->
                                <div class="padding10 create-send-show menu-edit <?php if ($model->category != 1 && $model->category): ?> none <?php endif; ?>">
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
                                        'id' => 'menu-form',
                                        'action' => array('update', 'id' => $model->id),
                                        'enableClientValidation' => true,
                                        'clientOptions' => array(
                                            'validateOnSubmit' => true,
                                        ),
                                    ));
                                    ?>

                                    <div class="editing">
                                        <div class="editing-tab">
                                            <ul class="editing-tab-nav">
                                                <li>
                                                    <?php echo CHtml::link('<i class="icon icon-text"></i>', array('index', 'id' => $model->id, 'type' => 1, 'category' => 1), array('title' => '文本', 'onclick' => 'js:$("#news-section").hide();$("#text-section").show();return false;')); ?>
                                                </li>
                                                <li>
                                                    <?php echo CHtml::link('<i class="icon icon-img"></i>', array('sourcefile', 'id' => $model->id, 'type' => 1, 'category' => 2), array('title' => '图片', 'onclick' => 'js:return popup($(this),"图片",850,500);')); ?>
                                                </li>
                                                <li>
                                                    <?php echo CHtml::link('<i class="icon icon-voice"></i>', array('sourcefile', 'id' => $model->id, 'type' => 1, 'category' => 3), array('title' => '音频', 'onclick' => 'js:return popup($(this),"音频",850,500);')); ?>
                                                </li>
                                                <li>
                                                    <?php echo CHtml::link('<i class="icon icon-video"></i>', array('sourcefile', 'id' => $model->id, 'type' => 1, 'category' => 4), array('title' => '视频', 'onclick' => 'js:return popup($(this),"视频",850,500);')); ?>
                                                </li>
                                                <li>
                                                    <?php echo CHtml::link('<i class="icon icon-single-graphic"></i>', array('sourcefile', 'id' => $model->id, 'type' => 1, 'category' => 5, 'multi' => 0), array('title' => '单图文', 'onclick' => 'js:return popup($(this),"单图文库",850,500);')); ?>
                                                </li>
                                                <li>
                                                    <?php echo CHtml::link('<i class="icon icon-more-graphic"></i>', array('sourcefile', 'id' => $model->id, 'type' => 1, 'category' => 5, 'multi' => 1), array('title' => '多图文', 'onclick' => 'js:return popup($(this),"多图文库",850,500);')); ?>
                                                </li>
                                            </ul>
                                            <div id="news-section" class="none fodder mage-text"></div>
                                            <div class="clear"></div>
                                            <div id="text-section">
                                                <div class="editing-tab-input">
                                                    <?php echo $form->textArea($model, 'description', array('id' => 'operationText', 'data-id' => 0, 'data-multi' => 0, 'data-type' => 1, 'onchange' => 'js:return popupConfirm($(this),$("#result-id"),$("#result-multi"),$("#result-type"),1)')); ?>
                                                    <?php echo $form->error($model, 'description'); ?>
                                                </div>
                                                <div class="editing_toolbar">
                                                    <a class="left emotion" href="javascript:;"><i class="icon icon-face"></i></a>
                                                    <p class="right">还可以输入<em>500</em>字</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="padding-top-30 menu-Submit">
                                        <?php echo $form->hiddenField($model, 'type', array('value' => 1)); ?>
                                        <?php echo $form->hiddenField($model, 'category', array('id' => 'result-type')); ?>
                                        <?php echo $form->hiddenField($model, 'source_file_id', array('id' => 'result-id')); ?>
                                        <?php echo $form->hiddenField($model, 'multi', array('id' => 'result-multi')); ?>
                                        <?php echo CHtml::submitButton('保存', array('class' => 'button button-green')); ?>
                                        <?php echo CHtml::link('返回', array('index', 'id' => $model->id), array('class' => 'button button-white return')); ?>
                                    </div>
                                    <?php $this->endWidget(); ?>
                                </div>

                            <?php elseif ($model->type == 2 || Yii::app()->request->getParam('type') == 2)://如果选择发送链接         ?>
                                <div class="create-link-show">
                                    <div class="create-edit-add-nav">
                                        <?php
                                        $form = $this->beginWidget('CActiveForm', array(
                                            'id' => 'menu-form',
                                            'action' => array('update', 'id' => $model->id),
                                            'enableClientValidation' => true,
                                            'clientOptions' => array(
                                                'validateOnSubmit' => true,
                                            ),
                                        ));
                                        ?>
                                        <?php echo $form->labelEx($model, 'url'); ?>
                                        <?php echo $form->hiddenField($model, 'type', array('value' => 2)); ?>
                                        <?php echo $form->textField($model, 'url', array('size' => 60, 'placeholder' => '输入链接地址')); ?>
                                        <?php echo $form->error($model, 'url'); ?>
                                        <div class="padding-top-30 text-center">
                                            <?php echo CHtml::submitButton('保存', array('class' => 'button button-green')); ?>
                                            <?php echo CHtml::link('返回', array('index', 'id' => $model->id), array('class' => 'button button-white return')); ?>
                                        </div>
                                        <?php $this->endWidget(); ?>
                                    </div>
                                </div>
                            <?php endif; ?>
                        <?php else: ?>
                            <div class="text-center padding10">
                                <p class="padding30 create-prompt color-9">请选择订阅者点击菜单后，公众号做出的相应动作</p>
                                <?php echo CHtml::link('<i class="icon-50 icon-50-info"></i>发送内容', array('index', 'id' => $model->id, 'type' => 1), array('class' => 'create-send')); ?>
                                <?php echo CHtml::link('<i class="icon-50 icon-50-link"></i>跳转到页面', array('index', 'id' => $model->id, 'type' => 2), array('class' => 'create-link')); ?>
                            </div>
                        <?php endif; ?>

                    <?php else: ?>
                        <p class="create-prompt color-9">你可以先添加一个菜单，然后开始为其设置响应动作</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <div class="clear"></div>
        <div class="add-mage-text-submit">
            <?php echo CHtml::link('发布菜单', array('generate'), array('class' => 'button button-green')); ?>
            <?php echo CHtml::link('撤销菜单', array('remove'), array('class' => 'button button-white')); ?>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(function () {
        var $size = '<?php echo Yii::app()->user->getState('public_id') ?>';
        if ($size != '1') {
            $('dd').each(function () {
                if ($(this).attr('class') == 'lock') {
                    $(this).find('.create-menu-nav-content-event').html('');
                }
            });
        }
        if ($('.text-preview-text').html() != '') {
            $('.menu-edit').hide();
            $('.text-preview').show();
        }
        $('.menu-Submit').find('input:submit').click(function () {
            if ($('#news-section').html() != '') {
                $('#text-section').find('textarea').val('');
            }
        });
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