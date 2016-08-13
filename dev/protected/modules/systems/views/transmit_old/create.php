<?php
/* @var $this TransmitController */
/* @var $model Transmit */

$this->breadcrumbs = array(
    'Transmits' => array('index'),
    'Create',
);

$this->menu = array(
    array('label' => 'List Transmit', 'url' => array('index')),
    array('label' => 'Manage Transmit', 'url' => array('admin')),
);
?>

<?php //$this->renderPartial('_form', array('model'=>$model)); ?>

<link href="<?php echo Yii::app()->baseUrl; ?>/weixin_css/marketing.css" rel="stylesheet" type="text/css" />
<div class="right content-main">
    <h2 class="content-main-title">新建转发有奖</h2>
    <div>
        <div class="tabhost">
            <div class="tabhost-title">
                <div class="clear"></div>
            </div>
            <div class="padding30 tabhost-center">

                <div class="forward-prize">

                    <!--新建步骤-->
                    <div class="forward-prize-step">
                        <div class="forward-prize-step-bj"></div>
                        <a href="javascript:;" class="forward-prize-step-one forward-prize-step-on">1</a>
                        <a href="javascript:;" class="forward-prize-step-two">2</a>
                        <a href="javascript:;" class="forward-prize-step-three">3</a>
                    </div>
                    <div class="padding10 clear"></div>

                    <?php
                    $form = $this->beginWidget('CActiveForm', array(
                        'id' => 'transmit-form',
                        'enableAjaxValidation' => true,
                    ));
                    ?>

                    <table class="wechat-table-seek">
                        <tbody>
                            <tr>
                                <td class="tdl"><label for="Admin_username">活动</label></td>
                                <td>
                                    <?php echo $form->textField($model, 'title', array('size' => 40, 'placeholder' => "输入活动名称")); ?></td>
                                <td class="tdl"><label for="Admin_name">时间</label></td>
                                <td>
                                    <?php
                                    $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                                        'language' => 'zh_cn',
                                        'model' => $model,
                                        'attribute' => 'time_start',
                                        'options' => array(
                                            'showOn' => 'button', // 'focus', 'button', 'both'
                                            'buttonImage' => Yii::app()->request->baseUrl . '/images/cal.png',
                                            'buttonImageOnly' => true,
                                            'changeMonth' => true,
                                            'changeYear' => true,
                                            'mode' => 'datetime',
                                            'dateFormat' => 'yy-mm-dd',
                                        ),
                                        'htmlOptions' => array(
                                            'readonly' => 'readonly',
                                            'maxlength' => 10,
                                            'style' => 'margin:0; margin-right:5px;',
                                        )
                                    ));
                                    ?>

                                    <?php
                                    $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                                        'language' => 'zh_cn',
                                        'model' => $model,
                                        'attribute' => 'time_end',
                                        'options' => array(
                                            'showOn' => 'button', // 'focus', 'button', 'both'
                                            'buttonImage' => Yii::app()->request->baseUrl . '/images/cal.png',
                                            'buttonImageOnly' => true,
                                            'changeMonth' => true,
                                            'changeYear' => true,
                                            'mode' => 'datetime',
                                            'dateFormat' => 'yy-mm-dd',
                                        ),
                                        'htmlOptions' => array(
                                            'readonly' => 'readonly',
                                            'maxlength' => 10,
                                            'style' => 'margin:0; margin-right:5px;',
                                        )
                                    ));
                                    ?>
                                </td>
                                <td class="tdl"><label for="Admin_name">转发积分</label></td>
                                <td>
                                    <?php echo $form->textField($model, 'integral', array('size' => "15", 'placeholder' => "转发所得积分")); ?>
                                </td>
                            </tr>
                            <tr>
                                <td class="tdl"><label for="Admin_username">活动说明</label></td>
                                <td colspan="5">
                                    <?php echo $form->textarea($model, 'description', array('size' => 60, 'maxlength' => 200)); ?>
                                    <?php echo $form->error($model, 'description'); ?>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="6">
                                    <?php echo CHtml::submitButton($model->isNewRecord ? '确定' : '保存', array('class' => 'right button')); ?>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <?php $this->endWidget(); ?>
                </div>


                <div class="none forward-prize">
                    <!--新建步骤2-->
                    <div class="forward-prize-step">
                        <div class="forward-prize-step-bj"></div>
                        <a href="javascript:;" class="forward-prize-step-one forward-prize-step-ok">1</a>
                        <a href="javascript:;" class="forward-prize-step-two forward-prize-step-on">2</a>
                        <a href="javascript:;" class="forward-prize-step-three">3</a>
                    </div>
                    <div class="padding10 clear"></div>
                    <?php
                    $form = $this->beginWidget('CActiveForm', array(
                        'id' => 'transmit2-form',
                        // Please note: When you enable ajax validation, make sure the corresponding
                        // controller action is handling ajax validation correctly.
                        // There is a call to performAjaxValidation() commented in generated controller code.
                        // See class documentation of CActiveForm for details on this.
                        'enableAjaxValidation' => false,
                    ));
                    ?>
                    <table class="wechat-table-seek">
                        <tbody>
                            <tr>
                                <td class="tdl"><label for="Admin_username">微信关键字</label></td>
                                <td>
                                    <?php echo $form->textField($model, 'keyword', array('size' => 50, 'placeholder' => '输入关键字')); ?>
                                    <?php echo $form->error($model, 'keyword'); ?>
                                    <input type="button" value="确定" class="margin-left-5 width-auto button button-green">
                                </td>
                            </tr>
