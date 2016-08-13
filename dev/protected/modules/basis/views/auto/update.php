<?php
/* @var $this AutoController */
/* @var $model Auto */

$this->breadcrumbs=array(
	'Autos'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Auto', 'url'=>array('index')),
	array('label'=>'Create Auto', 'url'=>array('create')),
	array('label'=>'View Auto', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Auto', 'url'=>array('admin')),
);
?>

<h1>Update Auto <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>