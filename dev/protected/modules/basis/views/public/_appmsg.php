<?php
/* @var $this SourcefileController */
/* @var $data SourceFile */
?>


<?php $type= Yii::app()->request->getParam('type');
?>

 <div class="voice_file video_file">
                    <div class="voice_file_ct">
                        <h4 class="title img_text_tit"><a href="javascript:;"><?php echo CHtml::encode($data->title); ?></a></h4>
                        <div class="video_date img_text_date">
                            <em><?php echo CHtml::encode(date('Y-m-d',$data->time_created)); ?></em>
                        </div>
                        <div class="voice_info video_info">
                            <a href="javascript:;" onclick="javascript:;">
                                <img src="<?php echo Yii::app()->baseurl.'/upload/sourcefile/image/source/'.$data->filename.'.'.$data->ext?>">
                            </a>
                        </div>
                        <p class="img_text_desc"><?php echo CHtml::encode($data->description); ?></p>
                    </div>
                    <div class="voice_ft video_ft">
                        <ul class="img_text_ft">
                            <li><a href="<?php echo Yii::app()->createUrl('/basis/sourcefilegather/group',array('id'=>$data->id,'gather_id'=>$data->gather_id,'type'=>'5','multi'=>'0'));?>" class="gatherall" title="移动分组"><i class="yd_bj"></i></a></li>
                            <li><a href="<?php echo Yii::app()->createURL('/basis/sourcefile/Updatemsg',array('id'=>$data->id,'type'=>'5'))?>" class="update-item" title="编辑"><i class="vo_bj"></i></a></li>
                            <li><a onclick="return ConfirmDel()"; url="<?php echo Yii::app()->createURL('/basis/sourcefile/delete',array('id'=>$data->id,'type'=>'5','gatherid'=>$data->gather_id))?>" title="删除" class="deletemsg"><i class="vo_sc"></i></a></li>
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