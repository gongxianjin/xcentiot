<?php

/**
 * 前台用户组件
 * Enter description here ...
 * @author Administrator
 *
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
		$this->user = Member::model()->find('csc_user=:user', array(':user'=>$this->username));
		if(!$this->user){
			return '用户不存在';
		}

		if($this->user->csc_pwd != BaseApi::system_md5($this->password)){
			return '密码错误';
		}

		if($this->user->csc_lock){
			return '帐号已锁定';
		}

		return false;
	}
	
	/**
	 * 检测用户是否登录
	 * Enter description here ...
	 */
	static public function isLogin(){
			
		$sesion = Yii::app()->session;
		$cookie = Yii::app()->request->getCookies();
		if(isset($sesion['user_id']) && isset($sesion['user_user']) && isset($sesion['user_email']) && isset($sesion['user_phone']) && isset($sesion['user_nichen']) && isset($sesion['user_type']) &&
			isset($cookie['user_id']) && isset($cookie['user_user']) && isset($cookie['user_email']) && isset($cookie['user_phone']) && isset($cookie['user_nichen']) && isset($cookie['user_type']) && 
				isset($cookie['token'])){
					
			if($sesion['user_id']==$cookie['user_id']->value && $sesion['user_user']==$cookie['user_user']->value &&
				$sesion['user_nichen']==$cookie['user_nichen']->value && $sesion['user_phone']==$cookie['user_phone']->value &&
				$sesion['user_type']==$cookie['user_type']->value && $sesion['user_email']==$cookie['user_email']->value
				){
				$ses = array(
					'user_id' => $sesion['user_id'],
					'user_user' => $sesion['user_user'],
					'user_phone' => $sesion['user_phone'],
					'user_email' => $sesion['user_email'],
					'user_nichen' => $sesion['user_nichen'],
					'user_type' => $sesion['user_type'],
				);
				
				$confuse = Yii::app()->params['confuse'];
				$token = md5(base64_encode(json_encode($ses)). $confuse);
				return $token == $cookie['token']->value;
			}
		}
		return false;
	}
}