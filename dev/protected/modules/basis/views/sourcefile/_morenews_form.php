
<div class="padding30 tabhost-center">

    <div class="left fodder add-mage-text">


        <div class="add-mage-text-center">
            <!--<div class="fodder-center">
                <div class="relative fodder-img add-mage-text-img">
                    <img class="none" src="http://wechat.oppein.cn/upload/sourcefile/image/medium/20150129102741142874.jpg" />
                    <i class="add-mage-text-img-background">封面图片</i>
                    <div class="mage-text-img-title"><a href="javascript:;" title="标题">标题</a></div>

                    <div class="none add-mage-text-mask">
                        <a href="javascript:;" class="add-up" title="向上"></a>
                        <a href="javascript:;" class="add-next" title="向下"></a>
                        <a href="javascript:;" class="add-edit" title="编辑"></a>
                        <a href="javascript:;" class="add-del" title="删除"></a>
                    </div>
                </div>
            </div>-->

            <div class="relative add-mage-text-more-one-title">
                <div class="mage-text-img-title"><a href="javascript:;" title="标题">标题</a></div>
            </div>

            <div class="morenews-add-img">
                <div class="relative add-mage-text-more add-mage-text-more-one add-mage-text-more-one-del">
                    <h4 class="left"><a href="javascript:;" title="多图文信息标题2">多图文信</a></h4>
                    <div class="right mage-text-more-img">
                        <img class="none" src="http://wechat.oppein.cn/upload/sourcefile/image/medium/20150129102741142874.jpg" />
                        <i class="add-mage-text-img-background">缩略图</i>
                    </div>
                    <!--<div class="none add-mage-text-mask">
                        <a href="javascript:;" class="add-up" title="向上"></a>
                        <a href="javascript:;" class="add-next" title="向下"></a>
                        <a href="javascript:;" class="add-edit" title="编辑"></a>
                        <a href="javascript:;" class="add-del" title="删除"></a>
                    </div>-->
                </div>
                <!--<div class="relative add-mage-text-more">
                    <h4 class="left"><a href="javascript:;" title="多图文信息标题2">多图文信息标题2</a></h4>
                    <div class="right mage-text-more-img">
                        <img class="none" src="http://wechat.oppein.cn/upload/sourcefile/image/medium/20150129102741142874.jpg" />
                        <i class="add-mage-text-img-background">缩略图</i>
                    </div>
                    <div class="none add-mage-text-mask">
                        <a href="javascript:;" class="add-up" title="向上"></a>
                        <a href="javascript:;" class="add-next" title="向下"></a>
                        <a href="javascript:;" class="add-edit" title="编辑"></a>
                        <a href="javascript:;" class="add-del" title="删除"></a>
                    </div>
                </div>-->

                <div class="del"></div>
            </div>

        </div>
    </div>
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'source-create-form',
        'enableClientValidation' => true,
        'htmlOptions' => array('enctype' => 'multipart/form-data',),
    ));
    ?>
    <div class="left add-mage-text-input">
        <div class="triangle"></div>

        <div class="add-mage-text-compile">
            <?php echo $form->labelEx($model, 'title'); ?>
            <div class="add-mage-text-compile-content title">
                <?php echo $form->textField($model, 'title', array('size' => 70, 'placeholder' => '标题')); ?>
                <span class="right color-9"><em>0</em>/60</span>
            </div>
            <?php echo $form->error($model, 'title'); ?>
        </div>
        <div class="add-mage-text-compile">
            <?php echo $form->labelEx($model, 'description'); ?>
            <div class="add-mage-text-compile-content textarea">
                <?php echo $form->textArea($model, 'description'); ?>
                <span class="right color-9"><em>0</em>/120</span>
            </div>
            <?php echo $form->error($model, 'description'); ?>
        </div>

        <div class="padding30 text-center background-white">


            <a onclick='js:return popup($(this), "选择单图文", 860, 675);' href="<?php echo Yii::app()->createUrl('basis/sourcefile/sourcefile',array('type'=>'5','multi'=>'0')) ?>" class="icon-50 icon-50-add" ></a>

            <!--<div class="relative fodder mage-text add-mage-text-material-block">
                <div class="fodder-center add-mage-text-border-bottom">
                    <h4><a href="javascript:;">图文标题</a></h4>
                    <em class="fodder-date">2015-01-29</em>
                    <div class="fodder-img mage-text-img">
                        <a href="javascript:;"><img src="http://wechat.oppein.cn/upload/sourcefile/image/medium/20150129102741142874.jpg" /></a>
                    </div>
                    <p class="fodder-introduce">
                        <a href="javascript:;" title="这是图文的介绍内容">这是图文的介绍内容</a>
                    </p>
                </div>
                <div class="none add-mage-text-mask">
                    <a href="javascript:;" class="add-icon" title="添加"></a>
                </div>
            </div>
            <div class="relative fodder mage-text add-mage-text-material-block">
                <div class="fodder-center add-mage-text-border-bottom">
                    <h4><a href="javascript:;">图文标题</a></h4>
                    <em class="fodder-date">2015-01-29</em>
                    <div class="fodder-img mage-text-img">
                        <a href="javascript:;"><img src="http://wechat.oppein.cn/upload/sourcefile/image/medium/20150129102741142874.jpg" /></a>
                    </div>
                    <p class="fodder-introduce">
                        <a href="javascript:;" title="这是图文的介绍内容">这是图文的介绍内容</a>
                    </p>
                </div>
                <div class="none add-mage-text-mask">
                    <a href="javascript:;" class="add-icon" title="添加"></a>
                </div>
            </div>-->

        </div>
        <div class="clear"></div>

        <div class="margin-top-15 add-mage-text-compile">
            <?php echo $form->labelEx($model, 'content_source_url'); ?>
            <div class="add-mage-text-compile-content textarea">
                <?php echo $form->textField($model, 'content_source_url', array('size' => 74)); ?>
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
        $('.textarea').form_count(120);
        wechat_icovw($('#SourceFile_title'),$('.mage-text-img-title a'),'标题');
        //web_release ($('.add-mage-text-submit').find('input:submit'));//关闭页面提醒
        var div_html = $('.morenews-add-img').html();//获取页面加载进来后左边无编辑下的html
        //控制排序
        $(".add-up").live('click', function() {
            var obj = $('.add-mage-text-more');
            var ob =$(this).parent().parent();
            ob.insertBefore(ob.prev());
            obj.removeClass('add-mage-text-more-one');
            $('.add-mage-text-more').eq(0).addClass('add-mage-text-more-one');
        });
        $(".add-next").live('click', function() {
            var obj = $('.add-mage-text-more');
            var ob = $(this).parent().parent();
            ob.insertBefore(ob.next().next());
            obj.removeClass('add-mage-text-more-one');
            $('.add-mage-text-more').eq(0).addClass('add-mage-text-more-one');
        });
        //删除增加的图片
        $('.add-del').live('click',function(){
            if(confirm('您确定要删除吗？')){
                var obj = $('.morenews-add-img');
                $(this).parent().parent().remove();
                $('.add-mage-text-more').eq(0).removeClass('add-mage-text-more-one');
                $('.add-mage-text-more').eq(0).addClass('add-mage-text-more-one');
                if(obj.children().length == 1){
                    obj.find('.del').replaceWith(div_html);
                }
            }
        });
        $('.add-mage-text-mask-add-icon').live('click',function(){
            if($(this).parent().prev().find('.selected').html()!= undefined){
                if(confirm('您确定创建吗？')){
                    var obj = $('.morenews-add-img');
                    if(obj.children().length <=8){
                        var html='';
                        var tit = $(this).parent().prev().find('.selected').find('h4').html();
                        var src = $(this).parent().prev().find('.selected').find('.mage-text-img').find('img').attr('src');
                        var img_id = $(this).parent().prev().find('.selected').attr('data-id');
                        $('.add-mage-text-more-one-del').remove();
                        html += "<div class='relative add-mage-text-more add-mage-text-more-one' data-id= "+ img_id +"> <h4 class='left'><a href='javascript:;' title='+tit+'>"+ tit +"</a></h4>";
                        html += "<div class='right mage-text-more-img'> <img src="+ src + " /> </div> <div class='none add-mage-text-mask'>";
                        html += "<a href='javascript:;' class='add-up'' title='向上'></a> <a href='javascript:;' class='add-next' title='向下'></a>";
                        html += "<a href='javascript:;' class='add-edit' title='编辑'></a> <a href='javascript:;' class='add-del' title='删除'></a> </div> </div>"
                        obj.find('.del').replaceWith(html);
                        obj.children().removeClass('add-mage-text-more-one');
                        obj.children().first().addClass('add-mage-text-more-one');
                        obj.append("<div class='del'></div>");
                    }else{
                        alert('对不起！您最多可以添加8张图文信息！！');
                    }
                }
            }else {
                alert('对不起！你没有选择素材，请选择素材！！');
            }
        });
        /*保存*/
        $('.add-mage-text-submit').find('.button-green').click(function(){
            var image_array=[];
            $('.morenews-add-img').children('.add-mage-text-more').each(function(){
                image_array.push($(this).attr('data-id'));
            });
            alert(image_array);
        });

    })
</script>