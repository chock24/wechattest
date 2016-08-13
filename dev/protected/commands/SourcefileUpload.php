<?php

/**
 * 自动化执行 命令行模式
 */
class SourcefileUpload extends CConsoleCommand {

    public function run($args) {
        $subsidiaryids = array();
        //查询主公众号的素材------单图文
        $dataProvider = Yii::app()->db->createCommand()
                ->select('*')
                ->from('{{source_file}}')
                ->where('public_id=1 and isdelete=0 and status=0 and type = 5')
                ->queryAll(); //查询用户列表数据
        //查询多有多图文 
        $moreimagetext = Yii::app()->db->createCommand()
                ->select('id,admin_id,public_id,title,description')
                ->from('{{source_file_group}}')
                ->where('public_id=1 and isdelete=0 and status=0 ')
                ->queryAll();
        /* -----------------获取托管公众号列表------------------ */
        $publics = Yii::app()->db->createCommand()
                ->select(array('id', 'appid', 'appsecret', 'admin_id'))
                ->from('{{public}}')
                ->where('isdelete=0 and trust=1')
                ->queryAll(); //查询公众号数据

        $publicDataProvider = array();
        if (!empty($publics) && is_array($publics)) {
            foreach ($publics as $public) {
                $publicDataProvider[$public['id']]['appid'] = $public['appid'];
                $publicDataProvider[$public['id']]['appsecret'] = $public['appsecret'];
            }
        }
        /* -----------------获取托管公众号列表------------------ */


        //判断主公众号 单图文 是否存在
        if (!empty($dataProvider)) {
            //循环单图文 信息
            foreach ($dataProvider as $key => $sf) {
                /* 首先复制主公众号 单图文 给托管账号
                 * 循环托管公众号 查询是否存在该单图文
                 */
                foreach ($publics as $k => $ps) {
                    $appid = $ps['appid'];
                    $appsecret = $ps['appsecret'];
                    $subsidiaryids[$k] = $ps['id'];
                    $subsidiarysourcefile = Yii::app()->db->createCommand()
                            ->select('id')
                            ->from('{{source_file}}')
                            ->where('public_id=' . $ps['id'] . ' and isdelete=0 and type = 5 and title="' . $sf['title'] . '"')
                            ->queryRow();
                    //如果 存在
                    if (!empty($subsidiarysourcefile)) {
                        //  echo '存在<br/>';
                    }
                    //插入 单图文 给对应的附属公众号
                    else {
                        $row = Yii::app()->db->createCommand()->insert('wc_source_file', array(
                            'admin_id' => $ps['admin_id'],
                            'public_id' => $ps['id'],
                            'type' => '5',
                            'public_name' => $sf['public_name'],
                            'public_url' => $sf['public_url'],
                            'title' => $sf['title'],
                            'filename' => $sf['filename'],
                            'length' => $sf['length'],
                            'author' => $sf['author'],
                            'description' => $sf['description'],
                            'show_content' => $sf['show_content'],
                            'content' => $sf['content'],
                            'content_source_url' => $sf['content_source_url'],
                            'ext' => $sf['ext'],
                            'size' => $sf['size'],
                            'time_created' => time(),
                            'time_updated' => time(),
                        ));
                        if ($row == 1) {
                            //添加成功
                        }
                    }
                }
            }

            /* ---------------------------查询所有托管公众号的图文素材--循环上传微信服务器--------------------------- */
            $subids = implode(',', $subsidiaryids);
            $subsidiarySource = Yii::app()->db->createCommand()
                    ->select('*')
                    ->from('{{source_file}}')
                    ->where('type = 5 and public_id in (' . $subids . ')')
                    ->queryAll(); //查询用户列表数据

            if (!empty($subsidiarySource)) {
                //循环 所有托管公众号 素材 并添加到微信服务器
                foreach ($subsidiarySource as $subkey => $subsource) {
                    $publicmodel = Yii::app()->db->createCommand()
                            ->select(array('id', 'appid', 'appsecret'))
                            ->from('{{public}}')
                            ->where('isdelete=0 and id = ' . $subsource['public_id'])
                            ->queryRow();

                    if (!empty($publicmodel)) {

                        // 对应的公众号 的appid  和 appsecret
                        $wechatInfo = $this->returnWechatInfo($subsource['id'], 0, $publicmodel['appid'], $publicmodel['appsecret'], $publicmodel['id']); //返回微信端数据    
                    }
                }
            }
        }

        //判断主公众号 多图文 是否存在
        if (!empty($moreimagetext)) {
            //循环单图文 信息
            foreach ($moreimagetext as $key => $mt) {
                /* 首先复制主公众号 单图文 给托管账号
                 * 循环托管公众号 查询是否存在该单图文
                 */
                foreach ($publics as $k => $ps) {
                    $appid = $ps['appid'];
                    $appsecret = $ps['appsecret'];
                    $subsidiaryids[$k] = $ps['id'];
                    //查询 该多图文 是否存在
                    $subsidiarysourcefile = Yii::app()->db->createCommand()
                            ->select('id')
                            ->from('{{source_file_group}}')
                            ->where('public_id=' . $ps['id'] . ' and isdelete=0 and title="' . $mt['title'] . '"')
                            ->queryRow();
                    //如果 存在
                    if (!empty($subsidiarysourcefile)) {
                        //  echo '存在<br/>';
                    }
                    //插入 单图文 给对应的附属公众号
                    else {

                        $row = Yii::app()->db->createCommand()->insert('wc_source_file_group', array(
                            'admin_id' => $ps['admin_id'],
                            'public_id' => $ps['id'],
                            'title' => $mt['title'],
                            'description' => $mt['description'],
                            'time_created' => time(),
                            'time_updated' => time(),
                        ));
                        if ($row == 1) {
                            $group_id = Yii::app()->db->getLastInsertID();
                            //根据 分组 id 查询 source_file_detail 信息
                            $sourcefiledetail = Yii::app()->db->createCommand()
                                    ->select('group_id,file_id,sort')
                                    ->from('{{source_file_detail}}')
                                    ->where('group_id = ' . $mt['id'])
                                    ->queryAll();
                            if (!empty($sourcefiledetail)) {
                                foreach ($sourcefiledetail as $key => $sf) {
                                    $row = Yii::app()->db->createCommand()->insert('wc_source_file_detail', array(
                                        'group_id' => $group_id,
                                        'file_id' => $sf['file_id'],
                                        'sort' => $sf['sort'],
                                        'time_created' => time(),
                                        'time_updated' => time(),
                                    ));
                                }
                            }

                            //添加成功
                        }
                    }
                }
            }

            /* ---------------------------查询所有托管公众号的图文素材--循环上传微信服务器--------------------------- */
            $subids = implode(',', $subsidiaryids);
            $subsidiarySource = Yii::app()->db->createCommand()
                    ->select('*')
                    ->from('{{source_file}}')
                    ->where('type = 5 and public_id in (' . $subids . ')')
                    ->queryAll(); //查询用户列表数据

            if (!empty($subsidiarySource)) {
                //循环 所有托管公众号 素材 并添加到微信服务器
                foreach ($subsidiarySource as $subkey => $subsource) {
                    $publicmodel = Yii::app()->db->createCommand()
                            ->select(array('id', 'appid', 'appsecret'))
                            ->from('{{public}}')
                            ->where('isdelete=0 and id = ' . $subsource['public_id'])
                            ->queryRow();

                    if (!empty($publicmodel)) {
                        // 对应的公众号 的appid  和 appsecret
                        $wechatInfo = $this->returnWechatInfo($subsource['id'], 0, $publicmodel['appid'], $publicmodel['appsecret'], $publicmodel['id']); //返回微信端数据    
                    }
                }
            }
            //查询 多图文 所有集合
            $imgtextmodel = Yii::app()->db->createCommand()
                    ->select('*')
                    ->from('{{source_file_group}}')
                    ->where('public_id in (' . $subids . ')')
                    ->queryAll(); //查询用户列表数据
            if (!empty($imgtextmodel)) {
                foreach ($imgtextmodel as $key => $itms) {
                    //多图文
                    $wechatInfo = $this->returnWechatInfo($itms['id'], 1, $publicmodel['appid'], $publicmodel['appsecret'], $publicmodel['id']); //返回微信端数据       
                }
            }
        }
    }

