<?php
/* @var $this TransmitController */
/* @var $model Transmit */
/* @var $form CActiveForm */
?>
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/weixin_css/marketing_tool.css" />

<div class="right content-main">
    <div class="margin-top-10 tabhost">
        <div class="tabhost-title">
            <ul>
                <li><a href="<?php echo Yii::app()->createUrl('systems/activitiy/index'); ?>">活动列表</a></li>
                <li class="active"><a href="<?php echo Yii::app()->createUrl('systems/activitiy/create'); ?>"><?php
                        $action = $this->getAction()->getId();
                        if ($action == 'create') {
                            echo '新建活动';
                        } else {
                            echo '修改活动';
                        }
                        ?></a></li>
                <li><a href="<?php echo Yii::app()->createUrl('systems/activitiy/awardlist'); ?>">中奖名单</a></li>
                <li><a href="<?php echo Yii::app()->createUrl('systems/transmitUser/index', array('type' => 1)); ?>">转发记录</a></li>
            </ul>

            <div class="clear"></div>
        </div>
        <div class="margin-right-15 right wechat-seek">
            <form>
                <input type="text" class="left wechat-seek-input" size="30" placeholder="活动信息">
                <input type="submit" class="left wechat-seek-button" value="">
            </form>
        </div>
        <div class="padding20 tabhost-center">

            <?php
            $form = $this->beginWidget('CActiveForm', array(
                'id' => 'transmit-form',
                // Please note: When you enable ajax validation, make sure the corresponding
                // controller action is handling ajax validation correctly.
                // There is a call to performAjaxValidation() commented in generated controller code.
                // See class documentation of CActiveForm for details on this.
                'enableAjaxValidation' => false,
                'htmlOptions' => array('enctype' => 'multipart/form-data',),
            ));
            ?>
            <?php echo $form->errorSummary($model); ?>

            <div class="form marketing_add_article">
                <div class="row add_article_list">
                    <?php echo $form->labelEx($model, 'title'); ?>
                    <?php echo $form->textField($model, 'title', array('size' => 67, 'maxlength' => 50)); ?>
                    <?php echo $form->error($model, 'title'); ?>
                </div>

                <div class="row add_article_list">
                    <div class="left">
                        <?php
                        if (!empty($model->time_start)) {
                            $time_start = date('Y-m-d H:i:s', $model->time_start);
                        } else {
                            $time_start = date('Y-m-d H:i:s', time());
                        }
                        if (!empty($model->time_end)) {
                            $time_end = date('Y-m-d H:i:s', $model->time_end);
                        } else {
                            $time_end = date('Y-m-d H:i:s', strtotime("+3 day"));
                        }
                        ?>
                        <?php echo $form->labelEx($model, 'time_start'); ?>
                        <?php echo $form->textField($model, 'time_start', array('class' => 'laydate-icon', 'value' => $time_start)); ?>
                        <?php echo $form->error($model, 'time_start'); ?>
                    </div>
                    <div class="left">
                        <?php echo $form->labelEx($model, 'time_end'); ?>
                        <?php echo $form->textField($model, 'time_end', array('class' => 'laydate-icon', 'value' => $time_end)); ?>
                        <?php echo $form->error($model, 'time_end'); ?>
                    </div>
                </div>
                <div class="row add_article_list">
                    <?php echo $form->labelEx($model, 'description'); ?>
                    <?php echo $form->textField($model, 'description', array('size' => 67, 'maxlength' => 255)); ?>
                    <?php echo $form->error($model, 'description'); ?>
                </div>
                <div class="add_article_list">
                    <label class="left">设置封面<span class="required">*</span></label>
                    <div class="add_article_list_img">
                        <img src="<?php echo Yii::app()->params->WEBROOT . Yii::app()->params->FILEFOLDER . Yii::app()->params->FILEPATH['sourcefile']['image']['medium'] . $model->image_src; ?>"  class="none" />
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
                    <span class="margin-left-20">（图片大小：<i class="color-red">宽：66px；高：58px</i>）</span>
                </div>
                <div class="add_article_list">
                    <label></label>

                    <?php echo $form->checkbox($model, 'show_cover_pic', array('class' => 'frm_checkbox')); ?>
                    是否显示封面

                </div>
                <div class="row add_article_list">
                    <?php echo $form->labelEx($model, 'content', array('class' => 'left')); ?>

                    <div class="left">
                        <div class="textarea">
                            <?php echo $form->textarea($model, 'content', array('id' => 'SourceFile_content')); ?>
                            <?php
                            $this->widget('ext.ueditor.Ueditor', array(
                                'getId' => 'SourceFile_content',
                                'UEDITOR_HOME_URL' => "/",
                                'options' => '
                        toolbars:[["fontfamily","fontsize","forecolor","bold","italic","underline","strikethrough","backcolor","removeformat","|","indent","|","justifyleft","justifycenter","justifyright","justifyjustify","|",
    "rowspacingtop","rowspacingbottom","lineheight","|","insertunorderedlist","insertorderedlist","blockquote","horizontal","|","insertvideo","insertimage","|",
    "link","unlink","highlightcode","|","undo","redo","source"]],
                    wordCount:true,
                    elementPathEnabled:false,
                    initialContent:"",
                    imageUrl:"' . Yii::app()->createUrl('/basis/sourcefile/imageupload') . '",
                    imagePath:"",
                    imageManagerUrl:"' . Yii::app()->createUrl('/basis/sourcefile/onlineimage') . '",
                    imageManagerPath:"",
                    ',
                            ));
                            ?>
                        </div>
                    </div>
                    <?php /* echo $form->textArea($model, 'content', array('rows' => 6, 'cols' => 50)); */ ?>
                    <?php /* echo $form->error($model, 'content'); */ ?>

                </div>

                <div class="row add_article_list">
                    <div class="left">
                        <?php echo $form->labelEx($model, 'number'); ?>
                        <?php echo $form->textField($model, 'number'); ?>
                        <?php echo $form->error($model, 'number'); ?>
                    </div>
                    <div class="left">
                        <?php echo $form->labelEx($model, 'integral'); ?>
                        <?php echo $form->textField($model, 'integral'); ?>
                        <?php echo $form->error($model, 'integral'); ?>
                    </div>
                </div>
                <div class="row add_article_list">
                    <div class="left">
                        <?php echo $form->labelEx($model, 'order_by'); ?>
                        <?php echo $form->textField($model, 'order_by'); ?>
                        <?php echo $form->error($model, 'order_by'); ?>
                    </div>
                    <div class="left">
                        <?php echo $form->labelEx($model, 'star'); ?>
                        <?php echo $form->dropDownList($model, 'star', Yii::app()->params->STAR); ?>
                        <?php echo $form->error($model, 'star'); ?>
                    </div>

                </div>
                <div class="row add_article_list">

                    <div class="left">
                        <?php echo $form->labelEx($model, 'content_source_url'); ?>
                        <?php echo $form->textField($model, 'content_source_url', array('size' => 76, 'maxlength' => 255)); ?>
                        <?php echo $form->error($model, 'content_source_url'); ?>
                    </div>

                </div>
                <div class="row buttons text-center add_article_list">
                    <?php echo CHtml::submitButton($model->isNewRecord ? '确定' : '保存', array('class' => 'margin-top-15 button button-green')); ?>
                    <?php echo $form->hiddenField($model, 'image_src', array('id' => 'result-id')); ?>
                </div>

                <?php $this->endWidget(); ?>

            </div>

        </div>
    </div>
</div>
<script type="text/javascript">

    $(function () {



        //forwarding();
        function forwarding() {
            if ($('#Transmit_type_id').find('option:selected').text() != '有奖活动') {
                $('#Transmit_number').prev().html('阅读人数');
                $('#Transmit_status').html('<option value="1">置顶</option><option value="1">取消置顶</option>').prev().html('置顶');
            } else {
                $('#Transmit_number').prev().html('转发人数');
                $('#Transmit_status').html('<option selected="selected" value="0">未开始</option><option value="1">活动中</option><option value="2">已结束</option>').prev().html('状态');
            }
        }

        //childtype($('#Transmit_type_id').val());
        if ($(".add_article_list_img img").attr('src') != 'http://wechat.oppein.cn/upload/sourcefile/image/medium/')
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
        time_sorter('#Transmit_time_start', '#Transmit_time_end', 'YYYY-MM-DD');//时间选择器
    })
</script>




