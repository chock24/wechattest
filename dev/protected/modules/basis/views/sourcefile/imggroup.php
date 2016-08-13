<?php
/* @var $this SourcefileController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs = array(
    '管理' => array('/managers'),
    '素材管理',
);
?>
<?php Yii::app()->clientScript->registerCoreScript('jquery'); ?>
<link href="<?php echo Yii::app()->baseUrl . "/css/" ?>voice.css" rel="stylesheet" type="text/css" />
<div class="message img_message">
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'source-images-form',
    ));
    ?>
    <!--
    <?php echo "上传图片"; ?>
    <?php echo CHtml::activeFileField($model, 'files'); ?>
    建议尺寸：900像素 * 500像素
        <br>
    
    -->
    <?php echo $form->hiddenField($model, 'ids'); ?>
    <div class="voice_bd img_left" id="voice" >
        <?php $gather = Yii::app()->request->getParam('gather'); ?>
        <div class="voice_bd" id="voice" >
            <?php
            $this->widget('zii.widgets.CListView', array(
                'dataProvider' => $dataProvider,
                'itemView' => '_groupimages',
                'ajaxUpdate' => false,
                'template' => '{items}{summary}{pager}',
            ));
            ?>
        </div>
    </div>
    <div class="img_right">
        <dl>
            &nbsp;&nbsp; <?php echo CHtml::link('显示全部', array('/basis/sourcefile/imggroup', 'type' => '2'), array('class' => 'showimgs')); ?>
            <?php
            foreach ($sourcefilegather as $s) {
                echo '<dd>';
                echo '<a class="showimgs" href="' . Yii::app()->createUrl('/basis/sourcefile/imggroup/', array('type' => '2', 'gather' => $s->id)) . '">' . $s->name . '</a>';
                echo '(' . count(@$s->sourcefiles) . ')';
                echo '</dd>';
            }
            ?>
             
        </dl>
    </div>

<?php $this->endWidget(); ?>

