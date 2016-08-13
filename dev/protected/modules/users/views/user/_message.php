<?php if ($data->receive == 1)://接收的消息                                                                                          ?>
    <li class="dialogue-list">
        <div class="left dialogue-list-img">

            <?php echo CHtml::image(substr($user->headimgurl, 0, -1) . "64"); ?>
        </div>
        <div class="left dialogue-list-text">
            <div class="dialogue-list-text-user"><?php echo CHtml::encode($user->nickname); ?><?php
                if (!empty($user->remark)) {
                    echo "(" . CHtml::encode($user->remark) . ")";
                }
                ?></div>
            <div class="dialogue-list-text-p">
                <?php if ($data->type == 1)://文字信息 ?>
                    <?php echo PublicStaticMethod::replaceQqFace($data->content); ?>
                <?php elseif ($data->type == 2)://图片信息 ?>                
                    <?php echo CHtml::image(Yii::app()->baseUrl . '/upload/sourcefile/image/message/' . $data->picurl); ?>   
                <?php elseif ($data->type == 3)://语音信息 ?>
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
                <?php elseif ($data->type == 4)://视频信息    ?>

                <?php elseif ($data->type == 5)://图文信息    ?>

                <?php elseif ($data->type == 6)://位置信息    ?>

                <?php elseif ($data->type == 7)://链接信息   ?>
                    <?php echo CHtml::link($data->title, $data->url, array('target' => '_blank')); ?>
                    <br />
                    <?php echo CHtml::encode($data->description) ?>
                <?php elseif ($data->type == 8)://事件信息   ?>
                    <?php if ($data->menutype == 1): ?>
                        菜单点击事件：<?php echo @CHtml::encode($data->menu->title); ?>
                    <?php elseif ($data->menutype == 2): ?>
                        菜单跳转事件：
                        <?php
                        echo CHtml::link(CHtml::encode(@$data->menunew->title), $data->content, array('target' => '_blank'));
                        ?>
                    <?php endif; ?>
                <?php elseif ($data->type == 9)://音乐信息    ?>

                <?php endif; ?>
            </div>
        </div>
        <div class="left dialogue-list-date"><?php echo Yii::app()->format->formatDateTime($data->createtime); ?></div>
        <div class="right dialogue-list-select">
            <div class="margin-right-15 left">
                <a href="<?php echo Yii::app()->createUrl("users/message/remark", array("id" => $data->id, 'view_id' => Yii::app()->request->getParam('id'))); ?>" data-id="<?php echo $data->id; ?>" onclick='js:return popup($(this), "修改备注", 350, 300);'  class="">备注:<span class="message-remark-value"><?php echo $data->remark; ?></span></a>     
            </div>
            <?php if ($data->star) { ?>
                <a title="取消收藏" class="margin-right-5" href="<?php echo Yii::app()->createUrl("users/message/star", array("id" => $data->id, "accept" => 0, 'view_id' => Yii::app()->request->getParam('id'))); ?>"><i class="icon icon-collect icon-collect-red"></i></a>
            <?php } else { ?>
                <a title="快速收藏" class="margin-right-5" href="<?php echo Yii::app()->createUrl("users/message/star", array("id" => $data->id, "accept" => 1, 'view_id' => Yii::app()->request->getParam('id'))); ?>"><i class="icon icon-collect"></i></a>
            <?php }
            ?>
        </div>
    </li>
