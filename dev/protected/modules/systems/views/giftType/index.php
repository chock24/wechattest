<?php
/* @var $this GiftTypeController */

$this->breadcrumbs = array(
    'Gift Type',
);
?>
<!--<h1><?php /* echo $this->id . '/' . $this->action->id; */ ?></h1>

<p>
        You may change the content of this page by modifying
        the file <tt><?php /* echo __FILE__; */ ?></tt>.
</p>-->

<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/weixin_css/marketing_tool.css" />

<div class="right content-main">
    <div class="margin-top-10 tabhost">
        <div class="tabhost-title">
            <ul>
                <li><a href="<?php echo Yii::app()->createUrl('systems/gift/index'); ?>">礼品商城</a></li>
                <li><a href="<?php echo Yii::app()->createUrl('systems/gift/create'); ?>">新增礼品</a></li>
                <li class="active"><a href="<?php echo Yii::app()->createUrl('systems/giftType/index'); ?>">礼品分类管理</a></li>
                <li><a href="<?php echo Yii::app()->createUrl('systems/giftExchange/index'); ?>">礼品兑换记录</a></li>
            </ul>
            <div class="clear"></div>
        </div>
        <div class="padding20 tabhost-center">
            <div class="classify-tit">
                <a href="<?php echo Yii::app()->createUrl('systems/giftType/create'); ?>" class="margin-top-5 margin-left-5 button button-white">新增分类</a>
            </div>
            <div class="classify-con">
                <div class="classify-con-nav">
                    <ul>
                        <?php foreach ($model as $m) { ?>
                            <li class="classify-con-nav-li">
                                <div class="margin-right-15 left"><?php echo $m->name; ?></div>
                                <div class="margin-left-20 right">
                                    <a title="修改" href="<?php echo Yii::app()->createUrl('systems/giftType/update', array('id' => $m->id)) ?>" class="margin-top-8"><i class="margin-top-5 margin-right-15 icon icon-text"></i></a>
                                    <a title="删除" href="<?php echo Yii::app()->createUrl('systems/giftType/delete', array('id' => $m->id)) ?>" class="margin-top-8 "><i class="margin-top-5 margin-right-15 icon icon-del"></i></a>
                                </div>
                                <div class="clear"></div>
                            </li>
                        <?php }; ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(function () {
        element_del($('.icon-del'), '你确定要删除吗？');//删除提示
    });
</script>