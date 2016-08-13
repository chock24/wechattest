<?php
/* @var $this TransmitController */

$this->breadcrumbs = array(
    'Transmit',
);
?>
<link href="<?php echo Yii::app()->baseUrl; ?>/weixin_css/marketing.css" rel="stylesheet" type="text/css" />
<div class="right content-main">
    <h2 class="content-main-title">转发有奖</h2>
    <div>
        <div class="tabhost">
            <div class="tabhost-title">
                <div class="clear"></div>
            </div>
            <div class="padding30 tabhost-center">
                <a href="<?php echo Yii::app()->createUrl('systems/transmit/create',array('status'=>1));?>" class="button button-green">+新建转发有奖</a>
                <div class="forward-prize-list">
                    <table class="margin-top-15 wechat-table">
                        <thead>
                            <tr>
                                <th>活动名称</th>
                                <th>时间</th>
                                <th>转发积分</th>
                                <th width="600">活动说明</th>
                                <th colspan='2'>详情</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php
                            $this->Widget('zii.widgets.CListView', array(
                                'dataProvider' => $transmit,
                                'itemView' => '_view',
                                'emptyText' => '您的公众号下面并没有用户分组数据，您可以从微信服务器下载',
                                'ajaxUpdate' => false,
                                'ajaxVar' => '',
                                'template' => '{items} {summary} {pager}',
                                'summaryText' => '转发信息数:<span>{count}</span>  总页数:<span>{pages}</span>',
                                'pager' => array(
                                    'class' => 'CLinkPager',
                                    'header' => '',
                                    'nextPageLabel' => '&gt;',
                                    'prevPageLabel' => '&lt;',
                                ),
                            ));
                            ?>


                        </tbody>
                    </table>
                   
                </div>

            </div>
        </div>
    </div>
</div>

