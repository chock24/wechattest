<div class="background-white content">
    <div class="padding30">
        <h2 class="content-main-title">创建公众号</h2>
        <div>
            <div class="tabhost">
                <div class="tabhost-title">
                    <ul>
                        <li>
                            <?php echo CHtml::link('公众号列表', array('index')); ?>
                        </li>
                        <li class="active">
                            <?php echo CHtml::link('创建公众号', array('create')); ?>
                        </li>
                    </ul>
                    <div class="clear"></div>
                </div>
                <div class="tabhost-center">
                    <?php $this->renderPartial('_form', array('model' => $model, 'kefulist' => $kefulist)); ?>
                </div>
            </div>
        </div>
    </div>

</div>