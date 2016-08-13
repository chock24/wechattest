<div class="right content-main">
    <div class="margin-top-10 tabhost">
        <div class="tabhost-title">
            <ul>
                <li class="active" ><a href="<?php echo Yii::app()->createUrl('systems/poster/index'); ?>">海报列表</a></li>
                <li><a href="<?php echo Yii::app()->createUrl('systems/poster/create'); ?>">新增海报</a></li>
                <li><a href="<?php echo Yii::app()->createUrl('systems/PosterType/index'); ?>">所属栏目管理</a></li>
<!--                <li class="active"><a href="--><?php //echo Yii::app()->createUrl('systems/poster/index'); ?><!--">海报列表</a></li>-->
<!--                <li><a href="--><?php //echo Yii::app()->createUrl('systems/poster/create'); ?><!--">新增海报</a></li>-->
<!--                <li><a href="--><?php //echo Yii::app()->createUrl('systems/poster/create'); ?><!--">所属栏目管理</a></li>-->
            </ul>
            <div class="clear"></div>
        </div>
        <div class="padding10 tabhost-center">
            <table class="margin-top-10 wechat-table">
                <thead>
                <tr>
                    <th width="50"><input type="checkbox" data-id="data-checkbox" value="checkbox"></th>
                    <th width="50">ID</th>
                    <th>所属栏目</th>
                    <th>创建时间</th>
                    <th width="50"></th>
                </tr>
                </thead>
                <?php
                $this->widget('zii.widgets.CListView', array(
                    'dataProvider' => $dataProvider,
                    'itemView' => '_view',
                    'emptyText' => '您的公众号下面并没有消息数据',
                    'ajaxUpdate' => false,
                    'ajaxVar' => '',
                    'template' => '{items}',
                    'summaryText' => '消息数:<span>{count}</span>  总页数:<span>{pages}</span>',
                    'pager' => array(
                        'class' => 'CLinkPager',
                        'header' => '',
                        'maxButtonCount' => 5,
                        'nextPageLabel' => '&gt;',
                        'prevPageLabel' => '&lt;',
                    ),
                ));
                ?>

            </table>

            <?php
            $this->widget('zii.widgets.CListView', array(
                'dataProvider' => $dataProvider,
                'itemView' => '_view',
                'emptyText' => '您的公众号下面并没有消息数据',
                'ajaxUpdate' => false,
                'ajaxVar' => '',
                'template' => '{summary}',
                'summaryText' => '消息数:<span>{count}</span>  总页数:<span>{pages}</span>',
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
