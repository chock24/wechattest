<?php

/**
 * This is the model class for table "{{auto}}".
 *
 * The followings are the available columns in table '{{auto}}':
 * @property integer $id
 * @property integer $admin_id
 * @property integer $public_id
 * @property integer $type
 * @property string $content
 * @property integer $source_file_id
 * @property integer $timing
 * @property integer $time_start
 * @property integer $time_end
 * @property integer $status
 * @property integer $sort
 * @property integer $isdelete
 * @property integer $time_created
 * @property integer $time_updated
 */
class Auto extends CActiveRecord {
    
    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{auto}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            //array('admin_id, public_id, type, content, source_file_id, timing, time_start, time_end, status, sort, isdelete, time_created, time_updated', 'required'),
            array('content','length','max'=>2048),
            array('admin_id, public_id, type, source_file_id, status, sort, isdelete, time_created, time_updated', 'numerical', 'integerOnly' => true),
            array('timing, time_start, time_end','safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, admin_id, public_id, type, content, source_file_id, timing, time_start, time_end, status, sort, isdelete, time_created, time_updated', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'sourceFile'=>array(self::BELONGS_TO,'SourceFile','source_file_id','select'=>'length,id,title,description,filename,ext,time_created','on'=>'isdelete=:isdelete','params'=>array(':isdelete'=>0)),
            'sourceFileGroup'=>array(self::BELONGS_TO,'sourceFileGroup','source_file_id','select'=>'id,title,description,time_created','on'=>'isdelete=:isdelete','params'=>array(':isdelete'=>0)),
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
            'type' => '发送类型',
            'content' => '回复内容',
            'source_file_id' => '内容ID',
            'timing' => '是否定时开启',
            'time_start' => '开始时间',
            'time_end' => '结束时间',
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
        $criteria->compare('admin_id', $this->admin_id);
        $criteria->compare('public_id', $this->public_id);
        $criteria->compare('type', $this->type);
        $criteria->compare('content', $this->content, true);
        $criteria->compare('source_file_id', $this->source_file_id);
        $criteria->compare('timing', $this->timing);
        $criteria->compare('time_start', $this->time_start);
        $criteria->compare('time_end', $this->time_end);
        $criteria->compare('status', $this->status);
        $criteria->compare('sort', $this->sort);
        $criteria->compare('isdelete', $this->isdelete);
        $criteria->compare('time_created', $this->time_created);
        $criteria->compare('time_updated', $this->time_updated);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /*
     * 保存管理员ID到自动回复
     */

    public function beforeSave() {
        if (parent::beforeSave()) {
            if ($this->isNewRecord) {
                $this->admin_id = Yii::app()->user->id;
                $this->public_id = Yii::app()->user->getState('public_id');
            }
            return true;
        } else {
            return false;
        }
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Auto the static model class
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
