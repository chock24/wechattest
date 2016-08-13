<?php
/* @var $this GiftController */
/* @var $model Gift */
/* @var $form CActiveForm */
?>
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl; ?>/weixin_js/jquery.wallform.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/weixin_css/marketing_tool.css" />

<div class="right content-main">
    <div class="margin-top-10 tabhost">
        <div class="tabhost-title">
            <ul>
                <li><a href="<?php echo Yii::app()->createUrl('systems/gift/index'); ?>">礼品商城</a></li>
                <li class="active"><a href="<?php echo Yii::app()->createUrl('systems/gift/create'); ?>">新增礼品</a></li>
                <li><a href="<?php echo Yii::app()->createUrl('systems/giftType/index'); ?>">礼品分类管理</a></li>
                <li><a href="<?php echo Yii::app()->createUrl('systems/giftExchange/index'); ?>">礼品兑换记录</a></li>
            </ul>

            <div class="clear"></div>
        </div>
        <div class="padding20 tabhost-center">

            <div class="form marketing_add_article">

                <?php
                $form = $this->beginWidget('CActiveForm', array(
                    'id' => 'gift-form',
                    // Please note: When you enable ajax validation, make sure the corresponding
                    // controller action is handling ajax validation correctly.
                    // There is a call to performAjaxValidation() commented in generated controller code.
                    // See class documentation of CActiveForm for details on this.
                    'enableClientValidation' => true,
                    'htmlOptions' => array('enctype' => 'multipart/form-data',),
                ));
                ?>

                <?php echo $form->errorSummary($model); ?>
                <div class="row add_article_list">
                    <?php echo $form->labelEx($model, 'name'); ?>
                    <?php echo $form->textField($model, 'name', array('size' => 60, 'maxlength' => 255)); ?>
                    <?php echo $form->error($model, 'name'); ?>
                </div>
                <?php if (!empty($gifttype)) { ?>
                    <div class="row add_article_list">
                        <?php echo $form->labelEx($model, 'type_id'); ?>
                        <?php echo $form->dropDownList($model, 'type_id', $gifttype); ?>
                        <?php echo $form->error($model, 'type_id'); ?>
                    </div>
                <?php } ?>
                <div class="row add_article_list">
                    <div class="left">
                        <?php echo $form->labelEx($model, 'number'); ?>
                        <?php echo $form->textField($model, 'number', array('size' => 17, 'maxlength' => 200)); ?>
                        <?php echo $form->error($model, 'number'); ?>
                    </div>
                    <div class="left">
                        <?php echo $form->labelEx($model, 'count_stock'); ?>
                        <?php echo $form->textField($model, 'count_stock', array('size' => '17')); ?>
                        <?php echo $form->error($model, 'count_stock'); ?>
                    </div>
                </div>

                <div class="row add_article_list">
                    <div class="left">
                        <?php /* echo $form->labelEx($model, 'integral'); */ ?>
                        <label>商品积分</label>
                        <?php echo $form->textField($model, 'integral', array('size' => '17')); ?>
                        <?php echo $form->error($model, 'integral'); ?>
                    </div>
                    <div>
                        <?php echo $form->labelEx($model, 'prizevalue'); ?>
                        <?php echo $form->textField($model, 'prizevalue', array('size' => '17')); ?>
                        <?php echo $form->error($model, 'prizevalue'); ?>
                    </div>
                </div>

                <div class="add_article_list">
                    <div>
                        <label class="left">设置封面<span class="color-red">*</span></label>
                        <div class="add_article_list_img">
                            <?php
                                $imgdata=rtrim($model->image_src,',');
                                $img    =explode(',',$imgdata);
                            ?>
                            <?php if(isset($img[0])&&!empty($img[0])){?>
                                <img src="<?php echo Yii::app()->params->WEBROOT . Yii::app()->params->FILEFOLDER . Yii::app()->params->FILEPATH['sourcefile']['image']['medium'] . $img[0]; ?>"  class="none" />
                            <?php }else {?>
                                <img src="">
                            <?php } ?>
                            <i>封面<br/>图片1</i>
                        </div>
                        <input id="delimg" class="delete-addText" type="hidden" name="Gift[delimg]" value="">
                        <?php echo CHtml::activeFileField($model, 'files', array('class' => "none add-image-preview", 'style' => 'display:none')); ?>

                        <a onclick="$(this).prev().click();" class="button button-white" href="javascript:;">上传</a>
                        <?php
                        if (Yii::app()->user->hasFlash('alert')) {
                            echo '<br/>' . Yii::app()->user->getFlash('alert');
                        }
                        ?>
                        <!--<a onclick="js:return popup($(this), '从图库中选择图文', 880, 590);" class="margin-top-15 button button-white" href="<?php /*echo Yii::app()->createUrl('basis/sourcefile/sourcefile', array('type' => 2)); */?>">从图片库选择</a>-->
                        <span class="margin-left-20">（图片大小：<i class="color-red">宽：525px；高：424px</i>）</span>
                    </div>
                <!--</div>
                <div class="add_article_list">-->
                    <div class="clear"></div>
                    <div>
                        <label class="left">设置封面2<span class="color-red"></span></label>
                        <div class="add_article_list_img">
                            <?php if(isset($img[1])&&!empty($img[1])){?>
                            <img src="<?php echo Yii::app()->params->WEBROOT . Yii::app()->params->FILEFOLDER . Yii::app()->params->FILEPATH['sourcefile']['image']['medium'] . $img[1]; ?>"  class="none" />
                            <?php }else {?>
                                <img src="">
                            <?php } ?>
                            <i>封面<br/>图片2</i>
                        </div>
                        <input id="delimgtwo" class="delete-addText" type="hidden" name="Gift[delimgtwo]" value="">
                        <?php echo CHtml::activeFileField($model, 'filestwo', array('class' => "none add-image-preview", 'style' => 'display:none')); ?>
                        <a onclick="$(this).prev().click();" class="margin-top-15 button button-white" href="javascript:;">上传</a><br/>
                        <a class="margin-top-15 button button-white delete-addImages" href="javascript:;" data-id="1">删除封面</a>
                        <?php
                        if (Yii::app()->user->hasFlash('alert')) {
                            echo '<br/>' . Yii::app()->user->getFlash('alert');
                        }
                        ?>
                        <!--<a onclick="js:return popup($(this), '从图库中选择图文', 880, 590);" class="margin-top-15 button button-white" href="<?php /*echo Yii::app()->createUrl('basis/sourcefile/sourcefile', array('type' => 2)); */?>">从图片库选择</a>-->
                        <span class="margin-left-20">（图片大小：<i class="color-red">宽：525px；高：424px</i>）</span>
                    </div>
                <!--</div>
                <div class="add_article_list">-->
                    <div class="clear"></div>
                    <div>
                        <label class="left">设置封面3<span class="color-red"></span></label>
                        <div class="add_article_list_img">
                            <?php if(isset($img[1])&&!empty($img[1])){?>
                            <img src="<?php echo Yii::app()->params->WEBROOT . Yii::app()->params->FILEFOLDER . Yii::app()->params->FILEPATH['sourcefile']['image']['medium'] . $img[2]; ?>"  class="none" />
                            <?php }else {?>
                                <img src="">
                            <?php } ?>
                            <i>封面<br/>图片3</i>
                        </div>
                        <input id="delimgthree" class="delete-addText" type="hidden" name="Gift[delimgthree]" value="">
                        <?php echo CHtml::activeFileField($model, 'filesthree', array('class' => "none add-image-preview", 'style' => 'display:none')); ?>
                        <a onclick="$(this).prev().click();" class="margin-top-15 button button-white" href="javascript:;">上传</a><br/>
                        <a class="margin-top-15 button button-white delete-addImages" href="javascript:;" data-id="2">删除封面</a>
                        <?php
                        if (Yii::app()->user->hasFlash('alert')) {
                            echo '<br/>' . Yii::app()->user->getFlash('alert');
                        }
                        ?>
                        <!--<a onclick="js:return popup($(this), '从图库中选择图文', 880, 590);" class="margin-top-15 button button-white" href="<?php /*echo Yii::app()->createUrl('basis/sourcefile/sourcefile', array('type' => 2)); */?>">从图片库选择</a>-->
                        <span class="margin-left-20">（图片大小：<i class="color-red">宽：525px；高：424px</i>）</span>
                    </div>
                </div>


