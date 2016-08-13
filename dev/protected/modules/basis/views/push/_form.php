<?php
/* @var $this PushController */
/* @var $model Push */
/* @var $form CActiveForm */
?>
<?php
Yii::app()->clientScript->registerCss('checkbox', "
	.checkboxarea{padding:1px;border:1px solid #a9a9a9;}
	.checkboxarea label{	display:inline;}
	.checkboxarea .firstbox{border-bottom:1px solid #E0E0E0;background:#F4F4F4;font-size:14px;padding:0 0 0 5px;margin-bottom:5px;color:#1670a7;}
	.checkboxarea .firstbox input{margin-bottom:4px;}
	.checkboxarea .group{float:left;width:200px;padding-left:5px;}			
");
?>

<link href="<?php echo Yii::app()->baseUrl; ?>/weixin_css/reply.css" rel="stylesheet" type="text/css" />
<div class="right content-main">
    <h2 class="content-main-title">新建群发消息</h2>
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'push-form',
        'enableAjaxValidation' => false,
    ));
    ?>
    <div>
        <div class="tabhost">
            <div class="tabhost-title">
                <div class="clear"></div>
            </div>
            <div class="tabhost-center">

                <div class="padding30 new-group-sending">

                    <div class="new-group-sending-select">
                        <h4>选择用户:</h4>
                        <select>
                            <option value="1">全部用户</option>
                            <option value="2">按分组选择</option>
                            <option value="3">按用户选择</option>
                            <option value="4">此公众号全部用户</option>
                        </select>
                        <select class="none gruppnamn">
                            <?php
                            if (!empty($groupDataProvider)) {
                                foreach ($groupDataProvider as $key => $value) {
                                    ?>
                                    <option value="<?php echo $key; ?>">
                                        <?php echo $value; ?>
                                    </option>
                                    <?php
                                }
                            }
                            ?>  

                        </select>
                        <a href="<?php echo Yii::app()->createUrl('/users/user/admin'); ?>" class="none width-auto button button-white">选择用户</a>
                        <div class="ie7margin-top20 margin-top-5 margin-right-15 right color-9">群发用户：您已选择<?php echo Yii::app()->request->getParam('count') ? Yii::app()->request->getParam('count') : "0"; ?>位用户</div>
                    </div>
                    <!--创建显示信息-->
                    <!--<div class="margin-top-15 new-group-sending-show">

                        <div class="group-sending-list">
                            <div class="left margin-right-15">
                                <img src="http://wechat.oppein.cn/upload/sourcefile/image/medium/20150129102741142874.jpg" />
                            </div>
                            <div class="group-sending-list-info">
                                <p><a href="javascript:;">[图文信息]图文的信息信息来着</a></p>
                                <p class="color-9">单图文信息单图文信息单图文信息单图文信息单图文信息单图文信息单图文信息单图文信息单图文信息单图文信息单图文信息单图文信息</p>
                            </div>
                            <div class="right group-sending-list-choice">
                                <span class="left color-9 group-sending-list-status">待审核</span>
                                <em class="color-9 group-sending-list-time">02月12日</em>
                                <a href="javascript:;" class="right">删除</a>
                                <div class="clear"></div>
                            </div>
                        </div>

                    </div>-->

                    <div class="margin-top-15 font-14 color-9"><?php echo $form->labelEx($model, 'content'); ?>：</div>
                    <div class="margin-top-8 preview">
                        <?php echo PublicStaticMethod::replaceQqFace($model->content); ?>
                    </div>
                    <div class="clear"></div>
                    <div class="margin-top-8 editing">
                        <div class="editing-tab">
                            <ul class="editing-tab-nav">
                                <li><?php echo CHtml::link('<i class="icon icon-text"></i>', Yii::app()->createUrl($this->route, array('genre' => Yii::app()->request->getParam('genre'), 'type' => 1, 'multi' => 0, 'count' => Yii::app()->request->getParam('count'), 'userarr' => Yii::app()->request->getParam('userarr')))); ?></li>
                                <li>
                                    <?php echo CHtml::link('<i class="icon icon-single-graphic"></i>', array('sourcefile', 'type' => 5, 'multi' => 0), array('title' => '单图文', 'onclick' => 'js:return popup($(this),"单图文库",850,500);')); ?>
                                </li>
                                <li>
                                    <?php echo CHtml::link('<i class="icon icon-more-graphic"></i>', array('sourcefile', 'type' => 5, 'multi' => 1), array('title' => '多图文', 'onclick' => 'js:return popup($(this),"多图文库",850,500);')); ?>
                                </li>
                                <!--<li><?php /* echo CHtml::link('<i class="icon icon-single-graphic"></i>', Yii::app()->createUrl($this->route, array('genre' => Yii::app()->request->getParam('genre'), 'type' => 5, 'multi' => 0, 'count' => Yii::app()->request->getParam('count'), 'userarr' => Yii::app()->request->getParam('userarr'))),array('onclick' => 'js:return popup($(this),"单图文库",850,500);')); */ ?></li>
                                <li><?php /* echo CHtml::link('<i class="icon icon-more-graphic"></i>', Yii::app()->createUrl($this->route, array('genre' => Yii::app()->request->getParam('genre'), 'type' => 5, 'multi' => 1, 'count' => Yii::app()->request->getParam('count'), 'userarr' => Yii::app()->request->getParam('userarr'))),array('onclick' => 'js:return popup($(this),"多图文库",850,500);')); */ ?></li>-->
                            </ul>
                            <div id="news-section" class="none fodder mage-text"></div>
                            <div class="clear"></div>
                            <div id="text-section">
                                <div class="editing-tab-input">
                                    <?php echo $form->textArea($model, 'content', array('rows' => 6, 'cols' => 50, 'maxlength' => 255)); ?>
                                </div>
                                <div class="editing_toolbar">
                                    <p><span class="emotion">表情</span></p>
                                    <?php echo $form->error($model, 'content'); ?>
                                    <?php
                                    Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . "/css/reset.css");
                                    Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . "/js/jquery.qqFace.js");
                                    Yii::app()->clientScript->registerScript('qqfaceInput', "
                                        $('.emotion').qqFace({
                                            id: 'facebox',
                                            assign: 'Push_content',
                                            path: '" . Yii::app()->baseUrl . "/images/arclist/',
                                        });
                                    ");
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?php /* if (Yii::app()->request->getParam('type') == 5): */ ?><!--
                    <div class="" id="images">
                        <div id="voice" style="padding-top: 10px;">
                    <?php /* if (Yii::app()->request->getParam('multi') == 1): */ ?>
                    <?php /* Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . "/css/menu/more_news.css"); */ ?>
                    <?php /*                            $this->widget('zii.widgets.CListView', array(
                      'dataProvider' => $sourceFileDataProvider,
                      'itemView' => '_more_news',
                      'viewData' => $modelDataProvider,
                      'id' => 'ajaxListView',
                      'template' => '{items} <div class="clear"></div> {summary} {pager}',
                      ));
                     */ ?>
                    <?php /* else: */ ?>
                    <?php /* Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . "/css/menu/news.css"); */ ?>
                    <?php /*                            $this->widget('zii.widgets.CListView', array(
                      'dataProvider' => $sourceFileDataProvider,
                      'itemView' => '_news',
                      'viewData' => $modelDataProvider,
                      'id' => 'ajaxListView',
                      'template' => '{items} <div class="clear"></div> {summary} {pager}',
                      ));
                     */ ?>
                    <?php /* endif; */ ?>
                        </div>
                    </div>
                    <div class="sidebar">
                        <dl>
                            <dd>
                    <?php /* echo CHtml::link('显示全部', Yii::app()->createUrl($this->route, array('genre' => Yii::app()->request->getParam('genre'), 'type' => 5, 'multi' => Yii::app()->request->getParam('multi'), 'count' => Yii::app()->request->getParam('count'), 'userarr' => Yii::app()->request->getParam('userarr')))); */ ?>
                            </dd>
                    <?php /*                                $this->widget('zii.widgets.CListView', array(
                      'dataProvider' => $sourceFileGather,
                      'itemView' => '/public/_gather',
                      'id' => 'gatherListView',
                      'template' => '{items} {pager}',
                      'pager' => array(
                      'class' => 'CLinkPager',
                      'maxButtonCount' => 3,
                      'header' => '翻页:',
                      'prevPageLabel' => '<',
                      'nextPageLabel' => '>',
                      ),
                      ));
                     */ ?>
                            <dd>
                    <?php /* echo CHtml::link('+添加分组', array('/basis/sourcefilegather/create/', 'type' => 5, 'multi' => Yii::app()->request->getParam('multi')), array('class' => 'create-gather-item')); */ ?>
                            </dd>
                        </dl>
                    </div>
                    <div class="clear"></div>
                    <?php /* echo $form->hiddenField($model, 'source_file_id', array('class' => 'source_file_id')); */ ?>
                    --><?php /* endif; */ ?>

                    <div>
                        <?php echo $form->hiddenField($model, 'groupArr'); ?>
                        <?php echo $form->hiddenField($model, 'type', array('id' => 'result-type')); ?>
                        <?php echo $form->hiddenField($model, 'source_file_id', array('id' => 'result-id')); ?>
                        <?php echo $form->hiddenField($model, 'multi', array('id' => 'result-multi')); ?>
                        <?php echo CHtml::submitButton($model->isNewRecord ? '确定创建' : '保存修改', array('class' => 'left button button-green', 'style' => 'margin-right:20px;')); ?>
                    </div>

                </div>

            </div>
        </div>
    </div>
    <?php $this->endWidget(); ?>
</div>
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'mydialog',
    'options' => array(
        'autoOpen' => false,
        'modal' => true,
        'width' => 'auto',
        'height' => 'auto',
    ),
));
?>
<div class="content"></div>
<?php $this->endWidget(); ?>

