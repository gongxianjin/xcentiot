<?php
/**
 * 登录注销控制器
 */
class UserController extends Controller{

	public function actionLogin(){
		if(Yii::app()->request->isPostRequest){
			$form = new LoginForm('login');
			$form->setAttributes($_POST);

			$form->getValidators();
			if(!$form->validate()){
				$error = implode('', current($form->getErrors()));
				$this->jsonMsg(500, $error);
			}
			if(!$form->login()){
				$error = implode('', current($form->getErrors()));
				$this->jsonMsg(505, $error);
			}

			$this->addOperLog($form->username.'登录系统');

			$this->jsonMsg(200, '登录成功', '', $this->createUrl('/admin/'));
		}

		$this->layout=false;
		return $this->render('login');
	}


	//注销
	public function actionLogout(){
		//    	Yii::app()->session->clear();
		//    	Yii::app()->session->destroy();
			
		$k = array(
    		'sysuser_id', 'sysuser_user', 'sysuser_tname', 'sysuser_phone','sysuser_time'
		);
			
		$cookie_config = Yii::app()->params['cookie'];
		$cookie_config['expire'] = 0;
		foreach ($k as $v){
			unset(Yii::app()->session[$v]);
			unset(Yii::app()->request->cookies[$v]);

			$cookie = new CHttpCookie($v, null, $cookie_config);
			Yii::app()->request->cookies[$v] = $cookie;
		}
		$cookie = new CHttpCookie('stoken', null, $cookie_config);
		Yii::app()->request->cookies['stoken'] = $cookie;
			
		$this->redirect(array('user/login'));
	}


	//修改密码
	public function actionPasswd(){
			
		if(Yii::app()->request->isPostRequest){
			$model = new Sysuser('update');
			//$model->csc_user=Yii::app()->request->getParam('user_name');

			$model->csc_oldpwd=Yii::app()->request->getParam('oldpwd');
			$model->csc_password=Yii::app()->request->getParam('newpwd');
			$model->csc_pwd=Yii::app()->request->getParam('password_confirm');
			if($model->csc_oldpwd==null || $model->csc_password==null || $model->csc_pwd==null){
				$this->jsonMsg(501, '参数有误');
			}
			if($model->csc_password != $model->csc_pwd){
				$this->jsonMsg(501, '输入密码不一致');
			}

			$user = $model->find("csc_id=:id",array(':id'=>Yii::app()->session['sysuser_id']));
			if(!$user){
				$this->jsonMsg(502, '参数有误');
			}
			if($user->csc_password!=BaseApi::system_md5($model->csc_oldpwd)){
				$this->jsonMsg(503, '密码有误');
			}

			$model->csc_pwd = $model->csc_password = BaseApi::system_md5($model->csc_password);
			$model->csc_user = $user->csc_user;
			$model->csc_id = $user->csc_id;

			$model->setIsNewRecord(false);
			if(!$model->save()){
				$error = implode('', current($model->getErrors()));
				$this->jsonMsg(504, '修改失败'.$error);
			}
			$this->jsonMsg(200, '修改密码成功', '', $this->createUrl("index/index"));

		}
		return $this->render('passwd');
	}


//	//切换站点
//	public function actionSite(){
//		$k = array();
//		switch(Yii::app()->request->getParam('id')){
//			case 0:
//				$k = 'db';
//				break;
//			case 1:
//				$k = 'db2';
//				break;
//			default:
//				break;
//		}
//		$cookie_config = Yii::app()->params['cookie'];
//		$cookie_config['expire'] = time() + 3600;
//		$_cookie = new CHttpCookie('master_db', $k, $cookie_config);
//		Yii::app()->request->cookies['master_db'] = $_cookie;
//		$this->redirect(Yii::app()->request->urlReferrer);
//	}


	//加载验证码
	public function actions(){
		$s = array('a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z',
    				'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z',
    				'0', '1', '2', '3', '4', '5', '6', '7', '8', '9'
    				);
    					
    				$rand = array_rand($s, 4);
    				$c = '';
    				foreach ($rand as $v){
    					$c .= $s[$v];
    				}
    					
    				Yii::app()->session['captcha'] = $c;

    					
    				return array(
    		'captcha'=>array(
    			'class'=>'CCaptchaAction',
    			'padding'=>6,
    			'minLength'=>4,
    			'maxLength'=>4, 
    			'height'=>36,
    			'width'=>76,
    			'offset'=>2,
    			'fixedVerifyCode' => $c, //每次都刷新验证码
    				),
    				);
    					
	}

	// 心跳
	public function actionHeart(){
		$k = array(
    		'sysuser_id', 'sysuser_user', 'sysuser_tname', 'sysuser_phone', 'sysuser_time','stoken',
		);
			
		$cookie_config = Yii::app()->params['cookie'];
		$cookie_config['expire'] = time() + 3600;
			
		foreach ($k as $v){
			$cookie = Yii::app()->request->cookies[$v];
			if($cookie){
				$_cookie = new CHttpCookie($v, $cookie->value, $cookie_config);
				Yii::app()->request->cookies[$v] = $_cookie;
			}
		}

	}
}
