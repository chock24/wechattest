<?php

/**
 * This is the model class for table "{{log_error}}".
 *
 * The followings are the available columns in table '{{log_error}}':
 * @property integer $id
 * @property integer $admin_id
 * @property string $ip
 * @property integer $error_code
 * @property string $content
 * @property string $error_url
 * @property string $from_url
 * @property integer $status
 * @property integer $sort
 * @property integer $isdelete
 * @property integer $time_created
 * @property integer $time_updated
 */
class LogError extends CActiveRecord {

    public $_select ='*';
    public $time_start;
    public $time_end;
    
    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{log_error}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('error_code, content', 'required'),
            array('admin_id, error_code, status, sort, isdelete, time_created, time_updated', 'numerical', 'integerOnly' => true),
            array('ip', 'length', 'max' => 20),
            array('content, error_url, from_url', 'length', 'max' => 255),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, admin_id, ip, error_code, content, error_url, from_url, status, sort, isdelete, time_created, time_updated, time_start, time_end', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'admin_id' => '管理员',
            'ip' => '登录IP',
            'error_code' => '错误代码',
            'content' => '错误描述',
            'error_url' => '错误页面',
            'from_url' => '来源页面',
            'status' => 'Status',
            'sort' => 'Sort',
            'isdelete' => 'Isdelete',
            'time_created' => '出错时间',
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
        $criteria->compare('id', $this->id);
        $criteria->compare('admin_id', $this->admin_id);
        $criteria->compare('ip', $this->ip, true);
        $criteria->compare('error_code', $this->error_code);
        $criteria->compare('content', $this->content, true);
        $criteria->compare('error_url', $this->error_url, true);
        $criteria->compare('from_url', $this->from_url, true);
        $criteria->compare('status', $this->status);
        $criteria->compare('sort', $this->sort);
        $criteria->compare('isdelete', $this->isdelete);
        //$criteria->compare('time_created', $this->time_created);
        //$criteria->compare('time_updated', $this->time_updated);
        if (!empty($this->time_start) && !empty($this->time_end)) {
            $criteria->addBetweenCondition('time_created', strtotime($this->time_start), strtotime($this->time_end) + 3600 * 24);
        }

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 50,
            ),
            'sort'=>array(
                'defaultOrder'=>'`time_created` DESC',
            ),
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return LogError the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    
    /*
     * 储存入数据库前操作
     */
    public function beforeSave() {
        if(parent::beforeSave()){
            if($this->isNewRecord){
                $this->error_url = Yii::app()->request->url;
                $this->from_url = Yii::app()->request->urlReferrer;
                $this->admin_id = Yii::app()->user->id;
                $this->ip = Yii::app()->request->userHostAddress;
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
