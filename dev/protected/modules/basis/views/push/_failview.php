<?php
$status = '';
if ($data->status == 0) {
    $status = '已经撤销';
} elseif ($data->status == 1) {
    $status = '审核中';
} elseif ($data->status == 2) {
    $status = '审核成功';
} elseif ($data->status == 3) {
    $status = '审核失败';
} elseif ($data->status == 4) {
    $status = '发送成功';
} elseif ($data->status == 5) {
    $status = '发送失败';
}
?>
<?php if ($data->type == '5') { ?>

    <?php if ($data->multi == '1') { ?>

        <div class="group-sending-list">
            <?php foreach (@$data->sourceFileGroup->sourceDetail as $key => $value)://循环素材细节 ?>

                <?php if ($key == 0) {//如果是第一个单图文 ?>
                    <div class="left margin-right-15">
                        <?php echo CHtml::image(PublicStaticMethod::returnSourceFile($value->sourceFile->filename, $value->sourceFile->ext, 'image', 'medium')) ?>
                    </div>
                <?php } ?>
            <?php endforeach; //结束素材细节循环 ?>
            <div class="group-sending-list-info">
                <?php foreach (@$data->sourceFileGroup->sourceDetail as $key => $value)://循环素材细节 ?>
                    <?php if ($key == 0)://如果是第一个单图文 ?>
                        <p><a href="<?php echo Yii::app()->createUrl('basis/push/view', array('id' => $data->id)); ?>">[图文信息<?php echo $key + 1 ?>]<?php echo @$data->sourceFileGroup->title ?></a></p>
                    <?php else://如果不是第一个单图文 ?>
                        <p><a href="<?php echo Yii::app()->createUrl('basis/push/view', array('id' => $data->id)); ?>">[图文信息<?php echo $key + 1 ?>]<?php echo $value->sourceFile->title ?></a></p>
                    <?php endif; ?>
                <?php endforeach; //结束素材细节循环 ?>
            </div>
            <div class="group-sending-list-choice">
                <span class="left color-9 group-sending-list-status"><?php echo $status;?></span>
                <em class="color-9 group-sending-list-time"><?php echo date('m', $data->time_created) . '月' . date('d', $data->time_created) . '日'; ?></em>
                <a href="<?php echo Yii::app()->createUrl('basis/push/view', array('id' => $data->id)); ?>" class="right">查看</a>
                <div class="clear"></div>
                <div class="margin-top-15 group-sending-list-audit-cause">
                    <!--<p class="color-9">
                        <b>原因：</b>
                        这里显示审核不通过的原因这里显示审核不通过的原因这里显示审核不通过的原因这里显示审核不通过的原因这里显示
                    </p>-->
                </div>
            </div>
        </div>
    <?php } else { ?>
        <div class="group-sending-list">
            <div class="left margin-right-15">
                <img src="<?php echo PublicStaticMethod::returnFile('sourcefile', $data->sourceFile->filename, $data->sourceFile->ext, 'image', 'medium'); ?>" />
            </div>
            <div class="group-sending-list-info">
                <p><a href="<?php echo Yii::app()->createUrl('basis/push/view', array('id' => $data->id)); ?>">[图文信息]<?php echo $data->sourceFile->title; ?></a></p>
                <p class="color-9"><?php echo $data->sourceFile->description; ?></p>
            </div>
            <div class="group-sending-list-choice">
                <span class="left color-9 group-sending-list-status"><?php echo $status;?></span>
                <em class="color-9 group-sending-list-time"><?php echo date('m', $data->time_created) . '月' . date('d', $data->time_created) . '日'; ?></em>
                <a href="<?php echo Yii::app()->createUrl('basis/push/view', array('id' => $data->id)); ?>" class="right">查看</a>
                <div class="clear"></div>
                <div class="margin-top-15 group-sending-list-audit-cause">
                    <!--<p class="color-9">
                        <b>原因：</b>
                        这里显示审核不通过的原因这里显示审核不通过的原因这里显示审核不通过的原因这里显示审核不通过的原因这里显示
                    </p>-->
                </div>
            </div>
        </div> 
        <?php
    }
} else {
    ?>


    <div class="group-sending-list">
        <div class="left margin-right-15">
    <!--            <img src="http://wechat.oppein.cn/upload/sourcefile/image/medium/20150129102741142874.jpg" />-->
        </div>
        <div class="group-sending-list-info">
            <p><a href="<?php echo Yii::app()->createUrl('basis/push/view', array('id' => $data->id)); ?>">[信息类型]文本信息</a></p>
            <p class="color-9">
                <?php echo PublicStaticMethod::replaceQqFace($data->content); ?></p>
        </div>
        <div class="right group-sending-list-choice">
            <span class="left color-9 group-sending-list-status"><?php echo $status;?></span>
            <em class="color-9 group-sending-list-time"><?php echo date('m', $data->time_created) . '月' . date('d', $data->time_created) . '日'; ?></em>
            <a href="<?php echo Yii::app()->createUrl('basis/push/view', array('id' => $data->id)); ?>" class="right">查看</a>
            <div class="clear"></div>
        </div>
    </div>
    <?php
}?>