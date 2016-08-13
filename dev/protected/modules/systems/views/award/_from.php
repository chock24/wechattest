<?php
$form = $this->beginWidget('CActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
        ));
?>
<div class="right content-main">
    <div class="margin-top-10 tabhost">
        <div class="tabhost-title">
            <ul>
                <li><a href="<?php echo Yii::app()->createUrl('systems/poster/index'); ?>">中奖名单</a></li>
                <li class="active"><a href="<?php echo Yii::app()->createUrl('systems/poster/create'); ?>">新增中奖</a></li>
            </ul>
            <div class="clear"></div>
        </div>
        <div class="padding10 tabhost-center">
            <!-- 新增中奖 -->
            <div class="padding10 tabhost-title">
                <div class="margin-top-5 left font-14"><?php echo $tramsmit_model->title; ?></div>
                <div class="right wechat-fodder-seek">
                    <form method="get" action="javascript:;" id="yw0">
                        <?php echo $form->textField($user, 'nickname', array('size' => 20, 'placeholder' => '请输入微信昵称', 'value' => @$_GET['User']['nickname'] ? @$_GET['User']['nickname'] : '', 'class' => 'left wechat-seek-input')); ?>
                        <?php
                        echo CHtml::submitButton('', array('class' => 'left wechat-seek-button'));
                        // echo Yii::app()->request->getParam('title');
                        ?>
                    </form>
                </div>
                <div class="clear"></div>
            </div>
            <table class="margin-top-10 wechat-table">
                <thead>
                    <tr>
                        <th><input type="checkbox" data-id="data-checkbox" value="checkbox"></th>
                        <th>ID</th>
                        <th>头像</th>
                        <th>昵称</th>
                        <th>分组</th>
                        <th>手机号</th>
                        <th width="80">添加</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="odd">
                        <td width="30">
                            <input type="checkbox" value="">
                        </td>
                        <td></td>
                        <td></td>
                        <td><?php echo CHtml::encode($user->nickname); ?></td>
                        <td></td>
                        <td></td>
                        <td><a href="javascript:;" class="button web-menu-btn width-auto" onclick="js:return popup($(this), '添加分組', 590, 475);">确定</a></td>
                </tbody>
            </table>

        </div>
    </div>
</div>
<?php $this->endWidget(); ?>