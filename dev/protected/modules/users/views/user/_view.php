<?php
/* @var $this UserController */
/* @var $data User */
?>

<div class="view">

    <b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
    <?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id' => $data->id)); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('admin_id')); ?>:</b>
    <?php echo CHtml::encode($data->admin_id); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('source')); ?>:</b>
    <?php echo CHtml::encode($data->source); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('openid')); ?>:</b>
    <?php echo CHtml::encode($data->openid); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('nickname')); ?>:</b>
    <?php echo CHtml::encode($data->nickname); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('star')); ?>:</b>
    <?php echo CHtml::encode($data->star); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('group_id')); ?>:</b>
    <?php echo CHtml::encode($data->group_id); ?>
    <br />

    <?php /*
      <b><?php echo CHtml::encode($data->getAttributeLabel('remark')); ?>:</b>
      <?php echo CHtml::encode($data->remark); ?>
      <br />

      <b><?php echo CHtml::encode($data->getAttributeLabel('subscribe')); ?>:</b>
      <?php echo CHtml::encode($data->subscribe); ?>
      <br />

      <b><?php echo CHtml::encode($data->getAttributeLabel('headimgurl')); ?>:</b>
      <?php echo CHtml::encode($data->headimgurl); ?>
      <br />

      <b><?php echo CHtml::encode($data->getAttributeLabel('mobile')); ?>:</b>
      <?php echo CHtml::encode($data->mobile); ?>
      <br />

      <b><?php echo CHtml::encode($data->getAttributeLabel('sex')); ?>:</b>
      <?php echo CHtml::encode($data->sex); ?>
      <br />

      <b><?php echo CHtml::encode($data->getAttributeLabel('age')); ?>:</b>
      <?php echo CHtml::encode($data->age); ?>
      <br />

      <b><?php echo CHtml::encode($data->getAttributeLabel('language')); ?>:</b>
      <?php echo CHtml::encode($data->language); ?>
      <br />

      <b><?php echo CHtml::encode($data->getAttributeLabel('country')); ?>:</b>
      <?php echo CHtml::encode($data->country); ?>
      <br />

      <b><?php echo CHtml::encode($data->getAttributeLabel('province')); ?>:</b>
      <?php echo CHtml::encode($data->province); ?>
      <br />

      <b><?php echo CHtml::encode($data->getAttributeLabel('city')); ?>:</b>
      <?php echo CHtml::encode($data->city); ?>
      <br />

      <b><?php echo CHtml::encode($data->getAttributeLabel('district')); ?>:</b>
      <?php echo CHtml::encode($data->district); ?>
      <br />

      <b><?php echo CHtml::encode($data->getAttributeLabel('subscribe_time')); ?>:</b>
      <?php echo CHtml::encode($data->subscribe_time); ?>
      <br />

      <b><?php echo CHtml::encode($data->getAttributeLabel('unionid')); ?>:</b>
      <?php echo CHtml::encode($data->unionid); ?>
      <br />

      <b><?php echo CHtml::encode($data->getAttributeLabel('integral')); ?>:</b>
      <?php echo CHtml::encode($data->integral); ?>
      <br />

      <b><?php echo CHtml::encode($data->getAttributeLabel('status')); ?>:</b>
      <?php echo CHtml::encode($data->status); ?>
      <br />

      <b><?php echo CHtml::encode($data->getAttributeLabel('sort')); ?>:</b>
      <?php echo CHtml::encode($data->sort); ?>
      <br />

      <b><?php echo CHtml::encode($data->getAttributeLabel('isdelete')); ?>:</b>
      <?php echo CHtml::encode($data->isdelete); ?>
      <br />

      <b><?php echo CHtml::encode($data->getAttributeLabel('time_created')); ?>:</b>
      <?php echo CHtml::encode($data->time_created); ?>
      <br />

      <b><?php echo CHtml::encode($data->getAttributeLabel('time_updated')); ?>:</b>
      <?php echo CHtml::encode($data->time_updated); ?>
      <br />

     */ ?>

</div>