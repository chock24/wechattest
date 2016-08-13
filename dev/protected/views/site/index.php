<?php
/* @var $this SiteController */

$this->pageTitle = Yii::app()->name;
?>

<link href="<?php echo Yii::app()->baseUrl; ?>/weixin_css/index.css" rel="stylesheet" type="text/css" />

<!--
<h1>欢迎来到<?php /* echo CHtml::encode(Yii::app()->name); */ ?></h1>
<h2>今日新增关注用户:<?php /* echo CHtml::link($userTodayCount,array('/users/user/admin')); */ ?></h2>
<h2>总关注用户:<?php /* echo CHtml::link($userCount,array('/users/user/admin')); */ ?></h2>
<h2>取消关注用户:<?php /* echo CHtml::link($userCancelCount,array('/users/user/admin')); */ ?></h2>-->

<div class="right content-main">
    <div class="padding30">
        <div class="padding10 index-show-notice">
            <ul>
                <li>
                    <a href="<?php echo Yii::app()->createUrl('users/user/admin'); ?>">
                        <h5><?php echo CHtml::encode($userTodayCount); ?></h5>
                        <h6>今日新增关注用户</h6>
                    </a>
                </li>
                <li>
                    <a href="<?php echo Yii::app()->createUrl('users/user/admin'); ?>">
                        <h5><?php echo CHtml::encode($userCount); ?></h5>
                        <h6>总关注用户</h6>
                    </a>
                </li>
                <li>
                    <a href="<?php echo Yii::app()->createUrl('users/user/admin'); ?>">
                        <h5><?php echo CHtml::encode($userCancelCount); ?></h5>
                        <h6>取消关注用户</h6>
                    </a>
                </li>
                <li>
                    <a href="<?php echo Yii::app()->createUrl('/users/message/index'); ?>">
                        <h5><?php echo CHtml::encode($messageUnreadCount); ?></h5>
                        <h6>未读消息</h6>
                    </a>
                </li>
                <li>
                    <a href="javascript:;">
                        <h5 class="color-9">暂无</h5>
                        <h6>附加信息</h6>
                    </a>
                </li>
                <li class="border-none">
                    <a href="javascript:;">
                        <h5 class="color-9">暂无</h5>
                        <h6>附加信息</h6>
                    </a>
                </li>
            </ul>
        </div>

        <div class="margin-top-15 index-affiche">
            <div class="index-affiche-title">
                <h3>系统公告  <a href="<?php echo Yii::app()->createUrl('site/createnews'); ?>" class="margin-top-5 right margin-right-15 button button-white">+增加</a></h3>
            </div>

            <?php
            $this->widget('zii.widgets.CListView', array(
                'id' => 'news-listview',
                'ajaxUpdate' => false,
                'dataProvider' => $dataProvider,
                'itemsCssClass' => 'index-affiche-content',
                'template' => '{items} {summary} {pager}',
                'summaryText' => '消息数:<span>{count}</span>  总页数:<span>{pages}</span>',
                'itemView' => '_news', // refers to the partial view named '_post'
                'pager' => array(
                    'class' => 'CLinkPager',
                    'header' => '',
                    'maxButtonCount' => 5,
                    'nextPageLabel' => '&gt;',
                    'prevPageLabel' => '&lt;',
                ),
            ));
            ?>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(function () {
        element_del($('.del'), '你确定要删除吗？');
    })
</script>