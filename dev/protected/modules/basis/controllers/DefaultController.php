<?php

class DefaultController extends Controller {

    public function actionIndex() {
        $this->render('index', array(
        ));
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
