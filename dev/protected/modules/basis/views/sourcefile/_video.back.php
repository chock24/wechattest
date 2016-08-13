<?php
/* @var $this SourcefileController */
/* @var $data SourceFile */
?>


<?php $type= Yii::app()->request->getParam('type');
?>


	 
	 <div class="block_file video_file">
                <div class="block_file_ct video_file_ct">
                    <h4 class="title"><?php echo CHtml::encode($data->title); ?></h4>
                    <div class="video_date">
                        <em> <?php echo date('Y-m-d',@$data->time_created);?></em>
                        <em>(来自本地视频)</em>
                    </div>
                    <div class="video_info">
                        <a target="_blank" href="<?php echo Yii::app()->createUrl('/basis/sourcefile/playvideo',array('videoname'=>$data->filename.'.'.$data->ext));?>" onclick="javascript:;">
                            <video  data-src="<?php echo Yii::app()->baseurl.'/upload/sourcefile/video/'.$data->filename.'.'.$data->ext?>"
                      	 src="<?php echo Yii::app()->baseurl.'/upload/sourcefile/video/'.$data->filename.'.'.$data->ext?>"></video>
                            <p class="time"><?php echo CHtml::encode($data->length); ?></p>
                        </a>
                    </div>
                </div>
                <div class="function video_ft">
                    <ul>
                    <li><a href="<?php echo Yii::app()->createUrl('/basis/sourcefilegather/group',array('id'=>$data->id,'gather_id'=>$data->gather_id,'type'=>'4'));?>" class="gatherall" title="修改分组"><i class="fu_icon move"></i></a></li>
                    <li><a href="<?php echo Yii::app()->createUrl('/basis/sourcefile/video',array('type'=>'4','action'=>'dw','name'=>@$data->filename));?>" title="下载"><i class="fu_icon download"></i></a></li>
                    <li><a href="<?php echo Yii::app()->createURL('/basis/sourcefile/update',array('id'=>$data->id,'type'=>'4'))?>" class="update-item" title='编辑'><i class="fu_icon modify"></i></a></li>
                    <li><a onclick="return ConfirmDel()"; url="<?php echo Yii::app()->createURL('/basis/sourcefile/delete',array('id'=>$data->id,'type'=>'4'))?>" title="删除" class="deletevideo"><i class="fu_icon del"></i></a></li>
                    </ul>
                </div>
            </div>

<?php
if(@$_GET['action']=='dw'){
$name = @$_GET['name'];
$file = Yii::getPathOfAlias('webroot').'/upload/sourcefile/video/'.@$name.'.'.@$data->ext;   //要下载的文件(含文件的目录)
$filename = @$name.'.'.@$data->ext; //这个只是文件的名字
header("Content-Type: application/force-download");
header("Content-Disposition: attachment; filename=".($filename));
readfile($file);
}
?>

 <script language="javascript" type="text/javascript">
       
   //删除 
       function ConfirmDel() {
		if (confirm("确定要删除吗？")){
			//删除 视频文件
			 $('.deletevideo').live('click',function(){
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
    </script>