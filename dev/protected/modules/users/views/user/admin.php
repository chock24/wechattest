<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="<?php echo Yii::app()->baseUrl; ?>/weixin_css/member_home.css" rel="stylesheet" type="text/css" />
<?php
/* @var $this UserController */
/* @var $model User */

$this->breadcrumbs = array(
    '用户中心' => array('/users'),
    '用户管理',
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
/*$('.search-form form').submit(function(){
	$('#user-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});*/
");
Yii::app()->clientScript->registerScript('operation', "	
        $('.level-item,.tag-item,.integral-item,.remark-item').live('click',function(){
                var operationUrl = $(this).attr('href');
                $('#operationUrl').val(operationUrl);
		$.get(operationUrl,'',function(s){
			$('#operationSection').dialog({title:'用户操作界面'});
			$('#operationSection .content').html(s);
			$('#operationSection').dialog('open'); return false;
		});	
                return false;
	});
                $('.allocation2').live('click',function(){
     $('#mydialog').dialog('open');     
                  $(this).parent().parent().parent().find('input:checkbox').attr('checked', false);
                  $(this).parent().parent().find('input:checkbox').attr('checked', 'checked');
                return false;
	});
      
");
?>


<div class="right content-main">
    <h2 class="content-main-title">用户管理</h2>
    <div>
        <div class="tabhost">
            <div class="tabhost-title">
                <div class="padding10">
                    <div class="padding10 user-control-seek">
                        <?php
                        $this->renderPartial('_search', array(
                            'model' => $model,
                        ));
                        ?>
                    </div><!-- search-form -->
                </div>
                <div class="clear"></div>

            </div>
            <div class="tabhost-center">
                <div class="padding10">

                    <div class="padding10">
                        <input type="button" class="left button" value="导入系統用戶">
                        <a class="button button-green web-menu-btn left select-user blue" href="javascript:;">群发信息</a>
                        <div class="clear"></div>
                    </div>
                    <div class="padding10">
                        <?php
                        $this->widget('zii.widgets.grid.CGridView', array(
                            'id' => 'user-grid',
                            'dataProvider' => $model->search(),
                            'itemsCssClass' => 'wechat-table',
                            'template' => '{items} {summary} {pager}',
                            'summaryCssClass' => 'right margin-top-8',
                            'summaryText' => '筛选结果<b>(共{count}人)</b> | 第{start}行-{end}行 共{pages}页 | 当前为第{page}页',
                            'columns' => array(
                                array(
                                    'class' => 'CCheckBoxColumn',
                                    'selectableRows' => 2,
                                    'value' => '$data->id',
                                    'htmlOptions' => array(
                                        'class' => 'select-user-item',
                                        'width' => '30'
                                    ),
                                ),
                                array(
                                    //'name' => 'star',
                                    'type' => 'html',
                                    'value' => '$data->star?CHtml::link(CHtml::image(Yii::app()->baseUrl."/images/star.png","星标用户"),Yii::app()->createUrl("/users/user/star",array("id"=>$data->id,"accept"=>0)),array("class"=>"star-item")):CHtml::link(CHtml::image(Yii::app()->baseUrl."/images/nostar.png","非星标用户"),Yii::app()->createUrl("/users/user/star",array("id"=>$data->id,"accept"=>1)),array("class"=>"star-item"))',
                                ),
                                array(
                                    'name' => 'headimgurl',
                                    'type' => 'html',
                                    'value' => array($this, 'headimgurl'),
                                ),
                                array(
                                    'name' => 'nickname',
                                    'htmlOptions' => array(
                                        'class' => 'nickname-column',
                                    ),
                                    'value' => '$data->nickname.($data->remark?"(".$data->remark.")":"")',
                                ),
                                array(
                                    'name' => 'group_id',
                                    'value' => array($this, 'group'),
                                ),
                                /* array(
                                  'name' => 'level',
                                  'value' => array($this,'level'),
                                  ), */
                                //'integral',
                                'mobile',
                                'subscribe_time:datetime',
                                /* array(
                                  'name' => 'time_message_last',
                                  'value' => '$data->time_message_last?Yii::app()->format->formatDateTime($data->time_message_last):""'
                                  ), */
                                array(
                                    'name' => 'province',
                                    'value' => array($this, 'province'),
                                ),
                                array(
                                    'name' => 'city',
                                    'value' => array($this, 'city'),
                                ),
                                array(
                                    'class' => 'CButtonColumn',
                                    'htmlOptions' => array(
                                        'style' => 'width:100px;',
                                    ),
                                    //'template' => '{level} {tag} {integral} {remark} {refresh} {message}',
                                    'template' => '{group}{remark} {refresh} {message}',
                                    'buttons' => array(
                                        'level' => array(
                                            'label' => '设等级', // text label of the button
                                            'url' => 'Yii::app()->createUrl("/users/user/level",array("id"=>$data->id))', // a PHP expression for generating the URL of the button
                                            'options' => array(
                                                'class' => 'level-item',
                                            ), // HTML options for the button tag
                                            'imageUrl' => Yii::app()->baseUrl . '/images/level.png',
                                        ),
                                        'tag' => array(
                                            'label' => '加标签', // text label of the button
                                            'url' => 'Yii::app()->createUrl("/users/user/tag",array("id"=>$data->id))', // a PHP expression for generating the URL of the button
                                            'options' => array(
                                                'class' => 'tag-item',
                                            ), // HTML options for the button tag
                                            'imageUrl' => Yii::app()->baseUrl . '/images/tag.png',
                                        ),
                                        'integral' => array(
                                            'label' => '给积分', // text label of the button
                                            'url' => 'Yii::app()->createUrl("/users/user/integral",array("id"=>$data->id))', // a PHP expression for generating the URL of the button
                                            'options' => array(
                                                'class' => 'integral-item',
                                            ), // HTML options for the button tag
                                            'imageUrl' => Yii::app()->baseUrl . '/images/script.png',
                                        ),
                                        'group' => array(
                                            'label' => '', // text label of the button
                                            'url' => 'Yii::app()->createUrl("/users/user/group",array("id"=>$data->id,"status"=>"admin"))',
                                            // 'url' => '$data->id',
                                            'options' => array(
                                                'class' => 'margin-left-5 allocation2 icon icon-packet',
                                                'title' => '修改分组',
                                                'onclick' => 'js:return popup($(this),"修改用户分组",400,200)',
                                            ), // HTML options for the button tag
                                        //'imageUrl' => Yii::app()->baseUrl . '/images/user.png',
                                        ),
                                        'remark' => array(
                                            'label' => '', // text label of the button
                                            'url' => 'Yii::app()->createUrl("/users/user/remark",array("id"=>$data->id,"status"=>"admin"))', // a PHP expression for generating the URL of the button
                                            'options' => array(
                                                'class' => 'margin-left-5 remark-item icon icon-notes',
                                                'title' => '备注',
                                                'onclick' => 'js:return popup($(this),"修改备注",400,200)',
                                            ), // HTML options for the button tag
                                        //'imageUrl' => Yii::app()->baseUrl . '/images/photo.png',
                                        ),
                                        'refresh' => array(
                                            'label' => '', // text label of the button
                                            'url' => 'Yii::app()->createUrl("/users/user/refresh",array("id"=>$data->id))', // a PHP expression for generating the URL of the button
                                            'options' => array(
                                                'class' => 'margin-left-5 refresh-item icon icon-update',
                                                'title' => '更新用户信息',
                                            ), // HTML options for the button tag
                                        //'imageUrl' => Yii::app()->baseUrl . '/images/trackback.png',
                                        ),
                                        'message' => array(
                                            'label' => '', // text label of the button
                                            'url' => 'Yii::app()->createUrl("/users/user/view",array("id"=>$data->id))', // a PHP expression for generating the URL of the button
                                            //'imageUrl' => Yii::app()->baseUrl . '/images/comment.png',
                                            'options' => array(
                                                'class' => 'margin-left-5 icon icon-examine',
                                                'target' => '_blank',
                                                'title' => '查看对话记录',
                                            ), // HTML options for the button tag
                                        ),
                                    ),
                                ),
                            ),
                        ));
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div><?php
Yii::app()->clientScript->registerScript('usergroup', "      
           $('.allocationBtn').click(function(){
                var groupId=0;//灏囪鍒嗛厤鐨勭敤鎴风粍ID
                var clientIdArr=[];//灏嗚鍒嗛厤缁欑敤鎴风粍鐨勭敤鎴稩D
                $('.select-user-item input:checkbox').each(function (){
                    if($(this).attr('checked')=='checked'){
                    if (groupId=='0'){
                     groupId=$(this).val();
                    }else {
                            groupId=$(this).val()+','+groupId;
                    }                   
                    }
                });
                $('#mydialog input:checkbox[name=\'allocationBar_c0[]\']').each(function (){
                        if($(this).attr('checked')=='checked'){
                                clientIdArr=($(this).val());
                        }
                });
            if(clientIdArr>0){
              $.post('" . Yii::app()->createUrl('/users/user/updateusergroup') . "',{clientIdArr:clientIdArr,groupId:groupId},function(s){
                  $.fn.yiiGridView.update('user-grid');
                    $('#mydialog').dialog('close');
                   window.location.reload();
                  
                });
                 }
        });
         $('.allocation').click(function(){
                var groupId=0;//灏囪鍒嗛厤鐨勭敤鎴风粍ID
                var clientIdArr=[];//灏嗚鍒嗛厤缁欑敤鎴风粍鐨勭敤鎴稩D
                $('#user-grid input:checkbox').each(function (){
                    if($(this).attr('checked')=='checked'){
                    if (groupId=='0'){
                     groupId=$(this).val();
                    }else {
                            groupId=$(this).val()+','+groupId;
                    }                   
                    }   
                });
                if(!groupId){
                        alert('璇峰厛閫夋嫨鎮ㄨ鍒嗛厤鐨勭郴缁熺敤鎴凤紒');
                        return false;
                }else {
                     $('#mydialog').dialog('open');     
                      return false;
                }
        });
                //鍗曠嫭绉诲姩鍒嗙粍
                 $('.allocation2').click(function(){
                  $('#mydialog').dialog('open');     
                  $(this).parent().parent().parent().find('input:checkbox').attr('checked', false);
                  $(this).parent().parent().find('input:checkbox').attr('checked', 'checked');
                return false;
        });

");
?>

<?php
//鎿嶄綔琛ㄥ崟鎻愪氦
Yii::app()->clientScript->registerScript('operationSubmit', "	
    function operationSubmit(){
        var operationUrl = $('#operationUrl').val();
        var data = $('#user-form').serialize();
        $.post(operationUrl,data,function(s){
                $.fn.yiiGridView.update('user-grid');
                $('#operationSection').dialog('close');
        });
    }
");
//鍔犳槦鏍囧鎴锋搷浣
Yii::app()->clientScript->registerScript('operationStar', "	
    $('.star-item').live('click',function(){
        var operationUrl = $(this).attr('href');
        $.post(operationUrl,function(s){
                $.fn.yiiGridView.update('user-grid');
                return false;
        });
        return false;
    })
");
//鍒锋柊鐢ㄦ埛鏁版嵁鎿嶄綔
Yii::app()->clientScript->registerScript('operationRefresh', "	
    $('.refresh-item').live('click',function(){
        var operationUrl = $(this).attr('href');
        $.post(operationUrl,function(s){
                $.fn.yiiGridView.update('user-grid');
                return false;
        });
        return false;
    })
");
//閫夋嫨鐢ㄦ埛
Yii::app()->clientScript->registerScript('selectUser', "	
    $('.select-user').live('click',function(){
        if(!confirm('是否选择这些用户发送信息?')){return false;}
        var userArr = [];
        //var userNameArr = [];
        $('.select-user-item input:checkbox').each(function (){
            if($(this).attr('checked')=='checked'){
                if($.inArray($(this).val(),userArr)==-1){
                    userArr.push($(this).val());
                    //userNameArr.push($(this).parent().parent().find('td.nickname-column').text());
                }                
            }
        });
        var count = userArr.length;
        window.location.href = '" . Yii::app()->createUrl('/basis/push/create', array('genre' => 3)) . "?count='+count+'&userarr='+userArr;
        return false;
    })
");
?>

