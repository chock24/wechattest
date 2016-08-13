<head>
    <title>个人资料</title>
</head>
<body>
    <section class="wrap">
        <div class="personal_data">
            <div class="personal_data_hea"></div>
            <div class="personal_data_li">
                <?php
                $form = $this->beginWidget('CActiveForm', array(
                    'id' => 'userdata-form',
                    // Please note: When you enable ajax validation, make sure the corresponding
                    // controller action is handling ajax validation correctly.
                    // There is a call to performAjaxValidation() commented in generated controller code.
                    // See class documentation of CActiveForm for details on this.
                    'enableAjaxValidation' => false,
                    'htmlOptions' => array('enctype' => 'multipart/form-data',),
                ));
                ?>
                <ul>
                    <li>
                        <span>姓名</span>
                        <?php echo $form->textField($model, 'nickname', array('size' => 67, 'maxlength' => 50, 'placeholder' => "请输入姓名", 'data-null' => 'non-null', 'data-name' => '姓名')); ?>
                    </li>
                    <li>
                        <span>性别</span>
                        <p class="user_gender">
                            <label id="1"><em class="<?php echo @$userdetail->sex == 1 ? "on" : "" ?>" ></em>先生</label>
                            <label id="2"><em class="<?php echo @$userdetail->sex == 2 ? "on" : "" ?>"></em>女士</label>
<!--                            <label id="0"><em class="<?php echo $model->sex == 0 ? "on" : "" ?>"></em>保密</label>-->
                        </p>
                    </li>
                    <li>
                        <span>出生年月</span>
                        <p class="date_of_birth"><?php
                            if (!empty($userdetail)) {
                                echo $userdetail->age;
                            }else {
                                echo '请选择出生年月';
                            }
                            ?></p>
                        <input style="float: right;width: 100%;height: 100%;opacity: 0;z-index: 3;" class="personal_data_li_data" type="date" value="<?php
                        if (!empty($userdetail)) {
                            echo $userdetail->age;
                        }
                        ?>" placeholder="请选择出生年月" max="<?php echo date('Y-m-d', time()) ?>">
                    </li>
                    <li>
                        <span>电话</span>
                        <?php echo $form->textField($model, 'mobile', array('placeholder' => "请输入手机号码", 'data-tel' => 'non-null', 'value' => @$userdetail->mobile)); ?>
                    </li>
                    <li class="click_address">
                        <span>地址</span>
                        <p>
                            <a href="javascript:;">
                                <b data-null="non-null" data-name="地址" style="position: absolute;width: 100%;height: 100%;"><?php
                                     if (!empty($userdetail)) {
                                      echo  $this->country($userdetail, 0) . $this->province($userdetail, 0) . $this->city($userdetail, 0) . $this->district($userdetail, 0);
                                    }
                                    ?></b>
                            </a>
                        </p>
                    </li>
                    <li>
                        <?php echo $form->hiddenField($model, 'province'); ?>
                        <?php echo $form->hiddenField($model, 'city'); ?>
                        <?php echo $form->hiddenField($model, 'district'); ?>
                        <?php echo $form->hiddenField($model, 'sex'); ?>
                        <?php echo $form->hiddenField($model, 'age'); ?>
                        <?php echo CHtml::submitButton('确定', array('onclick' => 'return crmValidator("li")')); ?>
                    </li>
                </ul>
                <?php $this->endWidget(); ?>
            </div>
        </div>
        <div class="none popup_sonar_selection">
            <div class="sonar_selection">

            </div>
        </div>
    </section>
    <script type="text/javascript">
        $(function () {
            //选择出生日期的方法
            $('.date_of_birth').click(function(){
                $('.personal_data_li').find('.personal_data_li_data').focus();
            });
            $('.personal_data_li').find('.personal_data_li_data').blur(function(){
                $('.date_of_birth').html($(this).val());
            });
            $('.user_gender').find('label').click(function () {
                $(this).find('em').addClass('on');
                $(this).siblings().find('em').removeClass('on');
                //隐藏域 性别  赋值
                $('#User_sex').attr('value', $(this).attr('id'));
            });
            $('input[type=date]').change(function () {
                // alert($(this).val());//获取修改出生年月后得到的值
                $('#User_age').attr('value', $(this).val());

            });
            //获取省市区的方法
            $('.click_address').click(function () {
                $('.popup_sonar_selection').css({marginTop: -$('.personal_data').height()});
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
                            $('.click_address').find('b').eq(0).html(html);
                            // alert(html_id);//省市区的获取id
                            $('#User_province').attr('value', $(this).parent().prev().attr('id'));
                            $('#User_city').attr('value', $(this).parent().find('dt').attr('id'));
                            $('#User_district').attr('value', $(this).attr('id'));
                            $('.popup_sonar_selection').hide();
                        });
                        $('.sonar_selection').find('dt').unbind().click(function () {
                            childtype($(this).parent().prev().attr('id'), $(this).parent().prev().html());
                        });
                        $('.sonar_selection').find('h2').unbind().click(function () {
                            province();
                        });
                    } else if (data == '') {
                        $('.sonar_selection').find('dt').unbind().click(function () {
                            var html = $(this).parent().prev().html() + $(this).html();
                            var html_id = $(this).parent().prev().attr('id') + '/' + $(this).attr('id');
                            $('.click_address').find('b').eq(0).html(html);
                            //alert(html_id);//省市区的获取id
                            $('.popup_sonar_selection').hide();
                        });
                    }

                }, 'json');
            }

        });
    </script>
</body>
