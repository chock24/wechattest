<?php

/**
 * This is the model class for table "{{user_group}}".
 *
 * The followings are the available columns in table '{{user_group}}':
 * @property integer $id
 * @property integer $public_id
 * @property integer $group_id
 * @property string $name
 * @property integer $count
 * @property integer $status
 * @property integer $sort
 * @property integer $isdelete
 * @property integer $time_created
 * @property integer $time_updated
 */
class UserGroup extends CActiveRecord {

    public $time_start;
    public $time_end;

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{user_group}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('name, count', 'required'),
            //array('group_id','unique'),
            array('public_id, group_id, count, status, sort, isdelete, time_created, time_updated', 'numerical', 'integerOnly' => true),
            array('name', 'length', 'max' => 55),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, public_id, group_id, name, count, status, sort, isdelete, time_created, time_updated, time_start, time_end', 'safe', 'on' => 'search'),
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
            'public_id' => '所属公众号',
            'group_id' => '微信公众平台的group_id',
            'name' => '分组名',
            'count' => '分组内用户数量',
            'status' => '数据状态',
            'sort' => '排序',
            'isdelete' => 'Isdelete',
            'time_created' => '创建时间',
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
        $criteria->compare('public_id', $this->public_id);
        $criteria->compare('group_id', $this->group_id);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('count', $this->count);
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
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return UserGroup the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /*
     * 保存管理员ID到二维码数据
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
