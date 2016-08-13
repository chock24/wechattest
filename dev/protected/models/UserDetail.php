<?php

/**
 * This is the model class for table "{{user_detail}}".
 *
 * The followings are the available columns in table '{{user_detail}}':
 * @property integer $id
 * @property integer $admin_id
 * @property integer $public_id
 * @property integer $source
 * @property string $openid
 * @property string $nickname
 * @property integer $star
 * @property integer $level
 * @property integer $group_id
 * @property string $remark
 * @property string $subscribe
 * @property string $headimgurl
 * @property string $name
 * @property string $mobile
 * @property string $telphone
 * @property string $email
 * @property string $address
 * @property integer $sex
 * @property integer $age
 * @property string $language
 * @property integer $country
 * @property integer $province
 * @property integer $city
 * @property integer $district
 * @property integer $subscribe_time
 * @property string $unionid
 * @property integer $integral
 * @property integer $time_message_last
 * @property integer $last_attendance_time
 * @property integer $status
 * @property integer $sort
 * @property integer $isdelete
 * @property integer $time_created
 * @property integer $time_updated
 */
class UserDetail extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{user_detail}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
	
			array('name', 'length', 'max'=>20),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, admin_id, public_id, source, openid, nickname, star, level, group_id, remark, headimgurl, name, mobile, telphone, email, address, sex, age, language, country, province, city, district, subscribe_time, unionid, integral, time_message_last, last_attendance_time, status, sort, isdelete, time_created, time_updated', 'safe', 'on'=>'search'),
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
			'admin_id' => 'Admin',
			'public_id' => 'Public',
			'source' => 'Source',
			'openid' => 'Openid',
			'nickname' => 'Nickname',
			'star' => 'Star',
			'level' => 'Level',
			'group_id' => 'Group',
			'remark' => 'Remark',
			'subscribe' => 'Subscribe',
			'headimgurl' => 'Headimgurl',
			'name' => 'Name',
			'mobile' => 'Mobile',
			'telphone' => 'Telphone',
			'email' => 'Email',
			'address' => 'Address',
			'sex' => 'Sex',
			'age' => 'Age',
			'language' => 'Language',
			'country' => 'Country',
			'province' => 'Province',
			'city' => 'City',
			'district' => 'District',
			'subscribe_time' => 'Subscribe Time',
			'unionid' => 'Unionid',
			'integral' => 'Integral',
			'time_message_last' => 'Time Message Last',
			'last_attendance_time' => 'Last Attendance Time',
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
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('admin_id',$this->admin_id);
		$criteria->compare('public_id',$this->public_id);
		$criteria->compare('source',$this->source);
		$criteria->compare('openid',$this->openid,true);
		$criteria->compare('nickname',$this->nickname,true);
		$criteria->compare('star',$this->star);
		$criteria->compare('level',$this->level);
		$criteria->compare('group_id',$this->group_id);
		$criteria->compare('remark',$this->remark,true);
		$criteria->compare('subscribe',$this->subscribe,true);
		$criteria->compare('headimgurl',$this->headimgurl,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('mobile',$this->mobile,true);
		$criteria->compare('telphone',$this->telphone,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('address',$this->address,true);
		$criteria->compare('sex',$this->sex);
		$criteria->compare('age',$this->age);
		$criteria->compare('language',$this->language,true);
		$criteria->compare('country',$this->country);
		$criteria->compare('province',$this->province);
		$criteria->compare('city',$this->city);
		$criteria->compare('district',$this->district);
		$criteria->compare('subscribe_time',$this->subscribe_time);
		$criteria->compare('unionid',$this->unionid,true);
		$criteria->compare('integral',$this->integral);
		$criteria->compare('time_message_last',$this->time_message_last);
		$criteria->compare('last_attendance_time',$this->last_attendance_time);
		$criteria->compare('status',$this->status);
		$criteria->compare('sort',$this->sort);
		$criteria->compare('isdelete',$this->isdelete);
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
	 * @return UserDetail the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
