<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
	public $user;
	/**
	 * Authenticates a user.
	 * The example implementation makes sure if the username and password
	 * are both 'demo'.
	 * In practical applications, this should be changed to authenticate
	 * against some persistent user identity storage (e.g. database).
	 * @return boolean whether authentication succeeds.
	 */
	public function authenticate()
	{	
		$this->user = Sysuser::model()->find('csc_user=:user', array(':user'=>$this->username));
		if(!$this->user){
			return '用户不存在';
		}
		
		if($this->user->csc_password != BaseApi::system_md5($this->password)){
			return '密码错误';
		}
		
		if($this->user->csc_locked){
			return '帐号已锁定';
		}
		
		return false;
	}
	
	static public function isLogin(){
		$sesion = Yii::app()->session;
		$cookie = Yii::app()->request->getCookies();
		
		if(isset($sesion['sysuser_id']) && isset($sesion['sysuser_user']) && isset($sesion['sysuser_tname']) && isset($sesion['sysuser_phone']) &&
			isset($cookie['sysuser_id']) && isset($cookie['sysuser_user']) && isset($cookie['sysuser_tname']) && isset($cookie['sysuser_phone']) && 
				isset($cookie['stoken'])){
			
			if($sesion['sysuser_id']==$cookie['sysuser_id']->value && $sesion['sysuser_user']==$cookie['sysuser_user']->value &&
				$sesion['sysuser_tname']==$cookie['sysuser_tname']->value && $sesion['sysuser_phone']==$cookie['sysuser_phone']->value){
				
				$ses = array(
					'sysuser_id' => $sesion['sysuser_id'],
					'sysuser_user' => $sesion['sysuser_user'],
					'sysuser_tname' => $sesion['sysuser_tname'],
					'sysuser_phone' => $sesion['sysuser_phone'],
					'sysuser_role_id' => $sesion['sysuser_role_id'],
					'sysuser_time' => $sesion['sysuser_time'],
				);
				
				$confuse = Yii::app()->params['confuse'];
				$token = md5(base64_encode(json_encode($ses)). $confuse);
				
				return $token == $cookie['stoken']->value;
			}
		}
		return false;
	}
	
	/**
	 * 根据SESSION_ID自动登录
	 * @param String $session_id
	 */
	static public function autologinBySessionID($session_id){
		if(!$session_id) return ;
		
		//Yii::app()->session->destroy();
		Yii::app()->session->setSessionID($session_id);
		Yii::app()->session->open();
		$sesion = Yii::app()->session;
		
		$ses = array(
			'sysuser_id' => $sesion['sysuser_id'],
			'sysuser_user' => $sesion['sysuser_user'],
			'sysuser_tname' => $sesion['sysuser_tname'],
			'sysuser_phone' => $sesion['sysuser_phone'],
            'sysuser_role_id' => $sesion['sysuser_role_id'],
			'sysuser_time' => $sesion['sysuser_time'],
		);
		
		$cookie_config = Yii::app()->params['cookie'];
		$cookie_config['expire'] = time() + '3600';
		
		foreach ($ses as $k=>$v){
			$v = $v ? $v : ' ';
			
			$cookie = new CHttpCookie($k, $v, $cookie_config);
			Yii::app()->request->cookies[$k] = $cookie;
			
			$ses[$k] = $v;
		}
		
		$confuse = Yii::app()->params['confuse'];
		$stoken = md5(base64_encode(json_encode($ses)). $confuse);
		
		$cookie = new CHttpCookie('stoken', $stoken, $cookie_config);
		Yii::app()->request->cookies['stoken'] = $cookie;
	}
	
}