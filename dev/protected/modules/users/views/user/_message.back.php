<?php
/* @var $this MessageController */
/* @var $data Message */
?>
<?php if ($data->receive == 1): ?>
    <div class="view receive">
        <div class="left message-headimage">
            <?php echo CHtml::image(substr($user->headimgurl, 0, -1) . "64"); ?>
        </div>
        <div class="left message-detail">
            <b class="left message-name">
                <?php echo CHtml::encode($user->nickname); ?>
                <?php echo $user->remark ? CHtml::encode('(' . $user->remark . ')') : ''; ?>
            </b>
            <div class="left time">
                <?php echo Yii::app()->format->formatDateTime($data->createtime); ?>
            </div>
            <div class="right message-remark">
                <span class="message-remark-value" data-id="<?php echo CHtml::encode($data->id); ?>">
                    <?php echo $data->remark ? CHtml::encode('[' . $data->remark . ']') : ''; ?>
                </span>
                <?php echo CHtml::link('备注', array('/users/message/remark', 'id' => $data->id), array('class' => 'message-remark-item', 'data-id' => $data->id)); ?>
            </div>
            <div class="right message-star">
                <?php echo $data->star ? CHtml::link(CHtml::image(Yii::app()->baseUrl . "/images/star.png", "星标消息"), Yii::app()->createUrl("/users/message/star", array("id" => $data->id, "accept" => 0)), array("class" => "message-star-item")) : CHtml::link(CHtml::image(Yii::app()->baseUrl . "/images/nostar.png", "非星标消息"), Yii::app()->createUrl("/users/message/star", array("id" => $data->id, "accept" => 1)), array("class" => "message-star-item")); ?>
            </div>
            <div class="clear"></div>
            <div class="left message-content">
                <?php if ($data->type == 1)://文字信息 ?>
                    <?php echo PublicStaticMethod::replaceQqFace($data->content); ?>
                <?php elseif ($data->type == 2)://图片信息 ?>                
                    <?php echo CHtml::image($data->picurl); ?>
                <?php elseif ($data->type == 3)://语音信息 ?>

                <?php elseif ($data->type == 4)://视频信息 ?>

                <?php elseif ($data->type == 5)://图文信息 ?>

                <?php elseif ($data->type == 6)://位置信息 ?>

                <?php elseif ($data->type == 7)://链接信息 ?>
                    <?php echo CHtml::link($data->title, $data->url, array('target' => '_blank')); ?>
                    <br />
                    <?php echo CHtml::encode($data->description) ?>
                <?php elseif ($data->type == 8)://事件信息 ?>
                    <?php if ($data->menutype == 1): ?>
                        菜单点击事件：<?php echo @CHtml::encode($data->menu->title); ?>
                    <?php elseif ($data->menutype == 2): ?>
                        菜单跳转事件：
                        <?php
                        echo CHtml::link('跳转地址', $data->content, array('target' => '_blank'));
                        ?>
                    <?php endif; ?>
                <?php elseif ($data->type == 9)://音乐信息 ?>

                <?php endif; ?>

            </div>
            <div class="clear"></div>
        </div>
        <div class="clear"></div>
    </div>
<?php else: ?>
    <div class="view send">
        <div class="left message-headimage">

        </div>
        <div class="left message-detail">
            <div class="left time">
                <?php echo Yii::app()->format->formatDateTime($data->createtime); ?>
                <?php echo $data->auto == 1 ? '自动回复：' : '回复：'; ?>
            </div>
            <div class="clear"></div>
            <div class="left message-content">
                <?php if ($data->type == 1)://文字信息 ?>
                    <?php echo PublicStaticMethod::replaceQqFace($data->content); ?>
                <?php elseif ($data->type == 2)://图片信息 ?>                
                    <?php echo CHtml::image($data->picurl); ?>
                <?php elseif ($data->type == 3)://语音信息 ?>

                <?php elseif ($data->type == 4)://视频信息 ?>

                <?php elseif ($data->type == 5)://图文信息 ?>
                    <?php if ($data->multi == 1): ?>
                        <?php
                        echo CHtml::link(
                                '[多图文链接]', array('/basis/sourcefile/moremsg', 'id' => $data->source_file_id), array('target' => '_blank')
                        );
                        ?>
                    <?php else: ?>
                        <?php
                        echo CHtml::link(
                                '[单图文链接]', array('/basis/sourcefile/updatemsg', 'id' => $data->source_file_id), array('target' => '_blank')
                        );
                        ?>
                    <?php endif; ?>
                <?php elseif ($data->type == 6)://位置信息 ?>

                <?php elseif ($data->type == 7)://链接信息 ?>

                <?php elseif ($data->type == 8)://事件信息 ?>

                <?php elseif ($data->type == 9)://音乐信息 ?>

                <?php endif; ?>
            </div>
            <div class="clear"></div>
        </div>
        <div class="clear"></div>
    </div>
<?php endif; ?>
