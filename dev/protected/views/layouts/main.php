<?php /* @var $this Controller */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="robots" content="noindex,nofollow" />
        <meta name="language" content="en" />

        <!-- blueprint CSS framework -->
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/screen.css" media="screen, projection" />
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css" media="print" />
        <!--[if lt IE 8]>
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection" />
        <![endif]-->

        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/library.css" />
        <?php
            Yii::app()->clientScript->registerMetaTag('keywords','关键字');
            Yii::app()->clientScript->registerMetaTag('description','描述');
            Yii::app()->clientScript->registerMetaTag('author','作者');
        ?>

        <title><?php echo CHtml::encode($this->pageTitle); ?></title>
    </head>

    <body>

        <div class="container" id="page">

            <div id="header">
                <div id="logo">
                    <div>
                        <div style="float:left;width:260px;margin-left:-12px;"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/top_bend.jpg" alt="logo" /></div>
                        <div style="float:left;width:500px;padding-top:13px;color:#EEE;"><?php echo CHtml::encode(Yii::app()->name); ?></div>
                        <?php echo CHtml::link('退出网站',array('/site/logout'),array('class'=>'logout-btn right','onclick'=>'return confirm("确定要退出吗？");')); ?>
                        <?php echo CHtml::link('修改密码',array('/systems/admin/update'),array('class'=>'logout-btn right')); ?>
                        <div style="clear: both;"></div>
                    </div>
                </div>
                <div id="mainmenu">
                    <div class="read_new">
                        <?php echo CHtml::link('未读消息('.PublicStaticMethod::getMessageCount(Yii::app()->user->getState('public_id')).')',array('/users/message/admin')); ?>
                    </div>
                    <?php 
                        $dataProver = PublicStaticMethod::getPublicDataProvider(Yii::app()->user->id);
                        if(is_array($dataProver) && !empty($dataProver)):
                    ?>
                    <div class="publics">
                        <?php echo CHtml::link(Yii::app()->user->getState('public_name').'(切换)','#',array('class'=>'public-name')); ?>
                        <ul class="publics-list">
                            <?php foreach($dataProver as $key=>$value): ?>
                                <li><?php echo CHtml::link($value->title,array('/publics/wcpublic/change','id'=>$value->id)); ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                    <?php
                        endif;
                    ?>
                    <?php
                        $this->widget('zii.widgets.CMenu', array(
                            'encodeLabel' => false,
                            'activateParents' => true,
                            'items' => array(
                                array('label' => '网站首页', 'url' => array('/site')),
                                array('label' => '系统设置', 'url' => array('/systems/system/index'),'visible'=>Yii::app()->user->getState('roles')==1),
                                array('label' => '微信素材', 'url' => array('/basis/sourcefile/appmsg')),
                                array('label' => '消息管理', 'url' => array('/users/message')),
                                array('label' => '用户管理', 'url' => array('/users/user/admin')),
                                //array('label' => '互动中心', 'url' => array('/interacts')),
                                //array('label' => '附加功能', 'url' => array('/additions')),
                                array('label' => '公众号设置', 'url' => array('/publics/wcpublic/admin')),
                            ),
                        ));
                    ?>
                </div><!-- mainmenu -->
            </div><!-- header -->

            <div style="position:fixed;text-align:center;width:160px;height: auto;top:0;bottom:0;margin:84px 0 10px 0;background:#4f9bc6;">
                    <div id="sidebar">
                        <?php
                        $this->beginWidget('zii.widgets.CPortlet', array(
                            'title' => '管理菜单',
                        ));
                        $this->widget('zii.widgets.CMenu', array(
                            'items' => Yii::app()->user->getState('roles')==1?Yii::app()->params->LEFTMENU['superadmin']:Yii::app()->params->LEFTMENU['admin'],
                            'htmlOptions' => array('class' => 'operations'),
                        ));
                        $this->endWidget();
                        ?>
                    </div><!-- sidebar -->
            </div> 

            <div style="padding-left:150px;padding-top:85px;">
                <?php if (isset($this->breadcrumbs)): ?>
                    <?php
                    $this->widget('zii.widgets.CBreadcrumbs', array(
                        'links' => $this->breadcrumbs,
                    ));
                    ?><!-- breadcrumbs -->
                <?php endif ?>
                <?php echo $content; ?>
                <div class="clear"></div>
                <div id="footer">
                    Copyright &copy; <?php echo date('Y'); ?> Oppein furniture group co., LTD<br/>
                    All Rights Reserved.<br/>
                    欧派家居集团
                </div><!-- footer -->
            </div>
        </div><!-- page -->
    </body>
</html>

<?php
Yii::app()->clientScript->registerScript('gather-operation', "	
      	 
    $('.create-item,.update-gather-item,.create-gather-item').live('click',function(){
        var operationUrl = $(this).attr('href');
                $.get(operationUrl,'',function(s){
                $('#mydialog').dialog({title:'操作界面'});
                $('#mydialog .content').html(s);
                $('#mydialog').dialog('open'); return false;
        });	
        return false;
    });
    $('.delete-gather-item').live('click',function(){
        if(!confirm('您确定要删除这个分组吗?')){return false;}
        var operationUrl = $(this).attr('href');
        var object = $(this);
        $.post(operationUrl,'',function(s){
            object.parent().remove();
        });	
        return false;
    });
    $('.gather-item').live('click',function(){
        var operationUrl = $(this).attr('href');
                $.get(operationUrl,'',function(s){
                $('#mydialog').dialog({title:'分组列表'});
                $('#mydialog .content').html(s);
                $('#mydialog').dialog('open'); return true;
        });	
        return false;
    });
    $('#updatetitle').live('click',function(){
        var operationUrl = $(this).attr('href');
                $.get(operationUrl,'',function(s){
                $('#mydialog').dialog({title:'修改分组名称'});
                $('#mydialog .content').html(s);
                $('#mydialog').dialog('open'); return true;
        });	
        return false;
    });
    $('.gatherall').live('click',function(){
        var operationUrl = $(this).attr('href');
                $.get(operationUrl,'',function(s){
                $('#mydialog').dialog({title:'分组列表'});
                $('#mydialog .content').html(s);
                $('#mydialog').dialog('open'); return true;
        });	
        return false;
    });
    $('#updatetitle').live('click',function(){
        var operationUrl = $(this).attr('href');
                $.get(operationUrl,'',function(s){
                $('#mydialog').dialog({title:'修改分组名称'});
                $('#mydialog .content').html(s);
                $('#mydialog').dialog('open'); return true;
        });	
        return false;
    });
");
?>