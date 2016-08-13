<?php

/**
 * This is the model class for table "{{reply}}".
 *
 * The followings are the available columns in table '{{reply}}':
 * @property integer $id
 * @property integer $admin_id
 * @property integer $public_id
 * @property integer $rule_id
 * @property integer $type
 * @property integer $multi
 * @property string $content
 * @property integer $source_file_id
 * @property integer $status
 * @property integer $sort
 * @property integer $isdelete
 * @property integer $time_created
 * @property integer $time_updated
 */
class Reply extends CActiveRecord {

    public $number;
    
    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{reply}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('admin_id, public_id, rule_id, type, content, source_file_id, ', 'required'),
            array('admin_id, public_id, rule_id, type, multi, source_file_id, status, sort, isdelete, time_created, time_updated', 'numerical', 'integerOnly' => true),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, admin_id, public_id, rule_id, type, multi, content, source_file_id, status, sort, isdelete, time_created, time_updated', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'sourceFile'=>array(self::BELONGS_TO,'SourceFile','source_file_id', 'select' => 'length,filename,ext,title,description', 'on' => 'isdelete=:isdelete', 'params' => array('isdelete' => 0)),
            'multiSourceFile'=>array(self::BELONGS_TO,'SourceFileGroup','source_file_id', 'select' => 'id,title,description', 'on' => 'isdelete=:isdelete', 'params' => array('isdelete' => 0)),
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
            'rule_id' => 'Rule',
            'type' => '发送类型',
            'multi' => '是否是多图文',
            'content' => '回复内容',
            'source_file_id' => '内容ID',
            'status' => '数据状态',
            'sort' => '排序',
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
        $criteria->compare('rule_id', $this->rule_id);
        $criteria->compare('type', $this->type);
        $criteria->compare('multi', $this->multi);
        $criteria->compare('content', $this->content, true);
        $criteria->compare('source_file_id', $this->source_file_id);
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
     * @return Reply the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * 在存入数据库前的操作
     */
    public function beforeSave() {
        if(parent::beforeSave()){
            if($this->isNewRecord){
                $this->admin_id = Yii::app()->user->id;
                $this->public_id = Yii::app()->user->getState('public_id');
            }
            return true;
        }else{
            return false;
        }
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
