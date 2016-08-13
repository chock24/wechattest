<link href="<?php echo Yii::app()->baseUrl; ?>/weixin_css/member_home.css" rel="stylesheet" type="text/css" />

<div class="right content-main">
    <h2 class="content-main-title">与 <span><?php echo CHtml::encode($model->nickname); ?></span> 的聊天记录</h2>

    <div class="padding30 user-control-dialogue">

        <div class="user-control-dialogue-input">
            <div class="left editing-content">
                <?php
                Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . "/css/reset.css");
                Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . "/js/jquery.qqFace.js");
                Yii::app()->clientScript->registerScript('qqfaceInput', "
                                        $('.emotion').qqFace({
                                            id: 'facebox',
                                            assign: 'operationText',
                                            path: '" . Yii::app()->baseUrl . "/images/arclist/',
                                        });
                                    ");
                ?>
                <?php
                $form = $this->beginWidget('CActiveForm', array(
                    'id' => 'auto-form',
                    'action' => array('view', 'id' => $model->id),
                    'enableClientValidation' => true,
                    'clientOptions' => array(
                        'validateOnSubmit' => true,
                    ),
                ));
                ?>
                <div class="margin-top-15 editing">
                    <div class="editing-tab">
                        <ul class="editing-tab-nav">
                            <li>
                                <?php echo CHtml::link('<i class="icon icon-text"></i>', array('view', 'id' => $model->id, 'type' => 1), array('title' => '文本')); ?>
                            </li>
                            <li>
                                <?php echo CHtml::link('<i class="icon icon-img"></i>', array('sourcefile', 'type' => 2), array('title' => '图片', 'onclick' => 'js:return popup($(this),"图片库",850,500);')); ?>
                            </li>
                            <li>
                                <?php echo CHtml::link('<i class="icon icon-single-graphic"></i>', array('sourcefile', 'type' => 5, 'multi' => 0), array('title' => '单图文', 'onclick' => 'js:return popup($(this),"单图文库",850,500);')); ?>
                            </li>
                            <li>
                                <?php echo CHtml::link('<i class="icon icon-more-graphic"></i>', array('sourcefile', 'type' => 5, 'multi' => 1), array('title' => '多图文', 'onclick' => 'js:return popup($(this),"多图文库",850,500);')); ?>
                            </li>
                            <li>
                                <?php echo CHtml::link('<i class="icon icon-voice"></i>', array('sourcefile', 'type' => 3), array('title' => '音频', 'onclick' => 'js:return popup($(this),"音频库",850,500);')); ?>
                            </li>
                            <li>
                                <?php echo CHtml::link('<i class="icon icon-video"></i>', array('sourcefile', 'type' => 4), array('title' => '视频', 'onclick' => 'js:return popup($(this),"视频库",850,500);')); ?>
                            </li>
                        </ul>
                        <div id="news-section" class="fodder mage-text">

                        </div>
                        <div class="clear"></div>
                        <div id="text-section">
                            <div class="editing-tab-input">
                                <?php echo $form->textArea($messageModel, 'content', array('id' => 'operationText', 'data-id' => 0, 'data-multi' => 0, 'data-type' => 1, 'onchange' => 'js:return popupConfirm($(this),$("#result-id"),$("#result-multi"),$("#result-type"),1)')); ?>
                                <?php echo $form->error($messageModel, 'content'); ?>
                            </div>
                            <div class="editing_toolbar">
                                <a class="left emotion" href="javascript:;"><i class="icon icon-face"></i></a>
                                <p class="right">还可以输入<em>500</em>字</p>
                            </div>
                        </div>
                    </div>
                </div>
                <?php echo $form->hiddenField($messageModel, 'type', array('id' => 'result-type')); ?>
                <?php echo $form->hiddenField($messageModel, 'source_file_id', array('id' => 'result-id')); ?>
                <?php echo $form->hiddenField($messageModel, 'multi', array('id' => 'result-multi')); ?>
                <?php echo CHtml::submitButton('发送', array('class' => 'button button-green')); ?>
                <?php $this->endWidget(); ?>
            </div>
            <div class="padding10 right user-information">
                <?php
                $this->widget('zii.widgets.CDetailView', array(
                    'data' => $model,
                    'id' => 'user-grid',
                    'attributes' => array(
                        array(
                            'name' => 'nickname',
                            'type' => 'html',
                            'value' => @$model->nickname,
                        ),
                        array(
                            'name' => 'star',
                            'type' => 'html',
                            'value' => $model->star ? CHtml::link(CHtml::image(Yii::app()->baseUrl . "/images/star.png", "星标用户"), Yii::app()->createUrl("users/message/star", array("id" => $model->id, "accept" => 0)), array("class" => "star-item")) : CHtml::link(CHtml::image(Yii::app()->baseUrl . "/images/nostar.png", "非星标用户"), Yii::app()->createUrl("users/message/star", array("id" => $model->id, "accept" => 1)), array("class" => "star-item")),
                        ),
                        array(
                            'name' => 'group_id',
                            'type' => 'html',
                            'value' => '<span class="group-value">' . @$model->groups->name . '</span>' . CHtml::link('<i class="icon icon-text"></i>', array('group', 'id' => $model->id), array('class' => 'right none group-item', 'title' => '修改分组',)),
                        ),
                        array(
                            'name' => 'remark',
                            'type' => 'html',
                            'value' => '<span class="remark-value" >' . $model->remark . '</span>' . CHtml::link('<i class="icon icon-text"></i>', array('remark', 'id' => $model->id), array('class' => 'right none remark-item', 'title' => '修改备注名')),
                        ),
                        array(
                            'name' => 'headimgurl',
                            'type' => 'html',
                            'value' => ($model->subscribe ? "<span class=\"subscribe\">" . CHtml::image(Yii::app()->baseUrl . "/images/subscribe.png", "关注中", array("class" => "sub_image")) . CHtml::image(substr($model->headimgurl, 0, -1) . "64") . "</span>" : "<span class=\"unsubscribe\">" . CHtml::image(Yii::app()->baseUrl . "/images/unsubscribe.png", "已取消关注", array("class" => "sub_image")) . CHtml::image(substr($model->headimgurl, 0, -1) . "64") . "</span>"),
                        ),
                        array(
                            'name' => 'mobile',
                            'type' => 'html',
                            'value' => '<span class="mobile-value">' . $model->mobile . '</span>' . CHtml::link('<i class="icon icon-text"></i>', array('mobile', 'id' => $model->id), array('class' => 'right none mobile-item', 'title' => '手机号码')),
                        ),
                        array(
                            'name' => 'sex',
                            'type' => 'html',
                            'value' => '<span class="sex-value">' . @Yii::app()->params->SEX[$model->sex] . '</span>' . CHtml::link('<i class="icon icon-text"></i>', array('sex', 'id' => $model->id), array('class' => 'right none sex-item', 'title' => '性别')),
                        ),
                        array(
                            'name' => 'age',
                            'type' => 'html',
                            'value' => '<span class="age-value">' . $model->age . '</span>' . CHtml::link('<i class="icon icon-text"></i>', array('age', 'id' => $model->id), array('class' => 'right none age-item', 'title' => '年龄')),
                        ),
                        array(
                            'name' => 'language',
                            'type' => 'html',
                            'value' => '<span class="language-value">' . @Yii::app()->params->LANGUAGE[$model->language] . '</span>' . CHtml::link('<i class="icon icon-text"></i>', array('language', 'id' => $model->id), array('class' => 'right none language-item', 'title' => '语言')),
                        ),
                        array(
                            'name' => 'country',
                            'value' => $this->country($model, 0),
                        ),
                        array(
                            'name' => 'province',
                            'value' => $this->province($model, 0),
                        ),
                        array(
                            'name' => 'city',
                            'value' => $this->city($model, 0),
                        ),
                        'subscribe_time:datetime',
                        array(
                            'label' => '用户唯一ID',
                            'name' => 'openid',
                        //'value' => CHtml::textField('openid', $model->openid, array('size' => 15)),
                        ),
                    ),
                ));
                ?>
            </div>
        </div>
        <div class="clear"></div>

        <div class="margin-top-15 user-control-dialogue-content">

            <div class="">
                <div class="top-35 left wechat-seek">
                    <form>
                        <?php
                        $form = $this->beginWidget('CActiveForm', array(
                            'action' => Yii::app()->createUrl($this->route),
                            'method' => 'get',
                        ));
                        ?>
                        <div class="left row">
                            <?php echo $form->textField($messageModel, 'content', array('class' => "left wechat-seek-input", 'placeholder' => '关键字/聊天信息')); ?>
                        </div>
                        <?php echo CHtml::submitButton('', array('class' => 'left wechat-seek-button')); ?>
                        <?php $this->endWidget() ?>
                    </form>
                </div>
            </div>

            <?php
            $this->widget('zii.widgets.CListView', array(
                'dataProvider' => $dataProvider,
                'viewData' => $userModel,
                'itemView' => '_message',
            ));
            ?>
        </div>
    </div>
</div>





<div class="clear"></div>


<?php
/* @var $this UserController */
/* @var $model User */

$this->breadcrumbs = array(
    '用户中心' => array('/users'),
    '用户管理' => array('/users/user/admin'),
    '查看对话记录 - ' . $model->nickname,
);
Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
");
Yii::app()->clientScript->registerScript('operation', "
        $('.language-item,.level-item,.group-item,.mobile-item,.sex-item,.age-item,.tag-item,.integral-item,.remark-item,.message-remark-item').live('click',function(){
                var href = $(this).attr('href');
                var action = $(this).attr('title');
                var data_id = $(this).attr('data-id');
                js:return popup($(this),action,400,200);
//                $('#action').val(action);
//                $('#operationUrl').val(operationUrl);
//                $('#dataid').val(data_id);
//		$.get(operationUrl,'',function(s){
//			$('#operationSection').dialog({title:'用户操作界面'});
//			$('#operationSection .content').html(s);
//			$('#operationSection').dialog('open'); return false;
//		});
//                return false;
	});
");
?>




<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'operationSection',
    'options' => array(
        'autoOpen' => false,
        'modal' => true,
        'width' => 'auto',
        'height' => 'auto',
        'buttons' => array(
            array('text' => '确定', 'click' => 'js:function(){operationSubmit()}'),
            array('text' => '取消', 'click' => 'js:function(){$(this).dialog("close");}'),
        ),
    ),
));
?>
<?php echo CHtml::hiddenField('action'); ?>
<?php echo CHtml::hiddenField('dataid'); ?>
<?php echo CHtml::hiddenField('operationUrl'); ?>

