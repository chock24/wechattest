<?php

/**
 * This is the model class for table "{{source_file_detail}}".
 *
 * The followings are the available columns in table '{{source_file_detail}}':
 * @property integer $group_id
 * @property integer $file_id
 * @property integer $status
 * @property integer $sort
 * @property integer $isdelete
 * @property integer $time_created
 * @property integer $time_updated
 */
class SourceFileDetail extends CActiveRecord
{
	public $_select;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{source_file_detail}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			//array('group_id, file_id, status, isdelete, time_created, time_updated', 'required'),
			array('group_id, file_id, status, sort, isdelete, time_created, time_updated', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('group_id, file_id, status, sort, isdelete, time_created, time_updated', 'safe', 'on'=>'search'),
			array('group_id, file_id, status, sort, isdelete, time_created, time_updated', 'safe'),
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
                    'sourcefile'=>array(self::BELONGS_TO, 'SourceFile', 'file_id','select'=>'id,title,description,content,filename,ext'),
                    'sourceFile'=>array(self::BELONGS_TO,'SourceFile','file_id','select'=>'title,filename,ext','on'=>'isdelete=:isdelete','params'=>array('isdelete'=>0)),
		);
	} 

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'group_id' => '图文集合ID',
			'file_id' => '图文素材ID',
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
		$criteria->select = $this->_select;
		$criteria->compare('group_id',$this->group_id);
		$criteria->compare('file_id',$this->file_id);
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
	 * @return SourceFileDetail the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	/*
	 *  自动填充创建时间和更新时间
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
