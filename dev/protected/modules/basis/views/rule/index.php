<link href="<?php echo Yii::app()->baseUrl; ?>/weixin_css/reply.css" rel="stylesheet" type="text/css" />
<link href="<?php echo Yii::app()->baseUrl; ?>/weixin_css/member_home.css" rel="stylesheet" type="text/css" />

<div class="right content-main">
    <!--<h2 class="content-main-title">关键字回复</h2>-->

    <div class="margin-top-10 tabhost">
        <div class="tabhost-title">
            <ul>
                <li><a href="<?php echo Yii::app()->createUrl('/basis/welcome/index');?>">欢迎语</a></li>
                <li><a href="<?php echo Yii::app()->createUrl('/basis/auto/index') ?>">自动回复</a></li>
                <li class="active"><a href="<?php echo Yii::app()->createUrl('/basis/rule/index') ?>">关键字回复</a></li>
            </ul>
            <div class="clear"></div>
        </div>
        <div class="tabhost-center">
            <a href="<?php echo Yii::app()->createUrl('basis/rule/create'); ?>" class="margin-top-10 margin-left-10 button button-white" onclick="js:return popup($(this), '添加规则', 390, 190);">+添加规则</a>
            <div class="clear"></div>
            <div class="summary"></div>
            <div class="padding10 reply">
                <?php
                $this->Widget('zii.widgets.CListView', array(
                    'dataProvider' => $dataProvider,
                    'itemView' => '_view',
                    'emptyText' => '您的公众号下面并没有用户分组数据，您可以从微信服务器下载',
                    'ajaxUpdate' => false,
                    'ajaxVar' => '',
                    'template' => '{items}{summary}',
                    'summaryText' => '<div class="summary">规则数:<span>{count}</span>  总页数:<span>{pages}</span></div>',
                    'pager' => array(
                        'class' => 'CLinkPager',
                        'header' => '',
                        'maxButtonCount' => 5,
                        'nextPageLabel' => '&gt;',
                        'prevPageLabel' => '&lt;',
                    ),
                ));
                ?>
                <div class="clear"></div>
                <?php
                $this->Widget('zii.widgets.CListView', array(
                    'dataProvider' => $dataProvider,
                    'itemView' => '_view',
                    'emptyText' => '您的公众号下面并没有用户分组数据，您可以从微信服务器下载',
                    'ajaxUpdate' => false,
                    'ajaxVar' => '',
                    'template' => '{pager}',
                    'summaryText' => '<div class="summary">规则数:<span>{count}</span>  总页数:<span>{pages}</span></div>',
                    'pager' => array(
                        'class' => 'CLinkPager',
                        'header' => '',
                        'maxButtonCount' => 5,
                        'nextPageLabel' => '&gt;',
                        'prevPageLabel' => '&lt;',
                    ),
                ));
                ?>
            </div>
        </div>
    </div>
</div>
<!--消息中心和用户界面消息记录，鼠标移动到消息图片放大图片-->
<div class="information_popup_who">
    <div class="information_popup_img">
        <div class="information_popup_img_con">
            <span class="information_popup_img_con_img">
                <img src="" / >
                     <a href="javascript:;">X</a>
            </span>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(function () {
        $('.keyword-list-title').click(function () {/*点击展开关键字回复详情*/
            var obj1 = $(this).parent().find('.keyword-list-original');
            var obj2 = $(this).parent().find('.keyword-list-modify');
            if (obj1.css('display') == 'block') {
                obj1.hide();
                obj2.show();
            } else {
                obj1.show();
                obj2.hide();
            }
            return false;
        });
        $('.keyword-list-modify-list-input').live('click', function () {/*加载添加回复内容的ajax页面*/
            var obj = $(this).parent().find('.keyword-list-modify-list-date');
            var url = $(this).attr('href');
            if (obj.html() == '') {
                $.get(url, '', function (data) {
                    obj.html(data);
                });
            } else {
                obj.html('');
            }
            return false;
        });
        $('.keyword-list-modify-list-cancel').live('click', function () {/*删除添加回复内容的ajax页面*/
            var obj = $(this).parent().parent().parent().parent().parent().parent().parent().find('.keyword-list-modify-list-date');
            obj.html('');
        });
        var keyword_list_id = '<?php echo YII::app()->request->getParam('rule_id');?>';/*保存后显示保存的关键字回复详情*/
        $('.keyword-list').each(function(){
            if($(this).find('.keyword-list-title').attr('data_id') == keyword_list_id){
                $(this).find('.keyword-list-original').hide();
                $(this).find('.keyword-list-modify').show();
            }
        });

        //音频点击播放
        if(isIE = navigator.userAgent.indexOf("MSIE")!=-1) {
            voice($('.audio-message-list'),'embed');
        }else{
            //不是ie浏览器将embed替换成audio
            $('.audio-message-list').each(function(){
                var src = $(this).find('embed').attr('src');
                var audio = $(this).find('embed');
                audio.replaceWith("<audio src = "+ src + " autostart='false' name='voi'></audio>");
            });
            voice($('.audio-message-list'),'audio');
        }
        //判断视频格式做修改
        if(navigator.appName == "Microsoft Internet Explorer" && (navigator.appVersion .split(";")[1].replace(/[ ]/g,"")=="MSIE6.0" || navigator.appVersion .split(";")[1].replace(/[ ]/g,"")=="MSIE7.0" || navigator.appVersion .split(";")[1].replace(/[ ]/g,"")=="MSIE8.0")){
            $('.video-messaging-list').each(function(){
                var src = $(this).find('video').attr('src');
                var video = $(this).find('video');
                video.replaceWith("<embed src="+ src +" autostart='false'></embed>");
            });
        }

        //图片点击新页面打开图片地址
        $('.keyword-list-modify-list-reply img').click(function (e) {
            $('.information_popup_who').unbind();
            //http://wechat.oppein.cn/upload/sourcefile/image/medium/20151202152721904830.png
            var url_img = $(this).attr('src').replace("medium","source");
            //medium  sourcefile

            $('.information_popup_who').show().find('img').attr('src', url_img);
            setTimeout(function () {
                $('.information_popup_who').click(function () {
                    $('.information_popup_who').hide();
                });
            }, 100);
            return false;
        });

    })
</script>
