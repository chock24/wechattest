<?php
/* @var $this QuickmarkController */
/* @var $data Quickmark */
?>
       <div class="fodder qr-code-list">
                            <div class="fodder-center">
                                <h4><?php echo $data->title;?></h4>
                                <span class="left qr-code-list-grouping">
                                    <?php echo $this->userGroupItem($data,0);?>
                                </span>
                                <em class="fodder-date"><?php echo date('Y-m-d',$data->time_created);?></em>
                                <div class="fodder-img qr-code-list-img">
                                   <img alt="" src="<?php echo Yii::app()->request->hostInfo.'/'.$data->path;?>">
                                </div>
                            </div>
                            <div class="operation operation-fodder-h44">
                                <ul>
                                    <li class="left">
                                        <a href="<?php echo Yii::app()->createUrl('basis/quickmark/download/',array('id'=>$data->id)); ?>"><i class="icon icon-download" title="下载"></i></a>
                                    </li>
                                    <li class="left">
                                        <a href="<?php echo Yii::app()->createUrl('basis/quickmark/update/',array('id'=>$data->id)); ?>"><i class="icon icon-text" title="修改"></i></a>
                                    </li>
                                    <li class="left">
                                        <a href="<?php echo Yii::app()->createUrl('basis/quickmark/delete/',array('id'=>$data->id)); ?>"><i class="icon icon-del" title="删除"></i></a>
                                    </li>
                                </ul>
                            </div>
                        </div>
    