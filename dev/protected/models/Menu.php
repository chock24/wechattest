<?php

/**
 * This is the model class for table "{{menu}}".
 *
 * The followings are the available columns in table '{{menu}}':
 * @property integer $id
 * @property integer $public_id
 * @property integer $parent_id
 * @property string $type
 * @property int $multi 
 * @property string $title
 * @property integer $category
 * @property string $description
 * @property integer $source_file_id
 * @property string $key
 * @property string $url
 * @property integer $status
 * @property integer $sort
 * @property integer $isdelete
 * @property integer $time_created
 * @property integer $time_updated
 */
class Menu extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{menu}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            //array('parent_id, type, title, category, source_file_id, key, url, status, sort, isdelete, time_created, time_updated', 'required'),
            array('title', 'required', 'on' => 'insert,update'),
            array('type', 'required', 'on' => 'update'),
            array('public_id, parent_id, multi, category, source_file_id, status, sort, isdelete, time_created, time_updated', 'numerical', 'integerOnly' => true),
            array('title', 'length', 'max' => 8),
            array('key', 'length', 'max' => 128),
            array('key', 'unique'),
            array('url', 'length', 'max' => 200),
            array('description', 'length', 'max' => 2048),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, public_id, parent_id, type, multi, title, category, source_file_id, key, url, status, sort, isdelete, time_created, time_updated', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'childrens' => array(self::HAS_MANY, 'Menu', array('parent_id' => 'id', 'public_id' => 'public_id'), 'select' => 'id,title,type,category,description,source_file_id,url,status', 'on' => 'isdelete=:isdelete', 'params' => array(':isdelete' => 0), 'order' => '`sort` ASC'),
            'sourceFile' => array(self::BELONGS_TO, 'SourceFile', 'source_file_id', 'select' => 'length,id,title,description,filename,ext,time_created', 'on' => 'isdelete=:isdelete', 'params' => array(':isdelete' => 0)),
            'sourceFileGroup' => array(self::BELONGS_TO, 'SourceFileGroup', 'source_file_id', 'select' => 'id,title,description,time_created', 'on' => 'isdelete=:isdelete', 'params' => array(':isdelete' => 0)),
        );
    }
    

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'public_id' => '所属公众号',
            'parent_id' => '所属上级',
            'type' => '菜单类型',
            'title' => '菜单名',
            'category' => '发送类型',
            'description' => '文本内容',
            'source_file_id' => '内容ID',
            'key' => '菜单KEY值，用于消息接口推送，不超过128字节',
            'url' => '发送链接地址',
            'status' => '数据状态',
            'sort' => '排序',
            'isdelete' => '是否删除',
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
        $criteria->compare('public_id', $this->public_id);
        $criteria->compare('parent_id', $this->parent_id);
        $criteria->compare('type', $this->type);
        $criteria->compare('multi', $this->multi);
        $criteria->compare('title', $this->title, true);
        $criteria->compare('category', $this->category);
        $criteria->compare('source_file_id', $this->source_file_id);
        $criteria->compare('key', $this->key, true);
        $criteria->compare('url', $this->url, true);
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
     * @return Menu the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /*
     * 储存入数据库前操作
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
