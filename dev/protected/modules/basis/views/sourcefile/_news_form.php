<div class="padding30 tabhost-center">

    <div class="left fodder add-mage-text">
        <div class="fodder-center add-mage-text-border-bottom">
            <h4>
                <a href="javascript:;" title="标题">标题</a>
            </h4>
            <div class="fodder-img add-mage-text-img">
                <img class="none add-image-preview-img" src="http://wechat.oppein.cn/upload/sourcefile/image/medium/20150129102741142874.jpg" />
                <i class="add-mage-text-img-background">封面图片</i>
            </div>
            <p class="fodder-introduce add-mage-text-title"></p>
        </div>
    </div>

    <div class="left add-mage-text-input">
        <div class="triangle"></div>

        <?php
        $form = $this->beginWidget('CActiveForm', array(
            'id' => 'source-create-form',
            'enableClientValidation' => true,
            'htmlOptions' => array('enctype' => 'multipart/form-data',),
        ));
        ?>
        <div class="add-mage-text-compile">
            <?php echo $form->labelEx($model, 'title'); ?>
            <div class="add-mage-text-compile-content title">
                <?php echo $form->textField($model, 'title', array('size' => 82, 'placeholder' => '标题')); ?>
                <span class="right color-9"><em>0</em>/60</span>
            </div>
            <?php echo $form->error($model, 'title'); ?>
        </div>
        <div class="add-mage-text-compile author">
            <?php echo $form->labelEx($model, 'author'); ?>
            <div class="add-mage-text-compile-content">
                <?php echo $form->textField($model, 'author', array('size' => 82, 'placeholder' => '作者')); ?>
                <span class="right color-9"><em>0</em>/8</span>
            </div>
            <?php echo $form->error($model, 'author'); ?>
        </div>
        <div class="add-mage-text-compile">
            <?php echo $form->labelEx($model, 'public_name'); ?>
            <div class="add-mage-text-compile-content">
                <?php echo $form->textField($model, 'public_name', array('size' => 88, 'placeholder' => '公众号名称')); ?>
            </div>
            <?php echo $form->error($model, 'public_name'); ?>
        </div>
        <div class="add-mage-text-compile">
            <?php echo $form->labelEx($model, 'public_url'); ?>
            <div class="add-mage-text-compile-content">
                <?php echo $form->textField($model, 'public_url', array('size' => 88, 'placeholder' => '点击公众号跳转地址')); ?>
            </div>
            <?php echo $form->error($model, 'public_url'); ?>
        </div>
        <div class="add-mage-text-compile">
            <?php echo $form->labelEx($model, 'filename'); ?>
            <input type="file" class="none add-image-preview" value="上传" />
            <a href="javascript:;" class="margin-top-8 button button-white" onclick="$(this).prev().click();">上传</a>
            <a href="javascript:;" class="margin-top-8 button button-white">从图片库选择</a>
            <?php echo $form->fileField($model, 'filename', array('class' => 'none')); ?>
            <?php echo $form->error($model, 'filename'); ?>
        </div>
        <div class="add-mage-text-compile">
            <?php echo $form->labelEx($model, 'description'); ?>
            <div class="add-mage-text-compile-content textarea">
                <?php echo $form->textArea($model, 'description'); ?>
                <span class="right color-9"><em>0</em>/120</span>
            </div>
            <?php echo $form->error($model, 'description'); ?>
        </div>
        <div class="add-mage-text-compile">
            <?php echo $form->labelEx($model, 'content'); ?>
            <div class="textarea">
                <?php echo $form->textArea($model, 'content'); ?>
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
            <?php echo $form->error($model, 'content'); ?>
        </div>
        <div class="add-mage-text-compile">
            <?php echo $form->labelEx($model, 'content_source_url'); ?>
            <div class="add-mage-text-compile-content textarea">
                <?php echo $form->textField($model, 'content_source_url', array('size' => 88)); ?>
            </div>
            <?php echo $form->error($model, 'content_source_url'); ?>
        </div>
        <div class="add-mage-text-compile">
            <label>
                是否选择公开
                <?php echo $form->checkbox($model, 'status'); ?>
                <?php echo $form->error($model, 'status'); ?>
            </label>
        </div>

    </div>
    <div class="clear"></div>
    <div class="add-mage-text-submit">
        <?php echo CHtml::submitButton('保存', array('class' => 'button button-green')) ?>
        <a href="javascript:;" class="button button-white">预览</a>
    </div>
    <?php $this->endWidget(); ?>
</div>
<script type="text/javascript">
    $(function() {
        $('.title').form_count(60);
        $('.author').form_count(8);
        $('.textarea').form_count(120);
        $('.add-mage-text').Header();
        wechat_icovw($('#SourceFile_title'),$('.add-mage-text-border-bottom h4 a'),'标题');
        wechat_icovw($('#SourceFile_description'),$('.add-mage-text-title'));
        web_release ($('.add-mage-text-submit').find('input:submit'));//关闭页面提醒
        //获取file的地址赋值给img
        $(".add-image-preview").on("change", function(){
            var objUrl = getObjectURL(this.files[0]) ;
            console.log("objUrl = "+objUrl) ;
            if (objUrl) {
                $(".add-image-preview-img").attr("src", objUrl).show();
                $(".add-image-preview-img").next().hide();
            }
        }) ;
        //建立一個可存取到該file的url
        function getObjectURL(file) {
            var url = null ;
            if (window.createObjectURL!=undefined) { // basic
                url = window.createObjectURL(file) ;
            } else if (window.URL!=undefined) { // mozilla(firefox)
                url = window.URL.createObjectURL(file) ;
            } else if (window.webkitURL!=undefined) { // webkit or chrome
                url = window.webkitURL.createObjectURL(file);
            }
            return url ;
        }
    })
</script>