<!--                                <tr>
                                    <td colspan="5">
                                        <div class="padding10">
                                            <a href="javascript:;" class="margin-right-15">关键字1</a>
                                            <a href="javascript:;" class="margin-right-15">关键字2</a>
                                        </div>
                                    </td>
                                </tr>-->
                            <tr>
                                <td class="tdl"><label for="Admin_username">回复内容</label></td>
                                <td colspan="5">
                                    <!--单图文显示-->
                                    <div class="none fodder mage-text" id="news-section"></div>
                                    <div class="padding10">
                                        <input type="button" value="选择素材" class="margin-left-20 button button-green" href="<?php echo Yii::app()->createUrl('systems/transmit/sourcefile', array('type' => 5, 'multi' => 0)); ?>" onclick='js:return popup($(this), "多图文库", 850, 500);'>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="6">
                                    <?php echo $form->hiddenField($model, 'type', array('id' => 'result-type')); ?>
                                    <?php echo $form->hiddenField($model, 'source_file_id', array('id' => 'result-id')); ?>
                                    <?php echo $form->hiddenField($model, 'multi', array('id' => 'result-multi')); ?>
                                    <?php
                                    //  if (Yii::app()->user->hasFlash('id')){
                                    //  echo $form->textField($model, 'id', array('value' => Yii::app()->user->getFlash('id')));    
                                    //  }
                                    echo $form->hiddenField($model, 'id', array('value' => Yii::app()->request->getParam('id')));
                                    ?>
                                    <?php echo CHtml::submitButton($model->isNewRecord ? '确定' : '保存', array('class' => 'right button')); ?>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <?php $this->endWidget(); ?>
                </div>

                <div class="none forward-prize">
                    <!--新建步骤    -->
                    <div class="forward-prize-step">
                        <div class="forward-prize-step-bj"></div>
                        <a href="javascript:;" class="forward-prize-step-one forward-prize-step-ok">1</a>
                        <a href="javascript:;" class="forward-prize-step-two forward-prize-step-ok">2</a>
                        <a href="javascript:;" class="forward-prize-step-three forward-prize-step-ok">3</a>
                    </div>
                    <div class="padding10 clear"></div>
                    <div class="text-center">
                        <i class="icon-50 icon-50-ok"></i>
                        <p class="margin-top-15 font-14">操作成功</p>
                        <div class="padding10">
                            <input type="button" value="查看" class="button button-green">

                            <a class="button button-white" href="<?php echo Yii::app()->createUrl('/systems/transmit/index'); ?>">返回页面</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div><script>
    $(function () {
        var $url = window.location.href;
        var $url2 = <?php echo Yii::app()->request->getParam('status'); ?> - 1;
        $('.forward-prize').hide();
        $('.forward-prize').eq($url2).show();
    });
</script>