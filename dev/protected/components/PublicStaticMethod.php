<?php

/*
 * 公共函数类
 */

class PublicStaticMethod {

    /**
     * 生成时间戳+随机数文件名
     */
    public static function generateFileName() {
        return date('YmdHis') . rand(100000, 999999);
    }

    /**
     * 截取字符串
     * @param string 要截取的字符串 
     * @param length 要截取的长度
     * @param etc 要保留的结尾，不需要为空
     */
    public static function truncate_utf8_string($string, $length, $etc = '..') {
        $result = '';
        $string = html_entity_decode(trim(strip_tags($string)), ENT_QUOTES, 'UTF-8');
        $strlen = strlen($string);
        for ($i = 0; (($i < $strlen) && ($length > 0)); $i++) {
            if ($number = strpos(str_pad(decbin(ord(substr($string, $i, 1))), 8, '0', STR_PAD_LEFT), '0')) {
                if ($length < 1.0) {
                    break;
                }
                $result .= substr($string, $i, $number);
                $length -= 1.0;
                $i += $number - 1;
            } else {
                $result .= substr($string, $i, 1);
                $length -= 0.5;
            }
        }
        $result = htmlspecialchars($result, ENT_QUOTES, 'UTF-8');
        if ($i < $strlen) {
            $result .= $etc;
        }
        return $result;
    }

    /**
     * 得到所有地区信息缓存
     * 组成数组
     */
    public static function getDistrictDataProvider() {
        if (Yii::app()->cache->get('district')) {
            return Yii::app()->cache->get('district');
        } else {
            $dataProvider = Yii::app()->db->createCommand()
                    ->select('id,name')
                    ->from('{{district}}')
                    ->where('isdelete=:isdelete',array(':isdelete'=>0))
                    ->queryAll();
            $district = array();
            if(is_array($dataProvider) && !empty($dataProvider)){
                foreach ($dataProvider as $value) {
                    $district[$value['id']] = $value['name'];
                }
            }
            Yii::app()->cache->set('district', $district);
            return $district;
        }
    }

