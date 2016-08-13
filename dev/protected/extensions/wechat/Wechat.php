<?php

/**
 * WeichatCallback
 * @author 359426334@qq.com
 */
class Wechat {

    //$_GET参数
    public $signature;
    public $timestamp;
    public $nonce;
    public $echostr;
    //
    public $token;
    public $debug = false;
    public $msg = array();
    public $setFlag = false;

    /**
     * __construct
     *
     * @param mixed $params
     * @access public
     * @return void
     */
    public function __construct($params) {
        foreach ($params as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $value;
            }
        }
    }

    /**
     * valid
     *
     * @access public
     * @return void
     */
    public function valid() {
        //valid signature , option
        if ($this->checkSignature()) {
            echo $this->echostr;
            Yii::app()->end();
        }
    }

    /**
     * 获得用户发过来的消息（消息内容和消息类型  ）
     *
     * @access public
     * @return void
     */
    public function init() {
        $postStr = empty($GLOBALS["HTTP_RAW_POST_DATA"]) ? '' : $GLOBALS["HTTP_RAW_POST_DATA"];
        if ($this->debug) {
            $this->log($postStr);
        }
        if (!empty($postStr)) {
            $this->msg = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
        }
    }

    /**
     * makeEvent
     *
     * @access public
     * @return void
     */
    public function makeEvent($text = '') {
        $createTime = time();
        $funcFlag = $this->setFlag ? 1 : 0;
        $textTpl = "<xml>
            <ToUserName><![CDATA[{$this->msg->FromUserName}]]></ToUserName>
            <FromUserName><![CDATA[{$this->msg->ToUserName}]]></FromUserName>
            <CreateTime>{$createTime}</CreateTime>
            <MsgType><![CDATA[text]]></MsgType>
            <Content><![CDATA[%s]]></Content>
            <FuncFlag>%s</FuncFlag>
            </xml>";
        return sprintf($textTpl, $text, $funcFlag);
    }

    /**
     * makeEvent
     *
     * @access public
     * @return void
     */
    public function makeService() {
        $createTime = time();
        $funcFlag = $this->setFlag ? 1 : 0;
        $textTpl = "<xml>
            <ToUserName><![CDATA[{$this->msg->FromUserName}]]></ToUserName>
            <FromUserName><![CDATA[{$this->msg->ToUserName}]]></FromUserName>
            <CreateTime>{$createTime}</CreateTime>
            <MsgType><![CDATA[transfer_customer_service]]></MsgType>
            </xml>";
        return $textTpl;
    }

    /**
     * 回复文本消息 至 邀请人
     *
     * @param string $text
     * @access public
     * @return void
     */
    public function makeTexttofrom($text = '', $fromopenid) {
        $createTime = time();
        $funcFlag = $this->setFlag ? 1 : 0;
        $textTpl = "<xml>
          <ToUserName><![CDATA[$fromopenid]]></ToUserName>
            <FromUserName><![CDATA[{$this->msg->ToUserName}]]></FromUserName>
            <CreateTime>{$createTime}</CreateTime>
            <MsgType><![CDATA[text]]></MsgType>
            <Content><![CDATA[%s]]></Content>
            <FuncFlag>%s</FuncFlag>
            </xml>";
        return sprintf($textTpl, $text, $funcFlag);
    }

    /**
     * 回复文本消息
     *
     * @param string $text
     * @access public
     * @return void
     */
    public function makeText($text = '') {
        $createTime = time();
        $funcFlag = $this->setFlag ? 1 : 0;
        $textTpl = "<xml>
            <ToUserName><![CDATA[{$this->msg->FromUserName}]]></ToUserName>
            <FromUserName><![CDATA[{$this->msg->ToUserName}]]></FromUserName>
            <CreateTime>{$createTime}</CreateTime>
            <MsgType><![CDATA[text]]></MsgType>
            <Content><![CDATA[%s]]></Content>
            <FuncFlag>%s</FuncFlag>
            </xml>";
        return sprintf($textTpl, $text, $funcFlag);
    }

    /**
     * 根据数组参数回复图文消息
     *
     * @param array $newsData
     * @access public
     * @return void
     */
    public function makeNews($newsData = array(), $userDataProvider = null) {
        $createTime = time();
        $funcFlag = $this->setFlag ? 1 : 0;
        $newTplHeader = "<xml>
            <ToUserName><![CDATA[{$this->msg->FromUserName}]]></ToUserName>
            <FromUserName><![CDATA[{$this->msg->ToUserName}]]></FromUserName>
            <CreateTime>{$createTime}</CreateTime>
            <MsgType><![CDATA[news]]></MsgType>
            <ArticleCount>%s</ArticleCount><Articles>";
        $newTplItem = "<item>
            <Title><![CDATA[%s]]></Title>
            <Description><![CDATA[%s]]></Description>
            <PicUrl><![CDATA[%s]]></PicUrl>
            <Url><![CDATA[%s]]></Url>
            </item>";
        $newTplFoot = "</Articles>
            <FuncFlag>%s</FuncFlag>
            </xml>";
        $content = '';
        $itemsCount = count($newsData['items']);
        //微信公众平台图文回复的消息一次最多10条
        $itemsCount = $itemsCount < 10 ? $itemsCount : 10;
        if ($itemsCount) {
            //更改欢迎语 替换用户信息
            if (!empty($userDataProvider)) {
                foreach ($newsData['items'] as $key => $item) {
                    if ($key <= 9) {
                        if ($key == 0) {
                            $content .= sprintf($newTplItem, $userDataProvider['nickname']."," . $item['title'], $item['description'], $item['picurl'], $item['url']);
                        } else if ($key == 1) {
                            $content .= sprintf($newTplItem, $item['title'], $item['description'], $userDataProvider['headimgurl'], $item['url']);
                        } else {
                            $content .= sprintf($newTplItem, $item['title'], $item['description'], $item['picurl'], $item['url']);
                        }
                    }
                }
            } else {
                foreach ($newsData['items'] as $key => $item) {
                    if ($key <= 9) {
                        $content .= sprintf($newTplItem, $item['title'], $item['description'], $item['picurl'], $item['url']);
                    }
                }
            }
        }
        $header = sprintf($newTplHeader, $itemsCount);
        $footer = sprintf($newTplFoot, $funcFlag);
        return $header . $content . $footer;
    }

    /**
     * makeImage
     *
     * @access public
     * @return void
     */
    public function makeImage($media_id = 0) {
        $createTime = time();
        $funcFlag = $this->setFlag ? 1 : 0;
        $textTpl = "<xml>
            <ToUserName><![CDATA[{$this->msg->FromUserName}]]></ToUserName>
            <FromUserName><![CDATA[{$this->msg->ToUserName}]]></FromUserName>
            <CreateTime>{$createTime}</CreateTime>
            <MsgType><![CDATA[image]]></MsgType>
            <Image>
            <MediaId><![CDATA[%s]]></MediaId>
            </Image>
            <FuncFlag>%s</FuncFlag>
            </xml>";
        return sprintf($textTpl, $media_id, $funcFlag);
    }

    /**
     * makeVoice
     *
     * @access public
     * @return void
     */
    public function makeVoice($media_id = 0) {
        $createTime = time();
        $funcFlag = $this->setFlag ? 1 : 0;
        $textTpl = "<xml>
            <ToUserName><![CDATA[{$this->msg->FromUserName}]]></ToUserName>
            <FromUserName><![CDATA[{$this->msg->ToUserName}]]></FromUserName>
            <CreateTime>{$createTime}</CreateTime>
            <MsgType><![CDATA[voice]]></MsgType>
            <Voice>
            <MediaId><![CDATA[%s]]></MediaId>
            </Voice>
            <FuncFlag>%s</FuncFlag>
            </xml>";
        return sprintf($textTpl, $media_id, $funcFlag);
    }

    /**
     * makeVideo
     *
     * @access public
     * @return void
     */
    public function makeVideo($media_id = 0, $title = '', $description = '') {
        $createTime = time();
        $funcFlag = $this->setFlag ? 1 : 0;
        $textTpl = "<xml>
            <ToUserName><![CDATA[{$this->msg->FromUserName}]]></ToUserName>
            <FromUserName><![CDATA[{$this->msg->ToUserName}]]></FromUserName>
            <CreateTime>{$createTime}</CreateTime>
            <MsgType><![CDATA[video]]></MsgType>
            <Video>
            <MediaId><![CDATA[%s]]></MediaId>
            <Title><![CDATA[%s]]></Title>
            <Description><![CDATA[%s]]></Description>
            </Video>
            <FuncFlag>%s</FuncFlag>
            </xml>";
        return sprintf($textTpl, $media_id, $title, $description, $funcFlag);
    }

    /**
     * makeMusic
     *
     * @access public
     * @return void
     */
    public function makeMusic($title = '', $description = '', $musicurl = '', $hqmusicurl = '', $media_id = 0) {
        $createTime = time();
        $funcFlag = $this->setFlag ? 1 : 0;
        $textTpl = "<xml>
            <ToUserName><![CDATA[{$this->msg->FromUserName}]]></ToUserName>
            <FromUserName><![CDATA[{$this->msg->ToUserName}]]></FromUserName>
            <CreateTime>{$createTime}</CreateTime>
            <MsgType><![CDATA[music]]></MsgType>
            <Music>
            <Title><![CDATA[%s]]></Title>
            <Description><![CDATA[%s]]></Description>
            <MusicUrl><![CDATA[%s]]></MusicUrl>
            <HQMusicUrl><![CDATA[%s]]></HQMusicUrl> 
            <ThumbMediaId><![CDATA[%s]]></ThumbMediaId>
            </Music>
            <FuncFlag>%s</FuncFlag>
            </xml>";
        return sprintf($textTpl, $title, $description, $musicurl, $hqmusicurl, $media_id, $funcFlag);
    }

    /**
     * reply
     *
     * @param mixed $data
     * @access public
     * @return void
     */
    public function reply($data) {
        if ($this->debug) {
            $this->log($data);
        }
        echo $data;
    }

    /**
     * checkSignature
     *
     * @access private
     * @return bool
     */
    private function checkSignature() {
        $tmpArr = array($this->token, $this->timestamp, $this->nonce);
        sort($tmpArr, SORT_STRING);
        $tmpStr = implode($tmpArr);
        $tmpStr = sha1($tmpStr);


        if ($tmpStr == $this->signature) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * log
     *
     * @access private
     * @return void
     */
    private function log($log) {
        if ($this->debug) {
            file_put_contents(Yii::getPathOfAlias('application') . '/runtime/weixin_log.txt', var_export($log, true) . "\n\r", FILE_APPEND);
        }
    }

}
