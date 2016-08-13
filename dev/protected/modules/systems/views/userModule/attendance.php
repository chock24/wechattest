<head>
    <title>签到</title>
</head>
<body>
    <section class="wrap">
        <div class="hold">
            <div class="tit">赶快领取奖励吧！</div>
            <div class="tit_bd">
                <div class="user_avatar hold_avatar">
                    <img src="<?php echo $model->headimgurl; ?>">
                </div>
                <div class="integral">积分：<span><?php echo $model->integral; ?>分</span></div>
                <div class="sign">本月签到：<span><?php echo $monthcount; ?></span>天</div>
            </div>
            <div class="clear"></div>
            <div class="hold_con">
                <div class="hold_con_tit"></div>
                <div class="hold_con_c">
                    <h3>签到奖励</h3>
                    <ul>
                        <li>1
                            <div class="hold_popup">第一天<span>+1分</span><i></i></div>
                        </li>
                        <li>2
                            <div class="hold_popup">第二天<span>+2分</span><i></i></div>
                        </li>
                        <li>3
                            <div class="hold_popup">第三天<span>+3分</span><i></i></div>
                        </li>
                        <li>4
                            <div class="hold_popup">第四天<span>+4分</span><i></i></div>
                        </li>
                        <li>5
                            <div class="hold_popup">第五天<span>+5分</span><i></i></div>
                        </li>
                        <li>6
                            <div class="hold_popup">第六天<span>+5分</span><i></i></div>
                        </li>
                        <li>7
                            <div class="hold_popup">第七天<span>+5分</span><i></i></div>
                        </li>
                    </ul>
                    <div class="clear"></div>
                    <p>签到的天数越多，获得的积分越多。<a href="<?php echo Yii::app()->createUrl('systems/userModule/attendancerule') ?>">查看规则</a></p>
                    <a class="hold_but" href="javascript:;">签到</a>
                </div>
            </div>
        </div>
        <div class="popup_bj">
            <div class="popup">
                <div class="popup_con">
                    <a href="javascript:;" class="popup_x"></a>
                    <div class="pop_icon"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/font/popup/popup_jf.png" /></div>
                    <h4>恭喜您获得<span>2个积分</span>!</h4>
                    <em>您已经签到<i></i>天，坚持签到有<br/>意外收获哦!</em>
                </div>
            </div>
        </div>
    </section>

    <script type="text/javascript">
        $(function () {
<?php if (!empty($userintegral) && empty($todayuserintegral)) { ?>
                var $todaycount = <?php echo $userintegral->sign_in_count; ?>;//默认进来用户有多少积分
                var $todaycount2 = <?php echo $userintegral->sign_in_count; ?>;//判断是否已经签到
<?php } else if (!empty($todayuserintegral)) { ?>
                var $todaycount = <?php echo $todayuserintegral->sign_in_count; ?>;//默认进来用户有多少积分
                var $todaycount2 = <?php echo $todayuserintegral->sign_in_count; ?>;//判断是否已经签到
<?php } else { ?>
                var $todaycount = 0;//默认进来用户有多少积分 
                var $todaycount2 = 0;
<?php } ?>
            var $todaycount1 = 0;//点击签到要加几分
            var $integral;
            if ($todaycount == 0) {
            } else if ($todaycount == 2 || ($todaycount % 7 == 2)) {

                $integral = 1;
            } else if ($todaycount == 3 || ($todaycount % 7 == 3)) {
                $integral = 2;
            } else if ($todaycount == 4 || ($todaycount % 7 == 4)) {
                $integral = 3;
            } else if ($todaycount == 5 || ($todaycount % 7 == 5)) {
                $integral = 4;
            } else if ($todaycount == 6 || ($todaycount % 7 == 6)) {
                $integral = 5;
            } else if ($todaycount == 7 || ($todaycount % 7 == 7)) {
                $integral = 6;
            } else if ($todaycount == 8 || ($todaycount % 7 == 1) || $todaycount == 1) {
                $integral = 0;
            }
            $('.hold_con_c').find('li').each(function () {
                if ($(this).index() <= $integral) {
                    $(this).addClass('on');
                }
            });
            $('.hold_popup').eq($integral).fadeIn('slow').parent().siblings().find('.hold_popup').hide();
            $('.hold_but').click(function () {
                var ind = $('.hold_con_c').find('li.on').length;
                function hole_but(ind) {
                    $('.hold_con_c').find('li').eq(ind).addClass('on');
                    $('.hold_popup').eq(ind).fadeIn('slow').parent().siblings().find('.hold_popup').hide();
                    if (ind >= 5) {
                        $todaycount1 = 5;
                    } else {
                        $todaycount1 = ind + 1;
                    }
                }
                hole_but(ind);
                if (ind >= 7) {
                    hole_but(0);
                    $('.hold_con_c').find('li').eq(0).siblings().removeClass('on');
                }
                //alert($todaycount1);//弹出值
                $('.integral').html(<?php echo $model->integral; ?> + $todaycount1 + '分');
                $('.sign').find('span').html(parseInt($('.sign').find('span').html()) + 1);
                var url = "<?php echo Yii::app()->createUrl('systems/userModule/postattendance'); ?>";
                var qs = '<?php echo $openid; ?>';
                $.post(url, {queryString: qs},
                function (data) {
                    // $todaycount2 = data;
                });
                $('.popup_bj').show().find('.popup_con').show().find('h4 span').html($todaycount1 + '个积分');
                if (ind >= 7)
                    ind = 0;
                $('.popup_con').find('em i').html(ind + 1);
                $(this).unbind().css('background', '#c2c2c2');
                setTimeout(function () {
                    location.href = 'http://wechat.oppein.cn/systems/userModule/homepage.html'
                }, 2000);

            });
            var nowtime = Date.parse(new Date().toLocaleDateString());
            var lasttime = <?php echo $model->last_attendance_time; ?> + '000';
            if (nowtime == lasttime) {
                $('.hold_but').unbind().css('background', '#c2c2c2');
            }
        })
    </script>
</body>
