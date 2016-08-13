<?php
/* @var $this UsergroupController */
/* @var $model UserGroup */

$this->breadcrumbs = array(
    '管理' => array('/users'),
    '用户分组管理' => array('admin'),
    '查看用户分组',
);
?>

<h1>查看用户分组 #<?php echo $model->id; ?></h1>

<?php
$this->widget('zii.widgets.CDetailView', array(
    'data' => $model,
    'attributes' => array(
        'id',
        'name',
        'count',
        'time_created:datetime',
    ),
));
?>