<!--                <div class="row add_article_list">-->
<!--                    <label class="margin-right-5 left">商品图片</label>-->
<!---->
<!--                    <div class="gift_details_file_con">-->
<!--                        <ul>-->
<!--                            --><?php
//                            if (!empty($model->image_arr)) {
//                                $images = explode(',', $model->image_arr);
//                                foreach ($images as $i) {
//                                    ?>
<!--                                    <li>-->
<!--                                        <img data-img="--><?php //echo $i; ?><!--" alt="" src="--><?php //echo Yii::app()->params->WEBROOT . Yii::app()->params->FILEFOLDER . Yii::app()->params->FILEPATH['sourcefile']['image']['medium'] . $i; ?><!--">-->
<!--                                        <a href="javascript:;">X</a>-->
<!--                                    </li>-->
<!--                                --><?php
//                                }
//                            }
//                            ?>
<!--                        </ul>-->
<!--                    </div>-->
<!--                    <div class="gift_details_file">-->
<!--                        <span class="button button-white">上传图片</span>-->
<!--                        <input type="file" name="photoimg" class="upload" onchange="add_img()">-->
<!--                    </div>-->
<!--                    <span class="margin-left-20">（图片大小：<i class="color-red">宽：540px；高：不固定</i>）</span>-->
<!--                    <div class="clear"></div>-->
<!--                </div>-->

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

                    <?php /* echo $form->textArea($model, 'content', array('rows' => 6, 'cols' => 50)); */ ?><!--
                    --><?php /* echo $form->error($model, 'content'); */ ?>
                </div>



                <div class="row add_article_list">
                    <?php echo $form->labelEx($model, 'remark'); ?>
                    <?php echo $form->textField($model, 'remark', array('size' => 60, 'maxlength' => 255)); ?>
                    <?php echo $form->error($model, 'remark'); ?>
                </div>

                <div class="row add_article_list">

                    <div class="left">
                        <?php echo $form->labelEx($model, 'order_by'); ?>
                        <?php echo $form->textField($model, 'order_by'); ?>
                        <?php echo $form->error($model, 'order_by'); ?>
                    </div>

                    <div class="left">
                        <?php echo $form->labelEx($model, 'status'); ?>
                        <?php echo $form->dropDownList($model, 'status', Yii::app()->params->GIFTSTATUS); ?>
                        <?php echo $form->error($model, 'status'); ?>
                    </div>
                </div>
                <div class="row buttons text-center add_article_list">
                    <?php echo $form->hiddenField($model, 'score'); ?>
                    <?php echo $form->hiddenField($model, 'genre'); ?>
                    <?php echo CHtml::submitButton($model->isNewRecord ? '创建' : '保存', array('name' => "submityes", 'class' => 'margin-top-15 button button-green submit_img', 'value' => Yii::t('common', $model->isNewRecord ? '创建' : '保存'))); ?>
                    <?php echo $form->hiddenField($model, 'image_src', array('id' => 'result-id')); ?>
                    <?php echo $form->hiddenField($model, 'image_arr'); ?>
                </div>

                <?php $this->endWidget(); ?>

            </div><!-- form -->
        </div>
    </div>
