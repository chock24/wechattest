<div class="background-white content">

    <div class="padding30">
        <h2 class="content-main-title">公众号管理</h2>
        <div>
            <div class="tabhost">
                <div class="tabhost-title">
                    <ul>
                        <li class="active">
                            <?php echo CHtml::link('公众号列表', array('index')); ?>
                        </li>
                        <li>
                            <?php
                            if (count($wcmmodel) < $adminmodel->bound) {
                                echo CHtml::link('创建公众号', array('create'));
                            }
                            ?></li>
                    </ul>
                    <div class="clear"></div>
                </div>

                <div class="right wechat-seek">
                    <form>
                        <div class="left wechat-seek-select">
                            <select>
                                <option value="1">订阅号</option>
                                <option value="2">订阅号</option>
                            </select>
                        </div>
                        <input type="text" class="left wechat-seek-input" size="30" placeholder="用户/信息">
                        <input type="submit" class="left wechat-seek-button" value="">
                    </form>
                </div>

                <div class="tabhost-center">
                    <div class="margin-top-15 padding10 investgames">
                        <div class="investgames-title">
                            <h4 class="left left">欧派家居集团</h4>
                            <span class="left color-9">地址：广东省广州市白云区广花三路366号</span>
                        </div>
                        <div class="clear"></div>
                        <div class="investgames-content">
                            <?php
                            $this->widget('zii.widgets.CListView', array(
                                'dataProvider' => $dataProvider,
                                'itemView' => '_view',
                                'emptyText' => '您的帐号下面并没有公众号，请您创建一个公众号以便您选择。',
                                'ajaxUpdate' => false,
                                'ajaxVar' => '',
                                'template' => '{items} {summary} {pager}',
                                'summaryText' => '公众号数:<span>{count}</span>  总页数:<span>{pages}</span>',
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
        </div>
    </div>
</div>