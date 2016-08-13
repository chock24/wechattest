<div class="background-white content">
    <div class="padding30">
        <h2 class="content-main-title">修改公众号信息 :<?php echo CHtml::encode($model->title); ?></h2>
        <div>
            <div class="tabhost">


                <div class="tabhost-title">
                    <ul>
                        <li>
                            <?php echo CHtml::link('公众号列表', array('index')); ?>
                        </li>
                        <li>
                            <?php echo CHtml::link('创建公众号', array('create')); ?>
                        </li>
                        <li class="active">
                            <?php echo CHtml::link('修改公众号信息', array('update', 'id' => $model->id)); ?>
                        </li>
                    </ul>
                    <div class="clear"></div>
                </div>
                
                <?php $this->renderPartial('_form', array('model' => $model, 'kefulist' => $kefulist)); ?>
            </div>
        </div>
    </div>
</div>