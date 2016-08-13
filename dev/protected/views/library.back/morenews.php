<hr />
<h4>多图文内容：</h4>

<div class="main-part left">
    <?php
    $this->widget('zii.widgets.CListView', array(
        'dataProvider' => $dataProvider,
        'itemView' => '//library/_morenews',
        'id' => 'ajaxListView',
        'template' => '{items} <div class="clear"></div> {pager}',
    ));
    ?>
</div>
