<?php

/**
 * This is the model class for table "{{user_integral}}".
 *
 * The followings are the available columns in table '{{user_integral}}':
 * @property integer $id
 * @property integer $public_id
 * @property integer $transmit_id
 * @property integer $user_id
 * @property integer $type_id
 * @property integer $score
 * @property integer $notify
 * @property string $cause
 * @property integer $sign_in_count
 * @property integer $status
 * @property integer $time_created
 */
class UserIntegral extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{user_integral}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('public_id, transmit_id, user_id, type_id, score, notify, sign_in_count, status, time_created', 'numerical', 'integerOnly' => true),
            array('cause', 'length', 'max' => 255),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, public_id, transmit_id, user_id, type_id, score, notify, cause, sign_in_count, status, time_created', 'safe', 'on' => 'search'),
        );
    }
    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'gifts' => array(self::BELONGS_TO, 'Gift', 'gift_idn', 'on' => 'status=:status', 'params' => array(':status' => 0)),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'public_id' => 'Public',
            'transmit_id' => 'Transmit',
            'user_id' => 'User',
            'type_id' => 'Type',
            'score' => 'Score',
            'notify' => 'Notify',
            'cause' => 'Cause',
            'sign_in_count' => 'Sign In Count',
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
        $criteria->compare('public_id', $this->public_id);
        $criteria->compare('transmit_id', $this->transmit_id);
        $criteria->compare('user_id', $this->user_id);
        $criteria->compare('type_id', $this->type_id);
        $criteria->compare('score', $this->score);
        $criteria->compare('notify', $this->notify);
        $criteria->compare('cause', $this->cause, true);
        $criteria->compare('sign_in_count', $this->sign_in_count);
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
     * @return UserIntegral the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
