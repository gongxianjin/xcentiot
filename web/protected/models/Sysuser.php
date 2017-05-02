<?php
class Sysuser extends SubCActiveRecord{
	
	public $captcha;
	public $csc_user;
	public $csc_phone;
	public $csc_password;
	public $csc_pwd;
	public $csc_tname;
	public $csc_oldpwd;
	
	/**
	 * 两个方法
	 * Enter description here ...
	 * @param unknown_type $className
	 */
	public static  function model($className=__CLASS__){
		return parent::model($className);
	}

	public function tableName(){
		return "{{sysuser}}";
	}
	
	/**
	 * 验证方法
	 * (non-PHPdoc)
	 * @see CModel::rules()
	 */
	public function rules(){
		return array(
			array('csc_pwd', 'compare', 'compareAttribute' => 'csc_password', 'message' => '两次密码输入不一致', 'on'=>'create,update'),
			array('csc_user,csc_password', 'required', 'message'=>'用户名密码不能为空', 'on'=>'create'),
			array('csc_user', 'checkuser', 'on'=>'create'),
			array('csc_phone', 'checkphone', 'on'=>'create'),
			array('csc_locked', 'in', 'range'=>array_keys(Yii::app()->params['lock']), 'on'=>'create'),
			array('csc_tname', 'length', 'max'=>20, 'tooLong'=>'姓名太长了', 'on'=>'create,update'),
		);
	}
	
	public function checkuser(){
		if(!$this->hasErrors()){
			$result = $this->find('csc_user=:user',array(':user'=>$this->csc_user));
			if($result){
				$this->addError('csc_user', '用户已存在');
			}
		}
	}
	
	public function checkphone(){
		
		if(!$this->hasErrors()){
			if($this->csc_phone && !ParamApi::check($this->csc_phone, 'mobile')){
				$this->addError('csc_phone', '手机号有误');
			}else{
				$result = $this->find('csc_phone=:phone',array(':phone'=>$this->csc_phone));
				if($result){
					$this->addError('csc_phone', '手机号已存在');
				}
			}
			
		}
	}
	
	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'role' => array(self::HAS_ONE, 'Sysrole', array('csc_id'=>'csc_role_id')),
		);
	}
	
	/**
	 * 默认填充数据
	 * @see CActiveRecord::save()
	 */
	public function save($runValidation=true,$attributes=null){
		if(!$runValidation || $this->validate($attributes)){
			
			if($this->getIsNewRecord()){
				$this->csc_id = getPrimaryKey();
				//$this->csc_role_id = 0;
				$this->csc_reg_time = date('Y-m-d H:i:s');
				$this->csc_login_time = $this->csc_reg_time;
				$this->csc_create = $this->csc_reg_time;
				
				return $this->insert($attributes);
			}else{
				return $this->update($attributes);
			}
		}else
			return false;
	}
	
}