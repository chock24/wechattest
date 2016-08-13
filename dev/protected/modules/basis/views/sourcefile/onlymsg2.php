<script type="text/javascript" src="<?php echo Yii::app()->baseUrl; ?>/weixin_js/jquery.wallform.js"></script>
<?php
/* @var $this SourcefileController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs = array(
    '基础功能' => array('/basis'),
    '素材管理' => array('/basis/sourcefile/appmsg'),
    '编辑图文',
);
?><?php
//if(confirm("你确定要保存吗？")){
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'imageform',
    'enableClientValidation' => true,
    'htmlOptions' => array('enctype' => 'multipart/form-data',),
        ));
//}
?>
<div class="right content-main">
    <h2 class="content-main-title">图文消息</h2>
    <div>
        <div class="tabhost">
            <div class="tabhost-title">
                <ul>
                    <ul>
                        <li>
                            <?php echo CHtml::link('单/多图文库', array('morenews')); ?>
                        </li>
                        <li>
                            <?php echo CHtml::link('图片库', array('image')); ?>
                        </li>
                        <li>
                            <?php echo CHtml::link('音频库', array('voice')); ?>
                        </li>
                        <li>
                            <?php echo CHtml::link('视频库', array('video')); ?>
                        </li>
                    </ul>
                </ul>
                <div class="clear"></div>
            </div>
            <div class="padding30 tabhost-center">

                <div class="left fodder add-mage-text">

                    <div class="morenews-add-img">
                        <?php
                        $id = Yii::app()->request->getParam("id");
                        if ($id == '0' || $id == '') {
                            ?>
                            <div class="relative add-mage-text-more" data-id="">
                                <h4 class="left"><a href="javascript:;">标题</a></h4>
                                <div class="right mage-text-more-img preview0">
                                    <div class="preview-con-img"><img src="<?php echo Yii::app()->baseurl . '/upload/sourcefile/image/source/' . $model->filename . '.' . $model->ext ?>" class="none add-image-preview-img img_text_thumb" /></div>
                                    <!--<img src="<?php // echo Yii::app()->baseurl . '/upload/sourcefile/image/source/' . $model->filename . '.' . $model->ext                                               ?>"  class="none add-image-preview-img" />-->
                                    <i class="add-mage-text-img-background">封面图片</i>
                                </div>

                                <div class="none add-mage-text-mask">
                                    <a title="编辑" class="add-edit" href="javascript:;"></a>
                                    <a title="保存" class="add-hold" href="javascript:;"></a>
                                </div>
                            </div>
                            <?php
                        } else {
                            foreach ($sourcefiledetail as $key => $d) {
                                ?>

                                <div class="relative add-mage-text-more" data-id="<?php echo $d->file_id ?>">
                                    <h4 class="left"><a href="javascript:;"><?php echo $d->sourcefile->title; ?></a></h4>
                                    <div class="right mage-text-more-img preview<?php echo $key; ?>">
                                        <div class="preview-con-img"><img id="<?php echo $d->file_id ?>" name="<?php echo $d->sourcefile->filename . '.' . $d->sourcefile->ext; ?>" class=" add-image-preview-img img_text_thumb"
                                                                          src="<?php echo Yii::app()->baseurl . '/upload/sourcefile/image/source/' . $d->sourcefile->filename . '.' . $d->sourcefile->ext ?>"></div>
                                        <i class="add-mage-text-img-background">封面图片</i>
                                    </div>
                                    <div class="none add-mage-text-mask">
                                        <a title="编辑" class="add-edit" name="update" href="javascript:;"></a>
                                        <a title="保存" class="add-hold" name="update" value =" <?php echo $d->file_id ?>"  href="javascript:;"></a>
                                        <a href="javascript:;" class="add-del" title="删除"></a>
                                    </div>
                                </div>
                                <?php
                            }
                        }
                        ?>
                    </div>
                    <div id="up_status"></div>
                    <div class="relative add-more-graphic-inp">
                        <i class="icon-50 icon-50-add"></i>
                    </div>

                </div>
                <div class="left add-mage-text-input">
                    <div class="triangle"></div>
                    <div class="add-mage-text-compile">
                        <label>标题</label>
                        <div class="add-mage-text-compile-content title">
                            <?php echo @$form->textField($model, 'title', array('size' => '82', 'placeholder' => '标题','onmouseenter'=>'info_entry($(this))','onkeyup'=>'info_entry($(this))')); ?>
                            <span class="ie7margin-top20 right color-9"><em>0</em>/60</span>
                        </div>
                    </div>
                    <div class="add-mage-text-compile">
                        <label>作者<span>(选填)</span></label>
                        <div class="add-mage-text-compile-content author">
                            <?php echo @$form->textField($model, 'author', array('size' => '82', 'placeholder' => '作者')); ?>
                            <span class="right color-9"><em>0</em>/8</span>
                        </div>
                    </div>

                    <div class="add-mage-text-compile">
                        <label>公众号名称</label>
                        <div class="add-mage-text-compile-content">
                            <?php echo @$form->textField($model, 'public_name', array('size' => '88')); ?>
                        </div>
                    </div>

                    <div class="add-mage-text-compile">
                        <label>点击公众号名称跳转页面 例如: http://www.qq.com</label>
                        <div class="add-mage-text-compile-content">
                            <?php echo @$form->textField($model, 'public_url', array('size' => '88')); ?>
                        </div>
                    </div>

                    <div class="add-mage-text-compile">
                        <label>封面<span>（大图片建议尺寸：900像素 * 500像素）</span></label>
                        <div class="fileUpload btn btn-primary">
                            <span class="button button-white">上传图片</span>
                            <input id="photoimg" type="file" name="photoimg" class="upload" onchange="add_img()">
                        </div>
                        <?php /* echo CHtml::activeFileField($model, 'files', array('class' => "none add-image-preview", 'style' => 'display:none')); */ ?>
                        <?php
                        if (Yii::app()->user->hasFlash('alert')) {
                            echo '<br/>' . Yii::app()->user->getFlash('alert');
                        }
                        ?>
                        <?php echo $form->error($model, 'files'); ?>
                        <a onclick="js:return popup($(this), '从图库中选择图文', 880, 590);" class="margin-top-8 button button-white" href="<?php echo Yii::app()->createUrl('basis/sourcefile/sourcefile', array('type' => 2)); ?>">从图片库选择</a>
                        <div class="clear"></div>
                        <label class="margin-top-15">
                            <?php echo $form->checkbox($model, 'show_content', array('class' => 'frm_checkbox')); ?>

                            <span>是否显示封面</span>
                        </label>
                    </div>
                    <div class="add-mage-text-compile">
                        <label>简介</label>
                        <div class="add-mage-text-compile-content textarea">
                            <?php echo $form->textarea($model, 'description'); ?>
                            <span class="right color-9"><em>6</em>/120</span>
                        </div>
                    </div>
                    <div class="add-mage-text-compile">
                        <label>内容</label>
                        <div class="textarea">
                            <?php echo $form->textarea($model, 'content'); ?>
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
                    <div class="add-mage-text-compile">
                        <label>点击查看全文的链接</label>
                        <div class="add-mage-text-compile-content textarea">
                            <?php echo $form->textField($model, 'content_source_url', array('size' => '88')); ?>
                            <?php echo $form->hiddenField($model, 'filename', array('id' => 'result-id')); ?>
                        </div>
                    </div>
                    <?php
                    $public_id = Yii::app()->user->getState('public_id');
                    if ($public_id == 1) {
                        ?>
                        <div class="add-mage-text-compile">
                            <label>是否作为模板 &nbsp;
                                <?php echo $form->checkBox($model, 'template', array('class' => 'margin-top-8')); ?>
                            </label>
                        </div>
                    <?php } ?>
                </div>
                <div class="clear"></div>
                <div class="add-mage-text-submit">
                    <?php echo $form->hiddenField($model, 'public_id'); ?>
                    <?php echo $form->hiddenField($model, 'ids'); ?>
                    <?php /* echo CHtml::submitButton('确定', array('class' => "button button-green")); */ ?>
                    <?php if ($id == '0' || $id == '') {
                        ?>
                        <a href="javascript:;" class="button button-green add-whole">确定</a>
                    <?php } else {
                        ?>
                        <a href="javascript:;" class="button button-green update-whole" value='<?php echo Yii::app()->request->getParam('id'); ?>'>保存</a>
                    <?php } ?>

                    <?php if (!$model->isNewRecord): ?>
                        <?php echo CHtml::link('预览', array('/site/view', 'id' => $model->id), array('class' => 'button button-white', 'target' => '_blank')); ?>
                    <?php endif; ?>

                </div>
            </div>
        </div>
    </div>
