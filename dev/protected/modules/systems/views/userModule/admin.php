<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/weixin_css/marketing_tool.css" />

<div class="right content-main">
    <h2 class="content-main-title">会员管理中心</h2>
    <div class="margin-top-10 tabhost">
        <div class="tabhost-title">
            <div class="clear"></div>
        </div>
        <div class="tabhost-center">
            <div class="padding20 member-center">
                <div class="member-center-data">
                    <div class="member-center-data-avatar">
                        <img src="http://wx.qlogo.cn/mmopen/ajNVdqHZLLAib1B33YbnJiaZ9O1P6EWQOUW9D8jGooFgyYwMcr5GeRVia53vRnIQFnLe0feEbv1BVXqRBdXTibyv0w/64" />
                    </div>
                    <div class="member-center-data-tex">
                        <p class="left">姓名:<span>皮蛋狂吃瘦肉粥</span></p>
                        <p class="right">性别:<span>男</span></p>
                        <div class="clear"></div>
                        <p>出生年月:<span>1920-06-29</span></p>
                        <p>电话:<span>13580385214</span></p>
                        <a href="javascript:;">修改</a>
                    </div>
                </div>
                <div class="coupon-integral">
                    <ul>
                        <li>
                            <span>皮蛋狂吃瘦肉粥优惠劵</span>
                            <a href="javascript:;" class="right button button-brown">查看</a>
                        </li>
                        <li>
                            <span>皮蛋狂吃瘦肉粥积分</span>
                            <a href="javascript:;" class="right button button-brown">查看</a>
                        </li>
                    </ul>
                </div>
                <div class="clear"></div>
                <div class="shipping-address">
                    <h3 class="shipping-address-tit">地址管理</h3>
                    <ul>
                        <li>广州市天河区广州大道北512号自编2号楼）五层515号</li>
                        <li>广州市天河区广州大道北512号自编2号楼）五层515号</li>
                        <li>广州市天河区广州大道北512号自编2号楼）五层515号</li>
                    </ul>
                </div>
                <div class="shipping-address">
                    <h3 class="shipping-address-tit">转发列表</h3>
                    <ul>
                        <?php foreach ($transmituser as $t) { ?>
                            <li><?php echo $t->transmits->title; ?></li>
                        <?php } ?>

                    </ul>
                </div>

            </div>
            <div class="clear"></div>
            <?php
            $form = $this->beginWidget('CActiveForm', array(
                'id' => 'usermodule-admin-form',
                // Please note: When you enable ajax validation, make sure the corresponding
                // controller action is handling ajax validation correctly.
                // There is a call to performAjaxValidation() commented in generated controller code.
                // See class documentation of CActiveForm for details on this.
                'enableAjaxValidation' => false,
                'htmlOptions' => array('enctype' => 'multipart/form-data',),
            ));
            ?>
            <div class="row add_article_list">
                <?php echo '地址分类'; ?>
                <?php echo $form->dropDownList($model, 'type_id', $trantype); ?>
                <?php echo $form->dropDownList($model, 'child_type_id', $trantype); ?>
                <?php echo $form->dropDownList($model, 'three_type_id', $trantype); ?>
                <?php echo $form->error($model, 'type_id'); ?>
            </div>
            <?php $this->endWidget(); ?>
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
                $('#UserModule_child_type_id').html(html);
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
                $('#UserModule_three_type_id').html(html);
            }, 'json');
        }

        $('#UserModule_type_id').live('change', function () {
            childtype($(this).val());
        });
        $('#UserModule_child_type_id').live('change', function () {
            threetype($(this).val());
        });
        childtype($('#UserModule_type_id').val());
        threetype($('#UserModule_child_type_id').val());
    })
</script>