</div>
<script type="text/javascript">
    $(function () {
        //if ($(".add_article_list_img img").attr('src') != 'http://wechat.oppein.cn/upload/sourcefile/image/medium/') $(".add_article_list_img img").show();
        //获取file的地址赋值给img
        $(".add-image-preview").on("change", function () {
            var objUrl = getObjectURL(this.files[0]);
            console.log("objUrl = " + objUrl);
            if (objUrl) {
                $(this).parent().find(".add_article_list_img img").attr("src", objUrl).show();
                $(this).parent().find(".add_article_list_img img").next().hide();
                $(this).parent().find('.delete-addText').val('');
            }
        });
        var location = [];
        $(".add_article_list_img img").each(function(){
            if ($(this).attr('src') != ''&& $(this).attr('src')!='http://wechat.oppein.cn/upload/sourcefile/image/medium/') {
                $(this).show();
                location.push($(this).attr('src'));
            }else {
                $(this).hide();
            }
        });
        /*删除封面图片方法*/
        $('.delete-addImages').click(function(){
            if($(this).parent().find('.add_article_list_img img').attr('src')!=''&& $(this).parent().find('.add_article_list_img img').attr('src')!='http://wechat.oppein.cn/upload/sourcefile/image/medium/'){
                $(this).parent().find(".add_article_list_img img").hide();
                $(this).parent().find(".add_article_list_img img").next().show();
                $(this).parent().find('.delete-addText').val($(this).attr('data-id'));
            }
        });

//        $('.submit_img').click(function(){
//            var location_com = [];
//            for(var location_i in location){
//                if($(".add_article_list_img").find('img').eq(location_i).attr('src')==location[location_i]){
//                    location_com.push('0');
//                }else{
//                    location_com.push($(".add_article_list_img").find('img').eq(location_i).attr('src'));
//                }
//            }
//            alert(location_com);
//            return false;
//        });


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

        $('.gift_details_file_con').find('ul a').live('click', function () {
            $(this).parent().remove();
            if ($('.gift_details_file_con').find('ul').find('li').length < '6') {
                $('.gift_details_file').show();
            }
        });

        /*$('.buttons .button-green').click(function () {
            var img_array = [];
            $('.gift_details_file_con').find('li').each(function () {
                img_array.push($(this).find('img').attr('data-img'));
            });
            //图片集 赋值
            $('#Gift_image_arr').val(img_array);
            //alert($('#Gift_image_arr').val());

            $("#gift-form").ajaxSubmit({
                beforeSubmit: function () {
                    //status.show();
                },
                success: function () {
                    //status.hide();
                    window.location.href = "<?php echo Yii::app()->createUrl('systems/gift/index'); ?>";
                },
                error: function () {
                }}).submit();



        });*/

    });
    function add_img() {
        var ind = $('.gift_details_file_con').find('ul').find('li').length + 1;
        var ob = "preview" + ind;
        var ob2 = ".preview" + ind;
        $('.gift_details_file_con').find('ul').append('<li class=' + ob + '><a href="javascript:;">X</a></li>');
        $("#gift-form").ajaxForm({
            target: ob2,
            beforeSubmit: function () {
                //status.show();
                if ($('.gift_details_file_con').find('ul').find('li').length >= '6') {
                    $('.gift_details_file').hide();
                }
            },
            success: function () {
                //status.hide();
            },
            error: function () {
                //status.hide();
            }}).submit();
    }
</script>