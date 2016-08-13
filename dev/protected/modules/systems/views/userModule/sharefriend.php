<title>分享链接</title>
<body class="bj_fff">
    <section class="wrap">
        <div class="shared_links">
            <div class="shared_links_head">
                <div class="head_img"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/font/wx_logo.jpg"></div>
                <h2>欧派家居商城</h2>
            </div>
            <div class="shared_links_cont">
                <div class="shared_links_img">
                    <?php if (!empty($quickmoark)) { ?>
                        <img alt="" src="<?php echo Yii::app()->request->hostInfo . '/' . $quickmoark->path; ?>">
                    <?php }
                    ?>
                </div>
                <div class="shared_links_hi">
                    <span class="hi_tit">我是小派，</span>
                    <span class="hi_txt">一键长按，识别二维码，关注我专享会员特权！</span>
                </div>
            </div>
        </div>
    </section>
</body>
</html>