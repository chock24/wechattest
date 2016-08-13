<?php
/* @var $this GiftController */
/* @var $model Gift */
/* @var $form CActiveForm */
?>


<div class="right content-main">

    <div class="margin-top-10 tabhost">
        <div class="tabhost-title">
            <ul>
                <li><a href="<?php echo Yii::app()->createUrl('systems/gift/index'); ?>">礼品商城</a></li>
                <li><a href="<?php echo Yii::app()->createUrl('systems/gift/create'); ?>">新增礼品</a></li>
                <li><a href="<?php echo Yii::app()->createUrl('systems/giftType/index'); ?>">分类管理</a></li>
                <li class="active"><a href="<?php echo Yii::app()->createUrl('systems/giftExchange/index'); ?>">兑换记录</a></li>
            </ul>
            <div class="clear"></div>
        </div>
        <div class="padding20 tabhost-center">

            <div class="form marketing_add_article">

                <?php
                $form = $this->beginWidget('CActiveForm', array(
                    'id' => 'gift-form',
                    // Please note: When you enable ajax validation, make sure the corresponding
                    // controller action is handling ajax validation correctly.
                    // There is a call to performAjaxValidation() commented in generated controller code.
                    // See class documentation of CActiveForm for details on this.
                    'enableAjaxValidation' => false,
                    'htmlOptions' => array('enctype' => 'multipart/form-data',),
                ));
                ?>

                <?php echo $form->errorSummary($model); ?>
                <div class="row add_article_list">
                    <label>商品名称<span class="color-red">*</span></label>
                    <?php /* echo $form->labelEx($model, 'gift_name'); */ ?>
                    <?php echo $form->textField($model, 'gift_name', array('size' => 60, 'maxlength' => 255)); ?>
                    <?php echo $form->error($model, 'gift_name'); ?>
                </div>
                <div class="row add_article_list">
                    <div class="left">
                        <label>手机号码</label>
                        <?php /* echo $form->labelEx($model, 'tel'); */ ?>
                        <?php echo $form->textField($model, 'tel', array('size' => '25')); ?>
                        <?php echo $form->error($model, 'tel'); ?>
                    </div>
                    <div class="left">
                        <label>邮编</label>
                        <?php /* echo $form->labelEx($model, 'postcode'); */ ?>
                        <?php echo $form->textField($model, 'postcode', array('size' => '25')); ?>
                        <?php echo $form->error($model, 'postcode'); ?>
                    </div>
                </div>
                <div class="row add_article_list">
                    <div class="left">
                        <label>分值<span class="color-red">*</span></label>
                        <?php /* echo $form->labelEx($model, 'score'); */ ?>
                        <?php echo $form->textField($model, 'score', array('size' => '25')); ?>
                        <?php echo $form->error($model, 'score'); ?>
                    </div>
                    <div class="left">
                        <label>状态</label>
                        <?php /* echo $form->labelEx($model, 'status'); */ ?>
                        <?php echo $form->dropDownList($model, 'status', array('0' => '未发货', '1' => '已发货')); ?>
                        <?php echo $form->error($model, 'status'); ?>
                    </div>
                </div>
                <div class="row add_article_list">
                    <label>收货地址</label>
                    <?php echo $form->dropDownList($model, 'address_sheng', $trantype); ?>
                    <?php echo $form->dropDownList($model, 'address_shi', $trantype); ?>
                    <?php echo $form->dropDownList($model, 'address_qu', $trantype); ?>
                    <?php echo $form->textField($model, 'address_other', array('size' => '25')); ?>
                </div>
                <div class="row add_article_list">
                    <label>备注信息</label>
                    <?php /* echo $form->labelEx($model, 'remark'); */ ?>
                    <?php echo $form->textField($model, 'remark', array('size' => '60')); ?>
                    <?php echo $form->error($model, 'remark'); ?>
                </div>

                <div class="row buttons text-center add_article_list">
                    <?php echo CHtml::submitButton($model->isNewRecord ? '创建' : '保存', array('class' => 'margin-top-15 button button-green')); ?>
                    <?php $this->endWidget(); ?>
                </div>

            </div><!-- form -->
        </div>
    </div>
</div>
<script type="text/javascript">
    $(function () {
        //返回 二级地区 名称
        function childtype(i) {
            var url = "<?php echo Yii::app()->createUrl('systems/userModule/childdistrict'); ?>";
            var id = i;//需替换为动态获取
            var html = '<option>请选择</option>';
            $.post(url, {id: "" + id + ""},
            function (data) {
                for (var i = 0; i < data.length; i++) {
                    html += '<option value=' + data[i].id + '>' + data[i].name + '</option>'
                }
                $('#GiftExchange_address_shi').html(html);
            }, 'json');
        }
        //三级 地区名称  
        function threetype(i) {
            var url = "<?php echo Yii::app()->createUrl('systems/userModule/childdistrict'); ?>";
            var id = i;//需替换为动态获取
            var html = '<option>请选择</option>';
            $.post(url, {id: "" + id + ""},
            function (data) {
                for (var i = 0; i < data.length; i++) {
                    html += '<option value=' + data[i].id + '>' + data[i].name + '</option>'
                }
                $('#GiftExchange_address_qu').html(html);
            }, 'json');
        }

        $('#GiftExchange_address_sheng').live('change', function () {
            childtype($(this).val());
            threetype($(this).val());
        });
        $('#GiftExchange_address_shi').live('change', function () {
            threetype($(this).val());
        });
        //childtype($('#GiftExchange_address_sheng').val());
        //threetype($('#GiftExchange_address_shi').val());
    })
</script>