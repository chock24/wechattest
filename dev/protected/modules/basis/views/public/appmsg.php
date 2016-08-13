<?php
/* @var $this SourcefileController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs = array(
    '管理' => array('/managers'),
    '素材管理',
);
?>
 <?php $controlid = Yii::app()->controller->id;  ?>
<?php Yii::app()->clientScript->registerCoreScript('jquery'); ?>
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl."/js/"?>blocksit.min.js"></script>
<link href="<?php echo Yii::app()->baseUrl."/css/"?>voice.css" rel="stylesheet" type="text/css" />
	  
<h1>单图文管理</h1>

   
<div class="span-100">
    <div class="message img_text_message">
        <div class="img_text_title">
            <h3>图文消息列表</h3>
        </div>
        <div class="img_text_col k81 img_left">
            <div class="img_text_sc">
                <i class="img_text_icon img_text_hi"></i>
                <a href="<?php echo Yii::app()->createUrl("/basis/sourcefile/onlymsg")?>" class="da_img"><i class="img_text_icon"></i><strong>单图文消息</strong></a>
                <a href="<?php echo Yii::app()->createUrl("/basis/sourcefile/moremsg")?>" class="du_img"><i class="img_text_icon"></i><strong>多图文消息</strong></a>
            </div>
            <div class="voice_bd">
                  <?php
                $this->widget('zii.widgets.CListView', array(
                    'dataProvider' => $dataProvider,
                     'itemView' => '/public/_appmsg',
                	'ajaxUpdate'=>false,
                  //  'id'=>'ajaxListView',
               		'template'=>'{items}{summary} {pager}',
                ));
            ?>
            </div>
        </div>
        <div class="img_right">
          <dl>
            <dd>
                <?php echo CHtml::link('显示全部', array('/basis/welcome/index','type'=>2)); ?>
            </dd>
            <?php
            $this->widget('zii.widgets.CListView', array(
                'dataProvider' => $sourceFileGather,
                'itemView' => '/public/_gather',
                'id' => 'gatherListView',
                'template' => '{items}',
            ));
            ?>
            <dd>
                <?php echo CHtml::link('+添加分组', array('/basis/sourcefilegather/create/', 'type' => 2), array('class' => 'create-gather-item')); ?>
            </dd>
        </dl>
        </div>

    </div>
</div>
<script type="text/javascript">
    $(function(){
        //瀑布流
        $(window).load( function() {
            var winWidth = $(window).width();
            if(winWidth<=1500){
                pubu(3);
            }else if(winWidth>1500){
                pubu(4);
            }
            $(window).resize(function() {
                var winWidth = $(window).width();
                if(winWidth<=1500){
                    pubu(3);
                }else if(winWidth>1500){
                    pubu(4);
                }
            });
            function pubu(text){
                $('.items').BlocksIt({
                    numOfCol: text,
                    offsetX: 8,
                    offsetY: 8,
                    blockElement: '.voice_file'
                });
                $('.pager').css({position:'absolute',marginTop:$('.items').height()+20,left:'-30px'});
                $('.img_text_col.k81.img_left').height($('.items').height()+130);
                $('.img_right').css('minHeight',$('.items').height()+130);
                $('.message').height($('.items').height()+230);
            }
        });
        //单图(多图)鼠标移动显隐
        $('.img_text_sc').hover(function(){
            $(this).find('.img_text_hi').hide();
            $(this).find('a').css('display','inline-block');
        },function(){
            $(this).find('.img_text_hi').show();
            $(this).find('a').css('display','none');
        });
    })
</script>

