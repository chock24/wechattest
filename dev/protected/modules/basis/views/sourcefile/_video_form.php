<div class="padding30 tabhost-center">

    <!--    <div class="left fodder add-mage-text">
            <div class="fodder-center add-mage-text-border-bottom">
    
                <div class="fodder-img add-mage-text-img">
                    <img class="none add-image-preview-img" src="" />
                    <i class="add-mage-text-img-background">封面图片</i>
                </div>
                <h4>
                    <a href="javascript:;" title="标题">标题</a>
                </h4>
            </div>
        </div>-->
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'source-create-form',
        'enableClientValidation' => true,
        'htmlOptions' => array('enctype' => 'multipart/form-data',),
    ));
    ?>
    <div class="fresh-upload">

        <div class="margin-bottom-20 fresh-upload-list">
            <?php /* echo $form->labelEx($model, 'title',array('class'=>'left')); */ ?>
            <label>标题<span class="margin-left-5 color-red">*</span></label>
            <?php /* echo $form->labelEx($model, 'title'); */ ?>
            <div class="left add-mage-text-compile-content title">
                <?php echo $form->textField($model, 'title', array('size' => 50, 'placeholder' => '标题')); ?>
                <?php echo $form->error($model, 'title'); ?>
                <span class="right color-9"><em>0</em>/60</span>
            </div>
        </div>
        <div class="margin-bottom-20 row fresh-upload-list">
            <label for="SourceFile_length">分类<span class="margin-left-5 color-red">*</span></label>
            <select data-val="" name="gather_id" class="margin-top-5">
                <?php foreach ($sourceFileGather as $s) { ?>
                    <option value="<?php echo $s->id; ?>"><?php echo $s->name; ?></option>
                <?php };
                ?>
            </select>
        </div>

        <div class="margin-bottom-20 add-mage-text-compile fresh-upload-list">
            <label>视频内容<span class="margin-left-5 color-red">*</span></label>
            <div class="left">
                <p class="color-6">视频大小不超过20M，支持大部分主流视频格式</p>
                <div class="margin-top-10 none fresh-upload-progress">
                    <h5><span><!-- 文件名 --></span><em>0%</em></h5>
                    <div class="fresh-upload-progress-bar"><div class="fresh-upload-progress-bar-bg"></div></div>
                    <p>文件正在上传</p>
                </div>
                <?php /* echo $form->labelEx($model, 'filename'); */ ?>
                <?php echo $form->fileField($model, 'filename', array('class' => 'none add-image-preview')); ?>
                <a href="javascript:;" class="margin-top-10 left button button-white" onclick="$(this).prev().click();">选择文件</a>
                <?php echo $form->error($model, 'filename'); ?>
                <div class="margin-top-15 left up-state color-9"></div>
            </div>
        </div>
        <!--<div class="margin-top-5 margin-bottom-20 row fresh-upload-list">
            <?php /*echo $form->labelEx($model, 'length'); */?>
            <?php /*echo $form->textField($model, 'length'); */?>
            <?php /*echo $form->error($model, 'length'); */?>
        </div>-->
        <div class="margin-top-5 margin-bottom-20 row fresh-upload-list">
            <label>排序</label>
            <?php echo $form->textField($model, 'sort', array('size' => '20')); ?>
        </div>
        <div class="margin-top-5 row fresh-upload-list">
            <label>备注</label>
            <?php /* echo $form->labelEx($model, 'description'); */ ?>
            <?php echo $form->textArea($model, 'description', array('rows' => 10, 'cols' => 70)); ?>
            <?php echo $form->error($model, 'description'); ?>
        </div>
    </div>
    <div class="clear"></div>
    <div class="add-mage-text-submit">
        <?php echo CHtml::submitButton('保存', array('class' => 'left button button-browns fresh-upload-button')) ?>
    </div>
    <?php $this->endWidget(); ?>
</div>
<script type="text/javascript">
    function filesize(ele) {//判断上传的素材的大小
        // 返回 KB，保留小数点后两位
        return (ele.files[0].size / 1024).toFixed(2);
    }
    $(function () {
        $('.title').form_count(60);
        $('#SourceFile_filename').change(function () {
            $('.fresh-upload-progress-bar-bg').css('width', '0');
            $('.up-state').html('');
            var $text = $(this).attr('value');
            var $text0 = $text.substr($text.lastIndexOf(".") + 1, $text.length);
            if (filesize(this) < 20000) {
                if ($text0 == 'mov' || $text0 == 'rmvb' || $text0 == 'wmv' || $text0 == 'avi' || $text0 == 'mpeg' || $text0 == 'mpg' || $text0 == 'rm' || $text0 == 'mp4') {
                    $('.button-white').html('重新选择素材');
                    $('.fresh-upload-progress').show().find('h5 span').html($text);
                    $('.fresh-upload-progress-bar-bg').animate({width: "70%"}, 1500, function () {
                        $('.fresh-upload-progress-bar-bg').animate({width: "100%"}, 500);
                    });
                    var fresh_upload = setInterval(function () {
                        $('.fresh-upload-progress').find('h5 em').html((($('.fresh-upload-progress-bar-bg').width() / $('.fresh-upload-progress-bar').width()) * 100).toFixed(0) + '%');
                        if (($('.fresh-upload-progress-bar-bg').width() / 438) == 1) {
                            window.clearInterval(fresh_upload);
                            $('.fresh-upload-progress').find('p').html('文件上传成功');
                        }
                    }, 100);
                } else {
                    $('.up-state').html("你选择了素材" + "“ " + $text + " ”<span class='color-red'>文件格式错误</span>");
                    $('.fresh-upload-progress').hide();
                }
            } else {
                $('.up-state').html("你选择的素材" + "“ " + $text + " ”大小超过20M。<span class='color-red'>请重新上传</span>");
                $('.fresh-upload-progress').hide();
            }
        });
        $('.add-mage-text-submit').find('input').click(function () {
            var $text1 = $('#SourceFile_filename').attr('value').substr($('#SourceFile_filename').attr('value').indexOf(".") + 1, $('#SourceFile_filename').attr('value').length);
            if ($text1 == '') {
                alert('对不起！你还没有选择音频素材。');
                return false;
            } else if ($text1 == 'rmvb' || $text1 == 'mov' || $text1 == 'wmv' || $text1 == 'avi' || $text1 == 'mpeg' || $text1 == 'mpg' || $text1 == 'rm' || $text1 == 'mp4') {
                return true;
            } else {
                alert('对不起，你选择的素材文件后缀为“' + $text1 + '”，不支持此类文件(仅支持mp3,wma,wav,amr后缀)。');
                return false;
            }
        });
    })
</script>