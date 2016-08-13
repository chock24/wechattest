<?php $public_id = Yii::app()->user->getstate('public_id'); ?>
<div class="keyword">
    <div class="keyword-list">
        <?php
        echo CHtml::link('规则:#' . $data->id . ' ' . $data->title, array(), array('class' => 'keyword-list-title', 'data-modify' => 3,
            'data_id' => $data->id));
        ?>
        <?php echo CHtml::link('删除', array('delete', 'id' => $data->id), array('class' => 'right button button-white keyword-list-del')); ?>
        <?php
        if ($public_id == '1') {
            if ($data->template == 0) {
                echo CHtml::link('设置为模板', Yii::app()->createUrl('basis/rule/index', array('id' => $data->id, 'template' => '1')), array('class' => 'right button button-white', 'style' => 'margin:-36px 80px 0 0;*margin-right: 5px;'));
            } else {
                echo CHtml::link('取消为模板', Yii::app()->createUrl('basis/rule/index', array('id' => $data->id, 'template' => '0')), array('class' => 'right button button-dc', 'style' => 'margin:-36px 80px 0 0;*margin-right: 5px;'));
            }
        }
        ?>
        <div class="keyword-list-original">
            <div class="keyword-list-original-keyword">
                <p class="left">关键字:</p>
                <?php if ($data->keyword): ?>
                    <?php foreach ($data->keyword as $key => $value): ?>
                        <?php echo CHtml::link($value->title, 'javascript:;', array('class' => 'keyword-list-original-keyword-item')); ?>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
            <div>
                <?php echo count($data->reply) > 0 ? count($data->reply) : "0"; ?>条:
                <?php
                $textCount = 0;
                $textImgCount = 0;
                ?>
                <?php if ($data->reply): ?>
                    <?php
                    foreach ($data->reply as $key => $value) {
                        if ($value->type == 1) {
                            $textCount++;
                        } elseif ($value->type == 5) {
                            $textImgCount++;
                        } else {
                            continue;
                        }
                    }
                    ?>
                <?php endif; ?>
                <?php echo CHtml::encode('(' . $textCount . '条文字 , ' . $textImgCount . '条图文)'); ?>
                <div class="clear"><?php echo $data->entire == 1 ? '发送全部' : ""; ?></div>
            </div>
        </div>

        <div class="none keyword-list-modify">

            <?php
            $form = $this->beginWidget('CActiveForm', array(
                'id' => 'ruleupdate-form',
                'action' => Yii::app()->createUrl('basis/rule/index'), //这里我把action重新指向site控制器的login动作
                // Please note: When you enable ajax validation, make sure the corresponding
                // controller action is handling ajax validation correctly.
                // There is a call to performAjaxValidation() commented in generated controller code.
                // See class documentation of CActiveForm for details on this.
                'enableAjaxValidation' => false,
            ));
            ?>
            <div class="keyword-list-modify-list">
                <label>规则名 <span class="color-red">*</span></label>
                <?php echo $form->hiddenField($data, 'id'); ?>
                <?php echo $form->textField($data, 'title'); ?>
                <?php echo CHtml::submitButton($data->isNewRecord ? '创建' : '保存修改', array('class' => "margin-left-20 width-auto button button-white")); ?>
            </div>
            <?php $this->endWidget(); ?>
            <form>
                <?php
                $form = $this->beginWidget('CActiveForm', array(
                    'id' => 'rule-form',
                    // Please note: When you enable ajax validation, make sure the corresponding
                    // controller action is handling ajax validation correctly.
                    // There is a call to performAjaxValidation() commented in generated controller code.
                    // See class documentation of CActiveForm for details on this.
                    'enableAjaxValidation' => false,
                ));
                ?>

                <div class="keyword-list-modify-list">
                    <label>关键字：</label>
                    <a href="<?php echo Yii::app()->createUrl('basis/keyword/create', array('id' => $data->id)); ?>" onclick="js:return popup($(this), '添加关键字', 320, 200);" class="ie7margin-top25 right margin-top-8">+添加关键字</a>
                </div>
                <div class="keyword-list-modify-list">
                    <?php if ($data->keyword): ?>
                        <?php foreach ($data->keyword as $key => $value): ?>
                            <div class="keyword-list-modify-list-count">
                                <label class="left"><?php echo $value->title; ?></label>
                                <label class="left"><?php echo $value->type == 0 ? "未全匹配" : "全匹配"; ?></label>
                                <a href="<?php echo Yii::app()->createUrl('basis/keyword/update', array('id' => $value->id)); ?>" onclick="js:return popup($(this), '修改关键字', 320, 200);"
                                   title="修改" class="margin-top-8 margin-right-15 icon icon-text"></a>
                                <a href="<?php echo Yii::app()->createUrl('basis/keyword/delete', array('id' => $value->id)); ?>" title="删除" class="margin-top-8 icon icon-del"></a>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
                <div class="keyword-list-modify-list">
                    <label>回复内容：</label>
                    <a href="<?php echo Yii::app()->createUrl('basis/reply/index', array('rule_id' => $data->id, 'type' => '1')); ?>" class="ie7margin-top25 right margin-top-8 keyword-list-modify-list-input">+添加回复内容</a>
                    <div class="keyword-list-modify-list-date"></div><!--显示加载进来的添加内容-->
                </div>
                <div class="buttons keyword-list-modify-list">
                    <?php if ($data->reply): ?>
                        <?php foreach ($data->reply as $key => $value): ?>
                            <?php if ($value->type == 1) { ?>
                                <div class="keyword-list-modify-list-reply">
                                    <b>文字信息：</b>
                                    <?php echo PublicStaticMethod::replaceQqFace($value->content); ?>
                                    <a href="<?php echo Yii::app()->createUrl('basis/reply/delete', array('id' => $value->id)); ?>" title="删除" class="right icon icon-del"></a>
                                    <a href="<?php echo Yii::app()->createUrl('basis/reply/update', array('id' => $value->id)); ?>" onclick="js:return popup($(this), '修改回复内容', 450, 280);" title="修改" class="margin-right-15 right icon icon-text"></a>
                                </div>
                                <?php
                            } else if ($value->type == 2) { ?>
                                <div class='keyword-list-modify-list-reply'>
                                    <div class="margin-left-5 left">
                                        <b>图片：</b>
                                        <?php echo CHtml::image(PublicStaticMethod::returnSourceFile(@$value->sourceFile->filename, @$value->sourceFile->ext, 'image', 'medium', array('class' => 'left'))); ?>
                                    </div>
                                    <span class="margin-left-5 left"><?php echo @$value->sourceFile->title ?></span>
                                    <a class="right icon icon-del" title="删除" href="<?php echo Yii::app()->createUrl("basis/reply/delete", array("id" => $value->id)); ?>"></a>
                                </div>
                            <?php } else if ($value->type == 3) {
                                ?>

                                <div class='keyword-list-modify-list-reply'>
                                    <div class="margin-left-5 left">
                                        <b class="left">音频：</b>
                                        <div class="margin-left-5 left">
                                            <span class="padding-left-5"><?php echo @$value->sourceFile->title; ?></span>
                                            <div class="audio-message-list">
                                                <span class="margin-right-5 right color-9">
                                                    <?php
                                                    $titsa = @$value->sourceFile->length;
                                                    $hour = floor($titsa / 3600);
                                                    $minute = floor(($titsa - 3600 * $hour) / 60);
                                                    $second = floor((($titsa - 3600 * $hour) - 60 * $minute) % 60);
                                                    //echo $hour.':'.$minute.':'.$second;
                                                    echo $minute . ':' . $second;
                                                    ?>
                                                </span>
                                                <embed class="none" src="<?php echo PublicStaticMethod::returnFile('sourcefile', @$value->sourceFile->filename, @$value->sourceFile->ext, 'image', 'medium'); ?>" autostart="false" name="voi"></embed>
                                            </div>
                                        </div>
                                    </div>
                                    <a class="right icon icon-del" title="删除" href="<?php echo Yii::app()->createUrl("basis/reply/delete", array("id" => $value->id)); ?>"></a>
                                </div>

                                <!--<img  src="<?php /*echo Yii::app()->baseUrl; */?>/weixin_image/icon-info.png" />-->


                                <?php
                            } else if ($value->type == 4) {
                                ?>
                                    <div class='keyword-list-modify-list-reply'>
                                        <div class="margin-left-5 left">
                                            <b class="left">视频：</b>
                                            <div class="margin-left-5 left">
                                                <span class="padding-left-5"><?php echo @$value->sourceFile->title; ?></span>
                                                <div class="video-messaging-list">
                                                    <video  src="<?php echo PublicStaticMethod::returnFile('sourcefile', @$value->sourceFile->filename, @$value->sourceFile->ext, 'image', 'medium'); ?>" controls="controls">您的浏览器不支持 video 标签。</video>
                                                    <a href="<?php echo PublicStaticMethod::returnFile('sourcefile', @$value->sourceFile->filename, @$value->sourceFile->ext, 'image', 'medium'); ?>" target="_blank">点击放大查看</a>
                                                </div>
                                            </div>
                                        </div>
                                        <a class="right icon icon-del" title="删除" href="<?php echo Yii::app()->createUrl("basis/reply/delete", array("id" => $value->id)); ?>"></a>
                                    </div>
                                <?php
                            } else if ($value->type == 5) {
                                if ($value->multi == 0) {
                                    ?>
                                    <div class="keyword-list-modify-list-reply">
                                        <div class="margin-left-5 left">
                                            <b>单图文：</b>
                                            <?php echo CHtml::image(PublicStaticMethod::returnSourceFile(@$value->sourceFile->filename, @$value->sourceFile->ext, 'image', 'medium', array('class' => 'left'))); ?>
                                        </div>
                                        <div class="margin-left-5 left">
                                            <a href="<?php echo Yii::app()->createUrl('', array('site' => @$value->sourceFile->id)); ?>"><?php echo @$value->sourceFile->title; ?></a>
                                            <p><?php echo @$value->sourceFile->description; ?></p>
                                        </div>
                                        <a href="<?php echo Yii::app()->createUrl("basis/reply/delete", array("id" => $value->id)); ?>" title="删除" class="right icon icon-del"></a>
                                    </div>
                                    <?php
                                } elseif ($value->multi == 1) {
                                    ?>
                                    <div class="keyword-list-modify-list-reply">
                                        <div class="margin-left-5 left">
                                            <b>多图文：</b>
                                        </div>
                                        <div class="margin-left-5 left">
                                            <?php echo @$value->multiSourceFile->title; ?>
                                            <p><?php echo @$value->multiSourceFile->description; ?></p>
                                        </div>
                                        <a href="<?php echo Yii::app()->createUrl("basis/reply/delete", array("id" => $value->id)); ?>" title="删除" class="right icon icon-del"></a>
                                    </div>
                                    <?php
                                }
                            }
                            ?>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>


                <!--<div class="buttons keyword-list-modify-list">
                    <input type="button" class="button button-white" value="设置为模板">
                    <input type="button" class="button button-dc" value="取消为模板">
                </div>-->
                <?php $this->endWidget(); ?>
            </form>

        </div>
    </div>
</div>

<!--<div class="keyword">
<?php /*    echo CHtml::link('规则:#' . $data->id . ' ' . $data->title, array('view', 'id' => $data->id), array('class' => 'detail-item rule-title', 'data-modify' =>
  3, 'data_id' => $data->id));
 */ ?>
<?php /* echo CHtml::link('删除', array('delete', 'id' => $data->id), array('class' => 'delete-item web-menu-btn right inp_style')); */ ?>
    <div class="clear"></div>
    <div class="modify-section"></div>
</div>-->
