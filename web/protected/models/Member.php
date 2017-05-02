<?php

/**
 * This is the model class for table "{{user}}".
 *
 * The followings are the available columns in table '{{user}}':
 * @property integer $csc_id
 * @property string $csc_username
 * @property string $csc_phone
 * @property string $csc_email
 * @property string $csc_identity
 * @property string $csc_tname
 * @property string $csc_nichen
 * @property string $csc_pwd
 * @property string $csc_type
 * @property string $csc_login_time
 * @property string $csc_login_ip
 * @property string $csc_lock
 * @property string $csc_reg_time
 * @property string $csc_reg_ip
 * @property string $csc_sex
 * @property string $csc_header
 * @property string $csc_age
 * @property string $csc_jobs
 * @property string $csc_company
 * @property string $csc_education
 * @property string $csc_primary
 * @property string $csc_middle
 * @property string $csc_college
 * @property string $csc_address
 * @property string $csc_ratio
 */
class Member extends SubCActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{user}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('csc_username', 'required', 'message'=>'用户名不能为空'),
			array('csc_phone', 'required', 'message'=>'手机号不能为空'),
			array('csc_pwd', 'required', 'message'=>'密码不能为空'),
			array('csc_id', 'numerical', 'integerOnly'=>true),
			array('csc_username, csc_tname, csc_nichen, csc_login_ip, csc_reg_ip, csc_education', 'length', 'max'=>20),
			array('csc_phone', 'length', 'max'=>13),
			array('csc_email, csc_jobs, csc_company, csc_primary, csc_middle, csc_college, csc_address', 'length', 'max'=>50),
			array('csc_pwd', 'length', 'max'=>32),
			array('csc_type, csc_lock, csc_sex', 'length', 'max'=>1),
			array('csc_header', 'length', 'max'=>200),
			array('csc_age', 'length', 'max'=>3),
			array('csc_login_time', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('csc_id, csc_username, csc_phone, csc_identity,csc_email, csc_tname, csc_nichen, csc_pwd, csc_type, csc_login_time, csc_login_ip, csc_lock, csc_reg_time, csc_reg_ip, csc_sex, csc_header, csc_age, csc_jobs, csc_company, csc_education, csc_primary, csc_middle, csc_college, csc_address', 'safe', 'on'=>'search'),
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
			'store' => array(self::HAS_ONE, 'Store', array('csc_user_id'=>'csc_id')),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'csc_id' => '主键',
			'csc_username' => '用户名',
			'csc_phone' => '手机号',
			'csc_email' => '邮箱',
			'csc_identity'=>'身份证号',
			'csc_tname' => '真实姓名',
			'csc_nichen' => '昵称',
			'csc_pwd' => '密码',
			'csc_type' => '类型',
			'csc_login_time' => '登录时间',
			'csc_login_ip' => '登录ip地址',
			'csc_lock' => '是否锁定',
			'csc_reg_time' => '注册时间',
			'csc_reg_ip' => '注册ip地址',
			'csc_sex' => '性别',
			'csc_header' => '头像',
			'csc_age' => '年龄',
			'csc_jobs' => '职业',
			'csc_company' => '公司名',
			'csc_education' => '学历',
			'csc_primary' => '小学校名',
			'csc_middle' => '中学校名',
			'csc_college' => '大学校名',
			'csc_address' => '家庭地址',
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
		$criteria->compare('csc_id',$this->csc_id);
		$criteria->compare('csc_username',$this->csc_username,true);
		$criteria->compare('csc_phone',$this->csc_phone,true);
		$criteria->compare('csc_email',$this->csc_email,true);
		$criteria->compare('csc_identity',$this->csc_identity,true);
		$criteria->compare('csc_tname',$this->csc_tname,true);
		$criteria->compare('csc_nichen',$this->csc_nichen,true);
		$criteria->compare('csc_pwd',$this->csc_pwd,true);
		$criteria->compare('csc_type',$this->csc_type,true);
		$criteria->compare('csc_login_time',$this->csc_login_time,true);
		$criteria->compare('csc_login_ip',$this->csc_login_ip,true);
		$criteria->compare('csc_lock',$this->csc_lock,true);
		$criteria->compare('csc_reg_time',$this->csc_reg_time,true);
		$criteria->compare('csc_reg_ip',$this->csc_reg_ip,true);
		$criteria->compare('csc_sex',$this->csc_sex,true);
		$criteria->compare('csc_header',$this->csc_header,true);
		$criteria->compare('csc_age',$this->csc_age,true);
		$criteria->compare('csc_jobs',$this->csc_jobs,true);
		$criteria->compare('csc_company',$this->csc_company,true);
		$criteria->compare('csc_education',$this->csc_education,true);
		$criteria->compare('csc_primary',$this->csc_primary,true);
		$criteria->compare('csc_middle',$this->csc_middle,true);
		$criteria->compare('csc_college',$this->csc_college,true);
		$criteria->compare('csc_address',$this->csc_address,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Member the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	
	
	public function checkuser(){
		if(!$this->hasErrors()){
			$cond = new CDbCriteria();
			$cond->addCondition('csc_user=:user');
			$cond->params['user'] = $this->csc_user;
			
			if(!$this->getIsNewRecord()){
				$cond->addCondition('csc_id!=:id');
				$cond->params['id'] = $this->csc_id;
			}
			
			$num = $this->count($cond);
			if($num){
				$this->addError('csc_user', '用户已存在');
			}
		}
	}

	public function chkPhone(){
		if(!$this->hasErrors()){
			if($this->csc_phone && !ParamApi::check($this->csc_phone, 'mobile')){
				$this->addError('csc_phone', '手机号码格式有误');
			}
		}
			
		if(!$this->hasErrors()){
			
			$cond = new CDbCriteria();
			$cond->addCondition('csc_phone=:phone');
			$cond->params['phone'] = $this->csc_phone;

			if(!$this->getIsNewRecord()){
				$cond->addCondition('csc_id!=:id');
				$cond->params['id'] = $this->csc_id;
			}
				
			$num = $this->count($cond);
			if($num){
				$this->addError('csc_phone', '手机号已注册');
			}
			
		}
	}

	public function checkemail(){

		if(!$this->hasErrors()){
			
			$cond = new CDbCriteria();
			$cond->addCondition('csc_email=:email');
			$cond->params['email'] = $this->csc_email;
			
			if(!$this->getIsNewRecord()){
				$cond->addCondition('csc_id!=:id');
				$cond->params['id'] = $this->csc_id;
			}

			$num = $this->count($cond);
			if($num){
				$this->addError('csc_email', '邮箱已注册');
			}
		}
	}

	/**
	 * 默认填充数据
	 * @see CActiveRecord::save()
	 */
	public function save($runValidation=true,$attributes=null){
		if(!$runValidation || $this->validate($attributes)){

			if($this->getIsNewRecord()){
				$this->csc_id = getPrimaryKey($this);
				$this->csc_lock = 0;
				$this->csc_reg_time = date('Y-m-d H:i:s');
				$this->csc_ratio = 3;
				$this->csc_reg_ip = Yii::app()->request->userHostAddress;
				return $this->insert($attributes);
			}else{
				return $this->update($attributes);
			}
		}else{
			return false;
		}
	}
	
}
