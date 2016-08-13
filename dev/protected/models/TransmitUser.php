<?php

/**
 * This is the model class for table "{{transmit_user}}".
 *
 * The followings are the available columns in table '{{transmit_user}}':
 * @property integer $id
 * @property integer $transmit_id
 * @property integer $user_id
 * @property string $remark
 * @property integer $status
 * @property integer $time_created
 */
class TransmitUser extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{transmit_user}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('transmit_id, user_id, status, time_created', 'numerical', 'integerOnly' => true),
            array('remark', 'length', 'max' => 255),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, transmit_id, user_id, remark, status, time_created', 'safe', 'on' => 'search'),
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
            'transmits' => array(self::BELONGS_TO, 'Transmit', 'transmit_id', 'select' => 'id,type_id,title,time_start,time_end,image_src,description,content,number', 'on' => 'isdelete=:isdelete', 'params' => array(':isdelete' => 0)),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'transmit_id' => 'Transmit',
            'user_id' => 'User',
            'remark' => 'Remark',
            'status' => 'Status',
            'time_created' => 'Time Created',
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
        $criteria->compare('transmit_id', $this->transmit_id);
        $criteria->compare('user_id', $this->user_id);
        $criteria->compare('remark', $this->remark, true);
        $criteria->compare('status', $this->status);
        $criteria->compare('time_created', $this->time_created);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return TransmitUser the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
