<?php

/**
 * This is the model class for table "{{source_file}}".
 *
 * The followings are the available columns in table '{{source_file}}':
 * @property integer $id
 * @property integer $public_id
 * @property string $type
 * @property integer $parent_id
 * @property integer $media_id
 * @property integer $thumb_media_id
 * @property integer $created_at
 * @property integer $gather_id
 * @property string $public_name
 * @property string $public_url
 * @property string $title
 * @property string $author
 * @property string $description
 * @property integer $show_content
 * @property string $content
 * @property string $content_source_url
 * @property string $path
 * @property string $ext
 * @property string $size
 * @property integer $status
 * @property integer $sort
 * @property integer $isdelete
 * @property integer $time_created
 * @property integer $time_updated
 */
class SourceFile extends CActiveRecord {

    public $files;
    public $ids;
    public $_select = '*'; //查询字段
    public $_limit = 10; //查询条数
    public $watermark; //水印字段

    /**
     * @return string the associated database table name
     */

    public function tableName() {
        return '{{source_file}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            //	array('public_id, type ,  gather_id, title, author, description, show_content, content, content_source_url, path, ext, size, status, sort, isdelete, time_created, time_updated', 'required'),
            array('length,public_id, gather_id, show_content, status, sort, isdelete, time_created, time_updated', 'numerical', 'integerOnly' => true),
            array('type, ext', 'length', 'max' => 40),
            array('title, author, path, public_name, public_url', 'length', 'max' => 200),
            array('content_source_url', 'length', 'max' => 255),
            array('size', 'length', 'max' => 20),
            /* -------------------音频验证------------------ */
            array('files', 'file', 'allowEmpty' => true, 'types' => ' mp3,wma,wav,amr', 'maxSize' => 1024 * 1024 * 5,
                'tooLarge' => '文件大于5M，上传失败！请上传小于5M的文件', 'on' => 'voice'
            ),
            /* -------------------视频验证------------------ */
            array('files', 'file', 'allowEmpty' => true, 'types' => 'rm, rmvb, wmv, avi, mpg, mpeg, mp4', 'maxSize' => 1024 * 1024 * 20,
                'tooLarge' => '文件大于20M，上传失败！请上传小于20M的文件', 'on' => 'video'
            ),
            /* ---------------------图片验证---------------- */
            /* array('filename', 'file', 'types' => 'bmp, png, jpeg, jpg, gif', 'maxSize' => 1024 * 1024 * 2,
              'tooLarge' => '文件大于2M，上传失败！请上传小于2M的文件', 'on' => 'images'
              ), */
            array('filename', 'file', 'maxFiles' => 1, 'maxSize' => 2 * 1024 * 1024, 'tooLarge' => '文件超出规定尺寸', 'types' => array('jpg', 'gif', 'png'), 'wrongType' => '仅能上传jpg,png或者是gif的文件', 'on' => 'images'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('content_source_url,id, public_id, type, gather_id, title, author, description, show_content, content, content_source_url, path, ext, size, status, sort, isdelete, time_created, time_updated', 'safe', 'on' => 'search'),
            array('content_source_url,filename,length,files,content,id, public_id, type, gather_id, title, author, description, show_content, content, content_source_url, path, ext, size, status, sort, isdelete, time_created, time_updated', 'safe'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'public' => array(self::BELONGS_TO, 'WcPublic', 'public_id', 'select' => 'title', 'on' => 'isdelete=:isdelete', 'params' => array(':isdelete' => 0)),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'filename' => '文件',
            'public_id' => '公众号ID',
            'type' => '素材类型',
            'length' => '长度',
            'media_id' => '媒体文件上传后，获取时的唯一标识',
            'thumb_media_id' => '图文消息缩略图的media_id',
            'created_at' => '媒体文件上传时间戳',
            'gather_id' => '分组ID',
            'title' => '标题',
            'author' => '作者',
            'description' => '简介',
            'show_content' => '封面是否显示在正文',
            'content' => '内容',
            'content_source_url' => '点击查看全文的链接',
            'path' => '图片路径，视频路径，语音路径',
            'ext' => 'Ext',
            'size' => '素材尺寸',
            'status' => 'Status',
            'sort' => 'Sort',
            'isdelete' => 'Isdelete',
            'time_created' => 'Time Created',
            'time_updated' => 'Time Updated',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     *
     * Typical usecase:
     * - Initialize the model fields with values from filter form.
     * - Execute this method to get CActiveDataProvider instance which will filter
     * models according to data in model fields.
     * - Pass data provider to CGridView, CListView or any similar widget.
     *
     * @return CActiveDataProvider the data provider that can return the models
     * based on the search/filter conditions.
     */
    public function search($type) {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;
        //$criteria->select = $this->_select;

        $criteria->compare('id', $this->id);
        $criteria->compare('public_id', $this->public_id);
        if (!empty($type)) {
            $criteria->compare('type', $type);
        }
        $gather = Yii::app()->request->getParam('gather');
        if (!empty($gather)) {
            $criteria->compare('gather_id', $gather);
        }
        $criteria->compare('title', $this->title, true);
        $criteria->compare('author', $this->author, true);
        $criteria->compare('description', $this->description, true);
        $criteria->compare('show_content', $this->show_content);
        $criteria->compare('content', $this->content, true);
        $criteria->compare('content_source_url', $this->content_source_url, true);
        $criteria->compare('path', $this->path, true);
        $criteria->compare('ext', $this->ext, true);
        $criteria->compare('size', $this->size, true);
        $criteria->compare('status', $this->status);
        $criteria->compare('time_created', $this->time_created);
        $criteria->compare('time_updated', $this->time_updated);
        $criteria->compare('isdelete', '0');
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'PageSize' => 8,
            ),
            'sort' => array(
                'defaultOrder' => '`time_created` DESC',
            ),
        ));
    }

