<style>
    .admin-list-text-p img {max-width: 80px;max-height: 80px;}
</style>
<div class="admin-list">
    <div class="left admin-list-img">
        <?php echo CHtml::link(CHtml::image($this->matchUser($data->user_id, 'headimgurl')), array('/users/user/view', 'id' => $data->user_id), array('target' => '_blank')); ?>
    </div>
    <div class="left admin-list-text">
        <div class="admin-list-text-title">
            <b class="left"><?php echo CHtml::link(CHtml::encode($this->matchUser($data->user_id, 'nickname')), array('/users/user/view', 'id' => $data->user_id), array('target' => '_blank')); ?>
                <?php
                $remark = $this->matchUser($data->user_id, 'remark');
                if (!empty($remark)) {
                    echo "(" . CHtml::encode($remark) . ")";
                }
                ?></b>
            <div class="left"><?php echo Yii::app()->format->formatDateTime($data->createtime); ?></div>
            <div class="right admin-list-a">
                <div class="margin-right-15 left">
                    <a href="<?php echo Yii::app()->createUrl("users/message/remark", array("id" => $data->id)); ?>" data-id="<?php echo $data->id; ?>" onclick='js:return popup($(this), "修改备注", 350, 150);'  class="">备注:<span class="message-remark-value"><?php echo $data->remark; ?></span></a>
                </div>
                <!--
                <a href="javascript:;" class="message-star-item" title="非星标消息"><img alt="非星标消息" src="/images/nostar.png"></a>-->

                <?php if ($data->star) { ?>
                    <a title="取消收藏" class="margin-right-5" href="<?php echo Yii::app()->createUrl("users/message/star", array("id" => $data->id, "accept" => 0)); ?>"><i class="icon icon-collect icon-collect-red"></i></a>
                <?php } else { ?>
                    <a title="快速收藏" class="margin-right-5" href="<?php echo Yii::app()->createUrl("users/message/star", array("id" => $data->id, "accept" => 1)); ?>"><i class="icon icon-collect"></i></a>
                <?php }
                ?>
                <a title="快速回复" href="javascript:;"><i class="icon icon-reply"></i></a>
            </div>
        </div>
        <div class="clear"></div>
        <div class="admin-list-text-p">
            <?php // echo $data->id;?>
            <?php if ($data->type == 1)://文字信息  ?>
                <?php echo PublicStaticMethod::replaceQqFace($data->content); ?>
            <?php elseif ($data->type == 2)://图片信息 ?>                
                <?php echo CHtml::image(Yii::app()->baseUrl . '/upload/sourcefile/image/message/' . $data->picurl); ?>   
            <?php elseif ($data->type == 3)://音频信息 ?>    

                <div class="audio-message-list">
                    <?php
                    $textname = Yii::getPathOfAlias('webroot') . '/upload/sourcefile/voice/' . $data->title . '.mp3';
                    $file_voice_name = Yii::getPathOfAlias('webroot') . '/upload/sourcefile/voice/' . $data->title . '.' . $data->format;
                    if (!file_exists($textname)) {
                        if (file_exists($file_voice_name)) {
                            $amr = Yii::app()->request->hostInfo . '/upload/sourcefile/voice/' . $data->title . '.' . $data->format; //你amr文件路径
                            $file = base64_encode(base64_encode($amr)); //对文件路径进行base64加密
                            $back = file_get_contents("http://api.yizhancms.com/video/index.php?i=1&f=$file");
                            $result = (array) json_decode($back); //接口返回status和f’’参数,f为转换后mp3的文件路径:
                            copy($result['f'], Yii::getPathOfAlias('webroot') . '/upload/sourcefile/voice/' . $data->title . '.mp3'); //把接口返回的mp3文件重命名为new.mp3保存到当目录
                        }
                    }
                    ?>
                    <embed class="none" src=" <?php echo '/upload/sourcefile/voice/' . $data->title . '.mp3' ?>" autostart="false" name="voi"></embed>
                </div>

            <?php elseif ($data->type == 7)://链接信息  ?>
                <?php echo '7' . CHtml::link($data->title, $data->url, array('target' => '_blank')); ?>
            <?php elseif ($data->type == 8)://事件信息  
                ?>
                <?php if ($data->menutype == 1): ?>
                    菜单点击事件：<?php echo @CHtml::encode($data->menu->title); ?>
                <?php elseif ($data->menutype == 2): ?>
                    菜单跳转事件：
                    <?php
                    echo CHtml::link(CHtml::encode(@$data->menunew->title), $data->content, array('target' => '_blank'));
                    ?>
                <?php endif; ?>
                <br />
                <?php echo CHtml::encode($data->description) ?>
            <?php endif; ?>
        </div>
    </div>
    <div class="clear"></div>

    <!--快速回復-->
    <div class="margin-top-15 padding10 none quick-reply">
        <?php
        $form = $this->beginWidget('CActiveForm', array(
            'id' => 'message2-form',
            'htmlOptions' => array(
                'class' => 'operation-form',
            ),
            // Please note: When you enable ajax validation, make sure the corresponding
            // controller action is handling ajax validation correctly.
            // There is a call to performAjaxValidation() commented in generated controller code.
            // See class documentation of CActiveForm for details on this.
            'enableAjaxValidation' => false,
        ));
        ?>
        <form>
            <div class="editing">
                <div class="editing-tab">
                    <ul class="editing-tab-nav">
                        <li>
                            <?php echo CHtml::link('<i class="icon icon-text"></i>', array('index', 'type' => 1), array('title' => '文本', 'onclick' => 'js:$("#news-section").hide();$("#text-section").show();$("#text-section").find("textarea").val("");return false;')); ?>
                        </li>
                        <!--                        <li>
                        <?php echo CHtml::link('<i class="icon icon-single-graphic"></i>', array('sourcefile', 'type' => 5, 'multi' => 0), array('title' => '单图文', 'onclick' => 'js:return popup($(this),"单图文库",850,500);')); ?>
                                                </li>
                                                <li>
                        <?php echo CHtml::link('<i class="icon icon-more-graphic"></i>', array('sourcefile', 'type' => 5, 'multi' => 1), array('title' => '多图文', 'onclick' => 'js:return popup($(this),"多图文库",850,500);')); ?>
                                                </li>-->
                    </ul>
                    <div class="none fodder mage-text news-section">
                    </div>
                    <div class="clear"></div>
                    <div class="text-section">
                        <div class="editing-tab-input">
                            <?php echo $form->textArea($data, 'content', array('id' => 'operationText', 'data-id' => 0, 'data-multi' => 0, 'data-type' => 1, 'onchange' => 'js:return popupConfirm($(this),$("#result-id"),$("#result-multi"),$("#result-type"),1)')); ?>
                            <?php echo $form->error($data, 'content'); ?>
                        </div>
                        <div class="editing_toolbar">
                            <a class="left emotion" href="javascript:;"><i class="icon icon-face"></i></a>
                            <p class="right">还可以输入<em>500</em>字</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="margin-top-15">
                <?php echo $form->hiddenField($data, 'type', array('class' => "result-type")); ?>
                <?php echo $form->hiddenField($data, 'user_id'); ?>
                <?php echo $form->hiddenField($data, 'source_file_id', array('class' => "result-id")); ?>
                <?php echo $form->hiddenField($data, 'multi', array('class' => "result-multi")); ?>
                <?php echo CHtml::submitButton('发送', array('class' => 'button button-green')); ?>
                <input type="button" class="button button-white quick-reply-pack-up" value="收起">
            </div>
        </form>
        <?php $this->endWidget() ?>

    </div>

</div>