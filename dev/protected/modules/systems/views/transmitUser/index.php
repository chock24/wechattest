<?php
/* @var $this GiftController */

$this->breadcrumbs = array(
    'Gift',
);
?>
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/weixin_css/marketing_tool.css" />
<?php
$form = $this->beginWidget('CActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
        ));
?>
<div class="right content-main">
    <div class="margin-top-10 tabhost">
        <div class="tabhost-title">
            <ul>
                <li><a href="<?php echo Yii::app()->createUrl('systems/transmit/index'); ?>">文章列表</a></li>
                <li><a href="<?php echo Yii::app()->createUrl('systems/transmit/create'); ?>">新建文章</a></li>
                <li><a href="<?php echo Yii::app()->createUrl('systems/transmitType/admin'); ?>">文章分类管理</a></li>
                <li class="active"><a href="<?php echo Yii::app()->createUrl('systems/transmitUser/index'); ?>">转发记录</a></li>
            </ul>
            <div class="clear"></div>
        </div>
  
        <div class="padding10 tabhost-center">

            <table class="margin-top-10 wechat-table">

                <?php
                $this->widget('zii.widgets.CListView', array(
                    'dataProvider' => $dataProvider,
                    'itemView' => '_view',
                    'emptyText' => '您的公众号下面并没有消息数据',
                    'ajaxUpdate' => false,
                    'ajaxVar' => '',
                    'template' => '{items}',
                    'summaryText' => '消息数:<span>{count}</span>  总页数:<span>{pages}</span>',
                    'pager' => array(
                        'class' => 'CLinkPager',
                        'header' => '',
                        'maxButtonCount' => 5,
                        'nextPageLabel' => '&gt;',
                        'prevPageLabel' => '&lt;',
                    ),
                ));
                ?>

            </table>

            <?php
            $this->widget('zii.widgets.CListView', array(
                'dataProvider' => $dataProvider,
                'itemView' => '_view',
                'emptyText' => '您的公众号下面并没有消息数据',
                'ajaxUpdate' => false,
                'ajaxVar' => '',
                'template' => '{summary} {pager}',
                'summaryText' => '消息数:<span>{count}</span>  总页数:<span>{pages}</span>',
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
<?php $this->endWidget(); ?>
<script type="text/javascript">
    $(function () {
        $('.wechat-table').find('input,select').change(function () {
            if ($(this).attr('data-id') != 'data-checkbox') {
                var url = "<?php echo Yii::app()->createUrl('systems/gift/ajaxupdate'); ?>";
                var id = $(this).parent().parent().find('td').eq(1).html();//需替换为动态获取
                var value = $(this).val();
                var data_name = $(this).attr('data-id');
                $.post(url, {id: "" + id + "", value: "" + value + "", data_name: "" + data_name + ""},
                function (data) {

                    $('body').append('<div class="flash-success">保存成功能</div>');
                    setTimeout(function () {
                        $('.flash-success').fadeOut();
                        setTimeout(function () {
                            $('.flash-success').detach();
                        }, "1000");
                    }, "1000");
                });
            }
        });
        element_del($('.wechat-table .icon-del'), '你确定要删除吗？');//删除提示
    });
</script>