    /**
     * 查询素材数据
     * @return \CActiveDataProvider
     */
    public function getData() {
        $criteria = new CDbCriteria;
        $criteria->select = $this->_select;
        $criteria->compare('id', $this->id);
        $criteria->compare('type', $this->type);
        $criteria->compare('gather_id', $this->gather_id);
        $criteria->compare('title', $this->title, true);
        $criteria->compare('author', $this->author, true);
        $criteria->compare('description', $this->description, true);
        //$criteria->compare('show_content', $this->show_content);
        $criteria->compare('content', $this->content, true);
        $criteria->compare('content_source_url', $this->content_source_url, true);
        $criteria->compare('path', $this->path, true);
        $criteria->compare('ext', $this->ext, true);
        $criteria->compare('size', $this->size, true);

        $template = @Yii::app()->request->getParam('template');

        if ($template > 0) {
            $criteria->compare('template', $template);
            $criteria->compare('public_id', 1);
        } else {
            $criteria->compare('public_id', $this->public_id);
        }

        //$criteria->compare('status', $this->status);
        //$criteria->compare('time_created', $this->time_created);
        //$criteria->compare('time_updated', $this->time_updated);
        $criteria->compare('isdelete', $this->isdelete);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'PageSize' => $this->_limit,
            ),
            'sort' => array(
                'defaultOrder' => '`sort` DESC',
            ),
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return SourceFile the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * 在存入数据库前的操作
     */
    public function beforeSave() {
        if (parent::beforeSave()) {
            if ($this->isNewRecord) {
                $this->admin_id = Yii::app()->user->id;
                $this->public_id = Yii::app()->user->getState('public_id');
            }
            return true;
        } else {
            return false;
        }
    }

    /*
     *  自动填充创建时间和更新时间
     */

    public function behaviors() {
        return array(
            'CTimestampBehavior' => array(
                'class' => 'zii.behaviors.CTimestampBehavior',
                'createAttribute' => 'time_created',
                'updateAttribute' => 'time_updated',
                'setUpdateOnCreate' => true,
            ),
        );
    }

}
