<?php
/* @var $this TransmitController */
/* @var $model Transmit */

$this->breadcrumbs = array(
    'Award' => array('index'),
    'Create',
);

$this->menu = array(
    array('label' => 'List Transmit', 'url' => array('index')),
    array('label' => 'Manage Transmit', 'url' => array('admin')),
);
?>

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
                <li class=""><a href="<?php echo Yii::app()->createUrl('systems/activitiy/index'); ?>">活动列表</a></li>
                <li><a href="<?php echo Yii::app()->createUrl('systems/activitiy/create'); ?>">新建活动</a></li>
                <li><a href="<?php echo Yii::app()->createUrl('systems/award/list'); ?>">中奖名单</a></li>
                <li><a href="<?php echo Yii::app()->createUrl('systems/transmitUser/index', array('type' => 1)); ?>">转发记录</a></li>
                <li class='active'><a href="">新增中奖</a></li>
            </ul>
            <div class="clear"></div>
        </div>
        <div class="padding10 tabhost-center">
            <!-- 新增中奖 -->
            <div class="padding10 tabhost-title">
                <div class="margin-top-5 left font-14"><?php echo $tramsmit->title; ?></div>
                <?php if (!empty($giftmodel)) { ?>
                    <div class="margin-top-5 right row add_article_list">
                        礼品：   <?php echo $form->dropDownList($model, 'gift_id', $giftmodel); ?>
                    </div>
                <?php } ?>
                <div class="right wechat-fodder-seek">
                    <form method="get" action="javascript:;" id="yw0">
                        <?php echo $form->textField($user, 'nickname', array('size' => 20, 'placeholder' => '请输入微信昵称', 'value' => @$_GET['User']['nickname'] ? @$_GET['User']['nickname'] : '', 'class' => 'left wechat-seek-input')); ?>
                        <?php echo $form->hiddenField($tramsmit, 'id', array('size' => 20, 'placeholder' => 'id', 'value' => $_GET['transmit_id'] ? $_GET['transmit_id'] : $_GET['Transmit']['id'], 'class' => 'left wechat-seek-input')); ?>
                        <?php
                        echo CHtml::submitButton('', array('class' => 'left wechat-seek-button'));
                        ?>
                    </form>
                </div>
                <div class="clear"></div>
            </div>
            <?php if (isset($_GET['User']['nickname'])) { ?>
                <table class="margin-top-10 wechat-table">
                    <?php
                    $this->widget('zii.widgets.CListView', array(
                        'dataProvider' => $dataProvider,
                        'itemView' => '_view',
                        'emptyText' => '您的公众号下面并没有消息数据',
                        'ajaxUpdate' => false,
                        'ajaxVar' => '',
                        'template' => '{items} {pager}',
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
                    'template' => '{summary}',
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

            <?php } ?>
        </div>
    </div>
</div>
<?php $this->endWidget(); ?>
<script>

    $('.wechat-table .web-menu-btn').click(function () {
        var gift_id = $('#Award_gift_id').val();
        var user_id = $(this).parents().find('td').eq(1).html();
        var transmit_id = $("#Transmit_id").val();
        var posturl = "<?php echo Yii::app()->createURL('systems/award/createaward'); ?>";
        $.post(posturl, {"gift_id": gift_id, "user_id": user_id, "transmit_id": transmit_id},
        function (data) {
            var $html = '<div class="padding20"><table class="margin-top-10 wechat-table"><thead><tr><th>ID</th><th>微信昵称</th><th>手机号码</th><th>奖品</th><th width="20"></th></tr></thead><tbody>';
            $.each(data, function (e, v) {
                $html += '<tr><td>' + v.id + '</td><td>' + v.nickname + '</td><td>' + v.mobile + '</td><td>' + v.gift_name + '</td><td><a class="winningDel" title="删除" href="javascript:;"><i class="icon icon-del"></i></a></td></tr>';
            });
            $html += '</tbody></table></div>';
            $('.popup-data').html($html);
            $('.winningDel').click(function () {
                if (window.confirm('你确定要删除吗？？')) {
                    var id = $(this).parents().parents().find('td').eq(0).html();
                    var durl = "<?php echo Yii::app()->createUrl('systems/award/delete'); ?>";
                    $.post(durl, {id: "" + id + ""},
                    function (data) {
                        $('body').append('<div class="flash-success">删除成功</div>');
                        document.location.reload();
                    });
                }
            });
        }, "json");

    });



</script>