<script type="text/javascript">
    function selectItem(object) {
        $('.select-item').removeClass('current');
        if (object.hasClass('current')) {
            object.removeClass('current');
            $('input[class=\'source_file_id\']').val();
        } else {
            object.addClass('current');
            var data_id = object.attr('data-id');
            $('input[class=\'source_file_id\']').val(data_id);
        }
    }
</script>

<?php
Yii::app()->clientScript->registerScript('district', "
    $('.select-district-province').change(function(){
        var parent_id = $(this).val();
        $('.select-district-city').html('<option value>请选择</option>');
        $.getJSON('" . Yii::app()->createUrl('/basis/push/district') . "',{parent_id:parent_id,type:1},function(data){
            $.each(data, function(i,item){
                $('.select-district-city').append('<option value=\"'+i+'\">'+item+'</option>');
            });
        });
    })
");
?>

<script type="text/javascript">
    $(function () {
        var obj = $('.new-group-sending-select').find('select').eq(0);
        var $text1 = obj.attr('value');
        var $obj = $('.new-group-sending-select');
        var $url = window.location.href;
        var $url2 = $url.slice(-6, -5);
        obj.val($url2);
        if ($('.new-group-sending-select').find('select').eq(0).find("option:selected").text() != '全部用户') {
            select_fn(obj);
        }
        $('.new-group-sending-select').find('select').eq(0).change(function () {
            select_fn($(this));
        });
        function select_fn(obj) {
            var $text = obj.find("option:selected").text();
            var $text1 = obj.attr('value');
            var $url1 = $url.slice(-6);
            if ($text == '按分组选择') {
                $obj.find('select').eq(1).show();
                $obj.find('.width-auto.button.button-white').hide();
                if ($url2 != '2') {
                    window.location.href = $text1 + '.html';
                }
                $('.gruppnamn').change(function () {
                    var gruppnamn_id = $(this).attr('value');
                    $('#Push_groupArr').attr('value', gruppnamn_id);
                });
            } else if ($text == '按用户选择') {
                $obj.find('.width-auto.button.button-white').show();
                $obj.find('select').eq(1).hide();
                if ($url2 != '3') {
                    window.location.href = $text1 + '.html';
                }
            } else if ($text == '全部用户') {
                $obj.find('.width-auto.button.button-white').hide();
                $obj.find('select').eq(1).hide();
                if ($url2 != '1') {
                    window.location.href = $text1 + '.html';
                }
            } else {
                $obj.find('.width-auto.button.button-white').hide();
                $obj.find('select').eq(1).hide();
                if ($url2 != '4') {
                    window.location.href = $text1 + '.html';
                }
            }
        }
    })
</script>