<?php
/* @var $this UserModuleController */

$this->breadcrumbs = array(
    'User Module',
);
?>
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/weixin_css/marketing_tool.css" />
<div class="right content-main">
    <div class="margin-top-10 tabhost">
        <div class="tabhost-title">
            <ul>
                <li class="active"><a href="<?php echo Yii::app()->createUrl('systems/userModule/index');?>">会员中心模块</a></li>
                <li><a href="<?php echo Yii::app()->createUrl('systems/userModule/create') ?>">新增会员</a></li>
            </ul>
            <div class="clear"></div>
        </div>
        <div class="padding20 tabhost-center">
            <div class="clear"></div>
            <div class="margin-top-10 app-sudoku-table">
                <table>
                  
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
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
       $(function () {
        $('.app-sudoku-table').find('input,select').change(function () {
            if ($(this).attr('data-id') != 'data-checkbox') {
                var url = "<?php echo Yii::app()->createUrl('systems/userModule/ajaxupdate'); ?>";
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
        element_del($('.app-sudoku-table .icon-del'), '你确定要删除吗？');//删除提示
        checkboxSelect($('.app-sudoku-table').find('th').find('input:checkbox'), $('.app-sudoku-table').find('td').find('input:checkbox'), $(''));//checkbook全选
    })
</script>