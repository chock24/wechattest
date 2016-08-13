<?php
/* @var $this SourcefileController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs = array(
    '管理' => array('/managers'),
    '素材管理',
);
?>
<?php  Yii::app()->clientScript->registerCoreScript('jquery'); ?>
<link href="<?php echo Yii::app()->baseUrl."/css/"?>voice.css" rel="stylesheet" type="text/css" />


<h1>素材管理</h1>


<div class="span-100">
   <?php $this->renderPartial('header');?>
    <div class="message">
        <!-- 我爱播放器(52player.com)/代码开始 -->
        <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/cuplayer/images/swfobject.js"></script>
        <div class="video" id="CuPlayer" style="margin: 50px auto;"></div>
        <script type="text/javascript">
            var so = new SWFObject("<?php echo Yii::app()->request->baseUrl; ?>/cuplayer/CuPlayerMiniV4.swf", "CuPlayerV4", "592", "400", "9", "#000000");
            so.addParam("allowfullscreen", "true");
            so.addParam("allowscriptaccess", "always");
            so.addParam("wmode", "opaque");
            so.addParam("quality", "high");
            so.addParam("salign", "lt");
            so.addVariable("CuPlayerSetFile", "<?php echo Yii::app()->request->baseUrl; ?>/cuplayer/CuPlayerSetFile.php"); //播放器配置文件地址,例SetFile.xml、SetFile.asp、SetFile.php、SetFile.aspx
            so.addVariable("CuPlayerFile", "<?php echo Yii::app()->baseUrl.'/upload/sourcefile/video/'.@Yii::app()->request->getParam('videoname');?>"); //视频文件地址
            so.addVariable("CuPlayerImage", "<?php echo Yii::app()->request->baseUrl; ?>/images/1.png");//视频略缩图,本图片文件必须正确
            so.addVariable("CuPlayerWidth", "592"); //视频宽度
            so.addVariable("CuPlayerHeight", "400"); //视频高度
            so.addVariable("CuPlayerAutoPlay", "no"); //是否自动播放
            so.addVariable("CuPlayerLogo", "no"); //Logo文件地址
            so.addVariable("CuPlayerPosition", "bottom-right"); //Logo显示的位置
            so.write("CuPlayer");
        </script>
    </div>
</div>