    /**
     * 返回每个图文部分
     * @param int $id
     */
    private function returnPart($id = 0, $appid = 0, $appsecret = 0, $public_id = 0) {
        $dataProvider = array();
        $model = Yii::app()->db->createCommand()
                ->select(array('id',
                    'type',
                    'author',
                    'title',
                    'description',
                    'show_content',
                    'content_source_url',
                    'content',
                    'filename',
                    'ext'))
                ->from('{{source_file}}')
                ->where('public_id=' . $public_id . ' and isdelete=0 and status=0 and type = 5 and id = ' . $id)
                ->queryRow();

        $media = Yii::app()->db->createCommand()
                ->select(array('media_create_time', 'media_id',))
                ->from('{{media_id}}')
                ->where('public_id = ' . $public_id . ' and isdelete=0 and multi=0 and type = 5 and source_file_id = ' . $id)
                ->order('time_created DESC')
                ->queryRow();

        if ($model !== null) {//如果素材存在
            $differ = time() - $media['media_create_time'];
            if ($media !== null && ( $differ < 2.5 * 24 * 60 * 60)) {//如果media存在
                $dataProvider['thumb_media_id'] = $media['media_id'];
                $dataProvider['author'] = $model['author'];
                $dataProvider['title'] = $model['title'];
                $dataProvider['description'] = $model['description'];
                $dataProvider['content_source_url'] = $model['content_source_url'];
                $dataProvider['content'] = $model['content'];
                $dataProvider['show_content'] = $model['show_content'];
            } else {
                $publicArr = array(
                    'appid' => $appid,
                    'appsecret' => $appsecret,
                );
                $access_token = WechatStaticMethod::getAccessToken($publicArr);
                //  echo $access_token;exit;
                $url = "http://file.api.weixin.qq.com/cgi-bin/media/upload?access_token=$access_token&type=thumb";
                $postArr = array();
                if (class_exists('\CURLFile', FALSE)) {
                    $postArr['media'] = new CURLFile(PublicStaticMethod::returnFilePath('sourcefile', $model['filename'], $model['ext'], 'image', 'thumb'));
                } else {
                    $postArr['media'] = '@' . PublicStaticMethod::returnFilePath('sourcefile', $model['filename'], $model['ext'], 'image', 'thumb');
                }
                $result = WechatStaticMethod::https_request($url, $postArr);
                $result = json_decode($result, true);
                if (isset($result['thumb_media_id'])) {
                    //新增 微信端 mediaid 数据
                    $row = Yii::app()->db->createCommand()->insert('wc_media_id', array(
                        'type' => $model['type'],
                        'multi' => 0,
                        'thumb' => 1,
                        'source_file_id' => $model['id'],
                        'media_id' => $result['thumb_media_id'],
                        'media_create_time' => (int) $result['created_at'],
                        'time_created' => time(),
                        'time_updated' => time(),
                    ));
                    //添加成功
                    if ($row > 0) {
                        $dataProvider['thumb_media_id'] = $result['thumb_media_id'];
                        $dataProvider['author'] = $model['author'];
                        $dataProvider['title'] = $model['title'];
                        $dataProvider['description'] = $model['description'];
                        $dataProvider['content_source_url'] = $model['content_source_url'];
                        $dataProvider['content'] = $model['content'];
                        $dataProvider['show_content'] = $model['show_content'];
                    }
                } else {
                    return false;
                }
            }
        }

        return $dataProvider;
    }

