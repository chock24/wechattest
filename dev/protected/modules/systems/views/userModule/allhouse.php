<title>全屋家居</title>

</head>
<body class="bj_fff">
    <section class="wrap">

        <div class="the_house_head"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/font/header/allhouse_hed.jpg"></div>
        <div class="the_house_out">
            <?php
            if (!empty($transmit)) {
                foreach ($transmit as $t) {
                    ?>
                    <div class="the_house_list">
                        <a href="<?php echo Yii::app()->createUrl('systems/userModule/transmit_detail', array('id' => $t->id,'openid' => Yii::app()->session['openid'])); ?>">
                            <div class="the_house_cont">
                                <h3><?php echo $t->title; ?></h3>
                                <!--<span class="the_house_txt"><i><?php /*echo $t->description; */?></i><em>查看详细 >></em></span>-->
                            </div>
                            <div class="the_house_img"><img src="<?php echo Yii::app()->params->WEBROOT . Yii::app()->params->FILEFOLDER . Yii::app()->params->FILEPATH['sourcefile']['image']['medium'] . $t->image_src; ?>"></div>
                        </a>
                    </div>
                    <?php
                }
            }
            ?>
        </div>
    </section>
    <script>
        $(function(){
            //截取字符串
            capture_c($('.the_house_cont h3'),36);
            //capture_c($('.the_house_txt i'),55);
        })
    </script>
</body>
</html>
