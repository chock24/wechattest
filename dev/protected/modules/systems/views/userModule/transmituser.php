<title>我的分享</title>
<body>
    <section class="wrap">
        <div class="myShare">
            <div class="myShare_detail">
                <ul>
                    <?php
                    if (!empty($TransmitUser)) {
                        foreach ($TransmitUser as $t) {
                            ?>

                            <li>
                                <a href="<?php echo Yii::app()->createUrl('systems/userModule/transmit_detail',array('id'=>$t->transmits->id)) ?>">
                                    <div class="myShare_pic">
                                        <img src="<?php echo Yii::app()->params->WEBROOT . Yii::app()->params->FILEFOLDER . Yii::app()->params->FILEPATH['sourcefile']['image']['medium'] . $t->transmits->image_src; ?>">
                                    </div>
                                    <div class="myShare_tit">
                                        <div class="myShare_title"><?php echo $t->transmits->title ?></div>
                                        <div class="myShare_new">
                                            <span>有奖活动</span>
                                            <span class="myShare_data">2015-08-08</span>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <?php
                        }
                    }
                    ?>

                </ul>
            </div>
        </div>
    </section>
</body>