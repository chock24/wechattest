<?php

/**
 * This is the model class for table "{{admin}}".
 *
 * The followings are the available columns in table '{{admin}}':
 * @property integer $id
 * @property string $username
 * @property string $password
 * @property string $company
 * @property integer $phone
 * @property integer $province
 * @property integer $city
 * @property integer $district
 * @property integer $unicom
 * @property integer $bound
 * @property integer $role_id
 * @property integer $status
 * @property integer $sort
 * @property integer $isdelete
 * @property integer $time_created
 * @property integer $time_updated
 */
class Admin extends CActiveRecord {
    
    public $repeat;
    public $old_password;
    public $_select = '*';

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{admin}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('username, name, role_id', 'required'),
            array('password, repeat', 'required', 'on'=>'insert'),
            array('unicom, bound, role_id, phone, province, city, district, status, sort, isdelete, time_created, time_updated', 'numerical', 'integerOnly' => true),
            array('username, name', 'length', 'max' => 55),
            array('company, password', 'length', 'max' => 200),
            array('repeat','compare','compareAttribute'=>'password'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, username, password, name, role_id, group_id, company, phone, province, city, district, status, sort, isdelete, time_created, time_updated', 'safe', 'on' => 'search'),
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
            'username' => '用户名',
            'password' => '密码',
            'repeat' => '确认密码',
            'name' => '姓名',
            'role_id' => '管理员级别',
            'group_id' => '管理员分组',
            'phone' => '手机号码',
            'company' => '公司名称',
            'province' => '所在地',
            'unicom' => '公众号素材共享',
            'bound' => '可绑定公众号数量',
            'status' => '数据状态',
            'sort' => 'Sort',
            'isdelete' => 'Isdelete',
            'time_created' => '创建时间',
            'time_updated' => '修改时间',
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

        $criteria->compare('username', $this->username, true);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('company', $this->company, true);
        $criteria->compare('role_id', $this->role_id);
        $criteria->compare('group_id', $this->group_id);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize'=>50,
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
     * @return Admin the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    
    public function validationPassword($password) {
        return crypt($password, $this->password) === $this->password;
    }

    public function hashPassword($password) {
        return crypt($password, $this->generateSalt());
    }

    /**
     * Generates a salt that can be used to generate a password hash.
     *
     * The {@link http://php.net/manual/en/function.crypt.php PHP `crypt()` built-in function}
     * requires, for the Blowfish hash algorithm, a salt string in a specific format:
     *  - "$2a$"
     *  - a two digit cost parameter
     *  - "$"
     *  - 22 characters from the alphabet "./0-9A-Za-z".
     *
     * @param int cost parameter for Blowfish hash algorithm
     * @return string the salt
     */
    protected function generateSalt($cost = 10) {
        if (!is_numeric($cost) || $cost < 4 || $cost > 31) {
            throw new CException(Yii::t('长度必须要在4字符以上与31字符以下'));
        }
        // Get some pseudo-random data from mt_rand().
        $rand = '';
        for ($i = 0; $i < 8; ++$i) {
            $rand.=pack('S', mt_rand(0, 0xffff));
        }
        // Add the microtime for a little more entropy.
        $rand.=microtime();
        // Mix the bits cryptographically.
        $rand = sha1($rand, true);
        // Form the prefix that specifies hash algorithm type and cost parameter.
        $salt = '$2a$' . str_pad((int) $cost, 2, '0', STR_PAD_RIGHT) . '$';
        // Append the random salt string in the required base64 format.
        $salt.=strtr(substr(base64_encode($rand), 0, 22), array('+' => '.'));
        return $salt;
    }
    
    /*
     * 保存入数据库前操作
     */
    public function beforeSave() {
        if (parent::beforeSave()) {
            if ($this->isNewRecord) {
                $this->password = self::model()->hashPassword($this->password);
            }else{
                $this->password = !empty($this->password)?self::model()->hashPassword($this->password):$this->old_password;
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
