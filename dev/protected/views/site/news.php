<link href="<?php echo Yii::app()->baseUrl; ?>/weixin_css/index.css" rel="stylesheet" type="text/css" />
<div class="right content-main">
    <!--<h2 class="content-main-title">系统公告</h2>-->
    <div>
        <div class="tabhost">
            <!--<div class="tabhost-title">
                <div class="clear"></div>
            </div>-->
            <div class="tabhost-center">

                <div class="breadcrumbs">
                    <a href="/">首页</a> »
                    <a href="javascript:;">系统公告</a> »
                    <span>文章页面</span>
                </div>

                <div class="padding30 padding-top-10 index-affiche-details">
                    <div class="index-affiche-details-title">
                        <h3>
                            <?php echo CHtml::encode($model->title); ?>
                            <div class="margin-top-5 font-12 color-9"> <?php echo date('Y年m月d日',$model->time_created); ?></div>
                        </h3>
                    </div>
                    <div>
                        <?php echo nl2br($model->content); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
