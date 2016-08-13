<?php
/* @var $this TransmitController */
/* @var $model Transmit */

$this->breadcrumbs = array(
    'Transmits' => array('index'),
    $model->title,
);

$this->menu = array(
    array('label' => 'List Transmit', 'url' => array('index')),
    array('label' => 'Create Transmit', 'url' => array('create')),
    array('label' => 'Update Transmit', 'url' => array('update', 'id' => $model->id)),
    array('label' => 'Delete Transmit', 'url' => '#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->id), 'confirm' => 'Are you sure you want to delete this item?')),
    array('label' => 'Manage Transmit', 'url' => array('admin')),
);

require_once "jssdk.php";
$appId = 'wx2846a5047326ce12';
$appSecret = "952d6efd51d48380c7159a252a31de2c";
$jssdk = new JSSDK($appId, $appSecret);
$signPackage = $jssdk->GetSignPackage();
?>

<link href="<?php echo Yii::app()->baseUrl; ?>/weixin_css/marketing.css" rel="stylesheet" type="text/css" />
<link href="<?php echo Yii::app()->baseUrl; ?>/weixin_css/popup_fodder.css" rel="stylesheet" type="text/css" />
<div class="right content-main">
    <h2 class="content-main-title">转发有奖 <span class="color-red"><?php echo $model->id; ?></span> 详情</h2>
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'user-form',
        // Please note: When you enable ajax validation, make sure the corresponding
        // controller action is handling ajax validation correctly.
        // There is a call to performAjaxValidation() commented in generated controller code.
        // See class documentation of CActiveForm for details on this.
        'enableAjaxValidation' => false,
    ));
    ?>

    <?php echo $form->hiddenField($usermodel, 'openid', array('value' => Yii::app()->cache->get('openid'))); ?>
    <?php echo $form->hiddenField($TransmitUser, 'transmit_id', array('value' => $model->id)); ?>
    <?php $this->endWidget(); ?>
    <div>
        <div class="tabhost">
            <div class="tabhost-title">
                <div class="clear"></div>
            </div>
            <div class="padding30 tabhost-center">

                <!--详情-->
                <div class="forward-prize">
                    <table class="wechat-table-seek">
                        <tbody>
                            <tr>
                                <td class="tdl"><label for="Admin_username">活动</label></td>
                                <td>
                                    <?php echo CHtml::encode($model->title); ?>  

                                </td>
                                <td class="tdl"><label for="Admin_name">时间</label></td>
                                <td>
                                    <?php echo CHtml::encode(date('Y-m-d', $model->time_start)); ?>  
                                    <?php echo CHtml::encode(date('Y-m-d', $model->time_end)); ?>  
                                </td>
                                <td class="tdl"><label for="Admin_name">转发积分</label></td>
                                <td>
                                    <?php echo CHtml::encode($model->integral); ?> 

                                </td>
                            </tr>
                            <tr>
                                <td class="tdl"><label for="Admin_username">活动说明</label></td>
                                <td colspan="5">
                                    <?php echo CHtml::encode($model->description); ?> 

                                </td>
                            </tr>

                            <tr>
                                <td class="tdl"><label for="Admin_username">微信关键字</label></td>
                                <td colspan="5">

                                    <?php echo CHtml::encode($model->keyword); ?> 

                                </td>
                            </tr>
                            <tr>
                                <td class="tdl"><label for="Admin_username">回复内容</label></td>
                                <td colspan="5">
                                    <!--单图文显示-->
                                    <div class="fodder mage-text">
                                        <div class="popup-fodder-center">
                                            <h4><?php echo @$sourcemodel->title; ?></h4>
                                            <div class="popup-fodder-img popup-fodder-img-teletext">
                                                <img alt="" src="<?php echo @PublicStaticMethod::returnSourceFile($sourcemodel->filename, $sourcemodel->ext, 'image', 'medium') ?>" />
                                            </div>
                                            <p class="popup-fodder-introduce"><?php echo @$sourcemodel->description; ?></p>
                                        </div>
                                        <div class="none popup-selected">
                                            <i class="icon-50 icon-50-icon-50-ok"></i>
                                            <div class="popup-selected-bj"></div>
                                        </div>
                                    </div>
                                    <!--<div class="padding10">
                                        <input type="button" value="选择素材" class="margin-left-20 button button-green" href="<?php /* echo Yii::app()->createUrl('systems/transmit/sourcefile', array('type' => 5, 'multi' => 0)); */ ?>" onclick='js:return popup($(this), "多图文库", 850, 500);'>
                                    </div>-->
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <!--转发用户列表-->
                <div class="margin-top-15 transpond-user-list">
                    <h3 class="font-14">转发用户列表</h3>
                    <div class="transpond-user-list-cont">
                        <?php
                        $this->Widget('zii.widgets.CListView', array(
                            'dataProvider' => $TransmitUserList,
                            'itemView' => '_userview',
                            'emptyText' => '该信息尚未被转发',
                            'ajaxUpdate' => false,
                            'ajaxVar' => '',
                            'template' => '{items} {summary} {pager}',
                            'summaryText' => '<div class="summary">转发有奖用户列表:<span>{count}</span>  总页数:<span>{pages}</span></div>',
                            'pager' => array(
                                'class' => 'CLinkPager',
                                'header' => '',
                                'nextPageLabel' => '&gt;',
                                'prevPageLabel' => '&lt;',
                            ),
                        ));
                        ?>

                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script>

    function AjaxClass()
    {
        var XmlHttp = false;
        try
        {
            XmlHttp = new XMLHttpRequest();        //FireFox专有  
        }
        catch (e)
        {
            try
            {
                XmlHttp = new ActiveXObject("MSXML2.XMLHTTP");
            }
            catch (e2)
            {
                try
                {
                    XmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
                }
                catch (e3)
                {
                    alert("你的浏览器不支持XMLHTTP对象，请升级到IE6以上版本！");
                    XmlHttp = false;
                }
            }
        }

        var me = this;
        this.Method = "POST";
        this.Url = "";
        this.Async = true;
        this.Arg = "";
        this.CallBack = function () {
        };
        this.Loading = function () {
        };

        this.Send = function ()
        {
            if (this.Url == "")
            {
                return false;
            }
            if (!XmlHttp)
            {
                return IframePost();
            }

            XmlHttp.open(this.Method, this.Url, this.Async);
            if (this.Method == "POST")
            {
                XmlHttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            }
            XmlHttp.onreadystatechange = function ()
            {
                if (XmlHttp.readyState == 4)
                {
                    var Result = false;
                    if (XmlHttp.status == 200)
                    {
                        Result = XmlHttp.responseText;
                    }
                    XmlHttp = null;

                    me.CallBack(Result);
                }
                else
                {
                    me.Loading();
                }
            }
            if (this.Method == "POST")
            {
                XmlHttp.send(this.Arg);
            }
            else
            {
                XmlHttp.send(null);
            }
        }

        //Iframe方式提交  
        function IframePost()
        {
            var Num = 0;
            var obj = document.createElement("iframe");
            obj.attachEvent("onload", function () {
                me.CallBack(obj.contentWindow.document.body.innerHTML);
                obj.removeNode()
            });
            obj.attachEvent("onreadystatechange", function () {
                if (Num >= 5) {
                    alert(false);
                    obj.removeNode()
                }
            });
            obj.src = me.Url;
            obj.style.display = 'none';
            document.body.appendChild(obj);
        }
    }



    wx.config({
        debug: false,
        appId: '<?php echo $signPackage["appId"]; ?>',
        timestamp: <?php echo $signPackage["timestamp"]; ?>,
        nonceStr: '<?php echo $signPackage["nonceStr"]; ?>',
        signature: '<?php echo $signPackage["signature"]; ?>',
        jsApiList: [
            'checkJsApi',
            'onMenuShareTimeline',
            'onMenuShareAppMessage',
        ]
    });
    wx.ready(function () {
        // 2.2 监听“分享到朋友圈”按钮点击、自定义分享内容及分享结果接口 
        wx.onMenuShareTimeline({
            desc: document.title, // 分享描述
            title: document.title,
            link: window.location.href,
            imgUrl: 'http://img.oppein.cn/updata/todayhot/source/2014101611221829216400131812.jpg',
            type: '', // 分享类型,music、video或link，不填默认为link
            dataUrl: '', // 如果type是music或video，则要提供数据链接，默认为空
            trigger: function (res) {
                alert('用户点击分享到朋友圈');
            },
            success: function (res) {
                alert('已分享');
                var openid = $("#User_openid").val();
                var transmit_id = $("#TransmitUser_transmit_id").val();
                var Ajax = new AjaxClass();         // 创建AJAX对象  
                Ajax.Method = "POST";               // 设置请求方式为POST  
                Ajax.Url = "<?php echo Yii::app()->createURL('systems/transmit/transmitmsg'); ?>";            // URL为default.asp  
                Ajax.Async = true;                  // 是否异步  
                Ajax.Arg = "openid=" + openid + "&transmit_id=" + transmit_id;               // POST的参数  
                Ajax.CallBack = function (str)       // 回调函数  
                {
                    alert(str);
                    location.reload();
                }
                Ajax.Send();                        // 发送请求  
            },
            cancel: function (res) {
                alert('已取消');
            },
            fail: function (res) {
                // alert(JSON.stringify(res));
            }
        });
        //发送给朋友
        wx.onMenuShareAppMessage({
            desc: document.title, // 分享描述
            title: document.title,
            link: window.location.href,
            imgUrl: 'http://img.oppein.cn/updata/todayhot/source/2014101611221829216400131812.jpg',
            type: '', // 分享类型,music、video或link，不填默认为link
            dataUrl: '', // 如果type是music或video，则要提供数据链接，默认为空
            success: function () {
                var openid = $("#User_openid").val();
                var transmit_id = $("#TransmitUser_transmit_id").val();
                var Ajax = new AjaxClass();         // 创建AJAX对象  
                Ajax.Method = "POST";               // 设置请求方式为POST  
                Ajax.Url = "<?php echo Yii::app()->createURL('systems/transmit/transmitmsg'); ?>";            // URL为default.asp  
                Ajax.Async = true;                  // 是否异步  
                Ajax.Arg = "openid=" + openid + "&transmit_id=" + transmit_id;               // POST的参数  
                Ajax.CallBack = function (str)       // 回调函数  
                {
                    alert(str);
                    location.reload();
                }
                Ajax.Send();                        // 发送请求  
            },
            cancel: function () {
                alert('转发好友失败');
            }
        });
    });
    wx.error(function (res) {
        alert('处理失败');
    });
</script>
