<?php

/**
 * This is the model class for table "{{poster}}".
 *
 * The followings are the available columns in table '{{poster}}':
 * @property integer $id
 * @property string $postername
 * @property integer $typeid
 * @property integer $is_delete
 * @property string $url
 * @property integer $time_created
 * @property integer $time_updated
 */
class Poster extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{poster}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('typeid, is_delete, time_created, time_updated', 'numerical', 'integerOnly'=>true),
			array('url,img_url', 'length', 'max'=>255),
            array('typename','length', 'max'=>64),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, typeid, typename, is_delete, url, img_url, time_created, time_updated', 'safe', 'on'=>'search'),
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
            'postertype' => array(self::BELONGS_TO, 'PosterType', 'typeid', 'select' => 'col_name', 'on' => 'is_delete=:isdelete', 'params' => array(':isdelete' => 0)),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'img_url' => '照片路径',
			'typeid' => 'Typeid',
			'is_delete' => 'Is Delete',
			'url' => '海报跳转链接',
            'typename'=>'栏目名称',
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
		$criteria->compare('typeid',$this->typeid);
		$criteria->compare('is_delete',$this->is_delete);
		$criteria->compare('url',$this->url,true);
        $criteria->compare('img_url',$this->img_url,true);
        $criteria->compare('typename',$this->typename,true);
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
	 * @return Poster the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    /**
     * 获取数据
     * @return CActiveDataProvider
     */
    public function getData() {
        $criteria = new CDbCriteria;
        $criteria->select = '`id`,`img_url`,`time_created`';
        $criteria->compare('is_delete',0);

        //$data=$this->findAll($criteria);
       // var_dump($data);exit;
        //echo get_class($this);exit;

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'PageSize' => 10,
            ),
            'sort' => array(
                'defaultOrder' => '`time_created` DESC',
            ),
        ));

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