</div>

<?php $this->endWidget(); ?>
<script type="text/javascript">

    //上传图片函数
    function add_img(){
        if($('.add-mage-text-more.img-selected').html()!=undefined){
            var ind=$('.add-mage-text-more.img-selected').index();
        }
        if(ind){
        }else {
            var ind=0;
        }
        var status = $("#up_status");
        var ob = ".preview" + ind;
        $('.add-mage-text-more').eq(ind).find('.mage-text-more-img').find('.preview-con-img').detach();
        $("#imageform").ajaxForm({
            target: ob,
            beforeSubmit: function () {
                status.show();
            },
            success: function () {
                status.hide();
            },
            error: function () {
                status.hide();
            }}).submit();
    }

    //编辑图片的方法
    function info_entry(obj1) {
        if($('.add-mage-text-more.img-selected').html()!=undefined){
            var ind=$('.add-mage-text-more.img-selected').index();
        }
        if(ind){
        }else {
            var ind=0;
        }
        var obj2 = $('.add-mage-text-more').eq(ind).find('h4 a');
        function icovw_title() {
            var wz = obj1.val();
            if (obj1.val() != '') {
                obj2.html(wz);
            }
        }
        icovw_title();
    }
    $(function () {
        $('.morenews-add-img').children().first().addClass('add-mage-text-more-one');//右边第一个图文增加class属性
        $('.morenews-add-img').children().first().find('.add-del').detach();//删除第一个图文的删除按钮
        $('.add-hold').hide();//默认所有图文的保存按钮显示
        $('.morenews-add-img').children().first().find('.add-hold').show();//默认第一个图文的保存按钮显示
        var add_preview_i = $('.add-mage-text-more').length;//获取右边图文的数量
        $('.add-more-graphic-inp').live('click', function () {
            if (add_preview_i < 8) {
                var add_preview_j = $('.add-mage-text-more').length;
                var html = '<div class="relative add-mage-text-more"><h4 class="left"><a href="javascript:;" title="">标题</a></h4><div class="right mage-text-more-img preview' + add_preview_j + '"><div class="preview-con-img"><img src="" class="none" /></div><i class="add-mage-text-img-background">缩略图</i></div><div class="none add-mage-text-mask"><a href="javascript:;" class="add-edit" title="编辑"></a><a title="保存" class="add-hold" href="javascript:;" style="display: none"></a><a href="javascript:;" class="add-del" title="删除"></a></div></div>'
                $('.morenews-add-img').append(html);
                add_preview_i++;
            }    else {
                alert('对不起！您最多可以添加8张图文信息！！');
            }
        });
        $('.add-del').live('click', function () {
            if (confirm('您确定要删除吗？')) {
                var obj = $('.morenews-add-img');
                var add_del_i = $(this).parent().parent().index() + 1;
                var i = 0;
                if (add_del_i == $('.add-mage-text-more').length) {
                    $('.add-mage-text-more').eq($(this).parent().parent().index() - 1).find('.add-edit').click();
                }
                $(this).parent().parent().remove();
                $('.add-mage-text-more').eq(0).addClass('add-mage-text-more-one');
                $('.add-mage-text-more').each(function () {
                    var rclass = 'preview' + i;
                    $(this).find('.mage-text-more-img').removeClass().addClass('right mage-text-more-img');
                    $(this).find('.mage-text-more-img').addClass(rclass);
                    i++;
                });
            }
        });
        $('.add-hold').live('click', function () {
            var imageurl = $(this).parent().parent().find('.preview-con-img img').attr('name');
            var title = $('#SourceFile_title').val();
            var author = $('#SourceFile_author').val();
            var public_name = $('#SourceFile_public_name').val();
            var public_url = $('#SourceFile_public_url').val();
            if($('#SourceFile_show_content').attr('checked')){
                var show_content = 1;
            }else {
                var show_content = 0;
            }

            var description = $('#SourceFile_description').val();
            var content = editor.getContent();
            var content_source_url = $('#SourceFile_content_source_url').val();
            if($('#SourceFile_template').attr('checked')){
                var template = 1;
            }else {
                var template = 0;
            }
            var url = "<?php echo Yii::app()->createUrl('basis/sourcefile/addmoremsg'); ?>";
            var si = $(this).parent().parent().index();//获取点击位置为图片提交做索引
            if ($(this).attr('name') == 'update') {
                var id = $(this).parent().parent().attr('data-id');
                $.post(url, {'id': id, 'imageurl': imageurl, 'title': title, 'author': author, 'public_name': public_name, 'public_url': public_url, 'show_content': show_content, 'description': description, 'content': content, 'content_source_url': content_source_url, 'template': template},
                function (data) {
                    var dd = JSON.parse(data);
                    $('.add-mage-text-more').eq(si).attr('data-id', dd.id);
                    var idsvalue = $('#SourceFile_ids').val();
                    if (idsvalue == "" || idsvalue == null) {
                        idsvalue = dd.id;

                    } else {
                        idsvalue = idsvalue + "," + dd.id;
                    }
                    $('body').append("<div class='flash-success'>保存成功</div>");//保存成功提示
                    setTimeout(function(){
                        $('.flash-success').fadeOut();
                        $('.flash-success').empty();//删除保存成功提示
                    },1000);
                    $('#SourceFile_ids').attr('value', idsvalue);
                });
            } else {
                //新增
                if (imageurl) {
                    var upload;
                    if($(this).parent().parent().find('.preview-con-img').find('.local_img').html()==undefined){
                         upload=1;
                    }else {
                         upload=0;
                    }
                    $.post(url, {'upload':upload,'imageurl': imageurl, 'title': title, 'author': author, 'public_name': public_name, 'public_url': public_url, 'show_content': show_content, 'description': description, 'content': content, 'content_source_url': content_source_url, 'template': template},
                    function (data) {
                        var dd = JSON.parse(data);
                        $('.add-mage-text-more').eq(si).attr('data-id', dd.id);
                        var idsvalue = $('#SourceFile_ids').val();
                        if (idsvalue == "" || idsvalue == null) {
                            idsvalue = dd.id;
                            $(this).attr('data-id', dd.id);
                        } else {
                            idsvalue = idsvalue + "," + dd.id;
                        }
                        $(this).attr('name', 'update');
                        $('body').append("<div class='flash-success'>保存成功</div>");//保存成功提示
                        setTimeout(function(){
                            $('.flash-success').fadeOut();
                            $('.flash-success').empty();//删除保存成功提示
                        },1000);
                        $('#SourceFile_ids').attr('value', idsvalue);
                        $('.add-mage-text-more').eq(si).find('.add-mage-text-mask').find('.add-hold').attr("name", "update");
                        $('.add-mage-text-more').eq(si).find('.add-mage-text-mask').find('.add-edit').attr("name", "update");
                    });
                } else {
                    alert('请先上传图片');
                }
            }
        });
        /*新增多图文提交*/
        $('.add-whole').live('click', function () {
            var obj = $('.morenews-add-img').find('.add-mage-text-more');
            var judge = true;
            if (judge) {
                var btnall = '1';
                var newids = $('#SourceFile_ids').val();
                if($('#SourceFile_template').attr('checked')){
                    var template = 1;
                }else {
                    var template = 0;
                }
                var url = "<?php echo Yii::app()->createUrl('basis/sourcefile/addmoremsg'); ?>";
                $.post(url, {'btnall': btnall, 'ids': newids, 'template': template},
                    function (data) {
                        if (data == 'ok') {
                            //alert("保存成功");
                            window.location.href = "<?php echo Yii::app()->createUrl('basis/sourcefile/morenews'); ?>";
                        }
                    });
            }
        });
        /*修改多图文提交*/
        $('.update-whole').live('click', function () {
            window_unbind_ie();//离开页面提示兼容ie内核
            var obj = $('.morenews-add-img').find('.add-mage-text-more');
            var judge = true;
            if (judge) {
                var my_array = [];
                $('.add-mage-text-more').each(function () {
                    var sz = $(this).attr('data-id');
                    my_array.push(sz);
                });
                var my_zfc = my_array.join();
                var btnall = '1';
                var ids = my_zfc;
                var id = $(this).attr('value');
                if($('#SourceFile_template').attr('checked')){
                    var template = 1;
                }else {
                    var template = 0;
                }
                var url = "<?php echo Yii::app()->createUrl('basis/sourcefile/addmoremsg'); ?>";
                $.post(url, {'btnall': btnall, 'ids': ids, 'template': template, 'id': id},
                    function (data) {
                        if (data == 'ok') {
                            //alert("保存成功");
                            window.location.href = "<?php echo Yii::app()->createUrl('basis/sourcefile/morenews'); ?>";
                        }
                    });
            }
        });
        free_nude(0);//调用图片库选择图片方法
        var ind_id = '';

        //判断离开页面提示兼容ie
        function window_unbind_ie(){
            //判断ie
            if ((navigator.userAgent.indexOf('MSIE') >= 0)&& (navigator.userAgent.indexOf('Opera') < 0)){
                $(window).unbind('beforeunload');
                setTimeout(function(){web_release($('.add-mage-text-submit').find('.update-whole'));},500);
            }
        }

        $('.add-edit').live('click', function () {
            window_unbind_ie();//离开页面提示兼容ie内核
            var obj = $(this).parent().parent();
            var ind = obj.index();
            var heg = obj.position().top;
            $('.add-mage-text-more').removeClass("img-selected");
            obj.addClass("img-selected");
            $('.add-hold').hide();//所有保存按钮隐藏
            $(this).next().show();//修改的图文的对应保存按钮显示
            $('.add-mage-text-input').css('marginTop', heg);//左边编辑的文本框的位置切换
            $(".add-image-preview").unbind();//删除点击事件外的上传图片的change事件
            $('.add-mage-text-mask-add-icon').die("click");//删除点击事件外的图片库选择click事件
            free_nude(ind);//调用图片库选择图片方法
            if (ind_id == '') {
                ind_id = 0;
            }
            var id = $(this).parent().parent().attr('data-id');
            var url = "<?php echo Yii::app()->createUrl('basis/sourcefile/selonemsg'); ?>";
            if ($(this).attr('name') == 'update') {
                $.post(url, {'id': id},
                function (data) {
                    var da = JSON.parse(data);
                    $('#SourceFile_title').val(da.title);
                    $('#SourceFile_author').val(da.author);
                    $('#SourceFile_public_name').val(da.public_name);
                    $('#SourceFile_public_url').val(da.public_url);
                    $('#SourceFile_description').val(da.description);
                    if(da.show_content==1){
                        $('#SourceFile_show_content').attr('checked',true);
                    }else {
                        $('#SourceFile_show_content').attr('checked',false);
                    }
                    editor.setContent(da.content);
                    $('#SourceFile_content_source_url').val(da.content_source_url);
                    if(da.template==1){
                        $('#SourceFile_template').attr('checked',true);
                    }else {
                        $('#SourceFile_template').attr('checked',false);
                    }
                });
            } else {
                //如果是新增的图文或者为未保存的图文则右边输入的文本框都为空
                $('#SourceFile_title').val('');
                $('#SourceFile_author').val('');
                $('#SourceFile_public_name').val('');
                $('#SourceFile_public_url').val('');
                $('#SourceFile_description').val('');
                editor.setContent('');
                $('#SourceFile_content_source_url').val('');
            }
            ind_id = ind;
        });
        //图片库选择方法
        function free_nude(index) {
            var iw = 1;
            $('.add-mage-text-mask-add-icon').live('click', function (event) {
                if(iw==1){
                    var obj = $(this).parent().prev().find('.popup-content-fodder-content').find('.items').find('.selected');
                    if (obj.html() != undefined) {
                        var url = obj.find('img').attr('src');
                        var url2 = url.substring(url.indexOf('medium/') + 7, url.length);
                        $('.add-mage-text-more').eq(index).find('img').attr({src: url, name: url2}).show().addClass('local_img');
                    } else {
                        alert('对不起！你没有选择素材，请选择素材！！');
                    }
                }
                iw++;
            });
        }
        //左边文本框的输入字符计算
        ie7_text_count($('.title'), 60);
        ie7_text_count($('.author'), 8);
        ie7_text_count($('.textarea'), 120);
        web_release($('.add-mage-text-submit').find('.button-green'));//关闭页面提醒
    });

</script>

<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'diaimggroup2',
    'htmlOptions' => array(
    // 'class' => 'mydialog',
    ),
    'options' => array(
        'autoOpen' => false,
        // 'modal'=>true,
        'width' => '970',
        'height' => 'auto',
        'buttons' => array(
            array('text' => '确定', 'click' => 'js:function(){$(this).dialog("close");}'),
            array('text' => '取消', 'click' => 'js:function(){$(this).dialog("close"); cancel();$(\'.img_img_i\').show();$(\'.img_f\').hide();}'),
        ),
    ),
));
?>

<div class="content2"></div>
<?php $this->endWidget(); ?>
