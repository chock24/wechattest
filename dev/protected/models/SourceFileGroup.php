<?php

/**
 * This is the model class for table "{{source_file_group}}".
 *
 * The followings are the available columns in table '{{source_file_group}}':
 * @property integer $id
 * @property integer $admin_id
 * @property integer $public_id
 * @property string $title
 * @property string $description
 * @property integer $status
 * @property integer $sort
 * @property integer $isdelete
 * @property integer $time_created
 * @property integer $time_updated
 */
class SourceFileGroup extends CActiveRecord {

    public $_select; //查询字段
    public $_limit; //查询数目
    public $ids;

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{source_file_group}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            //array('admin_id, public_id, title, description, status, sort, isdelete, time_created, time_updated', 'required'),
            array('admin_id, public_id, status, sort, isdelete, time_created, time_updated', 'numerical', 'integerOnly' => true),
            array('title', 'length', 'max' => 200),
            array('media_id, description', 'length', 'max' => 255),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('gather_id,id, admin_id, public_id, title, description, status, sort, isdelete, time_created, time_updated', 'safe', 'on' => 'search'),
        );
    }
  
    
    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'sourcedetail' => array(self::HAS_MANY, 'SourceFileDetail', 'group_id', 'on' => ' isdelete ="0" '),
            'sourceDetail' => array(self::HAS_MANY, 'SourceFileDetail', 'group_id', 'select' => 'group_id,file_id,sort', 'on' => 'isdelete=:isdelete', 'params' => array('isdelete' => 0), 'order' => 'sort ASC'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'admin_id' => '管理员ID',
            'public_id' => '公众号ID',
            'media_id' => '媒体ID',
            'title' => '分组名',
            'description' => '分组描述',
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
        $criteria->select = $this->_select;
        $id = Yii::app()->request->getParam('id');
        if (!empty($id)) {
            $criteria->compare('id', $id);
        }
        $gather = Yii::app()->request->getParam('gather');
        if (!empty($gather)) {
            $criteria->compare('gather_id', $gather);
        }
        $criteria->compare('admin_id', $this->admin_id);
        $criteria->compare('public_id', $this->public_id);
        $criteria->compare('title', $this->title, true);
        $criteria->compare('description', $this->description, true);
        $criteria->compare('status', $this->status);

        $criteria->compare('isdelete', 0);
        $criteria->compare('time_created', $this->time_created);
        $criteria->compare('time_updated', $this->time_updated);
        $criteria->order = 'sort DESC';
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * 查询多图文素材数据
     * @return \CActiveDataProvider
     */
    public function getData() {
        $criteria = new CDbCriteria;
        $criteria->select = $this->_select;
        $criteria->compare('id', $this->id);
        $criteria->compare('gather_id', $this->gather_id);
        $criteria->compare('title', $this->title, true);
        $criteria->compare('description', $this->description, true);
        //$criteria->compare('time_created', $this->time_created);
        //$criteria->compare('time_updated', $this->time_updated);
        $criteria->compare('isdelete', $this->isdelete);
        $template = @Yii::app()->request->getParam('template');
        if ($template > 0) {
            $criteria->compare('template', $template);
            $criteria->compare('public_id', 1);
        } else {
            $criteria->compare('public_id', $this->public_id);
        }

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'PageSize' => $this->_limit,
            ),
            'sort' => array(
                'defaultOrder' => '`time_created` DESC',
            ),
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return SourceFileGroup the static model class
     */
    public static function model($className = __CLASS__) {
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
