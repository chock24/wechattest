<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/weixin_css/marketing.css" />
<div class="right content-main">
    <div class="margin-top-10 tabhost">
        <div class="tabhost-title">
            <ul>
                <li><a href="<?php echo Yii::app()->createUrl('systems/poster/index'); ?>">海报列表</a></li>
                <li class="active"><a href="<?php echo Yii::app()->createUrl('systems/poster/create'); ?>">新增海报</a></li>
                <li><a href="<?php echo Yii::app()->createUrl('systems/postertype/index'); ?>">所属栏目管理</a></li>
            </ul>
            <div class="clear"></div>
        </div>
        <div class="padding20 tabhost-center">
            <?php
            $form = $this->beginWidget('CActiveForm', array(
                'id' => 'poster-poster-form',
                // Please note: When you enable ajax validation, make sure the corresponding
                // controller action is handling ajax validation correctly.
                // There is a call to performAjaxValidation() commented in generated controller code.
                // See class documentation of CActiveForm for details on this.
                'enableAjaxValidation' => true,
                'htmlOptions' => array('enctype' => 'multipart/form-data',),
            ));
            ?>
                <?php echo $form->errorSummary($model); ?>
                <?php if($this->getAction()->getId()=='create'){ ?>

                <div class="row add_article_list">
                    <?php echo $form->labelEx($model, '栏目'); ?>
                    <?php echo $form->dropDownList($model, 'typeid', $postertype,
                        array(
                            'class'=>'box-select',
                        )); ?>
                    <?php echo $form->error($model, 'typeid'); ?>
                </div>
            <?php }else{?>
                    <div class="row add_article_list">
                        <?php echo $form->labelEx($model, '栏目:').$postername; ?>
                    </div>
            <?php }?>
                <div class="poster-banner-com">
                    <h4>添加海报<strong>（注：图片大小为<span class="color-red">宽：640px；高：320px</span>，最多只能上传3张图片。）</strong></h4>
                    <ul>
                        <li>
                            <label>海报图1.</label>
                            <div class="poster-banner-com-img">
                                <?php if(!empty($dataprovider[0]['img_url'])){?>
                                    <img class="" alt="" src="<?php echo Yii::app()->params->WEBROOT . Yii::app()->params->FILEFOLDER . Yii::app()->params->FILEPATH['sourcefile']['image']['poster'].$dataprovider[0]['img_url'];?>" style="width: 160px;height: 80px;">
                                <?php }else{?>
                                <i>添加图片</i>
                                <img class="none" alt="" src="/images/font/header/transmit_hed.jpg">
                                <?php } ?>
                            </div>
                            <div class="margin-left-20 left">
                                <?php echo CHtml::activeFileField($model, 'files_one', array('class' => "none add-image-preview", 'style' => 'display:none')); ?>
                                <a onclick="$(this).prev().click();" class="left button button-white" href="javascript:;">选择图片</a>
                                <input id="delimgone"  class="delete-addText" type="hidden" value="" name="Poster[delimg_one]">
                                <input id="imgsrcone" class="imgsrcClass" type="hidden" value="" name="Poster[imgsrc_one]">
                                <?php if(!empty($dataprovider[0]['id'])){?>
                                    <input id="lid_one" type="hidden" value="<?php echo $dataprovider[0]['id'];?>" name="Poster[lid_one]">
                                <?php }?>
                                <a onclick="js:return popup($(this), '从图库中选择图文', 880, 590);" class="right button button-white photoChooserTask" href="<?php echo Yii::app()->createUrl('basis/posterfile/posterfile', array('type' => 1)); ?>">从图片库选择</a>
                                <div class="clear"></div>
                                <?php if(!empty($dataprovider[0]['url'])) {
                                    echo CHtml::activeTextField($model, 'url', array('class' => "margin-top-15", 'size' => 63, 'value' =>$dataprovider[0]['url'], 'name' => 'Poster[url_one]'));
                                }else{
                                    echo CHtml::activeTextField($model, 'url', array('class' => "margin-top-15", 'size' => 63, 'placeholder' => "请输入海报图跳转连接", 'name' => 'Poster[url_one]'));
                                }?>
                            </div>
                            <div class="margin-top-15 margin-left-20 left up-state color-9"></div>
                        </li>
                        <li>
                            <label>海报图2.</label>
                            <div class="poster-banner-com-img">
                                <?php if(!empty($dataprovider[1]['img_url'])){?>
                                    <i style="display: none;">添加图片</i>
                                    <img class="" alt="" src="<?php echo Yii::app()->params->WEBROOT . Yii::app()->params->FILEFOLDER . Yii::app()->params->FILEPATH['sourcefile']['image']['poster'].$dataprovider[1]['img_url'];?>" style="width: 160px;height: 80px;">
                                <?php }else{?>
                                    <i>添加图片</i>
                                    <img class="none" alt="" src="/images/font/header/transmit_hed.jpg">
                                <?php } ?>
                            </div>
                            <div class="margin-left-20 left">
                                <?php echo CHtml::activeFileField($model, 'files_two', array('class' => "none add-image-preview", 'style' => 'display:none')); ?>
                                <a onclick="$(this).prev().click();" class="left button button-white" href="javascript:;">选择图片</a>
                                <?php if(!empty($dataprovider[1]['id'])){?>
                                 <input id="lid_two" type="hidden" value="<?php echo $dataprovider[1]['id'];?>" name="Poster[lid_two]">
                                <?php }?>
                                <input id="imgsrctwo" class="imgsrcClass" type="hidden" value="" name="Poster[imgsrc_two]">
                                <input id="delimgtwo"  class="delete-addText"  type="hidden" value="" name="Poster[delimg_two]">
                                <a onclick="js:return popup($(this), '从图库中选择图文', 880, 590);" class="left button button-white photoChooserTask" href="<?php echo Yii::app()->createUrl('basis/posterfile/posterfile', array('type' => 1)); ?>">从图片库选择</a>
                                <a class="right button button-white delImages" href="javascript:;" data-id="<?php echo $dataprovider[1]['id']; ?>">删除图片</a>
                                <div class="clear"></div>
                                <?php if(!empty($dataprovider[1]['url'])) {
                                    echo CHtml::activeTextField($model, 'url', array('class' => "margin-top-15", 'size' => 63, 'value' => $dataprovider[1]['url'], 'name' => 'Poster[url_two]'));
                                }else{
                                    echo CHtml::activeTextField($model, 'url', array('class' => "margin-top-15", 'size' => 63, 'placeholder' => "请输入海报图跳转连接", 'name' => 'Poster[url_two]'));
                                }?>
                            </div>
                            <div class="margin-top-15 margin-left-20 left up-state color-9"></div>
                        </li>
                        <li>
                            <label>海报图3.</label>
                            <div class="poster-banner-com-img">
                                <?php if(!empty($dataprovider[2]['img_url'])){?>
                                    <i style="display: none;">添加图片</i>
                                    <img class="" alt="" src="<?php echo Yii::app()->params->WEBROOT . Yii::app()->params->FILEFOLDER . Yii::app()->params->FILEPATH['sourcefile']['image']['poster'].$dataprovider[2]['img_url'];?>" style="width: 160px;height: 80px;">
                                <?php }else{?>
                                    <i>添加图片</i>
                                    <img class="none" alt="" src="/images/font/header/transmit_hed.jpg">
                                <?php } ?>
                            </div>
                            <div class="margin-left-20 left">
                                <?php echo CHtml::activeFileField($model, 'files_three', array('class' => "none add-image-preview", 'style' => 'display:none')); ?>
                                <a onclick="$(this).prev().click();" class="left button button-white" href="javascript:;">选择图片</a>
                                <input id="delimgthree" class="delete-addText"  type="hidden" value="" name="Poster[delimg_three]">
                                <input id="imgsrcthree" class="imgsrcClass" type="hidden" value="" name="Poster[imgsrc_three]">
                                <?php if(!empty($dataprovider[2]['id'])){?>
                                <input id="lid_three" type="hidden" value="<?php echo $dataprovider[2]['id'];?>" name="Poster[lid_three]">
                                <?php }?>
                                <a onclick="js:return popup($(this), '从图库中选择图文', 880, 590);" class="left button button-white photoChooserTask" href="<?php echo Yii::app()->createUrl('basis/posterfile/posterfile', array('type' => 1)); ?>">从图片库选择</a>
