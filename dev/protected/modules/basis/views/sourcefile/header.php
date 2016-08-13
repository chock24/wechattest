<div class="message-menu">
    <?php
    $this->widget('zii.widgets.CMenu', array(
        'items' => array(
            array('label' => '单图文消息', 'url' => array('appmsg'), 'active' => $this->getAction()->getId() == 'appmsg'),
            array('label' => '多图文消息', 'url' => array('appmsgmore'), 'active' => $this->getAction()->getId() == 'appmsgmore'),
            array('label' => '图片库', 'url' => array('image'), 'active' => $this->getAction()->getId() == 'image'),
            //array('label' => '缩略图', 'url' => array('index'), 'active' => Yii::app()->request->getParam('type') == 'thumb'),
            array('label' => '语音', 'url' => array('voice'), 'active' => $this->getAction()->getId() == 'voice'),
            array('label' => '视频', 'url' => array('video'), 'active' => $this->getAction()->getId() == 'video'),
        ),
    ));
    ?>
    <div class="clear"></div>
</div>