<?php else://发出的消息       ?>
    <li class="dialogue-list">
        <div class="left dialogue-list-img">
            <img src="<?php echo Yii::app()->baseUrl; ?>/weixin_image/admin.jpg" />
        </div>
        <div class="left dialogue-list-text">
            <div class="dialogue-list-text-user"><?php echo $data->auto == 1 ? '自动回复：' : '回复：'; ?></div>
            <div class="dialogue-list-text-p">
                <?php if ($data->type == 1)://文字信息  ?>
                    <?php echo PublicStaticMethod::replaceQqFace($data->content); ?>
                <?php elseif ($data->type == 2)://图片信息 ?>                
                    <?php echo CHtml::image(PublicStaticMethod::returnSourceFile($data->sourcefile->filename, $data->sourcefile->ext, 'image', 'medium')); ?>
                <?php elseif ($data->type == 3)://语音信息    ?>
                    <div class="audio-message-list">
                        <span class="margin-right-5 right color-9">
                            <?php
                            $titsa = $data->sourcefile->length;
                            $hour = floor($titsa / 3600);
                            $minute = floor(($titsa - 3600 * $hour) / 60);
                            $second = floor((($titsa - 3600 * $hour) - 60 * $minute) % 60);
                            //echo $hour.':'.$minute.':'.$second;
                            echo $minute . ':' . $second;
                            ?>
                        </span>
                        <embed class="none" src="<?php echo PublicStaticMethod::returnSourceFile($data->sourcefile->filename, $data->sourcefile->ext, 'voice'); ?>" autostart="false" name="voi"></embed>
                    </div>
                <?php elseif ($data->type == 4)://视频信息     ?>
                    <div class="video-messaging-list">
                        <video src="<?php echo Yii::app()->baseUrl; ?>/weixin_image/shipin.mp4" controls="controls"></video>
                        <a target="_blank" href="<?php echo Yii::app()->baseUrl; ?>/weixin_image/shipin.mp4">点击放大查看>></a>
                    </div>
                <?php elseif ($data->type == 5)://图文信息  ?>
                    <?php if ($data->multi == 1): ?>
                        <?php
                        foreach ($data->sourcefilegroup->sourceDetail as $key => $value)://循环素材细节 
                            if ($key == 0):
                                ?>
                                <div class="dialogue-list-text-pl">
                                    <?php
                                    echo CHtml::link(CHtml::image(PublicStaticMethod::returnSourceFile($value->sourcefile->filename, $value->sourcefile->ext, 'image', 'medium')), array('/site/view', 'id' => $value->sourceFile->id), array('target' => '_blank'));
                                    ?>
                                </div>
                                <div class="dialogue-list-text-pr">
                                    <h3><?php
                                        echo CHtml::link(
                                                '[多图文链接]', array('/basis/sourcefile/moremsg', 'id' => $data->source_file_id), array('target' => '_blank')
                                        );
                                        echo $data->sourcefilegroup->title;
                                        ?></h3>
                                    <?php
                                    echo $data->sourcefilegroup->description;
                                    ?>
                                </div>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    <?php else: ?>

                        <div class="dialogue-list-text-pl">
                            <?php
                            echo CHtml::link(CHtml::image(PublicStaticMethod::returnSourceFile($data->sourcefile->filename, $data->sourcefile->ext, 'image', 'medium')), array('/site/view', 'id' => $data->source_file_id), array('target' => '_blank'));
                            ?>
                        </div>
                        <div class="dialogue-list-text-pr">
                            <h3><?php
                                echo CHtml::link(
                                        '[单图文链接]', array('/basis/sourcefile/updatemsg', 'id' => $data->source_file_id), array('target' => '_blank')
                                );
                                echo $data->sourcefile->title;
                                ?></h3>
                            <P>
                                <?php
                                echo $data->sourcefile->description;
                                ?>
                            </P>
                        </div>



                    <?php endif; ?>
                <?php elseif ($data->type == 6)://位置信息    ?>

                <?php elseif ($data->type == 7)://链接信息     ?>

                <?php elseif ($data->type == 8)://事件信息     ?>

                <?php elseif ($data->type == 9)://音乐信息     ?>

                <?php endif; ?>
            </div>
        </div>
        <div class="right dialogue-list-date"><?php echo Yii::app()->format->formatDateTime($data->createtime); ?></div>
    </li>
<?php endif; ?>
