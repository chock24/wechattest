
<?php

/**
 * This is the model class for table "{{user}}".
 *
 * The followings are the available columns in table'{{user}}':
 * @property integer $id
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
 * @property string $mobile
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
 * @property integer $status
 * @property integer $sort
 * @property integer $isdelete
 * @property integer $time_created
 * @property integer $time_updated
 */
class User extends CActiveRecord {

    public $tag; //用户标签
    public $_select = '*';
    public $code;//验证码

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return'{{user}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('openid', 'unique'),
            array('public_id, source, star, level, group_id, sex, age, country, province, city, district, subscribe_time, integral, time_message_last, status, sort, isdelete, time_created, time_updated', 'numerical', 'integerOnly' => true),
            array('openid, subscribe, headimgurl, unionid', 'length', 'max' => 200),
            array('nickname, remark, mobile, language', 'length', 'max' => 55),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, public_id, source, openid, nickname, star, level, group_id, remark, subscribe, headimgurl, mobile, sex, age, language, country, province, city, district, subscribe_time, unionid, integral, time_message_last, status, sort, isdelete, time_created, time_updated', 'safe', 'on' => 'search'),
           // array('mobile', 'required'),
                // array('mobile', 'match', 'pattern' => '/^1[3|4|5|8][0-9]\d{4,8}$/', 'message' => '请正确填写手机号，谢谢'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'countries' => array(self::BELONGS_TO, 'District', 'country'), //用户所在国家
            'provinces' => array(self::BELONGS_TO, 'District', 'province'), //用户所在省份
            'cities' => array(self::BELONGS_TO, 'District', 'city'), //用户所在城市
            'levels' => array(self::BELONGS_TO, 'UserLevel', 'level'), //用户等级
            //'groups'=>array(self::BELONGS_TO,'UserGroup','group_id'),//用户分组
            'groups' => array(self::BELONGS_TO, 'UserGroup', 'group_id', 'select' => 'id,name', 'condition' => 'public_id=:public_id AND isdelete=:isdelete', 'params' => array(':public_id' => Yii::app()->user->getState('public_id'), ':isdelete' => 0)),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => '用户ID',
            'public_id' => '属于哪个帐号',
            'source' => '客户来源',
            'openid' => '客户唯一ID',
            'nickname' => '昵称',
            'star' => '星标用户',
            'level' => '用户等级',
            'name' => '真实姓名',
            'group_id' => '分组',
            'remark' => '备注名',
            'subscribe' => '是否关注',
            'headimgurl' => '头像',
            'mobile' => '手机号码',
            'sex' => '性别',
            'age' => '年龄',
            'language' => '语言',
            'country' => '所在国家',
            'province' => '所在省份',
            'city' => '所在城市',
            'district' => '地域',
            'subscribe_time' => '关注时间',
            'unionid' => 'UnionID机制',
            'integral' => '积分',
            'time_message_last' => '最后对话',
            'status' => '数据状态',
            'tag' => '标签',
            'sort' => 'Sort',
            'isdelete' => 'Isdelete',
            'time_created' => 'Time Created',
            'time_updated' => 'Time Updated',
            'code'=>'验证码 ',
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
        
        $criteria->compare('public_id', $this->public_id);
        $criteria->compare('source', $this->source);
        $criteria->compare('openid', $this->openid, true);
        $criteria->compare('nickname', $this->nickname, true);
        $criteria->compare('star', $this->star);
        $criteria->compare('group_id', $this->group_id);
        //$criteria->compare('remark', $this->remark, true);
        if(!empty($this->nickname)){
        $criteria->addCondition("remark like '%".$this->nickname."%' AND public_id =". $this->public_id, 'OR');    
        }
        
        $criteria->compare('subscribe', $this->subscribe, true);
        $criteria->compare('headimgurl', $this->headimgurl, true);
        $criteria->compare('sex', $this->sex);
        $criteria->compare('age', $this->age);
        $criteria->compare('language', $this->language, true);
        $criteria->compare('country', $this->country);
        $criteria->compare('province', $this->province);
        $criteria->compare('city', $this->city);
        $criteria->compare('district', $this->district);
        $criteria->compare('subscribe_time', $this->subscribe_time);
        $criteria->compare('unionid', $this->unionid, true);
        $criteria->compare('status', $this->status);
        $criteria->compare('sort', $this->sort);
        $criteria->compare('isdelete', $this->isdelete);
        $criteria->compare('time_created', $this->time_created);
        $criteria->compare('time_updated', $this->time_updated);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 50,
            ),
            'sort' => array(
                'defaultOrder' => '`subscribe_time` DESC',
            ),
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return User the static model class
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
