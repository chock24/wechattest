<?php
/* @var $this SourcefileController */
/* @var $data SourceFile */
?>


<?php $type= Yii::app()->request->getParam('type');
?>
<!--<div class="view"></div>-->

	 <div class="voice_file">
            <div class="voice_file_ct img_file_ct">
                <div class="voice_info" style="background-image:url(<?php echo Yii::app()->baseurl.'/upload/sourcefile/image/source/'.$data->filename.'.'.$data->ext?>)">
                    <img class="img_click" onclick ="selimg(this)" alt="<?php echo $data->filename.'.'.$data->ext;?>" src="<?php echo PublicStaticMethod::returnSourceFile($data->filename, $data->ext, 'image', 'thumb');?>">
                    <div onclick ="selimg2(this)" class="selected"></div>
                </div>
                <h4 class="langue_title"></h4>
                <div class="img_size">
                    <label>   
                        <span class="lbl_content"><?php echo CHtml::encode($data->title); ?></span>
                    </label>
                </div>
            </div>
        </div>
 <script language="javascript" type="text/javascript">
		function selimg(obj){
            var newsrc = $(obj).attr('src');
            var filename = $(obj).attr('alt');
            $('.selected').hide();
            $(obj).parent().find('.selected').show();
            $('.img_f').attr('src',newsrc);
            $('#SourceFile_filename').attr('value',filename);
            $('.img_f').show();
		}
        function selimg2(obj){
            $('.selected').hide();
            $('.img_f').attr('src','');
            $('#SourceFile_filename').attr('value','');
            $('.img_f').hide();
        }
		//取消 选择图片
		function cancel ()
		{
		$('.img_f').attr('src','');
		}   	
    </script>
    
    