    /**
     * 將字符替换成表情
     * @param $string $content 
     */
    public static function replaceQqFace($content) {
        $content = str_replace('/::)', CHtml::image(Yii::app()->baseUrl . '/images/arclist/1.gif'), $content);
        $content = str_replace('/::~', CHtml::image(Yii::app()->baseUrl . '/images/arclist/2.gif'), $content);
        $content = str_replace('/::B', CHtml::image(Yii::app()->baseUrl . '/images/arclist/3.gif'), $content);
        $content = str_replace('/::|', CHtml::image(Yii::app()->baseUrl . '/images/arclist/4.gif'), $content);
        $content = str_replace('/::<', CHtml::image(Yii::app()->baseUrl . '/images/arclist/5.gif'), $content);
        $content = str_replace('/::$', CHtml::image(Yii::app()->baseUrl . '/images/arclist/6.gif'), $content);
        $content = str_replace('/::x', CHtml::image(Yii::app()->baseUrl . '/images/arclist/7.gif'), $content);
        $content = str_replace('/::z', CHtml::image(Yii::app()->baseUrl . '/images/arclist/8.gif'), $content);
        $content = str_replace('/::\'(', CHtml::image(Yii::app()->baseUrl . '/images/arclist/9.gif'), $content);
        $content = str_replace('/::-|', CHtml::image(Yii::app()->baseUrl . '/images/arclist/10.gif'), $content);
        $content = str_replace('/::@', CHtml::image(Yii::app()->baseUrl . '/images/arclist/11.gif'), $content);
        $content = str_replace('/::p', CHtml::image(Yii::app()->baseUrl . '/images/arclist/12.gif'), $content);
        $content = str_replace('/::D', CHtml::image(Yii::app()->baseUrl . '/images/arclist/13.gif'), $content);
        $content = str_replace('/::O', CHtml::image(Yii::app()->baseUrl . '/images/arclist/14.gif'), $content);
        $content = str_replace('/::(', CHtml::image(Yii::app()->baseUrl . '/images/arclist/15.gif'), $content);
        $content = str_replace('/:-b', CHtml::image(Yii::app()->baseUrl . '/images/arclist/16.gif'), $content);
        $content = str_replace('/::Q', CHtml::image(Yii::app()->baseUrl . '/images/arclist/17.gif'), $content);
        $content = str_replace('/::T', CHtml::image(Yii::app()->baseUrl . '/images/arclist/18.gif'), $content);
        $content = str_replace('/:,@P', CHtml::image(Yii::app()->baseUrl . '/images/arclist/19.gif'), $content);
        $content = str_replace('/:,@-D', CHtml::image(Yii::app()->baseUrl . '/images/arclist/20.gif'), $content);
        $content = str_replace('/::d', CHtml::image(Yii::app()->baseUrl . '/images/arclist/21.gif'), $content);
        $content = str_replace('/:,@o', CHtml::image(Yii::app()->baseUrl . '/images/arclist/22.gif'), $content);
        $content = str_replace('/::g', CHtml::image(Yii::app()->baseUrl . '/images/arclist/23.gif'), $content);
        $content = str_replace('/:|-)', CHtml::image(Yii::app()->baseUrl . '/images/arclist/24.gif'), $content);
        $content = str_replace('/::!', CHtml::image(Yii::app()->baseUrl . '/images/arclist/25.gif'), $content);
        $content = str_replace('/::L', CHtml::image(Yii::app()->baseUrl . '/images/arclist/26.gif'), $content);
        $content = str_replace('/::>', CHtml::image(Yii::app()->baseUrl . '/images/arclist/27.gif'), $content);
        $content = str_replace('/::,@', CHtml::image(Yii::app()->baseUrl . '/images/arclist/28.gif'), $content);
        $content = str_replace('/:,@f', CHtml::image(Yii::app()->baseUrl . '/images/arclist/29.gif'), $content);
        $content = str_replace('/::-S', CHtml::image(Yii::app()->baseUrl . '/images/arclist/30.gif'), $content);
        $content = str_replace('/:?', CHtml::image(Yii::app()->baseUrl . '/images/arclist/31.gif'), $content);
        $content = str_replace('/:,@x', CHtml::image(Yii::app()->baseUrl . '/images/arclist/32.gif'), $content);
        $content = str_replace('/:,@@', CHtml::image(Yii::app()->baseUrl . '/images/arclist/33.gif'), $content);
        $content = str_replace('/::8', CHtml::image(Yii::app()->baseUrl . '/images/arclist/34.gif'), $content);
        $content = str_replace('/:,@!', CHtml::image(Yii::app()->baseUrl . '/images/arclist/35.gif'), $content);
        $content = str_replace('/:xx', CHtml::image(Yii::app()->baseUrl . '/images/arclist/36.gif'), $content);
        $content = str_replace('/:bye', CHtml::image(Yii::app()->baseUrl . '/images/arclist/37.gif'), $content);
        $content = str_replace('/:wipe', CHtml::image(Yii::app()->baseUrl . '/images/arclist/38.gif'), $content);
        $content = str_replace('/:dig', CHtml::image(Yii::app()->baseUrl . '/images/arclist/39.gif'), $content);
        $content = str_replace('/:&-(', CHtml::image(Yii::app()->baseUrl . '/images/arclist/40.gif'), $content);
        $content = str_replace('/:B-)', CHtml::image(Yii::app()->baseUrl . '/images/arclist/41.gif'), $content);
        $content = str_replace('/:<@', CHtml::image(Yii::app()->baseUrl . '/images/arclist/42.gif'), $content);
        $content = str_replace('/:@>', CHtml::image(Yii::app()->baseUrl . '/images/arclist/43.gif'), $content);
        $content = str_replace('/::-O', CHtml::image(Yii::app()->baseUrl . '/images/arclist/44.gif'), $content);
        $content = str_replace('/:>-|', CHtml::image(Yii::app()->baseUrl . '/images/arclist/45.gif'), $content);
        $content = str_replace('/:P-(', CHtml::image(Yii::app()->baseUrl . '/images/arclist/46.gif'), $content);
        $content = str_replace("/::'|", CHtml::image(Yii::app()->baseUrl . '/images/arclist/47.gif'), $content);
        $content = str_replace('/:X-)', CHtml::image(Yii::app()->baseUrl . '/images/arclist/48.gif'), $content);
        $content = str_replace('/::*', CHtml::image(Yii::app()->baseUrl . '/images/arclist/49.gif'), $content);
        $content = str_replace('/:@x', CHtml::image(Yii::app()->baseUrl . '/images/arclist/50.gif'), $content);
        $content = str_replace('/:8*', CHtml::image(Yii::app()->baseUrl . '/images/arclist/51.gif'), $content);
        $content = str_replace('/:hug', CHtml::image(Yii::app()->baseUrl . '/images/arclist/52.gif'), $content);
        $content = str_replace('/:sun', CHtml::image(Yii::app()->baseUrl . '/images/arclist/53.gif'), $content);
        $content = str_replace('/:moon', CHtml::image(Yii::app()->baseUrl . '/images/arclist/54.gif'), $content);
        $content = str_replace('/:bome', CHtml::image(Yii::app()->baseUrl . '/images/arclist/55.gif'), $content);
        $content = str_replace('/:!!!', CHtml::image(Yii::app()->baseUrl . '/images/arclist/56.gif'), $content);
        $content = str_replace('/:pd', CHtml::image(Yii::app()->baseUrl . '/images/arclist/57.gif'), $content);
        $content = str_replace('/:pig', CHtml::image(Yii::app()->baseUrl . '/images/arclist/58.gif'), $content);
        $content = str_replace('/:<W>', CHtml::image(Yii::app()->baseUrl . '/images/arclist/59.gif'), $content);
        $content = str_replace('/:coffee', CHtml::image(Yii::app()->baseUrl . '/images/arclist/60.gif'), $content);
        $content = str_replace('/:eat', CHtml::image(Yii::app()->baseUrl . '/images/arclist/61.gif'), $content);
        $content = str_replace('/:heart', CHtml::image(Yii::app()->baseUrl . '/images/arclist/62.gif'), $content);
        $content = str_replace('/:strong', CHtml::image(Yii::app()->baseUrl . '/images/arclist/63.gif'), $content);
        $content = str_replace('/:weak', CHtml::image(Yii::app()->baseUrl . '/images/arclist/64.gif'), $content);
        $content = str_replace('/:share', CHtml::image(Yii::app()->baseUrl . '/images/arclist/65.gif'), $content);
        $content = str_replace('/:v', CHtml::image(Yii::app()->baseUrl . '/images/arclist/66.gif'), $content);
        $content = str_replace('/:@)', CHtml::image(Yii::app()->baseUrl . '/images/arclist/67.gif'), $content);
        $content = str_replace('/:jj', CHtml::image(Yii::app()->baseUrl . '/images/arclist/68.gif'), $content);
        $content = str_replace('/:ok', CHtml::image(Yii::app()->baseUrl . '/images/arclist/69.gif'), $content);
        $content = str_replace('/:no', CHtml::image(Yii::app()->baseUrl . '/images/arclist/70.gif'), $content);
        $content = str_replace('/:rose', CHtml::image(Yii::app()->baseUrl . '/images/arclist/71.gif'), $content);
        $content = str_replace('/:fade', CHtml::image(Yii::app()->baseUrl . '/images/arclist/72.gif'), $content);
        $content = str_replace('/:kiss', CHtml::image(Yii::app()->baseUrl . '/images/arclist/73.gif'), $content);
        $content = str_replace('/:love', CHtml::image(Yii::app()->baseUrl . '/images/arclist/74.gif'), $content);
        $content = str_replace('/:<L>', CHtml::image(Yii::app()->baseUrl . '/images/arclist/75.gif'), $content);
        return $content;
    }

