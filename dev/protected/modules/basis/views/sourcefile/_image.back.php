<?php
/* @var $this SourcefileController */
/* @var $data SourceFile */
?>
<div class="block_file img_file">
    <div class="block_file_ct img_file_ct">
        <div class="img_info select-item">
            <?php echo CHtml::image(PublicStaticMethod::returnSourceFile($data->filename,$data->ext,'image', 'thumb'),$data->title,array('title'=>$data->title)); ?>
        </div>
        <h4 class="langue_title"></h4>
        <div class="img_size">
            <label>
                <input type="checkbox" name="id[]" value="<?php echo CHtml::encode($data->id);?>" />
                <span class="lbl_content"><?php echo CHtml::encode($data->title); ?></span>
            </label>
        </div>
    </div>
    <div class="function img_ft">
        <ul>
            <li>
                <?php echo CHtml::link('<i class="fu_icon modify"></i>',array('update','id'=>$data->id,'type'=>2),array('class'=>'update-item','title'=>'编辑')); ?>
            </li>
            <li>
                <?php echo CHtml::link('<i class="fu_icon move"></i>',array('/basis/sourcefilegather/group','id'=>$data->id,'gather_id'=>$data->gather_id,'type'=>2),array('class'=>'gather-item','title'=>'移动分组')); ?>
            </li>
            <li>
                <?php echo CHtml::link('<i class="fu_icon del"></i>',array('delete','id'=>$data->id,'type'=>2),array('title'=>'删除', 'class'=>'delete-item')); ?>
            </li>
        </ul>
    </div>
</div>
 