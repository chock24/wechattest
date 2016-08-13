<?php
/* @var $this SourcefileController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs = array(
    '基础功能' => array('/basis'),
    '微信素材' => array('/basis/appmsg'),
    '图片素材'
);
?>
<?php
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . "/css/sourcefile/common.css");
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . "/css/sourcefile/image.css");
?>


<h1>图片素材</h1>

<div class="span-100">
    <?php $this->renderPartial('header'); ?>

    <div class="message whole_message">
        <?php echo CHtml::link('上传图片', array('create', 'type' => 2), array('class' => 'create-item inp_style')); ?>
        <span>大小:不超过2M,格式:bmp,png,jpeg,jpg,gif</span>

        <?php
        $form = $this->beginWidget('CActiveForm', array(
            'id' => 'source-image-form',
// Please note: When you enable ajax validation, make sure the corresponding
// controller action is handling ajax validation correctly.
// There is a call to performAjaxValidation() commented in generated controller code.
// See class documentation of CActiveForm for details on this.
        ));
        ?>
        <?php echo $form->hiddenField($model, 'ids'); ?>
        <div class="content" id="voice">
            <div class="op_group">
                <label class="qx_checked">
                    <input type="checkbox" data-label="全选" class="frm_checkbox">
                    <span class="lbl_content">全选</span>
                </label>
                <?php $gather = Yii::app()->request->getParam('gather');
                ?>
                <input type="button" value="移动分组" class="img_move a_screen inp_style" id="btnyidong" />

                <input type="button" value="删除" class="img_delete a_screen inp_style" />

                <div class="shade"></div>
            </div>
            <div id="voice" style="padding-top: 10px;">
                <?php
                $this->widget('zii.widgets.CListView', array(
                    'dataProvider' => $dataProvider,
                    'itemView' => '_image',
                    'id' => 'ajaxListView',
                    'template' => '{items} <div class="clear"></div> {summary} {pager}',
                ));
                ?>
            </div>
        </div>

        <?php $this->endWidget(); ?>
        <div class="sidebar">
            <dl>
                <dd>
                    <?php echo CHtml::link('显示全部', array('/basis/sourcefile/image')); ?>
                </dd>
                <?php
                $this->widget('zii.widgets.CListView', array(
                    'dataProvider' => $sourceFileGather,
                    'itemView' => '/public/_gather',
                    'id' => 'gatherListView',
                    'template' => '{items}',
                ));
                ?>
                <dd>
                    <?php echo CHtml::link('+添加分组', array('/basis/sourcefilegather/create/', 'type' => 2), array('class' => 'create-gather-item')); ?>
                </dd>
            </dl>
        </div>
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
        $(function () {
            $('.img_move,.img_delete').addClass('a_screen').attr('disabled', 'disabled');
            $('.img_size').find("input:checkbox").click(function () {
                var size = $('.img_size').find("input:checkbox").length;
                var inputs = $('.img_size').find("input:checkbox");
                var checked_counts = 0;
                if (inputs.is(':checked') == true) {
                    $('.img_move,.img_delete').removeClass('a_screen').removeAttr('disabled');
                } else {
                    $('.img_move,.img_delete').addClass('a_screen').attr('disabled', 'disabled');
                }
                for (var i = 0; i < inputs.length; i++) {
                    if (inputs[i].checked) {
                        checked_counts++;
                    }
                }
                if (checked_counts == size) {
                    $('.frm_checkbox').attr("checked", 'true');
                } else {
                    $('.frm_checkbox').removeAttr("checked");
                }
            });
            //全选（全不选）
            $('.frm_checkbox').click(function () {
                if ($(this).is(':checked') == true) {
                    $('.img_move,.img_delete').removeClass('a_screen').removeAttr('disabled');
                    $('.img_size').each(function () {
                        $(this).find("input:checkbox").attr("checked", 'true');
                    });
                } else {
                    $('.img_move,.img_delete').addClass('a_screen').attr('disabled', 'disabled');
                    $('.img_size').each(function () {
                        $(this).find("input:checkbox").removeAttr("checked");
                    });
                }
            });
            //点击获取所有选中的复选框的name  ----批量移动
            $('.img_move').click(function () {
                var my_array = new Array();
                $('.img_size').find("input:checkbox").each(function () {
                    if ($(this).is(':checked') == true) {
                        var sz = $(this).val();
                        my_array.push(sz)
                    }
                });
                $('#SourceFile_ids').attr('value', my_array);
                var operationUrl = "<?php echo Yii::app()->createURL('/basis/sourcefilegather/group', array('type' => 2, 'gather_id' => $gather)); ?>";
                var data = my_array;
                $.get(operationUrl, {queryString: "" + data + ""}, function (s) {
                    $('#mydialog').dialog({title: '分组列表'});
                    $('#mydialog .content').html(s);
                    $('#mydialog').dialog('open');
                    return true;
                });
                return false;

            });
            //点击获取所有选中的复选框的name -----批量删除
            $('.img_delete').click(function () {
                if (confirm('您确定要删除吗？')) {
                    var inputs = $('.img_size').find("input:checkbox");
                    var checked_counts = 0;
                    for (var i = 0; i < inputs.length; i++) {
                        if (inputs[i].checked) {
                            checked_counts++;
                        }
                    }
                    var my_array = new Array();
                    $('.img_size').find("input:checkbox").each(function () {
                        if ($(this).is(':checked') == true) {
                            var sz = $(this).val();
                            my_array.push(sz)
                        }
                    });
                    var ids = my_array;
                    var gatherid = "<?php echo Yii::app()->request->getParam('gather'); ?>";
                    var url = "<?php echo Yii::app()->createURL('/basis/sourcefile/delete', array('type' => '2')) ?>";
                    $.post(url, {ids: "" + ids + "", gatherid: "" + gatherid + ""}, function (s) {
                        window.location.reload();
                    });
                    return false;
                }
            });

        })
    </script>
    <?php
    Yii::app()->clientScript->registerScript('operation2', "
        $('.create-item').live('click',function(){
                var operationUrl = $(this).attr('href');
		$.get(operationUrl,'',function(s){
			$('#mydialog').dialog({title:'上传图片'});
			$('#mydialog .content').html(s);
			$('#mydialog').dialog('open'); return true;
		});	
                return false;
	});
        $('.update-item').live('click',function(){
                var operationUrl = $(this).attr('href');
			$.get(operationUrl,'',function(s){
			$('#mydialog').dialog({title:'修改图片标题'});
			$('#mydialog .content').html(s);
			$('#mydialog').dialog('open'); return false;
		});	
                return false;
	});
   ");
    ?>
