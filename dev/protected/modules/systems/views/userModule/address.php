<title>个人中心</title>
<body>
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'useraddress-form',
        // Please note: When you enable ajax validation, make sure the corresponding
        // controller action is handling ajax validation correctly.
        // There is a call to performAjaxValidation() commented in generated controller code.
        // See class documentation of CActiveForm for details on this.
        'enableAjaxValidation' => false,
        'htmlOptions' => array('enctype' => 'multipart/form-data',),
    ));
    ?>
   
    <?php echo $form->errorSummary($model); ?>
    <section class="wrap">
        <div class="sonar_map">
            <ul>
                <li>
                    <a href="javascript:;" class="onck_district">
                        <h3 data-null="non-null" data-name="所在地址"><?php echo @$model->sheng->name . @$model->shi->name . @$model->qu->name; ?></h3>
                        <span>所在地区</span>
                    </a>
                </li>
                <li>
                    <a href="javascript:;">
                        <h3 data-null="non-null" data-name="街道详细地址"><?php echo @$model->address_other; ?></h3>
                        <span>街道详细地址</span>
                        <i></i>
                    </a>
                    <?php echo $form->textField($model, 'address_other', array('placeholder' => '街道详细地址')); ?>
                </li>

                <li>
                    <a href="javascript:;">
                        <h3 data-null="non-null" data-name="收件人姓名"><?php echo @$model->name; ?></h3>
                        <span>收货人姓名</span>
                        <i></i>
                    </a>
                    <?php echo $form->textField($model, 'name', array('placeholder' => '姓名')); ?>
                </li>
                <li>
                    <a href="javascript:;">
                        <h3 data-tel="non-null"><?php
                            if (!empty($model->tel)) {
                                echo $model->tel;
                            }
                            ?></h3>
                        <span>收货人电话</span>
                        <i></i>
                    </a>
                    <?php echo $form->textField($model, 'tel', array('placeholder' => '电话')); ?>
                </li>
                <li>
                    <a href="javascript:;">
                        <h3><?php
                            if (!empty($model->postcode)) {
                                echo $model->postcode;
                            }
                            ?></h3>
                        <span>邮政编码</span>
                        <i></i>
                    </a>
                    <?php echo $form->textField($model, 'postcode', array('placeholder' => '邮政编码')); ?>
                </li>
            </ul>
            <div class="sonar_map_button">
                <a href="<?php echo Yii::app()->createUrl('systems/userModule/address', array('id' => $model->id, 'isdelete' => 1)) ?>" class="sonar_map_del"><em></em>删除</a>
                <?php echo $form->hiddenField($model, 'address_sheng'); ?>
                <?php echo $form->hiddenField($model, 'address_shi'); ?>
                <?php echo $form->hiddenField($model, 'address_qu'); ?>
                <?php echo CHtml::submitButton($model->isNewRecord ? '创建' : '保存', array('class' => 'sonar_map_save','onclick'=>'return crmValidator("li")')); ?>
            </div>
        </div>
        <div class="none popup_sonar_selection">
            <div class="sonar_selection">
                <!--<h2 class="sonar_selection_tit">广东省</h2>
                <dl>
                    <dt>广州市</dt>
                    <dd>天河区</dd>
                    <dd>白云区</dd>
                    <dd>白云区</dd>
                    <dd>白云区</dd>
                </dl>-->
            </div>
        </div>
        <div class="popup_bj">
            <div class="popup">
                <div class="popup_con popup_bu_int">
                    <a href="javascript:;" class="popup_x"></a>
                    <h5>亲，你确定要删除这个地址吗？</h5>
                    <div class="popup_bu_int_but">
                        <a class="left pop_but" href="javascript:;">是</a>
                        <a class="right pop_but bad" href="javascript:;">否</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php $this->endWidget(); ?>
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
</body>
<?php $this->endWidget(); ?>
<script type="text/javascript">
    $(function () {
        //删除地址
        $('.sonar_map_del').click(function () {
            $('.popup_bj').show().find('.popup_con').show().find('.pop_but').eq(0).attr('href', $(this).attr('href'));
            $('.popup_bj').find('.pop_but').eq(1).click(function () {
                $('.popup_bj').hide();
            });
            return false;
        });

        $('.sonar_map li a').click(function () {
            $('.sonar_map li a').show().next().hide();
            $(this).show().next().show().focus();
        });
        $('.sonar_map li').find('input').blur(function () {
            $(this).hide().prev().show();
            $(this).prev().find('h3').html($(this).val());
        });
        $('.onck_district').click(function () {
            $('.popup_sonar_selection').show().css({marginTop: -$('.sonar_map').height()});
            province();
        });
        //返回 一级城市 名称
        function province() {
            var html = '<h2 class="sonar_selection_tit">请选择省份</h2><dl>';
            var data_json = <?php echo json_encode($trantype); ?>;
            for (var i = 0; i < data_json.length; i++) {
                html += '<dd id=' + data_json[i].id + '>' + data_json[i].name + '</dd>';
            }
            html += '</dl>';
            $('.popup_sonar_selection').show().find('.sonar_selection').html(html);
            $('.sonar_selection').find('dd').unbind().click(function () {
                childtype($(this).attr('id'), $(this).html());
            });
        }
        //返回 二级地区 名称
        function childtype(i, text) {
            var url = "<?php echo Yii::app()->createUrl('systems/userModule/childdistrict'); ?>";
            var id = i;//需替换为动态获取
            var html = '<dl><dt id=' + i + '>' + text + '</dt>';
            $.post(url, {id: "" + id + ""},
            function (data) {
                for (var i = 0; i < data.length; i++) {
                    html += '<dd id=' + data[i].id + '>' + data[i].name + '</dd>';
                }
                html += '</dl>';
                $('.popup_sonar_selection').find('.sonar_selection').html(html);
                $('.sonar_selection').find('dd').unbind().click(function () {
                    threetype($(this).attr('id'), $(this).parent().find('dt').html(), $(this).html(), $(this).parent().find('dt').attr('id'));
                });
                $('.sonar_selection').find('dt').unbind().click(function () {
                    province();
                });
            }, 'json');
        }
        //三级 地区名称
        function threetype(i, text1, text2, j) {
            var url = "<?php echo Yii::app()->createUrl('systems/userModule/childdistrict'); ?>";
            var id = i;//需替换为动态获取
            var html = '<h2 class="sonar_selection_tit" id=' + j + '>' + text1 + '</h2><dl><dt id=' + i + '>' + text2 + '</dt>';
            $.post(url, {id: "" + id + ""},
            function (data) {
                for (var i = 0; i < data.length; i++) {
                    html += '<dd id=' + data[i].id + '>' + data[i].name + '</dd>';
                }
                html += '</dl>';
                $('.popup_sonar_selection').find('.sonar_selection').html(html);
                if (data != '') {
                    $('.sonar_selection').find('dd').unbind().click(function () {
                        var html = $(this).parent().prev().html() + $(this).parent().find('dt').html() + $(this).html();
                        var html_id = $(this).parent().prev().attr('id') + '/' + $(this).parent().find('dt').attr('id') + '/' + $(this).attr('id');
                        $('.sonar_map').find('li').eq(0).find('h3').html(html);
                        //  alert(html_id);//省市区的获取id
                        $('#UserAddress_address_sheng').attr('value', $(this).parent().prev().attr('id'));//省
                        $('#UserAddress_address_shi').attr('value', $(this).parent().find('dt').attr('id'));//市
                        $('#UserAddress_address_qu').attr('value', $(this).attr('id'));//区
                        $('.popup_sonar_selection').hide();
                    });
                    $('.sonar_selection').find('dt').unbind().click(function () {
                        childtype($(this).parent().prev().attr('id'), $(this).parent().prev().html());
                    });
                    $('.sonar_selection').find('h2').unbind().click(function () {
                        province();
                    });
                } else {
                    $('.sonar_selection').find('dt').unbind().click(function () {
                        var html = $(this).parent().prev().html() + $(this).html();
                        var html_id = $(this).parent().prev().attr('id') + '/' + $(this).attr('id');
                        $('.sonar_map').find('li').eq(0).find('h3').html(html);
                        //alert(html_id);//省市区的获取id
                        $('#UserAddress_address_sheng').attr('value', $(this).parent().prev().attr('id'));//省
                        $('#UserAddress_address_shi').attr('value', $(this).attr('id'));//市
                        $('.popup_sonar_selection').hide();
                    });
                }

            }, 'json');
        }
    })
</script>