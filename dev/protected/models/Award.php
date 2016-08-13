<?php

/**
 * This is the model class for table "{{award}}".
 *
 * The followings are the available columns in table '{{award}}':
 * @property integer $id
 * @property integer $admin_id
 * @property integer $public_id
 * @property integer $gift_id
 * @property string $nickname
 * @property string $transmit_title
 * @property integer $status
 * @property integer $sort
 * @property integer $isdelete
 * @property integer $time_created
 * @property integer $time_updated
 */

class Award extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{award}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array(' admin_id, public_id, gift_id', 'required'),
            array(' admin_id, public_id, gift_id, status, sort, isdelete, time_created, time_updated', 'numerical', 'integerOnly' => true),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, admin_id, public_id, gift_id, status, sort, isdelete, time_created, time_updated', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'users' => array(self::BELONGS_TO, 'User', 'user_id', 'select' => 'id,mobile,nickname', 'on' => 'isdelete=:isdelete', 'params' => array(':isdelete' => 0)),
            'transmits' => array(self::BELONGS_TO, 'Transmit', 'transmit_id', 'select' => 'id,title,type_id,image_src', 'on' => 'isdelete=:isdelete', 'params' => array(':isdelete' => 0)),
            'gifts' => array(self::BELONGS_TO, 'Gift', 'gift_id', 'select' => 'id,type_id,name,type_id,number,integral,content,image_src,count_stock,image_arr', 'on' => 'isdelete=:isdelete', 'params' => array(':isdelete' => 0)),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'admin_id' => 'Admin',
            'public_id' => 'Public',
            'gift_id' => 'Gift',
            'nickname' => 'Nickname',
            'transmit_title' => 'Transmit Title',
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
    public function search() {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('admin_id', $this->admin_id);
        $criteria->compare('public_id', $this->public_id);
        $criteria->compare('gift_id', $this->gift_id);
        $criteria->compare('nickname', $this->nickname, true);
        $criteria->compare('transmit_title', $this->transmit_title, true);
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
     * @return Award the static model class
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
