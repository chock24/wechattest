<title>好友关系</title>

<body class="bj_fff">
    <section class="wrap">

        <div class="apply_list_hold">
            <!-- 上一级邀请 -->
            <?php if (!empty($from_user)) { ?>
                <div class="apply_list_user_con">
                    <h3><?php echo $from_user->nickname; ?>邀请了我</h3>
                    <div class="apply_list_user">
                        <img src="<?php echo $from_user->headimgurl; ?>">
                    </div>
                    <a href="javascript:;"></a>
                </div>
            <?php } ?>
            <!-- 本人 -->
            <div class="apply_list_head_con">
                <div class="apply_list_head">
                    <img src="<?php echo $user->headimgurl; ?>">
                </div>
                <a href="javascript:;"></a>
            </div>
            <!-- 邀请的好友 -->
            <ul class="apply_list">

                <li class="apply">
                    <div class="favicon">
                        <a href="<?php echo Yii::app()->createUrl('systems/userModule/share',array('id'=>Yii::app()->request->getParam('id')))?>">
                            <span style="color: white">立即申请</span>
                        </a>
                    </div>
                </li>
                <?php
                if (!empty($ResultList)) {
                    foreach ($ResultList as $key => $r) {
                        if ($key < 8) {
                            ?>
                            <li>
                                <div class="favicon">
                                    <a href="javascript:;"></a>
                                    <div class="friends_head">
                                        <img src="<?php echo $r['headimgurl']; ?>">
                                    </div>
                                    <div class="friends_name">
                                        <span title="<?php echo $r['nickname']; ?>"><?php echo $r['nickname']; ?></span>
                                    </div>
                                </div>
                            </li>
                            <?php
                        }
                    }
                }
                ?>
            </ul>
            <div class="clear"></div>
            <div class="invitation_wz">邀请好友可获得<span>10积分/人</span>奖励哦！</div>
            <div class="friends_list">
                <ul>
                    <?php
                    if (!empty($ResultList)) {
                        if (count($ResultList) > 7) {
                            foreach ($ResultList as $key => $r) {
                                if ($key > 7) {
                                    ?>
                                    <li>
                                        <div class="person_name"><?php echo $r['nickname']; ?></div>
                                        <div class="date_time"><?php echo date('Y-m-d H:i:s',$r['time_created']); ?></div>
                                    </li>
                                    <?php
                                }
                            }
                        }
                    }
                    ?>
                </ul>
            </div>
        </div>
    </section>
    <script>
        $(function () {
            $('.apply_list li').each(function (index, element) {
                if (index == 0) {
                    $('.apply_list').addClass('apply_list_one');
                } else if (index == 1) {
                    $('.apply_list').addClass('apply_list_two');
                } else if (index == 2) {
                    $('.apply_list').addClass('apply_list_two apply_list_three');
                } else if (index == 3) {
                    $('.apply_list').removeClass('apply_list_one apply_list_two apply_list_three').addClass('apply_list_four');
                }
            })
             capture_c ($('.friends_name span'),8);//字符截取
        })
    </script>
</body>