<dd>
    
    <?php  //  CHtml::link($data->name. '(' . ($data->count ? $data->count : 0) . ')', Yii::app()->createUrl($this->route, array('id'=>Yii::app()->request->getParam('id'), 'genre'=>Yii::app()->request->getParam('genre'),'gather' => $data->id, 'type' => $data->type, 'multi' => $data->multi, 'count' => Yii::app()->request->getParam('count'),'userarr' => Yii::app()->request->getParam('userarr'))), array('class'=>'gather-item','title' => $data->name. '(' . ($data->count ? $data->count : 0) . ')')); 
    
    ?>
    <?php echo '<a class="gather-item" href='. Yii::app()->createUrl('basis/sourcefile/appmsgclass', array('gather' => $data->id, 'type' => $data->type, 'multi' => '0')).'>'.$data->name.'(' . count(@$data->sourcefiles) . ')'."</a>"?>
    </dd> 
    
<?php 
Yii::app()->clientScript->registerScript('operation', "	
      	 
    $('.create-item,.update-gather-item,.create-gather-item').live('click',function(){
            var operationUrl = $(this).attr('href');
                    $.get(operationUrl,'',function(s){
                    $('#mydialog').dialog({title:'操作界面'});
                    $('#mydialog .content').html(s);
                    $('#mydialog').dialog('open'); return false;
            });	
            return false;
	});
              	$('.gather-item').live('click',function(){
                var operationUrl = $(this).attr('href');
			 $.get(operationUrl,'',function(s){
			 $('.move_img_txt_bd').html(s);
                         return true;
		});	
                return false;
	});
        	
          
");
?>
