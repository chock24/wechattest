<?php

/**
 * This is the model class for table "{{quickmark}}".
 *
 * The followings are the available columns in table '{{quickmark}}':
 * @property integer $id
 * @property integer $public_id
 * @property string $title
 * @property string $description
 * @property string $action_name
 * @property integer $expire_seconds
 * @property string $action_info
 * @property string $scene_id
 * @property string $ticket
 * @property string $url
 * @property integer $status
 * @property integer $sort
 * @property integer $isdelete
 * @property integer $time_created
 * @property integer $time_updated
 */
class Quickmark extends CActiveRecord {

    public $time_start; //开始时间
    public $time_end; //结束时间
    public $user_id; //用户id

    /**
     * @return string the associated database table name
     */

    public function tableName() {
        return '{{quickmark}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            //array('public_id, title, description, action_name, expire_seconds, action_info, scene_id, ticket, url, status, sort, isdelete, time_created, time_updated', 'required'),
            //  array('title, description, action_name', 'required'),
            array('public_id, group_id, expire_seconds, status, sort, isdelete, time_created, time_updated', 'numerical', 'integerOnly' => true),
            array('public_id', 'safe'),
            array('title, action_info, ticket, url', 'length', 'max' => 200),
            array('action_name', 'length', 'max' => 20),
            array('scene_id', 'length', 'max' => 5),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, public_id, title, description, action_name, expire_seconds, action_info, scene_id, ticket, url, status, sort, isdelete, time_created, time_updated, time_start, time_end', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'sourceFile' => array(self::BELONGS_TO, 'SourceFile', 'description', 'select' => 'length,id,title,description,filename,ext,time_created', 'on' => 'isdelete=:isdelete', 'params' => array(':isdelete' => 0)),
            'sourceFileGroup' => array(self::BELONGS_TO, 'SourceFileGroup', 'description', 'select' => 'id,title,description,time_created', 'on' => 'isdelete=:isdelete', 'params' => array(':isdelete' => 0)),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'public_id' => '管理员',
            'group_id' => '关联用户组',
            'title' => '标题',
            'description' => '二维码描述(回复内容)',
            'action_name' => '二维码类型',
            'expire_seconds' => '有效时间',
            'action_info' => '关键字',
            'scene_id' => '场景值ID',
            'ticket' => '二维码ticket',
            'path' => '二维码',
            'url' => '二维码',
            'status' => '数据状态',
            'sort' => '排序',
            'isdelete' => 'Isdelete',
            'time_created' => '创建时间',
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
    public function search() {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('public_id', $this->public_id);
        $criteria->compare('group_id', $this->group_id);
        $criteria->compare('title', $this->title, true);
        $criteria->compare('description', $this->description, true);
        $criteria->compare('action_name', $this->action_name, true);
        $criteria->compare('expire_seconds', $this->expire_seconds);
        $criteria->compare('action_info', $this->action_info, true);
        $criteria->compare('scene_id', $this->scene_id, true);
        $criteria->compare('ticket', $this->ticket, true);
        $criteria->compare('url', $this->url, true);
        $criteria->compare('status', $this->status);
        $criteria->compare('sort', $this->sort);
        $criteria->compare('isdelete', $this->isdelete);
        //$criteria->compare('time_created', $this->time_created);
        //$criteria->compare('time_updated', $this->time_updated);
        if (!empty($this->time_start) && !empty($this->time_end)) {
            $criteria->addBetweenCondition('time_created', strtotime($this->time_start), strtotime($this->time_end) + 3600 * 24);
        }


        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Quickmark the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /*
     * 保存管理员ID到二维码数据
     */

    public function beforeSave() {
        if (parent::beforeSave()) {
            if ($this->isNewRecord) {
                $this->admin_id = Yii::app()->user->id;
                // $this->public_id = Yii::app()->user->getState('public_id');
            }
            return true;
        } else {
            return false;
        }
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
