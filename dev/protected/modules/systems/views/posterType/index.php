<?php
/* @var $this PosterTypeController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Poster Types',
);

//$this->menu=array(
//	array('label'=>'Create PosterType', 'url'=>array('create')),
//	array('label'=>'Manage PosterType', 'url'=>array('admin')),
//);
?>

<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/weixin_css/marketing_tool.css" />

<div class="right content-main">
    <div class="margin-top-10 tabhost">
        <div class="tabhost-title">
            <ul>
                <li><a href="<?php echo Yii::app()->createUrl('systems/poster/index'); ?>">海报列表</a></li>
                <li><a href="<?php echo Yii::app()->createUrl('systems/poster/create'); ?>">新增海报</a></li>
                <li class="active"><a href="<?php echo Yii::app()->createUrl('systems/PosterType/index'); ?>">所属栏目管理</a></li>
            </ul>
            <div class="clear"></div>
        </div>
        <div class="padding20 tabhost-center">
            <div class="classify-tit">
                <a href="<?php echo Yii::app()->createUrl('systems/PosterType/create'); ?>" class="margin-top-5 margin-left-5 button button-white">新增栏目分类</a>
            </div>
            <div class="classify-con">
                <div class="classify-con-nav">
                    <ul>
                        <?php foreach ($dataProvider as $m) { ?>
                            <li class="classify-con-nav-li">
                                <div class="margin-right-15 left"><?php echo $m->col_name; ?></div>
                                <div class="margin-left-20 right">
                                    <a title="修改" href="<?php echo Yii::app()->createUrl('systems/PosterType/update', array('id' => $m->id)) ?>" class="margin-top-8"><i class="margin-top-5 margin-right-15 icon icon-text"></i></a>
                                    <a title="删除" href="<?php echo Yii::app()->createUrl('systems/PosterType/delete', array('id' => $m->id)) ?>" class="margin-top-8 "><i class="margin-top-5 margin-right-15 icon icon-del"></i></a>
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
