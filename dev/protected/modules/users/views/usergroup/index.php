<link href="<?php echo Yii::app()->baseUrl; ?>/weixin_css/member_home.css" rel="stylesheet" type="text/css" />
<div class="right content-main">
    <h2 class="content-main-title">用户分组管理</h2>
    <div>
        <div class="tabhost">
            <div class="tabhost-title">
                <div class="clear"></div>
            </div>
            <div class="tabhost-center">
                <div class="padding30 tabhost-center">

                    <a href="<?php echo Yii::app()->createUrl('users/usergroup/create'); ?>" class="margin-bottom-20 button button-white" onclick="js:return  popup($(this), '新建用户分组', 380, 310);">新建分组</a>
                    <?php
                    $this->Widget('zii.widgets.CListView', array(
                        'dataProvider' => $dataProvider,
                        'itemView' => '_view',
                        'emptyText' => '您的公众号下面并没有用户分组数据，您可以从微信服务器下载',
                        'ajaxUpdate' => false,
                        'ajaxVar' => '',
                        'template' => '{items} {summary} {pager}',
                        'summaryText' => '公众号数:<span>{count}</span>  总页数:<span>{pages}</span>',
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
    </div>

</div>
<script type="text/javascript">
    $(function(){
        element_del($('.user-group-management .icon-del'), '你确定要删除吗？');//删除提示
    })
</script>