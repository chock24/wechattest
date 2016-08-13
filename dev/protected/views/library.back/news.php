<hr />
<h4>单图文内容：</h4>

<div class="main-part left">
    <?php
    $this->widget('zii.widgets.CListView', array(
        'dataProvider' => $dataProvider,
        'itemView' => '//library/_news',
        'id' => 'ajaxListView',
        'template' => '{items} <div class="clear"></div> {pager}',
    ));
    ?>
</div>
