<link href="<?php echo Yii::app()->baseUrl; ?>/weixin_css/reply.css" rel="stylesheet" type="text/css" />
<div class="right content-main">
    <h2 class="content-main-title">微信二维码</h2>
    <div>
        <div class="tabhost">
            <div class="tabhost-title">
                <div class="clear"></div>
            </div>
            <div class="margin-right-15 right wechat-seek">
                <form>
                    <input type="text" placeholder="分组信息" size="30" class="left wechat-seek-input">
                    <input type="submit" value="" class="left wechat-seek-button">
                </form>
            </div>
            <div class="tabhost-center">
                <div class="padding30 tabhost-center">
                    <a href="<?php echo Yii::app()->createUrl('basis/quickmark/create'); ?>" class="button button-white">创建二维码</a>
                    <a href="<?php echo Yii::app()->createUrl('basis/quickmark/updateuserqm'); ?>" class="button button-white" style="width: 130px">修改用户二维码分组</a>
                    <div class="clear"></div>
                    <div class="qr-code margin-top-15">
                        <?php
                        $this->widget('zii.widgets.CListView', array(
                            'dataProvider' => $dataProvider,
                            'itemView' => '_view',
                               'template' => '{items} <div class="clear"></div> {summary} {pager}',
                                'summaryText' => '单图文数:<span>{count}</span>  总页数:<span>{pages}</span>',
                        ));
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(function(){
        element_del($('.icon-del'), '你确定要删除二维码吗？');
    })
</script>