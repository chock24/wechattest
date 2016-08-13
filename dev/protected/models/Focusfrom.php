<?php

/**
 * This is the model class for table "{{focusfrom}}".
 *
 * The followings are the available columns in table '{{focusfrom}}':
 * @property integer $id
 * @property string $title
 * @property integer $public_id
 * @property integer $admin_id
 * @property integer $group_id
 * @property integer $user_id
 * @property integer $order_by
 * @property integer $time_created
 * @property integer $time_updated
 */
class Focusfrom extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{focusfrom}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id', 'required'),
			array('id, public_id, admin_id, group_id, user_id, order_by, time_created, time_updated', 'numerical', 'integerOnly'=>true),
			array('title', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, title, public_id, admin_id, group_id, user_id, order_by, time_created, time_updated', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'title' => 'Title',
			'public_id' => 'Public',
			'admin_id' => 'Admin',
			'group_id' => 'Group',
			'user_id' => 'User',
			'order_by' => 'Order By',
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
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('public_id',$this->public_id);
		$criteria->compare('admin_id',$this->admin_id);
		$criteria->compare('group_id',$this->group_id);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('order_by',$this->order_by);
		$criteria->compare('time_created',$this->time_created);
		$criteria->compare('time_updated',$this->time_updated);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Focusfrom the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