    /**
     * 返回微信服务器数据
     * @param int $id
     * @param int $multi
     */
    private function returnWechatInfo($id = 0, $multi = 0, $appid = 0, $appsecret = 0, $public_id = 0) {
        if ($id) {
            $dataProvider = array();
            if ($multi == 1) {
                $sourceFileDetail = Yii::app()->db->createCommand()
                        ->select('file_id')
                        ->from('{{source_file_detail}}')
                        ->where('group_id =' . $id)
                        ->queryAll();
                if (is_array($sourceFileDetail) && !empty($sourceFileDetail)) {
                    foreach ($sourceFileDetail as $value) {
                        $dataProvider[] = $this->returnPart($value['file_id'], $appid, $appsecret, $public_id);
                    }
                }
            } else {
                $dataProvider[] = $this->returnPart($id, $appid, $appsecret, $public_id);
            }
            return $this->processNews($dataProvider, $appid, $appsecret, $public_id);
        }
    }

    /**
     * 提交图文数据到微信数据库
     * @param array $dataProvider 图文数据
     * return 返回
      {
      "type":"news",
      "media_id":"CsEf3ldqkAYJAU6EJeIkStVDSvffUJ54vqbThMgplD-VJXXof6ctX5fI6-aYyUiQ",
      "created_at":1391857799
      }
     */
    private function processNews($dataProvider = array(), $appid = 0, $appsecret = 0, $public_id = 0) {
        if (is_array($dataProvider) && !empty($dataProvider)) {
            foreach ($dataProvider as &$item) {
                if (empty($item)) {
                    return false;
                }
                foreach ($item as $key => $value) {
                    //将""转化为单引号，转化为html实体后编码
                    if ($key == 'content') {
                        $item[$key] = urlencode(htmlspecialchars(str_replace("\"", "'", $value)));
                    } else {
                        $item[$key] = urlencode($value);
                    }
                }
            }
            $datas = '{"articles":[';
            foreach ($dataProvider as $key => $value) {
                $datas = $datas . '{';
                $datas = $datas . "\"thumb_media_id\":" . "\"" . $value['thumb_media_id'] . "\",";
                $datas = $datas . "\"author\":" . "\"" . $value['author'] . "\",";
                $datas = $datas . "\"title\":" . "\"" . $value['title'] . "\",";
                $datas = $datas . "\"content_source_url\":" . "\"" . $value['content_source_url'] . "\",";
                $datas = $datas . "\"content\":" . "\"" . $value['content'] . "\",";
                $datas = $datas . "\"digest\":" . "\"" . $value['description'] . "\",";
                $datas = $datas . "\"show_cover_pic\":" . "\"" . $value['show_content'] . "\"";
                $datas = $datas . '},';
            }
            $datas = trim($datas, ',');
            $datas = $datas . ']}';
            $datas = urldecode($datas);
            $datas = htmlspecialchars_decode($datas);
            $publicArr = array(
                'appid' => $appid,
                'appsecret' => $appsecret,
            );
            $access_token = WechatStaticMethod::getAccessToken($publicArr);
            $url = "https://api.weixin.qq.com/cgi-bin/media/uploadnews?access_token=$access_token";
            $result = WechatStaticMethod::https_request($url, $datas);

            return json_decode($result, true);
        }
    }

}
