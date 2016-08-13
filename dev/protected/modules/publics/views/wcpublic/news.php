<link href="<?php echo Yii::app()->baseUrl; ?>/weixin_css/index.css" rel="stylesheet" type="text/css" />

<div class="right content-main">
    <h2 class="content-main-title">公众号常见问题</h2>
    <div>
        <div class="tabhost">
            <div class="tabhost-title">
                <div class="clear"></div>
            </div>
            <div class="tabhost-center">
                <div class="padding30 index-affiche">
                    <div class="index-affiche-title">
                        公众号常见问题列表
                        <a href="<?php echo Yii::app()->createUrl('publics/wcpublic/createnews');?>" class="right margin-top-5 margin-right-15 button button-white">+增加</a>
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
    </div>

</div>
<script type="text/javascript">
    $(function(){
        element_del($('.del'),'你确定要删除吗？');
    })
</script>