    /**
     * 得到公众号数据
     * 组成数组
     */
    public static function getPublicDataProvider($admin_id = 0) {
        $criteria = new CDbCriteria();
        $criteria->select = 'id,title';
        $criteria->compare('admin_id', $admin_id);
        $criteria->compare('isdelete', 0);
        return WcPublic::model()->findAll($criteria);
    }
    
    /**
     * 得到未读消息数量
     * return int 数量
     */
    public static function getMessageCount($public_id = 0) {
        $criteria = new CDbCriteria();
        $criteria->select = 'COUNT(id)';
        $criteria->compare('public_id', $public_id);
        $criteria->compare('receive', 1);
        $criteria->compare('status', 1);
        $criteria->compare('isdelete', 0);
        return Message::model()->count($criteria);
    }

    /**
     * 返回素材绝对路径
     * @param string $fileName 文件名
     * @param string $ext 文件后缀名
     * @param string $type 传入素材类型
     * @param string $size 传入素材尺寸
     * 具体参照params文件里设置的参数
     */
    public static function returnSourceFile($fileName = '', $ext = '', $type = '', $size = '') {
        if (!empty($fileName) && !empty($ext)) {
            if (isset(Yii::app()->params->FILEPATH['sourcefile'][$type])) {
                if (isset(Yii::app()->params->FILEPATH['sourcefile'][$type][$size])) {
                    return Yii::app()->params->WEBROOT . Yii::app()->params->FILEFOLDER . Yii::app()->params->FILEPATH['sourcefile'][$type][$size] . $fileName . '.' . $ext;
                } else {
                    return Yii::app()->params->WEBROOT . Yii::app()->params->FILEFOLDER . Yii::app()->params->FILEPATH['sourcefile'][$type] . $fileName . '.' . $ext;
                }
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    /**
     * 返回文件的绝对路径
     * @param string $folder 文件夹
     * @param string $fileName 文件名
     * @param string $ext 文件后缀名
     * @param string $type 传入素材类型
     * @param string $size 传入素材尺寸
     * 具体参照params文件里设置的参数
     */
    public static function returnFile($folder = '', $fileName = '', $ext = '', $type = '', $size = '') {
        if (!empty($fileName)) {
            if (isset(Yii::app()->params->FILEPATH[$folder][$type])) {
                if (isset(Yii::app()->params->FILEPATH[$folder][$type][$size])) {
                    return Yii::app()->params->WEBROOT . Yii::app()->params->FILEFOLDER . Yii::app()->params->FILEPATH[$folder][$type][$size] . $fileName . '.' . $ext;
                } else {
                    return Yii::app()->params->WEBROOT . Yii::app()->params->FILEFOLDER . Yii::app()->params->FILEPATH[$folder][$type] . $fileName . '.' . $ext;
                }
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    /**
     * 返回图片素材路径(相对路径)
     * @param string $folder 文件夹
     * @param string $fileName 文件名
     * @param string $ext 文件后缀名
     * @param string $type 传入素材类型
     * @param string $size 传入素材尺寸
     * 具体参照params文件里设置的参数
     */
    public static function returnPath($folder = 'sourcefile', $fileName = '', $ext = '', $type = '', $size = '') {
        if (!empty($fileName) && !empty($ext)) {
            if (isset(Yii::app()->params->FILEPATH[$folder][$type])) {
                if (isset(Yii::app()->params->FILEPATH[$folder][$type][$size])) {
                    return Yii::app()->params->FILEFOLDER . Yii::app()->params->FILEPATH[$folder][$type][$size] . $fileName . '.' . $ext;
                } else {
                    return Yii::app()->params->FILEFOLDER . Yii::app()->params->FILEPATH[$folder][$type] . $fileName . '.' . $ext;
                }
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    /**
     * 图片处理
     * @param string $fileName 文件名
     * @param string $fileExt 文件类型
     * @param string $mark 水印文字
     * 
     */
    public static function photoShop($fileName = '', $fileExt = '', $mark = '') {
        /* ------------图标尺寸----------- */
        $imageThumb = new ImageThumb();
        $imageThumb->setSrcImg(self::returnPath('sourcefile', $fileName, $fileExt, 'image', 'source'));
        $imageThumb->setDstImg(self::returnPath('sourcefile', $fileName, $fileExt, 'image', 'icon'));
        $imageThumb->createImg(Yii::app()->params->FILESIZE['sourcefile']['image']['icon'][0], Yii::app()->params->FILESIZE['sourcefile']['image']['icon'][1]);

        /* ------------小图尺寸----------- */
        $imageThumb = new ImageThumb();
        $imageThumb->setSrcImg(self::returnPath('sourcefile', $fileName, $fileExt, 'image', 'source'));
        $imageThumb->setDstImg(self::returnPath('sourcefile', $fileName, $fileExt, 'image', 'thumb'));
        $imageThumb->createImg(Yii::app()->params->FILESIZE['sourcefile']['image']['thumb'][0], Yii::app()->params->FILESIZE['sourcefile']['image']['thumb'][1]);

        /* ------------中图尺寸----------- */
        $imageThumb = new ImageThumb();
        $imageThumb->setSrcImg(self::returnPath('sourcefile', $fileName, $fileExt, 'image', 'source'));
        $imageThumb->setDstImg(self::returnPath('sourcefile', $fileName, $fileExt, 'image', 'medium'));
        $imageThumb->createImg(Yii::app()->params->FILESIZE['sourcefile']['image']['medium'][0], Yii::app()->params->FILESIZE['sourcefile']['image']['medium'][1]);

        /* ------------水印大图尺寸----------- */
        $imageThumb = new ImageThumb();
        $imageThumb->setSrcImg(self::returnPath('sourcefile', $fileName, $fileExt, 'image', 'source'));
        $imageThumb->setDstImg(self::returnPath('sourcefile', $fileName, $fileExt, 'image', 'watermark'));
        $imageThumb->setMaskFont('css/simyou.ttf');

        $imageThumb->setMaskFontSize(20);
        $imageThumb->setMaskPosition(4);
        $imageThumb->setMaskFontColor("#ffffff");

        $imageThumb->setMaskWord($mark);
        $imageThumb->createImg(100);
    }

    /**
     * 將{username}转化为用户昵称
     * @param string $content 
     */
    public static function replaceNickname($content, $username) {
        return str_replace('{username}', $username, $content);
    }

    /**
     * 返回文件的绝对路径，用来上传至微信服务器
     * @param string $folder 文件夹
     * @param string $fileName 文件名
     * @param string $ext 文件后缀名
     * @param string $type 文件类型
     * @param string $size 文件尺寸
     * @return string
     */
    public static function returnFilePath($folder = 'sourcefile', $fileName = '', $ext = '', $type = '', $size = ''){
        if (!empty($fileName) && !empty($ext)) {
            if (isset(Yii::app()->params->FILEPATH[$folder][$type])) {
                if (isset(Yii::app()->params->FILEPATH[$folder][$type][$size])) {
                    return Yii::getPathOfAlias('webroot').'/'.Yii::app()->params->FILEFOLDER . Yii::app()->params->FILEPATH[$folder][$type][$size] . $fileName . '.' . $ext;
                } else {
                    return Yii::getPathOfAlias('webroot').'/'.Yii::app()->params->FILEFOLDER . Yii::app()->params->FILEPATH[$folder][$type] . $fileName . '.' . $ext;
                }
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
    
    /**
     * 返回素材数据
     * @param int $public_id
     * @param int $type
     * @param int $multi
     * @param int $gather_id
     * @return \CActiveDataProvider
     */
    public static function getSourceFile($public_id = 0, $type = 0, $multi = 0, $gather_id = 0, $title = '') {
        if ($multi == 1) {
            $criteria = new CDbCriteria();
            $criteria->select = 'id,title,description,time_created';
            $criteria->compare('title', $title, true);         
            $criteria->compare('public_id', $public_id);
            $criteria->compare('gather_id', $gather_id);
            $criteria->compare('isdelete', 0);
            $dataProvider = new CActiveDataProvider('SourceFileGroup', array(
                'criteria' => $criteria,
                'pagination' => array(
                    'pageSize' => 21,
                ),
                'sort' => array(
                    'defaultOrder' => '`time_created` DESC',
                ),
            ));
        } else {
            $criteria = new CDbCriteria();
            $criteria->select = 'id,title,filename,ext,time_created,description';
            $criteria->scopes = 
            $criteria->compare('title', $title, true);
            $criteria->compare('public_id', $public_id);
            $criteria->compare('type', $type);
            $criteria->compare('gather_id', $gather_id);
            $criteria->compare('isdelete', 0);
            $dataProvider = new CActiveDataProvider('SourceFile', array(
                'criteria' => $criteria,
                'pagination' => array(
                    'pageVar'=>'page',
                    'pageSize' => 21,
                ),
                'sort' => array(
                    'defaultOrder' => '`time_created` DESC',
                ),
            ));
        }
        return $dataProvider;
    }

    /**
     * 返回素材集合数据
     * @param int $public_id
     * @param int $type
     * @param int $multi
     * @return \CActiveDataProvider
     */
    public static function getSourceFileGather($public_id = 0, $type = 0, $multi = 0) {
        $criteria = new CDbCriteria();
        $criteria->select = 'id,type,name,multi';
        $criteria->compare('public_id', $public_id);
        $criteria->compare('type', $type);
        $criteria->compare('multi', $multi);
        $criteria->compare('isdelete', 0);
        return new CActiveDataProvider('SourceFileGather', array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageVar'=>'page',
                'pageSize' => 10,
            ),
            'sort' => array(
                'defaultOrder' => '`time_created` DESC',
            ),
        ));
    }
}