<div class="content"></div>
<?php $this->endWidget(); ?>

<?php
//加星标客户操作以及加星标消息
Yii::app()->clientScript->registerScript('operationStar', "
    $('.star-item').live('click',function(){
        var operationUrl = $(this).attr('href');
        var object = $(this).find('img');
        var title = $(this).find('img').attr('alt') == '星标用户' ? '非星标用户' : '星标用户';
        var src =  $(this).find('img').attr('alt') == '星标用户' ? '" . Yii::app()->baseUrl . '/images/nostar.png' . "' : '" . Yii::app()->baseUrl . '/images/star.png' . "';
        $.post(operationUrl,function(s){
                object.attr('src',src).attr('alt',title);
                return false;
        });
        return false;
    })

");
?>
<!--消息中心和用户界面消息记录，鼠标移动到消息图片放大图片-->
<div class="information_popup_who">
    <div class="information_popup_img">
        <div class="information_popup_img_con">
            <span class="information_popup_img_con_img">
                <img src="" />
                     <a href="javascript:;">X</a>
            </span>
        </div>
    </div>
</div>
<script>
    $(function () {
        //音频点击播放
        if(isIE = navigator.userAgent.indexOf("MSIE")!=-1) {
            voice($('.audio-message-list'),'embed');
        }else{
            //不是ie浏览器将embed替换成audio
            $('.audio-message-list').each(function(){
                var src = $(this).find('embed').attr('src');
                var audio = $(this).find('embed');
                audio.replaceWith("<audio src = "+ src + " autostart='false' name='voi'></audio>");
            });
            voice($('.audio-message-list'),'audio');
        }
        //判断视频格式做修改
        if(navigator.appName == "Microsoft Internet Explorer" && (navigator.appVersion .split(";")[1].replace(/[ ]/g,"")=="MSIE6.0" || navigator.appVersion .split(";")[1].replace(/[ ]/g,"")=="MSIE7.0" || navigator.appVersion .split(";")[1].replace(/[ ]/g,"")=="MSIE8.0")){
            $('.video-messaging-list').each(function(){
                var src = $(this).find('video').attr('src');
                var video = $(this).find('video');
                video.replaceWith("<embed src="+ src +" autostart='false'></embed>");
            });
        }
        //图片点击新页面打开图片地址
        $('.dialogue-list-text img,.information_popup_who img').click(function (e) {
            $('.information_popup_who').unbind();
            var url_img = $(this).attr('src');
            $('.information_popup_who').show().find('img').attr('src', url_img);
            setTimeout(function () {
                $('.information_popup_who').click(function () {
                    $('.information_popup_who').hide();
                });
            }, 100);
            return false;
        });
    })
</script>