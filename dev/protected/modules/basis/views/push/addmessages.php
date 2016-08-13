<?php
/* @var $this PushController */
/* @var $model Push */

$this->breadcrumbs = array(
    '基础功能' => array('/basis'),
    '群发功能' => array('admin'),
    '查看信息',
);
?>
<link href="<?php echo Yii::app()->baseUrl; ?>/weixin_css/reply.css" rel="stylesheet" type="text/css" />
<div class="right content-main">
    <h2 class="content-main-title">新建群发消息</h2>
    <div>
        <div class="tabhost">
            <div class="tabhost-title">
                <div class="clear"></div>
            </div>
            <div class="tabhost-center">

                <div class="padding30 new-group-sending">

                    <div class="new-group-sending-select">
                        <h4>选择用户:</h4>
                        <select>
                            <option value="1">全部用户</option>
                            <option value="2">按分组选择</option>
                            <option value="2">按用户选择</option>
                        </select>
                        <select class="none">
                            <option value="1">未分组</option>
                            <option value="2">技术组</option>
                            <option value="2">技术组</option>
                        </select>
                        <input type="button" class="none width-auto button button-white" value="选择用户">
                        <a href="<?php echo Yii::app()->createUrl('/users/user/admin');?>">选择用户</a>
                         
                        <div class="margin-top-5 margin-right-15 right color-9">群发用户：全部用户</div>
                    </div>

                    <div class="margin-top-15 new-group-sending-show">

                        <div class="group-sending-list">
                            <div class="left margin-right-15">
                                <img src="http://wechat.oppein.cn/upload/sourcefile/image/medium/20150129102741142874.jpg" />
                            </div>
                            <div class="group-sending-list-info">
                                <p><a href="javascript:;">[图文信息]图文的信息信息来着</a></p>
                                <p class="color-9">单图文信息单图文信息单图文信息单图文信息单图文信息单图文信息单图文信息单图文信息单图文信息单图文信息单图文信息单图文信息</p>
                            </div>
                            <div class="right group-sending-list-choice">
                                <span class="left color-9 group-sending-list-status">待审核</span>
                                <em class="color-9 group-sending-list-time">02月12日</em>
                                <a href="javascript:;" class="right">删除</a>
                                <div class="clear"></div>
                            </div>
                        </div>

                    </div>

                    <div class="editing">
                        <div class="editing-tab">
                            <ul class="editing-tab-nav">
                                <li><a href="javascript:;"><i class="icon icon-text"></i></a></a></li>
                                <li><a href="javascript:;"><i class="icon icon-img"></i></a></a></li>
                                <li><a href="javascript:;"><i class="icon icon-voice"></i></a></a></li>
                                <li><a href="javascript:;"><i class="icon icon-video"></i></a></a></li>
                            </ul>
                            <div class="editing-tab-input">
                                <textarea>请输入内容</textarea>
                            </div>
                            <div class="editing_toolbar">
                                <a class="left" href="javascript:;"><i class="icon icon-face"></i></a>
                                <p class="right">还可以输入<em>500</em>字</p>
                            </div>
                        </div>
                    </div>
                    <div>
                        <input type="button" class="button button-green" value="确定">
                    </div>

                </div>

            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(function(){
        $('.new-group-sending-select').find('select').eq(0).change(function(){
            var $text = $(this).find("option:selected").text();
            if($text=='按分组选择'){
                $('.new-group-sending-select').find('select').eq(1).show();
                $('.new-group-sending-select').find('input:button').hide();
            }else if($text=='按用户选择'){
                $('.new-group-sending-select').find('input:button').show();
                $('.new-group-sending-select').find('select').eq(1).hide();
            }else {
                $('.new-group-sending-select').find('input:button').hide();
                $('.new-group-sending-select').find('select').eq(1).hide();
            }
        });
    })
</script>