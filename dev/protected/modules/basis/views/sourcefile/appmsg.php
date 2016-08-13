<?php
/* @var $this SourcefileController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs = array(
    '基础功能' => array('/basis'),
    '微信素材' => array('/basis/appmsg'),
    '单图文素材'
);
?>

<?php
Yii::app()->clientScript->registerCoreScript('jquery');
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . "/css/sourcefile/common.css");
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . "/css/sourcefile/img_txt.css");
?>
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl . "/js/" ?>blocksit.min.js"></script>

<h1>单图文管理</h1>

<div class="span-100">
    <?php $this->renderPartial('header'); ?>
    <div class="message img_txt_message">
        <div class="img_txt_title">
            <h3>图文消息列表</h3>
        </div>
        <div class="content img_txt_col width81">
            <div class="img_txt_sc">
                <i class="img_txt_icon img_txt_hi"></i>
                <a href="<?php echo Yii::app()->createUrl("/basis/sourcefile/onlymsg") ?>" target="_blank" class="da_img"><i class="img_txt_icon"></i><strong>单图文消息</strong></a>
                <a href="<?php echo Yii::app()->createUrl("/basis/sourcefile/moremsg") ?>" target="_blank" class="du_img"><i class="img_txt_icon"></i><strong>多图文消息</strong></a>
            </div>
            <div class="img_txt_bd">
             
                <?php
                $this->widget('zii.widgets.CListView', array(
                    'dataProvider' => $dataProvider,
                    'itemView' => '_appmsg',
                    'ajaxUpdate' => false,
                    'template' => '{items} <div class="clear"></div> {summary} {pager}',
                ));
                ?>
            </div>
        </div>
        <div class="sidebar">
            <dl>
                <dd>
                    <?php echo CHtml::link('显示全部', array('/basis/sourcefile/appmsg')); ?>
                </dd>
                <?php
                $this->widget('zii.widgets.CListView', array(
                    'dataProvider' => $sourceFileGather,
                    'itemView' => '/public/_gather',
                    'id' => 'gatherListView',
                    'template' => '{items} {pager}',
                ));
                ?>
                <dd>
                    <?php echo CHtml::link('+添加分组', array('/basis/sourcefilegather/create/', 'type' => 5), array('class' => 'create-gather-item')); ?>
                </dd>
            </dl>
        </div>

    </div>
</div>

<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'mydialog',
    'htmlOptions' => array(
        'class' => 'mydialog',
    ),
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
    $(function () {
        //瀑布流
        $(window).load(function () {
            var winWidth = $(window).width();
            if (winWidth <= 1500) {
                pubu(3);
            } else if (winWidth > 1500) {
                pubu(4);
            }
            $(window).resize(function () {
                var winWidth = $(window).width();
                if (winWidth <= 1500) {
                    pubu(3);
                } else if (winWidth > 1500) {
                    pubu(4);
                }
            });
            function pubu(text) {
                $('.content').find('.items').BlocksIt({
                    numOfCol: text,
                    offsetX: 8,
                    offsetY: 8,
                    blockElement: '.img_txt_file'
                });
            }
        });
        //单图(多图)鼠标移动显隐
        $('.img_txt_sc').hover(function () {
            $(this).find('.img_txt_hi').hide();
            $(this).find('a').css('display', 'inline-block');
        }, function () {
            $(this).find('.img_txt_hi').show();
            $(this).find('a').css('display', 'none');
        });
    })
</script>



