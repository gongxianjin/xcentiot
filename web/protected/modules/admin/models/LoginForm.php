<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class LoginForm extends CFormModel
{
	public $username;
	public $password;
	public $rememberMe;
	public $captcha;

	private $_identity;

	/**
	 * Declares the validation rules.
	 * The rules state that username and password are required,
	 * and password needs to be authenticated.
	 */
	public function rules()
	{
		return array(
			//array('captcha', 'chkcaptcha', 'message'=>'验证码有误'),
			array('username, password', 'required'),
			array('password', 'authenticate'),
		);
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
			'rememberMe'=>'Remember me next time',
		);
	}

	/**
	 * Authenticates the password.
	 * This is the 'authenticate' validator as declared in rules().
	 */
	public function authenticate()
	{
		if(!$this->hasErrors())
		{
			$this->_identity = new UserIdentity($this->username, $this->password);
			$indenty = $this->_identity->authenticate();
			if($indenty){
				$this->addError('error', $indenty);
			}
		}
	}
	
	public function chkcaptcha(){
		
		if(strtolower($this->captcha) != strtolower(Yii::app()->session['captcha'])){
			$this->addError('captcha', '验证码有误');
		}
		// 清空验证码
		unset(Yii::app()->session['captcha']);
	}

	/**
	 * Logs in the user using the given username and password in the model.
	 * @return boolean whether login is successful
	 */
	public function login()
	{
		if($this->_identity===null){
			$this->_identity = new UserIdentity($this->username,$this->password);
		}
		
		$identy = $this->_identity->authenticate();
		if($identy){
			$this->addError('error', $identy);
			return false;
		}
		
		$user = $this->_identity->user;
		$p = array(
			'csc_login_time' => date('Y-m-d H:i:s'),
			'csc_login_ip' => Yii::app()->request->userHostAddress,
		);
		$count = Sysuser::model()->updateByPk($user->csc_id, $p, 'csc_id=:id', array(':id'=>$user->csc_id));
		if(!$count){
			$this->addError('error', '数据更新失败');
			return false;
		}
		
		$ses = array(
			'sysuser_id' => $user->csc_id,
			'sysuser_user' => $user->csc_user,
			'sysuser_tname' => $user->csc_tname,
			'sysuser_phone' => $user->csc_phone,
			//'sysuser_role_id' => $sesion['sysuser_role_id'],
			'sysuser_role_id' => $user->csc_role_id,
			'sysuser_time'=> date('Y-m-d H:i:s'),
		);
		
		$cookie_config = Yii::app()->params['cookie'];
		$cookie_config['expire'] = time() + '3600';
		
		foreach ($ses as $k=>$v){
			$v = $v ? $v : ' ';
			Yii::app()->session[$k] = $v;
			
			$cookie = new CHttpCookie($k, $v, $cookie_config);
			Yii::app()->request->cookies[$k] = $cookie;
			
			$ses[$k] = $v;
		}
		
		$confuse = Yii::app()->params['confuse'];
		$stoken = md5(base64_encode(json_encode($ses)). $confuse);
		
		$cookie = new CHttpCookie('stoken', $stoken, $cookie_config);
		Yii::app()->request->cookies['stoken'] = $cookie;
		
		return true;
	}
}
