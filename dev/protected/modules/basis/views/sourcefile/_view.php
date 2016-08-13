<?php
/* @var $this SourcefileController */
/* @var $data SourceFile */
?>


<?php $type= Yii::app()->request->getParam('type');
?>
	
<!--	 <div class="block_file voice_file">
            <div class="block_file_ct voice_file_ct">
                <div class="voice_info">
                    <a href="javascript:;" onclick="javascript:;">
                        <embed src="<?php echo Yii::app()->baseurl.'/upload/sourcefile/voice/'.$data->filename.'.'.$data->ext?>" autostart="false"></embed>
                        <span class="icon_info"></span>
                        <div class="sp_pause"></div>
                    </a>
                    <p class="desc"><?php echo CHtml::encode($data->length); ?>"</p>
                </div>
                <h4 class="langue_title"><?php echo CHtml::encode($data->title); ?></h4>
                <div class="desc"><?php echo round($data->size/1024/1024,2)." M" ?>
                </div>
            </div>
            <div class="function voice_ft">
                <ul>
                    <li><a href="<?php echo Yii::app()->createUrl('/basis/sourcefilegather/group',array('id'=>$data->id,'gather_id'=>$data->gather_id,'type'=>'3'));?>" class="gatherall" title="修改分组"><i class="fu_icon move"></i></a></li>
                    <li><a href="<?php echo Yii::app()->createUrl('basis/sourcefile/index',array('type'=>'3','action'=>'dw','name'=>@$data->filename));?>" title="下载"><i class="fu_icon download"></i></a></li>
                    <li><a href="<?php echo Yii::app()->createURL('/basis/sourcefile/update',array('id'=>$data->id,'type'=>'3'))?>" class="update-item" title='编辑'><i class="fu_icon modify"></i></a></li>
                    <li><a onclick="return ConfirmDel()"; url="<?php echo Yii::app()->createURL('/basis/sourcefile/delete',array('id'=>$data->id,'type'=>'3'))?>" title="删除" class="deletevoice"><i class="fu_icon del"></i></a></li>
                </ul>
            </div>
        </div>-->
<?php
if(@$_GET['action']=='dw'){
$name = @$_GET['name'];
$file = Yii::getPathOfAlias('webroot').'/upload/sourcefile/voice/'.@$name.'.'.@$data->ext; 
$filename = @$name.'.'.@$data->ext; 
header("Content-Disposition: attachment; filename=".($filename));

//readfile($file);
}
?>
<!--<script language="javascript" type="text/javascript">
        $(function(){
            if(isIE = navigator.userAgent.indexOf("MSIE")!=-1) {
                voice($('.icon_info'),'embed');
            }else{
                //不是ie浏览器将embed替换成audio
                $('.voice_info a').each(function(){
                    var src = $(this).find('embed').attr('src');
                    var audio = $(this).find('embed');
                    audio.replaceWith("<audio src = "+ src + " autostart='false' name='voi'></audio>");
                });
                voice($('.icon_info'),'audio');
            }
            function voice(obj,name){
                obj.live('click',function(){
                    $('.sp_pause').hide();
                    $(this).next().show();
                    $(name).each(function(){
                        $(this)[0].pause();
                    });
                    obj.removeClass('gif_icon');
                    $(this).addClass('gif_icon');
                    var audioEle = $(this).parents().find(name)[0];
                    audioEle.play();
                    $(this).parents().children().first().removeAttr('name');
                    audioEle.loop = false;//音频播放完毕执行
                    audioEle.addEventListener('ended', function () {
                        obj.removeClass('gif_icon');
                    }, false);
                });
                $('.sp_pause').live('click',function(){
                    obj.removeClass('gif_icon');
                    var audioEle = $(this).parents().find(name)[0];
                    audioEle.pause();
                    $(this).hide();
                });
            }
            $('.sidebar').css('minHeight',$('.content').height());
            //右边鼠标经过显示菜单的
            $('.sidebar dl').find('dd').hover(function(){
                $(this).find('.modify,.deletegather').show();
            },function(){
                $(this).find('.modify,.deletegather').hide();
            });
        })
        //删除 ----
       function ConfirmDel() {
		if (confirm("确定要删除吗？")){
			//删除 音频文件
			 $('.deletevoice').live('click',function(){
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
    </script>-->