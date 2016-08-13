<?php

/**
 * This is the model class for table "{{message}}".
 *
 * The followings are the available columns in table '{{message}}':
 * @property integer $id                主键
 * @property string $tousername         接收用户名
 * @property string $fromusername       发送用户名
 * @property integer $user_id           发送者ID
 * @property integer $receive           接收:1 发出2
 * @property integer $auto              自动:1 手动:2
 * @property integer $createtime        创建时间
 * @property integer $type              消息类型
 * @property integer $menutype          菜单类型
 * @property string $msgid              信息ID
 * @property string $picurl             图片地址
 * @property string $mediaid            媒体ID
 * @property string $format             语音格式，如amr，speex等
 * @property integer $thumbmediaid      视频消息缩略图的媒体id
 * @property string $location_x         地理位置维度
 * @property string $location_y         地理位置经度
 * @property integer $scale             地图缩放大小
 * @property string $label              地理位置信息
 * @property integer $star              是否加星标
 * @property string $remark             消息备注
 * @property string $title              标题
 * @property string $description        消息描述
 * @property string $content            内容
 * @property integer $multi             是否是多图文
 * @property integer $source_file_id    素材ID
 * @property string $url                消息链接
 * @property integer $status            数据状态 1:未读 0:已读
 * @property integer $sort              排序
 * @property integer $isdelete          是否删除
 * @property integer $time_created      创建时间
 * @property integer $time_updated      更新时间
 */
class Message extends CActiveRecord {

    public $_select = '*';
    public $lasttime; //上次对话时间
    public $time_start;
    public $time_end;
    public $view_id;

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{message}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            //array('tousername, fromusername, user_id, type, auto, createtime, msgtype, msgid, picurl, mediaid, format, thumbmediaid, location_x, location_y, scale, label, star, remark, title, description, content, url, status, sort, isdelete, time_created, time_updated', 'required'),
            //array('content','required'),
            array('public_id, user_id, receive, auto, createtime, type, menutype, scale, star, multi, source_file_id, status, sort, isdelete, time_created, time_updated', 'numerical', 'integerOnly' => true),
            array('tousername, content, fromusername, label, title', 'length', 'max' => 200),
            array('format, location_x, location_y, remark', 'length', 'max' => 55),
            array('msgid, mediaid, thumbmediaid', 'length', 'max' => 64),
            array('picurl, description, url', 'length', 'max' => 255),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, public_id, tousername, fromusername, user_id, receive, auto, createtime, type, msgid, picurl, mediaid, format, thumbmediaid, location_x, location_y, scale, label, star, remark, title, description, content, multi, source_file_id, url, status, sort, isdelete, time_created, time_updated, time_start, time_end', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'users' => array(self::BELONGS_TO, 'User', 'user_id', 'select' => 'nickname,headimage', 'on' => 'isdelete=:isdelete', 'params' => array(':isdelete' => 0)),
            'user' => array(self::BELONGS_TO, 'User', 'user_id', 'select' => 'nickname,headimgurl', 'on' => 'isdelete=:isdelete', 'params' => array(':isdelete' => 0)),
            'menu' => array(self::BELONGS_TO, 'Menu', 'menukey', 'select' => 'id,title'),
            'menunew' => array(self::BELONGS_TO, 'Menu', array('content' => 'url')),
            'sourcefile' => array(self::BELONGS_TO, 'SourceFile', 'source_file_id'),
            'sourcefilegroup' => array(self::BELONGS_TO, 'SourceFileGroup', 'source_file_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'tousername' => '管理员微信号',
            'fromusername' => '发送者OPENID',
            'user_id' => '用户ID',
            'receive' => '接收:1 发出2',
            'auto' => '自动:1 手动:2',
            'createtime' => '接收时间',
            'type' => '消息类型',
            'menutype' => '菜单类型',
            'msgid' => '信息ID',
            'picurl' => '图片地址',
            'mediaid' => '媒体ID',
            'format' => '语音格式，如amr，speex等',
            'thumbmediaid' => '视频消息缩略图的媒体id',
            'location_x' => '地理位置维度',
            'location_y' => '地理位置经度',
            'scale' => '地图缩放大小',
            'label' => '地理位置信息',
            'star' => '星标消息',
            'remark' => '消息备注',
            'title' => '标题',
            'description' => '消息描述',
            'content' => '内容',
            'multi' => '是否是多图文',
            'source_file_id' => '素材ID',
            'lasttime' => '最后一次对话时间',
            'url' => '消息链接',
            'status' => '数据状态',
            'sort' => 'Sort',
            'isdelete' => 'Isdelete',
            'time_created' => 'Time Created',
            'time_updated' => 'Time Updated',
            /* -----过滤---- */
            'filtershow' => '过滤显示的',
            'filter' => '过滤不显示的',
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
    public function search() {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;
        $criteria->select = $this->_select;
        $criteria->compare('id', $this->id);
        $criteria->compare('public_id', $this->public_id);
        $criteria->compare('tousername', $this->tousername, true);
        $criteria->compare('fromusername', $this->fromusername, true);
        $criteria->compare('user_id', $this->user_id);
        $criteria->compare('receive', $this->receive);
        $criteria->compare('auto', $this->auto);
        $criteria->compare('createtime', $this->createtime);
        $criteria->compare('type', $this->type);
        $criteria->compare('menutype', $this->menutype);
        $criteria->compare('msgid', $this->msgid, true);
        $criteria->compare('picurl', $this->picurl, true);
        $criteria->compare('mediaid', $this->mediaid, true);
        $criteria->compare('format', $this->format, true);
        $criteria->compare('thumbmediaid', $this->thumbmediaid);
        $criteria->compare('location_x', $this->location_x, true);
        $criteria->compare('location_y', $this->location_y, true);
        $criteria->compare('scale', $this->scale);
        $criteria->compare('label', $this->label, true);
        $criteria->compare('star', $this->star);
        $criteria->compare('remark', $this->remark, true);
        $criteria->compare('title', $this->title, true);
        $criteria->compare('description', $this->description, true);
        $criteria->compare('content', $this->content, true);
        $criteria->compare('url', $this->url, true);
        $criteria->compare('status', $this->status);
        $criteria->compare('sort', $this->sort);
        $criteria->compare('isdelete', $this->isdelete);
        //$criteria->compare('time_created', $this->time_created);
        //$criteria->compare('time_updated', $this->time_updated);
        if (!empty($this->time_start) && !empty($this->time_end)) {
            $criteria->addBetweenCondition('time_created', strtotime($this->time_start), strtotime($this->time_end) + 3600 * 24);
        }

        //$criteria->group = 'user_id';

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 20,
            ),
            'sort' => array(
                'defaultOrder' => '`createtime` DESC',
            ),
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Message the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /*
     * 自动填充创建时间和更新时间
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
