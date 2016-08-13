<title>个人兑换列表</title>

<body class="bj_fff">



    <section class="wrap">
        <header class="exchange_header">我的兑换</header>
        <div class="exchange_con">
            <table class="exchange_tab">
                <thead>
                    <tr>
                        <th width="30%">商品名称</th>
                        <th width="20%">数量</th>
                        <th width="25%">消耗积分</th>
                        <th width="25%">时间</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (!empty($giftexchange)) {
                        foreach ($giftexchange as $g) {
                            ?>
                            <?php /*                        echo $g->gift_name;
                              echo $g->sheng->name . $g->shi->name . $g->qu->name . $g->address_other;
                              echo '邮编' . $g->postcode;
                              echo'手机' . $g->tel;
                              echo '分值' . $g->score;
                              echo '备注' . $g->remark;
                              echo '状态' . $g->status;
                              echo '备注' . $g->remark;
                              echo '时间' . $g->time_created;
                              echo '<br/>';
                             */ ?>

                            <tr>
                                <td><?php echo $g->gift_name; ?></td>
                                <td>1</td>
                                <td><?php echo $g->score; ?></td>
                                <td><?php echo date('Y-m-d',$g->time_created); ?></td>
                            </tr>

        <?php
    }
}
?>
                </tbody>
            </table>
            <div class="exchange_paging">
                <a href="javascript:;">上一页</a>
                <span>1</span>
                <a href="javascript:;">下一页</a>
            </div>
        </div>

    </section>


</body>