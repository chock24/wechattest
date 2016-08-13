<div class="background-white content">

    <div class="padding30">
        <h2 class="content-main-title">管理员列表</h2>
        <div>
            <div class="tabhost">
                <div class="tabhost-title">
                    <ul>
                        <li>
                            <?php echo CHtml::link('系统设置', array('/systems/system/index')); ?>
                        </li>
                        <li class="active">
                            <?php echo CHtml::link('管理员列表', array('/systems/admin/index')); ?>
                        </li>
                        <li>
                            <?php echo CHtml::link('创建管理员', array('/systems/admin/create')); ?>
                        </li>
                        <li>
                            <?php echo CHtml::link('登录日志', array('/systems/system/logaccess')); ?>
                        </li>
                        <li>
                            <?php echo CHtml::link('错误日志', array('/systems/system/logerror')); ?>
                        </li>
                    </ul>
                    <div class="clear"></div>
                </div>

                <div class="tabhost-center">

                    <div class="search-form">
                        <?php
                        $this->renderPartial('_search', array(
                            'model' => $model,
                        ));
                        ?>
                    </div><!-- search-form -->

                    <?php
                    $this->widget('zii.widgets.grid.CGridView', array(
                        'id' => 'admin-grid',
                        'dataProvider' => $model->search(),
                        'itemsCssClass' => 'margin-top-15 wechat-table',
                        'template' => '{items} {summary} {pager}',
                        'summaryText' => '公众号数:<span>{count}</span>  总页数:<span>{pages}</span>',
                        'columns' => array(
                            array(
                                'class' => 'CCheckBoxColumn',
                                'selectableRows' => 2,
                                'value' => '$data->id',
                            ),
                            'username',
                            'name',
                            'company',
                            'province',
                            'city',
                            'district',
                            'group_id',
                            array(
                                'name' => 'role_id',
                                'value' => 'Yii::app()->params->ADMINROLE[$data->role_id]',
                            ),
                            array(
                                'class' => 'CButtonColumn',
                            ),
                        ),
                        'pager' => array(
                            'class' => 'CLinkPager',
                            'header' => '',
                            'maxButtonCount' => 5,
                            'nextPageLabel' => '&gt;',
                            'prevPageLabel' => '&lt;',
                        ),
                    ));
                    ?>
                    <!--<table class="margin-top-15 wechat-table">
                        <thead>
                            <tr>
                                <th><input type="checkbox" name=""></th>
                                <th>用户名</th>
                                <th>管理员名称</th>
                                <th>公司名称</th>
                                <th>省</th>
                                <th>市</th>
                                <th>区</th>
                                <th>分组</th>
                                <th width="65"></th>
                            </tr>
                        </thead>
                        <tbody>
                    <?php
                    $this->widget('zii.widgets.CListView', array(
                        'dataProvider' => $model->search(),
                        'itemView' => '_view',
                        'emptyText' => '<tr><td colspan="10">没有管理员数据,您可以创建管理员以便管理</td></tr>',
                        'ajaxUpdate' => false,
                        'ajaxVar' => '',
                        'template' => '{items} <tfoot> <tr><td colspan="20">{summary}</td></tr> <tr><td colspan="20">{pager}</td></tr> </tfoot>',
                        'summaryText' => '公众号数:<span>{count}</span>  总页数:<span>{pages}</span>',
                        'pager' => array(
                            'class' => 'CLinkPager',
                            'header' => '',
                            'maxButtonCount' => 5,
                            'nextPageLabel' => '&gt;',
                            'prevPageLabel' => '&lt;',
                        ),
                    ));
                    ?>
                        </tbody>
                    </table>-->
                </div>
            </div>
        </div>
    </div>

</div>