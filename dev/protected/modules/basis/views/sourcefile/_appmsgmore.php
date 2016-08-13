<?php
/* @var $this SourcefileController */
/* @var $data SourceFile */
?>

<div class="block_file img_txt_file">

    <?php
    if ($data->sourceDetail) {
        foreach ($data->sourceDetail as $key => $s) {
            if (!$key) {
                ?>
                <div class="img_txt_file_ct">
                    <div class="img_txt_date">
                        <em><?php echo date('Y-m-d', $data->time_created); ?></em>
                    </div>
                    <div class="voice_info video_info img_txt_info">
                        <a href="javascript:;" onclick="javascript:;">
                            <?php if (!empty($s->sourcefile->filename)) { ?>
                                <?php echo CHtml::image(PublicStaticMethod::returnSourceFile($s->sourcefile->filename, $s->sourcefile->ext, 'image', 'medium')) ?>
                            <?php } else { ?>
                                <img src="">
                            <?php } ?>
                            <div class="img_txt_float" title="<?php echo $data->title; ?>">
                                <?php echo CHTML::link($data->title, Yii::app()->createUrl('/site/' . $s->sourcefile->id), array('target' => '_blank')); ?>
                            </div>
                        </a>
                    </div>
                </div>
            <?php } else { ?>
                <div class="img_txt_item">

                    <img class="img_txt_thumb" alt="" src="<?php echo PublicStaticMethod::returnSourceFile($s->sourcefile->filename, $s->sourcefile->ext, 'image', 'icon'); ?>">
                        
                    <h4 class="img_txt_tit">
                        <?php echo CHTML::link(@$s->sourceFile->title, Yii::app()->createUrl('/site/' . $s->sourcefile->id), array('target' => '_blank')); ?>
                    </h4>
                </div>
                <?php
            }
        }
    }
    ?>
    <div class="function img_txt_ft">
        <ul class="img_text_ft">
            <li><a href="<?php echo Yii::app()->createUrl('/basis/sourcefilegather/group', array('id' => $data->id, 'gather_id' => $data->gather_id, 'type' => '5', 'multi' => '1')); ?>" class="gatherall" title="移动分组"><i class="fu_icon move"></i></a></li>
            <li><a href="<?php echo Yii::app()->createUrl('/basis/sourcefile/moremsg', array('id' => $data->id)); ?>" target="_blank" title="编辑"><i class="fu_icon modify"></i></a></li>
            <li><a url="<?php echo Yii::app()->createURL('/basis/sourcefile/delete', array('id' => $data->id, 'type' => 'sourcefilegroup')) ?>" onclick="return ConfirmDel()"; class="deletemsgmore" title="删除"><i class="fu_icon del"></i></a></li>
        </ul>
    </div>
</div>

<script language="javascript" type="text/javascript">
    //删除 
    function ConfirmDel() {
        if (confirm("确定要删除吗？")) {
            //删除 多图文 文件
            $('.deletemsgmore').live('click', function () {
                var operationUrl = $(this).attr('url');
                $.post(operationUrl, '', function (s) {
                    window.location.reload();
                    return true;
                });
                return false;
            });
            //删除分类 名
            $('.deletegather').live('click', function () {
                var operationUrl = $(this).attr('url');
                $.post(operationUrl, '', function (s) {
                    window.location.reload();
                    return true;
                });
                return false;
            });
        } else {
            return false;
        }
    }
    function dilagclose() {
        $('#mydialog').dialog('close');
    }
</script>