<!--                                <a href="javascript:;" class="right button button-white delImages">删除图片</a>-->
                                    <a class="right button button-white delImages" href="javascript:;" data-id="<?php echo $dataprovider[2]['id'];?>">删除图片</a>
                                <div class="clear"></div>
                                <?php if(!empty($dataprovider[2]['url'])) {
                                    echo CHtml::activeTextField($model, 'url', array('class' => "margin-top-15", 'size' => 63, 'value' => $dataprovider[2]['url'], 'name' => 'Poster[url_three]'));
                                }else{
                                    echo CHtml::activeTextField($model, 'url', array('class' => "margin-top-15", 'size' => 63, 'placeholder' => "请输入海报图跳转连接", 'name' => 'Poster[url_three]'));
                                }?>
                            </div>
                            <div class="margin-top-15 margin-left-20 left up-state color-9"></div>
                        </li>
                    </ul>
                </div>
                <div class="add-mage-text-submit">
                    <?php if($this->getAction()->getId()=='create'){echo CHtml::submitButton('创建', array('name' => "submityes", 'class' => 'left button button-browns', 'value' => Yii::t('common','创建'))); }?>
                    <?php if($this->getAction()->getId()=='update'){echo CHtml::submitButton('保存', array('name' => "submityes", 'class' => 'left button button-browns', 'value' => Yii::t('common','保存'))); }?>
                </div>

            <?php $this->endWidget(); ?>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(function(){

        $('#Poster_typeid').change(function(){
            //挣积分640x320、有奖活动
            //家装前沿588x172
            if($(this).find("option:selected").text()=='家装前沿'){
                $('.poster-banner-com').find('strong span').html('宽：588px；高：172px');
            }else {
                $('.poster-banner-com').find('strong span').html('宽：640px；高：320px');
            }
        });

        //获取file的地址赋值给img
        $(".add-image-preview").on("change", function () {
            var $text = $(this).attr('value');
            var $text0 = $text.substr($text.lastIndexOf(".") + 1, $text.length);
            if ($text0 == 'bmp' || $text0 == 'png' || $text0 == 'jpeg' || $text0 == 'jpg' || $text0 == 'gif') {
                $(this).parent().find('.imgsrcClass').val('');
                $(this).parent().parent().find('.up-state').html("你选择的素材为：<span class='color-red'>" + $text +"</span>");
                var objUrl = getObjectURL(this.files[0]);
                if (objUrl) {
                    $(this).parent().parent().find(".poster-banner-com-img i").hide();
                    $(this).parent().parent().find(".poster-banner-com-img img").attr("src", objUrl).show().next().html('上传成功');
                }
            } else {
                $(this).parent().parent().find('.up-state').html("你选择的素材" + "“ " + $text + " ”<span class='color-red'>文件格式错误</span>，请重新选择。");
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
        var $index=0;
        $('.photoChooserTask').click(function(){
            $index = $(this).parent().parent().index();
        });
        $(document).on('click','.add-mage-text-mask-add-icon', function (event) {
            var obj = $(this).parent().prev().find('.popup-content-fodder-content').find('.items').find('.selected');
            var url = obj.find('img').attr('src');
            $('.poster-banner-com').find('li').eq($index).find('img').attr('src',url).show().siblings().hide();
            $('.poster-banner-com').find('li').eq($index).find('.add-image-preview').val('');
            $('.poster-banner-com').find('li').eq($index).find('.imgsrcClass').val($(this).attr('data-id'));
            $('.poster-banner-com').find('li').eq($index).find('.up-state').html('');
        });
        /*删除封面图片方法*/
        $('.delImages').click(function(){
            if($(this).parent().parent().find('.poster-banner-com-img img').attr('src')!=''){
                $(this).parent().parent().find(".poster-banner-com-img img").hide();
                $(this).parent().find('.delete-addText').val($(this).attr('data-id'));
                $(this).parent().parent().find('.poster-banner-com-img').find('i').show();

                /*$(this).parent().find('.add-image-preview,.imgsrcClass').val('');
                $(this).parent().parent().find('.poster-banner-com-img').find('i').show().siblings().hide().attr('src','');
                $(this).parent().parent().find('.up-state').html('');*/


            }
        });
///***提交时记得注释掉**/
//        $('.photoChooserTask').click(function(){
//            return false;
//        });


    });
</script>