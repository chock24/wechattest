<?php
/* @var $this TransmitTypeController */
/* @var $model TransmitType */

$this->breadcrumbs = array(
    'Transmit Types' => array('index'),
    'Manage',
);

$this->menu = array(
    array('label' => 'List TransmitType', 'url' => array('index')),
    array('label' => 'Create TransmitType', 'url' => array('create')),
);
?>
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/weixin_css/marketing_tool.css" />

<div class="right content-main">
    <div class="margin-top-10 tabhost">
        <div class="tabhost-title">
            <ul>
                <li><a href="<?php echo Yii::app()->createUrl('systems/transmit/index'); ?>">文章列表</a></li>
                <li><a href="<?php echo Yii::app()->createUrl('systems/transmit/create'); ?>">新建文章</a></li>
                <li class="active"><a href="<?php echo Yii::app()->createUrl('systems/transmitType/admin'); ?>">文章分类管理</a></li>
                <li><a href="<?php echo Yii::app()->createUrl('systems/transmitUser/index'); ?>">转发记录</a></li>
            </ul>
            <div class="clear"></div>
        </div>
        <div class="padding20 tabhost-center">

            <div class="classify">
                <div class="classify-tit">
                    <a href="<?php echo Yii::app()->createUrl('systems/transmitType/create'); ?>" class="margin-top-5 margin-left-5 button button-white">新增分类</a>
                </div>



                <div class="classify-con">

                    <div class="classify-con-nav">
                        <ul>
                            <?php foreach ($model as $m) { ?>

                                <?php
                                //echo 'id'.$m->id.' &nbsp; ';
                                if ($m->parent_id == 0) {
                                    ?>
                                    <li class="classify-con-nav-li"><?php
                                        echo '<div class="margin-right-15 left">' . $m->name . '</div> ';
                                        echo '<div class="margin-left-20 right">';
                                        echo '<a class="margin-top-8" href =' . Yii::app()->createUrl('systems/transmitType/update', array('id' => $m->id)) . ' title="修改"><i class="margin-top-5 margin-right-15 icon icon-text"></i></a>';
                                        echo '<a class="margin-top-8 " href =' . Yii::app()->createUrl('systems/transmitType/delete', array('id' => $m->id)) . ' title="删除"><i class="margin-top-5 margin-right-15 icon icon-del"></i></a>';
                                        echo '<a class="button button-white" href =' . Yii::app()->createUrl('systems/transmitType/create', array('parent_id' => $m->id)) . '>增加子项</a>';
                                        echo '</div>';
                                        ?>
                                        <div class="clear"></div>
                                        <ul>
                                            <?php foreach ($m->childrens as $c) { ?>
                                                <li>
                                                    <span class="margin-right-15 left"><?php echo @$c->name; ?></span>
                                                    <a href="<?php echo Yii::app()->createUrl('systems/transmitType/update', array('id' => $c->id)); ?>"><i class="margin-top-5 margin-right-5 icon icon-text"></i></a>
                                                    <a href="<?php echo Yii::app()->createUrl('systems/transmitType/delete', array('id' => $c->id)); ?>"><i class="margin-top-5 icon icon-del"></i></a>
                                                </li>    
                                            <?php } ?>
                                        </ul>
                                    </li>
                                <?php } ?>

                            <?php } ?>
                        </ul>

                    </div>

                </div>

            </div>
        </div>
    </div>
</div>
<script>
    $(function () {
        element_del($('.icon-del'), '你确定要删除分类吗？')
    });
</script>