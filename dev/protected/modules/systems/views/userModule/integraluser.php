<title>积分记录</title>

<body class="bj_fff">
    <section class="wrap">
        <div class="wo_paging">
            <div class="wo_paging_hea">
                <h3><?php echo $user->nickname; ?></h3>
                <p>您目前积分为：<em><?php echo $user->integral; ?>分</em></p>
                <div class="wo_paging_det">
                    <label>我的积分明细：</label>
                    <div class="wo_paging_section">
                        <div class="wo_paging_section_txt">请选择</div>
                        <ul class="none">
                            <li data-id='1'>最近一周明细</li>
                            <li data-id='2'>最近一月明细</li>
                            <li data-id='3'>最近三月明细</li>
                            <li data-id='4'>三月前明细</li>
                        </ul>
                        <a href="javascript:;">&or;</a>
                    </div>
                </div>
            </div>
            <div class="wo_paging_con">
                <table class="wo_paging_tab">
                    <thead>
                        <tr>
                            <th>积分来源</th>
                            <th width="20%">收入/支出</th>
                            <th width="20%">时间</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (!empty($userintegral)) {
                            foreach ($userintegral as $u) {
                                ?>
                                <tr>
                                    <td><?php echo $u->cause; ?><br/></td>
                                    <td><?php echo $u->score; ?></td>
                                    <td><?php echo date('Y-m-d', $u->time_created); ?><br/></td>
                                </tr>
                                <?php
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <?php
            if (!empty($_GET['date'])) {
                $date = $_GET['date'];
            }
            ?>
            <a href="<?php echo Yii::app()->createUrl('systems/userModule/integraluser', array('date' => @$date)); ?>" class="wo_paging_more">
                ......<br/>
                查看更多

            </a>
        </div>
    </section>

    <script type="text/javascript">
        $(function () {
            $('.wo_paging_section').find('a').click(function () {
                $('.wo_paging_section').find('ul').show();
            });
            $('.wo_paging_section').find('ul li').click(function () {
                $(this).parent().hide().prev().html($(this).html());
                if ($(this).attr('data-id') == 1) {
                    window.location.href = "<?php echo Yii::app()->createUrl('systems/userModule/integraluser', array('date' => '1', 'num' => 10)); ?>";
                } else if ($(this).attr('data-id') == 2) {
                    window.location.href = "<?php echo Yii::app()->createUrl('systems/userModule/integraluser', array('date' => '2', 'num' => 10)); ?>";
                } else if ($(this).attr('data-id') == 3) {
                    window.location.href = "<?php echo Yii::app()->createUrl('systems/userModule/integraluser', array('date' => '3', 'num' => 10)); ?>";
                } else if ($(this).attr('data-id') == 4) {
                    window.location.href = "<?php echo Yii::app()->createUrl('systems/userModule/integraluser', array('date' => '4', 'num' => 10)); ?>";
                }
            });
            var data_id = <?php
            if (!empty($date)) {
                echo $date;
            } else {
                echo 0;
            }
            ?>;//传过来的值
            $('.wo_paging_section').find('ul li').each(function () {
                if ($(this).attr('data-id') == data_id) {
                    $(this).parent().hide().prev().html($(this).html());
                    $('.wo_paging_more').attr('href', '<?php echo Yii::app()->createUrl('systems/userModule/integraluser', array('date' => $date)); ?>');
                }
            });
        })
    </script>
</body>