<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

return array(
    'adminEmail' => '359426334@qq.com',
    'ADMINROLE' => array(
        1 => '超级管理员',
        2 => '全局管理员',
        3 => '文案编辑',
        4 => '微信客服',
        5 => '代理商',
    ), //管理员角色
    'SEX' => array(
        0 => '请选择',
        1 => '先生',
        2 => '女士',
    ), //性别
    'WHETHER' => array(
        0 => '否',
        1 => '是'
    ), //是否
    'LANGUAGE' => array(
        'en' => '英文',
        'zh_CN' => '中文',
    ), //语言类型

    /* --------------------自定义菜单类型-------------------- */
    'MENUTYPE' => array(
        1 => 'click', //发送内容
        2 => 'view', //转跳网页
    //3=>'scancode_waitmsg',//扫码带提示
    //4=>'scancode_push',//扫码推事件
    //5=>'pic_sysphoto',//系统拍照发图
    //6=>'pic_photo_or_album',//拍照或者相册发图
    //7=>'pic_weixin',//微信相册发图
    //8=>'location_select',//发送位置
    ),
    /* --------------------两个必须要一致-------------------- */
    'MENUTYPELABEL' => array(
        1 => '发送内容',
        2 => '转跳网页',
    //3=>'扫码带提示',
    //4=>'扫码推事件',
    //5=>'系统拍照发图',
    //6=>'拍照或者相册发图',
    //7=>'微信相册发图',
    //8=>'发送位置',
    ),
    /* --------------------自定义菜单类型-------------------- */
    'TYPE' => array(
        1 => 'text', //文字
        2 => 'image', //图片
        3 => 'voice', //语音
        4 => 'video', //视频
        5 => 'news', //新闻（图文）
        6 => 'location', //位置
        7 => 'link', //链接
        8 => 'event', //事件
        9 => 'music', //音乐
    ), //发送消息内容
    'REPLYTYPE' => array(
        1 => '被关注自动回复',
        2 => '消息自动回复',
        3 => '关键字自动回复',
    ), //自动回复类型
    'QUICKMARKTYPE' => array(
        'QR_LIMIT_SCENE' => '永久二维码',
    //'QR_SCENE'=>'临时二维码',
    ), //二维码类型
    'PUBLICTYPE' => array(
        1 => '订阅号',
        2 => '服务号',
    ), //公众号类型
    'FILTERSHOWTYPE' => array(
        1 => '显示自动回复的',
        2 => '显示菜单的',
    ), //消息过滤的显示
    'FILTERTYPE' => array(
        0 => '不选择过滤',
        1 => '过滤自动回复的',
        2 => '过滤菜单的',
    ),
    //有奖转发 状态
    'TRANSMITSTATUS' => array(0 => '未开始', 1 => '活动中', '2' => '已结束'),
    //消息过滤
    'PUSHGENRE' => array(
        1 => '全部用户',
        2 => '分组群发',
        3 => '选择用户',
    ), //群发消息 发送人群
    'GIFTSTATUS' => array(
        0 => '下架',
        1 => '在架',
    ),
    'PUSHSTATUS' => array(
        0 => '已经撤销',
        1 => '审核中',
        2 => '审核成功',
        3 => '审核失败',
        4 => '发送成功',
        5 => '发送失败',
    ), //群发消息 信息状态
    'PUSHACTION' => array(
        0 => '已经撤销',
        1 => '审核',
        2 => '查看/发送',
        3 => '失败原因',
        4 => '查看',
        5 => '失败原因',
    ), //活动星级等级
    'STAR' => array(
        1 => '一级',
        2 => '二级',
        3 => '三级',
        4 => '四级',
        5 => '五级',
    ), //群发按钮  动作
    'PUSHTYPE' => array(
        1 => 'text',
        2 => 'image',
        3 => 'voice',
        4 => 'video',
        5 => 'mpnews',
        6 => 'location',
        7 => 'link',
        8 => 'event',
        9 => 'music',
    ),
//积分 类型
    'INTEGRALTYPE' => array(
        1 => '关注公众号',
        2 => '邀请好友',
        3 => '推荐好友',
        4 => '完善个人资料',
        5 => '每日签到',
        6 => '转发文章',
        7 => '兑换礼品',
        8 => '有奖游戏',
        9 => '积分兑换',
        10 => '积分抽奖',
        11 => '参与活动',
        12 => '年度清零',
    ),
//群发消息 发送信息类型

    /* --------------------文件储存位置---------------------- */
    'WEBROOT' => 'http://wechat.oppein.cn/', //网站根目录
    'FILEFOLDER' => 'upload/', //网站根目录
    'FILEPATH' => array(
        'quickmark' => array(
            'eternal' => 'quickmark/eternal/',
            'temp' => 'quickmark/temp/',
        ),
        'sourcefile' => array(
            'image' => array(
                'source' => 'sourcefile/image/source/',
                'medium' => 'sourcefile/image/medium/',
                'thumb' => 'sourcefile/image/thumb/',
                'icon' => 'sourcefile/image/icon/',
                'watermark' => 'sourcefile/image/watermark/',
                'poster'    =>'sourcefile/image/poster/',
            ),
            'video' => 'sourcefile/video/',
            'voice' => 'sourcefile/voice/',
        ),
        'public' => array(
            'headimage' => 'public/headimage/',
        ),
        'service' => array(
            'headimage' => 'service/headimage/',
        )
    ),
    /* --------------------图片文件尺寸---------------------- */
    'FILESIZE' => array(
        'sourcefile' => array(
            'image' => array(
                'icon' => array(80, 80),
                'thumb' => array(200, 200),
                'medium' => array(360, 200),
                'poster' => array(640,320),
            ),
        ),
    ),
    /* --------------------菜单项数组---------------------- */
    'LEFTMENU' => array(
        array('label' => '<i class="margin-right-5 icon icon-menu"></i>用户中心', 'url' => 'javascript:;', 'submenuOptions' => array('class' => 'nav-SubMenu'), 'items' => array(
                array('label' => '消息中心', 'url' => array('/users/message/index')),
                array('label' => '用户管理', 'url' => array('/users/user/admin')),
                array('label' => '用户分组管理', 'url' => array('/users/usergroup/index')),
            )),
        array('label' => '<i class="margin-right-5 icon icon-menu"></i>基础功能', 'url' => 'javascript:;', 'submenuOptions' => array('class' => 'nav-SubMenu'), 'items' => array(
                array('label' => '消息管理', 'url' => array('/basis/welcome/index')),
                array('label' => '自定义菜单', 'url' => array('/basis/menu/index')),
                array('label' => '微信素材', 'url' => array('/basis/sourcefile/morenews')),
                array('label' => '微信二维码', 'url' => array('/basis/quickmark/index')),
                array('label' => '群发功能', 'url' => array('/basis/push/index')),
            )),
        array('label' => '<i class="margin-right-5 icon icon-menu"></i>公众号中心', 'url' => 'javascript:;', 'submenuOptions' => array('class' => 'nav-SubMenu'), 'items' => array(
                array('label' => '公众号列表', 'url' => array('/publics/wcpublic')),
                array('label' => '创建公众号', 'url' => array('/publics/wcpublic/create')),
                array('label' => '公众号常见问题', 'url' => array('/publics/wcpublic/news')),
            )),
        /* array('label' => '<i class="margin-right-5 icon icon-menu"></i>系统管理', 'url' => 'javascript:;', 'submenuOptions' => array('class' => 'nav-SubMenu'), 'items'=>array(
          array('label' => '系统设置', 'url' => array('/systems/system')),
          array('label' => '管理员列表', 'url' => array('/systems/admin')),
          array('label' => '创建管理员', 'url' => array('/systems/admin/create')),
          array('label' => '登录日志', 'url' => array('/systems/system/logaccess')),
          array('label' => '错误日志', 'url' => array('/systems/system/logerror')),
          )), */
        //
        array('label' => '<i class="margin-right-5 icon icon-menu"></i>营销工具', 'url' => 'javascript:;', 'submenuOptions' => array('class' => 'nav-SubMenu'), 'items' => array(
                // array('label' => '签到', 'url' => array('/systems/attendance/index')),
                array('label' => '首页模块管理', 'url' => array('/systems/userModule/index')),
                array('label' => '活动管理', 'url' => array('/systems/activitiy/index')),
                array('label' => '转发有奖', 'url' => array('/systems/transmit/index')),
                array('label' => '礼品商城', 'url' => array('/systems/gift/index')),
                array('label' => '积分记录', 'url' => array('/systems/userIntegral/index')),
                array('label' => '海报管理', 'url' => array('/systems/poster/index')),
                array('label' => '优惠券管理', 'url' => array('/systems/coupon/index')),
            )),
    ),
    'LEFTMENU2' => array(
        array('label' => '<i class="margin-right-5 icon icon-menu"></i>用户中心', 'url' => 'javascript:;', 'submenuOptions' => array('class' => 'nav-SubMenu'), 'items' => array(
                array('label' => '消息中心', 'url' => array('/users/message/index')),
                array('label' => '用户管理', 'url' => array('/users/user/admin')),
                array('label' => '用户分组管理', 'url' => array('/users/usergroup/index')),
            )),
        array('label' => '<i class="margin-right-5 icon icon-menu"></i>基础功能', 'url' => 'javascript:;', 'submenuOptions' => array('class' => 'nav-SubMenu'), 'items' => array(
                array('label' => '消息管理', 'url' => array('/basis/welcome/index')),
                array('label' => '自定义菜单', 'url' => array('/basis/menu/index')),
                array('label' => '微信素材', 'url' => array('/basis/sourcefile/morenews')),
                array('label' => '微信二维码', 'url' => array('/basis/quickmark/index')),
                array('label' => '群发功能', 'url' => array('/basis/push/index')),
            )),
        array('label' => '<i class="margin-right-5 icon icon-menu"></i>公众号中心', 'url' => 'javascript:;', 'submenuOptions' => array('class' => 'nav-SubMenu'), 'items' => array(
                array('label' => '公众号列表', 'url' => array('/publics/wcpublic')),
                array('label' => '创建公众号', 'url' => array('/publics/wcpublic/create')),
                array('label' => '公众号常见问题', 'url' => array('/publics/wcpublic/news')),
            )),
    ),
    /* --------------------客服  菜单项数组---------------------- */
    'KEFULEFTMENU' => array(
        array('label' => '<i class="margin-right-5 icon icon-menu"></i>用户中心', 'url' => 'javascript:;', 'submenuOptions' => array('class' => 'nav-SubMenu'), 'items' => array(
                array('label' => '消息中心', 'url' => array('/users/message')),
            )),
    ),
);
