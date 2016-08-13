<div class="padding30 tabhost-center">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'source-create-form',
        'enableClientValidation' => true,
        'htmlOptions' => array('enctype' => 'multipart/form-data',),
    ));
    ?>
    <div class="fresh-upload">

        <div class="margin-bottom-20 fresh-upload-list">
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
        <div class="margin-bottom-20 fresh-upload-list add-mage-text-compile">
            <label>图片内容<span class="color-red">*</span></label>
            <?php /* echo $form->labelEx($model, 'filename'); */ ?>
            <div class="left">
                <p class="color-6">图片大小不超过2M，支持bmp、png、jpeg、jpg、gif格式</p>
                <img class="margin-top-10 none left fresh-upload-list-img" src="" />
                <div class="margin-top-15 margin-left-20 left up-state color-9"></div>
                <div class="clear"></div>
                <?php echo $form->fileField($model, 'filename', array('class' => 'none add-image-preview')); ?>
                <a href="javascript:;" class="button button-white" onclick="$(this).prev().click();">选择图片</a>
                <?php echo $form->error($model, 'filename'); ?>
            </div>
        </div>
        <div class="margin-top-5 margin-bottom-20 row fresh-upload-list">
            <label>排序</label>
            <input type="text" size="20" />
        </div>
        <div class="margin-top-5 row fresh-upload-list">
            <label>备注</label>
            <textarea cols="70" rows="10" class="padding10"></textarea>
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
        //获取file的地址赋值给img
        $(".add-image-preview").on("change", function () {
            var $text = $(this).attr('value');
            var $text0 = $text.substr($text.lastIndexOf(".") + 1, $text.length);
            if (filesize(this) < 2000) {
                if ($text0 == 'bmp' || $text0 == 'png' || $text0 == 'jpeg' || $text0 == 'jpg' || $text0 == 'gif') {
                    $('.button-white').html('重新选择图片');
                    var objUrl = getObjectURL(this.files[0]);
                    console.log("objUrl = " + objUrl);
                    if (objUrl) {
                        $(".fresh-upload-list-img").attr("src", objUrl).show().next().html('上传成功');
                    }
                } else {
                    $('.up-state').html("你选择的素材" + "“ " + $text + " ”<span class='color-red'>文件格式错误</span>");
                }
            } else {
                $('.up-state').html("你选择的素材" + "“ " + $text + " ”大小超过2M。<span class='color-red'>请重新上传</span>");
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
        $('.add-mage-text-submit').find('input').click(function () {
            var $text1 = $(".add-image-preview").attr('value').substr($(".add-image-preview").attr('value').indexOf(".") + 1, $(".add-image-preview").attr('value').length);
            if ($text1 == '') {
                alert('对不起！你还没有选择图片素材。');
                return false;
            } else if ($text1 == 'bmp' || $text0 == 'png' || $text1 == 'jpeg' || $text1 == 'jpg' || $text1 == 'gif') {
                return true;
            } else {
                alert('对不起，你选择的素材文件后缀为“' + $text1 + '”，不支持此类文件(仅支持bmp、png、jpeg、jpg、gif后缀)。');
                return false;
            }
        });
    })
</script>