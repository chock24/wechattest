<?php
/* @var $this SourcefileController */
/* @var $data SourceFile */
?>


<?php $type= Yii::app()->request->getParam('type');
?>

<div class="block_file img_txt_file">
    <div class="block_file_ct img_txt_file_ct">
        <h4 class="title img_txt_tit">     
            <?php echo CHTML::link($data->title,Yii::app()->createUrl('/site/'.$data->id), array('target' => '_blank'));?>
        </h4>
        <div class="img_txt_date">
            <em><?php echo CHtml::encode(date('Y-m-d',$data->time_created)); ?></em>
        </div>
        <div class="img_txt_info">
            <a href="<?php echo Yii::app()->createUrl('site/view',array('id'=>$data->id));?>" target="_blank" onclick="javascript:;">
                <?php echo CHtml::image(PublicStaticMethod::returnSourceFile($data->filename, $data->ext, 'image', 'medium')) ?>
            </a>
        </div>
        <p class="img_text_desc"><?php echo CHtml::encode($data->description); ?></p>
    </div>
    <div class="function img_txt_ft">
        <ul>
            <li><a href="<?php echo Yii::app()->createUrl('/basis/sourcefilegather/group',array('id'=>$data->id,'gather_id'=>$data->gather_id,'type'=>'5','multi'=>'0'));?>" class="gatherall" title="移动分组"><i class="fu_icon move"></i></a></li>
            <li><a href="<?php echo Yii::app()->createURL('/basis/sourcefile/updatemsg',array('id'=>$data->id,'type'=>'5'))?>" target="_blank" class="update-item" title="编辑"><i class="fu_icon modify"></i></a></li>
            <li><a onclick="return ConfirmDel()"; url="<?php echo Yii::app()->createURL('/basis/sourcefile/delete',array('id'=>$data->id,'type'=>'5','gatherid'=>$data->gather_id))?>" title="删除" class="deletemsg"><i class="fu_icon del"></i></a></li>
        </ul>
    </div>
</div>

 <script language="javascript" type="text/javascript">
   //删除 
       function ConfirmDel() {
		if (confirm("确定要删除吗？")){
			//删除 视频文件
			 $('.deletemsg').live('click',function(){
	                var operationUrl = $(this).attr('url');
	           		$.post(operationUrl,'',function(s){
					window.location.reload();
					 return true;
			});	
	                return false;
		});
				//删除分类 名
			 $('.deletegather').live('click',function(){
	                var operationUrl = $(this).attr('url');
	           		$.post(operationUrl,'',function(s){
					window.location.reload();
					 return true;
			});	
	                return false;
		});
			
		}else{
			return false;
	}
	}
   	function dilagclose(){
   		$('#mydialog').dialog('close');
   	   	}
    </script>