<?php

/**
 * This is the model class for table "{{push}}".
 *
 * The followings are the available columns in table '{{push}}':
 * @property integer $id
 * @property integer $admin_id
 * @property integer $public_id
 * @property integer $msg_id
 * @property string $media_id
 * @property integer $created_at
 * @property integer $genre
 * @property integer $count
 * @property string $user
 * @property integer $type
 * @property integer $multi
 * @property string $content
 * @property integer $source_file_id
 * @property integer $timing
 * @property integer $time_action
 * @property string $status
 * @property integer $totalcount
 * @property integer $filtercount
 * @property integer $sentcount
 * @property integer $errorcount
 * @property integer $sort
 * @property integer $isdelete
 * @property integer $time_created
 * @property integer $time_updated
 */
class Push extends CActiveRecord {

    public $_select = '*';
    public $sex;
    public $province;
    public $city;
    public $time_start;
    public $time_end;
    public $groupArr;
    public $userArr;
    public $openid; //预览openid
    public $preview; //预览openid
    public $success;//是否通过审核

    /**
     * @return string the associated database table name
     */

    public function tableName() {
        return '{{push}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('groupArr', 'validationGroup', 'on' => 'insert'),
            array('userArr', 'validationUser', 'on' => 'insert'),
            array('content, source_file_id', 'validationContent', 'on' => 'insert'),
            array('openid', 'required', 'on' => 'preview'),
            array('admin_id, public_id, msg_id, created_at, genre, count, type, multi, source_file_id, timing, time_action, status, sort, isdelete, time_created, time_updated, preview', 'numerical', 'integerOnly' => true),
            array('media_id,  remark, openid', 'length', 'max' => 255),
            array('id, admin_id, public_id, msg_id, media_id, created_at, genre, count, user, type, multi, source_file_id, timing, time_action, status, totalcount, filtercount, sentcount, errorcount, sort, isdelete, time_created, time_updated, time_start, time_end', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'sourceFile' => array(self::BELONGS_TO, 'SourceFile', 'source_file_id', 'select' => 'id,title,description,filename,ext,time_created', 'on' => 'isdelete=:isdelete', 'params' => array(':isdelete' => 0)),
            'sourceFileGroup' => array(self::BELONGS_TO, 'SourceFileGroup', 'source_file_id', 'select' => 'id,title,description,time_created', 'on' => 'isdelete=:isdelete', 'params' => array(':isdelete' => 0)),
        );
    }

    /**
     * 验证用户组
     * @param type $attribute
     * @param type $params
     */
    public function validationGroup($attribute, $params) {
        if (!$this->hasErrors()) {
            if ($this->genre == 2) {//如果是按用户组发送
                if (empty($this->groupArr)) {
                    $this->addError('groupArr', '您需要选择要发送的用户组。');
                }
            }
        }
    }

    /**
     * 验证用户
     * @param type $attribute
     * @param type $params
     */
    public function validationUser($attribute, $params) {
        if (!$this->hasErrors()) {
            if ($this->genre == 3) {//如果是按用户组发送
                if (empty($this->userArr)) {
                    $this->addError('userArr', '您需要选择要发送的用户。');
                }
            }
        }
    }

    /**
     * 验证发送内容
     * @param type $attribute
     * @param type $params
     */
    public function validationContent($attribute, $params) {
        if (!$this->hasErrors()) {
            if ($this->type == 5) {//如果是按用户组发送
                if (!$this->source_file_id) {
                    $this->addError('source_file_id', '必须要选择发送的内容。');
                }
            } else {
                if (empty($this->content)) {
                    $this->addError('content', '请您输入您要发送的内容。');
                }
            }
        }
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'admin_id' => '管理员ID',
            'public_id' => '公众号ID',
            'msg_id' => '返回的消息ID',
            'media_id' => '返回媒体ID',
            'created_at' => '提交Media时间',
            'genre' => '发送类型',
            'groupArr' => '用户组',
            'count' => '发送用户/用户组数量',
            'user' => '发送用户数据',
            'type' => '发送类型',
            'multi' => '是否是多图文',
            'content' => '发送内容',
            'source_file_id' => '素材ID',
            'timing' => '是否定时发送',
            'time_action' => '执行时间',
            'status' => '发送状态',
            'remark' => '群发消息备注',
            'sex' => '性别',
            'province' => '省份',
            'city' => '城市',
            'sort' => 'Sort',
            'isdelete' => 'Isdelete',
            'time_created' => '创建时间',
            'time_updated' => 'Time Updated',
            'openid' => '预览人openid',
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
        $criteria->compare('admin_id', $this->admin_id);
        $criteria->compare('public_id', $this->public_id);
        $criteria->compare('msg_id', $this->msg_id);
        $criteria->compare('media_id', $this->media_id, true);
        $criteria->compare('created_at', $this->created_at);
        $criteria->compare('genre', $this->genre);
        $criteria->compare('count', $this->count);
        $criteria->compare('user', $this->user, true);
        $criteria->compare('type', $this->type);
        $criteria->compare('multi', $this->multi);
        $criteria->compare('content', $this->content, true);
        $criteria->compare('source_file_id', $this->source_file_id);
        $criteria->compare('timing', $this->timing);
        $criteria->compare('time_action', $this->time_action);
        $criteria->compare('status', $this->status);
        $criteria->compare('sort', $this->sort);
        $criteria->compare('isdelete', $this->isdelete);
        if (!empty($this->time_start) && !empty($this->time_end)) {
            $criteria->addBetweenCondition('time_created', strtotime($this->time_start), strtotime($this->time_end) + 3600 * 24);
        }

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 50,
            ),
            'sort' => array(
                'defaultOrder' => '`time_created` DESC',
            ),
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Push the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * 保存入数据库前操作
     */
    public function beforeSave() {
        if (parent::beforeSave()) {
            if ($this->isNewRecord) {
                $this->admin_id = Yii::app()->user->id;
                $this->public_id = Yii::app()->user->getState('public_id');
                $this->status = 1;
            }
            return true;
        } else {
            return false;
        }
    }

    /**
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
