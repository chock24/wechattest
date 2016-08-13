<?php

$this->widget('zii.widgets.CListView', array(
    'dataProvider' => $dataProvider,
    'itemView' => '_moremsg',
    'id' => 'ajaxListView',
    'template' => '{items} <div class="clear"></div> {summary} {pager}',
));
?>