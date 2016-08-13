<?php $this->pageTitle = '欧派微信管理-消息中心'; ?>

<link href="<?php echo Yii::app()->baseUrl; ?>/weixin_css/member_home.css" rel="stylesheet" type="text/css" />
<?php
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . "/css/reset.css");
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . "/js/jquery.qqFace.js");
Yii::app()->clientScript->registerScript('qqfaceInput', "
                                        $('.emotion').qqFace({
                                            id: 'facebox',
                                            assign: 'operationText',
                                            path: '" . Yii::app()->baseUrl . "/images/arclist/',
                                        });
                                    ");
?>
<div class="right content-main">
    <h2 class="content-main-title">消息管理</h2>
    <div>
        <div class="tabhost">
            <div class="tabhost-title">

                <ul>
                    <?php $star = Yii::app()->request->getParam('star'); ?>
                    <li class="<?php
                    if (empty($star)) {
                        echo 'active';
                    }
                    ?>"><a href="<?php echo Yii::app()->createUrl('users/message'); ?>">全部消息</a></li>
                    <li class="<?php
                    if (!empty($star)) {
                        echo 'active';
                    }
                    ?>"><a href="<?php echo Yii::app()->createUrl('users/message/index', array('star' => '1')); ?>">星标消息</a></li>
                </ul>

                <div class="clear"></div>
                <div class="newsmanagement-seek">
                    <?php
                    $this->renderPartial('_search', array(
                        'model' => $model,
                    ));
                    ?>
                </div><!-- search-form -->
                <div class="clear"></div>
            </div>
            <div class="tabhost-center">
                <div class="padding30 tabhost-center">
                    <?php
                    if ($dataProvider->totalItemCount > 0) {
                        $this->widget('zii.widgets.CListView', array(
                            'dataProvider' => $dataProvider,
                            'itemView' => '_view',
                            'emptyText' => '您的公众号下面并没有消息数据',
                            'ajaxUpdate' => false,
                            'ajaxVar' => '',
                            'template' => '{items} {summary} {pager}',
                            'summaryText' => '消息数:<span>{count}</span>  总页数:<span>{pages}</span>',
                            'pager' => array(
                                'class' => 'CLinkPager',
                                'header' => '',
                                'maxButtonCount' => 5,
                                'nextPageLabel' => '&gt;',
                                'prevPageLabel' => '&lt;',
                            ),
                        ));
                    } else {
                        ?>
                        <div id="operationText">您的公众号下面并没有消息数据</div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>

    <!--消息中心和用户界面消息记录，鼠标移动到消息图片放大图片-->
    <div class="information_popup_who">
        <div class="information_popup_img">
            <div class="information_popup_img_con">
                <span class="information_popup_img_con_img">
                    <img src="" />
                    <a href="javascript:;">X</a>
                </span>
            </div>
        </div>
    </div>

</div>
<?php
$url = "$_SERVER[HTTP_HOST]" . "/users/message/index/date/";
?>
<script type="text/javascript">
    $(function () {
        //音频点击播放
        if (isIE = navigator.userAgent.indexOf("MSIE") != -1) {
            voice($('.audio-message-list'), 'embed');
        } else {
            //不是ie浏览器将embed替换成audio
            $('.audio-message-list').each(function () {
                var src = $(this).find('embed').attr('src');
                var audio = $(this).find('embed');
                audio.replaceWith("<audio src = " + src + " autostart='false' name='voi'></audio>");
            });
            voice($('.audio-message-list'), 'audio');
        }
        /*快速回复的显隐*/
        $('.icon-reply').live('click', function () {
            var obj = $(this).parent().parent().parent().parent().parent().children('.quick-reply');
            i = $(this).parent().parent().parent().parent().parent().index();
            if (obj.css('display') != 'block') {
                $('.quick-reply').hide();
                $('.editing-tab-input').find('textarea').attr('id', '');
                obj.find('.editing-tab-input').find('textarea').attr('id', "operationText").val('');
                obj.show();
            } else {
                $('.editing-tab-input').find('textarea').removeAttr("operationText");
                obj.hide();
            }
        });
        $('.quick-reply-pack-up').live('click', function () {
            $(this).parent().parent().parent().hide();
        });
        /*添加图文回复*/
        $('#select-result').live('click', function () {
            var obj = $(this).parent().prev().find('.popup-content-fodder-content').find('.items').find('.selected');
            if (obj.html() != undefined) {
                var obj = $(this).parent().prev().find('.popup-content-fodder-content').find('.items').find('.selected');
                var html = obj.html();
                var id = obj.attr('data-id');//得到选中的id
                var multi = obj.attr('data-multi');//得到选中的id
                var type = obj.attr('data-type');//得到选中的id
                $('.result-id').eq(i).val(id);
                $('.result-multi').eq(i).val(multi);
                $('.result-type').eq(i).val(type);
                if (obj.html() != undefined) {
                    $('.news-section').eq(i).html(html).show();
                    $('.editing-tab-input').eq(i).hide();
                }
            } else {
                alert('对不起！你没有选择素材，请选择素材！！');
            }
        });
        $('.editing-tab-nav').find('.icon-text').live('click', function () {
            var $i = $(this).parent().parent().parent().parent().parent().parent().parent().parent().index();
            $('.editing-tab-input').eq($i).show();
            $('.news-section').eq($i).html('').hide();
        });

        //图片点击新页面打开图片地址
        $('.admin-list-text-p img,.information_popup_who img').click(function (e) {
            $('.information_popup_who').unbind();
            var url_img = $(this).attr('src');
            $('.information_popup_who').show().find('img').attr('src', url_img);
            setTimeout(function () {
                $('.information_popup_who').click(function () {
                    $('.information_popup_who').hide();
                });
            }, 100);
        });

        $('#message-date').val("<?php echo $_GET['date'] == 0 ? 3 : $_GET['date']; ?>").change(function () {
            window.location.href = "<?php echo 'http://' . $url; ?>" + $(this).val() + ".html";
        });

    })
</script>
