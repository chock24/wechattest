<?php

/**
 * This is the model class for table "{{coupon_exchange}}".
 *
 * The followings are the available columns in table '{{coupon_exchange}}':
 * @property integer $id
 * @property integer $public_id
 * @property integer $user_id
 * @property integer $coupon_id
 * @property integer $number
 * @property integer $isdelete
 * @property integer $time_created
 */
class CouponExchange extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{coupon_exchange}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('public_id, user_id, coupon_id', 'required'),
			array('public_id, user_id, coupon_id, number, isdelete, time_created', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, public_id, user_id, coupon_id, number, isdelete, time_created', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
                    'coupon' => array(self::BELONGS_TO, 'Coupon', 'coupon_id',  'condition' => 'status=:status', 'params' => array(':status' =>0)),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'public_id' => 'Public',
			'user_id' => 'User',
			'coupon_id' => 'Coupon',
			'number' => 'Number',
			'isdelete' => 'Isdelete',
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
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('public_id',$this->public_id);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('coupon_id',$this->coupon_id);
		$criteria->compare('number',$this->number);
		$criteria->compare('isdelete',$this->isdelete);
		$criteria->compare('time_created',$this->time_created);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return CouponExchange the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
