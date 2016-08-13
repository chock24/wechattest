<?php
/* @var $this SourcefileController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs = array(
    '基础功能' => array('/basis'),
    '微信素材' => array('/basis/appmsg'),
    '多图文素材' => array('/basis/sourcefile/appmsgmore'),
    '创建多图文'
);
?>

<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'moremsg-form',
// Please note: When you enable ajax validation, make sure the corresponding
// controller action is handling ajax validation correctly.
// There is a call to performAjaxValidation() commented in generated controller code.
// See class documentation of CActiveForm for details on this.
        ));
?>



<div class="right content-main">
    <h2 class="content-main-title">多图文信息</h2>

    <div>
        <div class="tabhost">
            <div class="tabhost-title">
                <ul>
                    <li class="<?php echo Yii::app()->request->getParam('type') == 5 && Yii::app()->request->getParam('multi') == 0 ? 'active' : ''; ?>">
                        <?php echo CHtml::link('单图文库', array('news')); ?>
                    </li>
                    <li class="<?php echo Yii::app()->request->getParam('type') == 5 && Yii::app()->request->getParam('multi') == 1 ? 'active' : ''; ?>">
                        <?php echo CHtml::link('多图文库', array('morenews')); ?>
                    </li>
                    <li class="<?php echo Yii::app()->request->getParam('type') == 2 ? 'active' : ''; ?>">
                        <?php echo CHtml::link('图片库', array('image')); ?>
                    </li>
                    <li class="<?php echo Yii::app()->request->getParam('type') == 3 ? 'active' : ''; ?>">
                        <?php echo CHtml::link('音频库', array('voice')); ?>
                    </li>
                    <li class="<?php echo Yii::app()->request->getParam('type') == 4 ? 'active' : ''; ?>">
                        <?php echo CHtml::link('视频库', array('video')); ?>
                    </li>
                </ul>
                <div class="clear"></div>
            </div>
            <div class="padding30 tabhost-center">

                <div class="left fodder add-mage-text">
                    <div class="add-mage-text-center">
                        <!--<div class="relative add-mage-text-more-one-title">
                            <div class="mage-text-img-title">
                                <a href=javascript:;><?php /* echo $model->title */ ?></a>
                            </div>
                        </div>-->

                        <div class="morenews-add-img">
                            <?php
                            $id = Yii::app()->request->getParam("id");
                            if ($id == '0' || $id == '') {
                                ?>

                                <div class="relative add-mage-text-more" data-id="">
                                    <h4 class="left"><a href="javascript:;">标题</a></h4>
                                    <div class="right mage-text-more-img">
                                        <i class="add-mage-text-img-background">封面图片</i>
                                        <img id="" class="img_text_thumb" src="">
                                    </div>

                                    <div class="none add-mage-text-mask">
                                        <a title="编辑" class="add-edit" href="javascript:;"></a>
                                    </div>
                                </div>


                                <!--<div class="relative add-mage-text-more add-mage-text-more-one add-mage-text-more-one-del">
                                    <div class="right mage-text-more-img" data-id="<?php /* echo @$d->file_id */ ?>">
                                        <i class="add-mage-text-img-background">封面图片</i>
                                    </div>
                                    <div class="none add-mage-text-mask">
                                        <a title="编辑" class="add-edit" href="javascript:;"></a>
                                    </div>
                                </div>-->
                                <!--                    <div class="relative add-mage-text-more">
                                                        <h4 class="left"><a title="" href="javascript:;">标题</a></h4>
                                                        <div class="right mage-text-more-img">
                                                            <i class="add-mage-text-img-background">缩略图</i>
                                                            <img id="" class="img_text_thumb" src="">
                                                        </div>
                                                        <div class="none add-mage-text-mask">
                                                            <a title="编辑" class="add-edit" href="javascript:;"></a>
                                                            <a href="javascript:;" class="add-del" title="删除"></a>
                                                        </div>
                                                    </div>-->
                                <?php
                            } else {
                                foreach ($sourcefiledetail as $key => $d) {
                                    ?>
                                    <!-- 修改 -->
                                    <div class="relative add-mage-text-more" data-id="<?php echo $d->file_id ?>">
                                        <h4 class="left"><a href="javascript:;"><?php echo $d->sourcefile->title; ?></a></h4>

                                        <div class="right mage-text-more-img">
                                            <img id="<?php echo $d->file_id ?>" class="img_text_thumb"
                                                 src="<?php echo Yii::app()->baseurl . '/upload/sourcefile/image/source/' . $d->sourcefile->filename . '.' . $d->sourcefile->ext ?>">
                                        </div>
                                        <div class="none add-mage-text-mask">
                                            <a title="向上" '="" class="add-up" href="javascript:;"></a>
                                            <a title="向下" class="add-next" href="javascript:;"></a>
                                            <a title="编辑" class="add-edit" target="_blank"
                                               href="<?php echo Yii::app()->createUrl('/basis/sourcefile/updatemsg', array('id' => $d->file_id)); ?>"></a>
                                            <a title="删除" class="add-del" href="javascript:;"></a>
                                        </div>
                                    </div>
                                    <!-- 修改 -->
                                    <?php
                                }
                            }
                            ?>
                            <!--<div class="del"></div>-->
                        </div>
                        <div class="relative add-more-graphic-inp">
                            <i class="icon-50 icon-50-add"></i>
                        </div>
                    </div>
                </div>


                <div class="left add-mage-text-input">
                    <div class="triangle"></div>
                    <div class="add-mage-text-compile">
                        <label>标题</label>

                        <div class="add-mage-text-compile-content title">
                            <?php echo $form->textField($model, 'title', array('size' => '82', 'placeholder' => '标题')); ?>
                            <span class="right color-9"><em>0</em>/60</span>
                        </div>
                    </div>
                    <div class="add-mage-text-compile">
                        <label>作者<span>(选填)</span></label>

                        <div class="add-mage-text-compile-content author">
                            <input type="text" id="SourceFile_author" size="82" placeholder="作者">
                            <span class="right color-9"><em>0</em>/8</span>
                        </div>
                    </div>
                    <div class="add-mage-text-compile">
                        <label>公众号名称</label>

                        <div class="add-mage-text-compile-content">
                            <input type="text" placeholder="公众号名称" size="88">
                        </div>
                    </div>

                    <div class="add-mage-text-compile">
                        <label>点击公众号名称跳转页面 例如: http://www.qq.com</label>

                        <div class="add-mage-text-compile-content">
                            <input type="text" size="88">
                        </div>
                    </div>

                    <div class="add-mage-text-compile">
                        <label>封面<span>（大图片建议尺寸：900像素 * 500像素）</span></label>
                        <input type="file" class="none add-image-preview">
                        <a onclick="$(this).prev().click();" class="margin-top-8 button button-white" href="javascript:;">上传</a>
                        <a onclick="js:return popup($(this), '从图库中选择图文', 880, 590);" class="margin-top-8 button button-white"
                           href="<?php echo Yii::app()->createUrl('basis/sourcefile/sourcefile', array('type' => 2)); ?>">从图片库选择</a>
                        <label class="margin-top-15">
                            <span>是否显示封面</span>
                        </label>
                    </div>

                    <div class="add-mage-text-compile">
                        <label>简介</label>

                        <div class="add-mage-text-compile-content textarea">
                            <?php echo $form->textarea($model, 'description', array('class' => 'frm_input frm_textarea')); ?>
                            <span class="right color-9"><em>0</em>/120</span>
                        </div>
                    </div>

                    <!--<div class="padding30 text-center background-white">
                        <a onclick='js:return popup($(this), "选择单图文", 860, 675);'
                           href="<?php /* echo Yii::app()->createUrl('basis/sourcefile/sourcefile', array('type' => '5', 'multi' => '0')) */ ?>"
                           class="icon-50 icon-50-add"></a>
                    </div>-->
                    <div class="clear"></div>
                    <!--                    <div class="margin-top-15 add-mage-text-compile">
                    <?php // echo $form->labelEx($model, 'content_source_url');   ?>
                                                        <div class="add-mage-text-compile-content textarea">
                    <?php //echo $form->textField($model, 'content_source_url', array('size' => 74));    ?>
                                                        </div>
                    <?php //echo $form->error($model, 'content_source_url');    ?>
                                                    </div>-->


                    <div class="margin-top-15 add-mage-text-compile">
                        <label>内容</label>

                        <div class="textarea">
                            <textarea id="SourceFile_content"></textarea>
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


                    <div class="margin-top-15 add-mage-text-compile">
                        <label>
                            是否选择公开
                            <?php echo $form->checkbox($model, 'status'); ?>
                            <?php echo $form->error($model, 'status'); ?>
                        </label>
                    </div>
                    <?php
                    $public_id = Yii::app()->user->getState('public_id');
                    if ($public_id == 1) {
                        ?>
                        <div class="margin-top-15 add-mage-text-compile">
                            <label>
                                是否作为模板
                                <?php echo $form->checkBox($model, 'template', array('class' => 'margin-top-8')); ?>
                                <?php echo $form->error($model, 'status'); ?>
                            </label>
                        </div>
                    <?php } ?>
                </div>


                <div class="clear"></div>
                <div class="add-mage-text-submit">
                    <?php echo $form->hiddenField($model, 'ids'); ?>
                    <?php echo $form->hiddenField($model, 'id'); ?>
                    <?php echo CHtml::submitButton('提交', array('class' => "button button-green")); ?>
                    <!--                    <input type="button" class="button button-white" value="预览">-->
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->endWidget(); ?>
<script type="text/javascript">
    $(function () {
        $('.morenews-add-img').children().removeClass('add-mage-text-more-one');
        $('.morenews-add-img').children().first().addClass('add-mage-text-more-one');
        ie7_text_count($('.title'), 60);
        ie7_text_count($('.author'), 8);
        $('.textarea').form_count(120);
        //web_release($('.add-mage-text-submit').find('input:submit'));//关闭页面提醒


        //加载进来默认编辑第一个
        info_entry($('#SourceFileGroup_title'), $('.add-mage-text-more').eq(0).find('h4 a'), '标题', 0, true);

        $('.add-edit').live('click', function () {
            var obj = $(this).parent().parent();
            var ind = obj.index();
            var heg = obj.position().top;
            $('.add-mage-text-input').css('marginTop', heg);
            info_entry($('#SourceFileGroup_title'), $('.add-mage-text-more').eq(ind).find('h4 a'), '标题', ind, true);
        });
        //编辑图片的方法
        function info_entry(obj1, obj2, bt, ind, st) {
            if (st) {
                var obj1_val = obj2.html() != '标题' ? obj2.html() : '';
            } else {
                var obj1_val = obj2.val() != '' ? obj2.val() : '';
            }
            obj1.val(obj1_val);
            icovw_title(ind);
            obj1.unbind();
            obj1.keyup(function () {
                icovw_title(ind);
            });
            obj1.mouseenter(function () {
                icovw_title(ind);
            });
            function icovw_title(ind) {
                var wz = obj1.val();
                if (obj1.val() != '') {
                    if (st) {
                        obj2.html(wz);
                    } else {
                        obj2.val(wz);
                    }
                }
            }
        }
        $('.add-more-graphic-inp').live('click', function () {
            if ($('.add-mage-text-more').length < 8) {
                var html = '<div class="relative add-mage-text-more"><h4 class="left"><a href="javascript:;" title="">标题</a></h4><div class="right mage-text-more-img"><i class="add-mage-text-img-background">缩略图</i></div><div class="none add-mage-text-mask"><a href="javascript:;" class="add-edit" title="编辑"></a><a href="javascript:;" class="add-del" title="删除"></a></div></div>'
                $('.morenews-add-img').append(html);
            } else {
                alert('对不起！您最多可以添加8张图文信息！！');
            }
        });
        $('.add-del').live('click', function () {
            if (confirm('您确定要删除吗？')) {
                var obj = $('.morenews-add-img');
                $(this).parent().parent().remove();
                $('.add-mage-text-more').eq(0).removeClass('add-mage-text-more-one');
                $('.add-mage-text-more').eq(0).addClass('add-mage-text-more-one');
            }
        });


        /*//控制排序
         $(".add-up").live('click', function () {
         var obj = $('.add-mage-text-more');
         var ob = $(this).parent().parent();
         ob.insertBefore(ob.prev());
         obj.removeClass('add-mage-text-more-one');
         $('.add-mage-text-more').eq(0).addClass('add-mage-text-more-one');
         });
         $(".add-next").live('click', function () {
         var obj = $('.add-mage-text-more');
         var ob = $(this).parent().parent();
         ob.insertBefore(ob.next().next());
         obj.removeClass('add-mage-text-more-one');
         $('.add-mage-text-more').eq(0).addClass('add-mage-text-more-one');
         });
         //删除增加的图片
         $('.add-del').live('click', function () {
         if (confirm('您确定要删除吗？')) {
         var obj = $('.morenews-add-img');
         $(this).parent().parent().remove();
         $('.add-mage-text-more').eq(0).removeClass('add-mage-text-more-one');
         $('.add-mage-text-more').eq(0).addClass('add-mage-text-more-one');
         if (obj.children().length == 1) {
         obj.find('.del').replaceWith(div_html);
         }
         }
         });*/
        /*$('.add-mage-text-mask-add-icon').live('click', function () {
         if ($(this).parent().prev().find('.relative.selected').html() != undefined) {
         var $obj = $('.morenews-add-img');
         if ($obj.children().length <= 8) {
         var html = '';
         var tit = $(this).parent().prev().find('.selected').find('h4').html();
         var src = $(this).parent().prev().find('.popup-content-fodder-content').find('.items').find('.selected').find('img').attr('src');
         var img_id = $(this).parent().prev().find('.selected').attr('data-id');
         var $url = '<?php echo Yii::app()->createUrl('basis/sourcefile/updatemsg'); ?>';
         var $surl = $url.slice(0, -1).slice(0, -4) + '/layout/1/id/' + img_id + '.html';
         $('.add-mage-text-more-one-del').remove();
         html += "<div class='relative add-mage-text-more add-mage-text-more-one' data-id= " + img_id + "> <h4 class='left'><a href='javascript:;' title='+tit+'>" + tit + "</a></h4>";
         html += "<div class='right mage-text-more-img'> <img src=" + src + " /> </div> <div class='none add-mage-text-mask'>";
         html += "<a href='javascript:;' class='add-up' title='向上'></a> <a href='javascript:;' class='add-next' title='向下'></a>";
         html += "<a href=" + $surl + " class='add-edit' title='编辑' target='_blank'></a> <a href='javascript:;' class='add-del' title='删除'></a> </div></div>";
         $obj.find('.del').replaceWith(html);
         $obj.children().removeClass('add-mage-text-more-one');
         $obj.children().first().addClass('add-mage-text-more-one');
         $obj.append("<div class='del'></div>");
         } else {
         alert('对不起！您最多可以添加8张图文信息！！');
         }
         } else {
         alert('对不起！你没有选择素材，请选择素材！！');
         }
         });*/
        /*提交*/
        $('.add-mage-text-submit').find('.button-green').live('click', function () {
            var obj = $('.morenews-add-img').find('.add-mage-text-more');
            if (obj.length >= 2) {//添加判断穿件的图片数量少于两张不予提交！
                var judge = true;
                $('.mage-text-more-img').each(function () {
                    if ($(this).find('img').attr('src') == '') {
                        judge = false;
                    }
                });
                if (judge) {
                    var my_array = new Array();
                    $('.add-mage-text-more').each(function () {
                        var sz = $(this).attr('data-id');
                        my_array.push(sz);
                    });
                    $('#SourceFileGroup_ids').attr('value', my_array);
                } else {
                    alert('亲，需要上传图片才能保存！');
                    return false;
                }
            } else {
                alert('亲，最少需要两张图片才能保存！');
                return false;
            }
        });
    })


</script>