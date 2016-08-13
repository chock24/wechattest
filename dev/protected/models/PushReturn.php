<?php

/**
 * This is the model class for table "{{push_return}}".
 *
 * The followings are the available columns in table '{{push_return}}':
 * @property integer $id
 * @property integer $push_id
 * @property string $msg_id
 * @property string $title
 * @property string $msg_status
 * @property integer $errcode
 * @property string $errmsg
 * @property integer $totalcount
 * @property integer $filtercount
 * @property integer $sentcount
 * @property integer $errorcount
 * @property integer $status
 * @property integer $sort
 * @property integer $isdelete
 * @property integer $time_created
 * @property integer $time_updated
 */
class PushReturn extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{push_return}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            //array('push_id, title, msg_status, errcode, errmsg, totalcount, filtercount, sentcount, errorcount, status, sort, isdelete, time_created, time_updated', 'required'),
            array('push_id, errcode, totalcount, filtercount, sentcount, errorcount, status, sort, isdelete, time_created, time_updated', 'numerical', 'integerOnly' => true),
            array('msg_id', 'length', 'max' => 20),
            array('title, msg_status, errmsg', 'length', 'max' => 200),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, push_id, msg_id, title, msg_status, errcode, errmsg, totalcount, filtercount, sentcount, errorcount, status, sort, isdelete, time_created, time_updated', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'push_id' => '群发消息ID',
            'msg_id' => '返回的消息ID',
            'title' => '执行操作',
            'msg_status' => '消息发送后的状态，SEND_SUCCESS表示发送成功',
            'errcode' => '错误码',
            'errmsg' => '错误信息',
            'totalcount' => 'group_id下粉丝数；或者openid_list中的粉丝数',
            'filtercount' => '过滤（过滤是指特定地区、性别的过滤、用户设置拒收的过滤，用户接收已超4条的过滤）后，准备发送的粉丝数，原则上，FilterCount = SentCount + ErrorCount',
            'sentcount' => '发送成功的粉丝数',
            'errorcount' => '发送失败的粉丝数',
            'status' => '数据状态',
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
    public function search() {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('push_id', $this->push_id);
        $criteria->compare('msg_id', $this->msg_id, true);
        $criteria->compare('title', $this->title, true);
        $criteria->compare('msg_status', $this->msg_status, true);
        $criteria->compare('errcode', $this->errcode);
        $criteria->compare('errmsg', $this->errmsg, true);
        $criteria->compare('totalcount', $this->totalcount);
        $criteria->compare('filtercount', $this->filtercount);
        $criteria->compare('sentcount', $this->sentcount);
        $criteria->compare('errorcount', $this->errorcount);
        $criteria->compare('status', $this->status);
        $criteria->compare('sort', $this->sort);
        $criteria->compare('isdelete', $this->isdelete);
        $criteria->compare('time_created', $this->time_created);
        $criteria->compare('time_updated', $this->time_updated);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return PushReturn the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
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
