<?php

class AdminModule extends CWebModule
{
	public function init()
	{
		// this method is called when the module is being created
		// you may place code here to customize the module or the application

		// import the module-level models and components
		$this->setImport(array(
			'admin.models.*',
			'admin.components.*',
		));
		
		//默认控制器
		$this->defaultController = 'index';
	}

	public function beforeControllerAction($controller, $action)
	{
		if(parent::beforeControllerAction($controller, $action))
		{
			// this method is called before any module controller action is performed
			// you may place customized code here
			if($controller->id != 'user'){
				if(!UserIdentity::isLogin()){
					$url = Yii::app()->createUrl($this->id.'/user/login');
					if(Yii::app()->request->isAjaxRequest){
						$this->jsonMsg(300, 'login failed', '', $url);
					}else{
						header('Location:'.$url);
					}
					exit;
				}
			}
			return true;
		}
		else
			return false;
	}
	

	
	/**
     * Ajax方式返回数据到客户端
     * @access protected
     * @param mixed $data 要返回的数据
     * @param String $type AJAX返回数据格式
     * @return void
     */
    protected function ajaxReturn($data,$type='') {
        if(empty($type)) $type = 'JSON';
        switch (strtoupper($type)){
            case 'JSON' :
                // 返回JSON数据格式到客户端 包含状态信息
                header('Content-Type:application/json; charset=utf-8');
                exit(json_encode($data));
            case 'XML'  :
                // 返回xml格式数据
                header('Content-Type:text/xml; charset=utf-8');
                exit(xml_encode($data));
            case 'JSONP':
                // 返回JSON数据格式到客户端 包含状态信息
                header('Content-Type:application/json; charset=utf-8');
                $handler  =   isset($_GET['jsonpcallback']) ? $_GET['jsonpcallback'] : 'jsonpcallback';
                exit($handler.'('.json_encode($data).');');  
            case 'EVAL' :
                // 返回可执行的js脚本
                header('Content-Type:text/html; charset=utf-8');
                exit($data);            
        }
    }
    
	protected function jsonMsg($code, $msg, $data='', $forwardUrl='', $translation=null){
			
		$jsonp = Yii::app()->request->getParam('jsonp');
			
		$array = array(
			'code' => $code,
			'msg' => $msg,
		);
		if($data){
			$array['data'] = $data;
		}
		if($forwardUrl){
			$array['forward'] = $forwardUrl;
		}

		if($translation) $translation->rollback(); // 事务操作失败后回滚
		
		if(!$jsonp){
			$this->ajaxReturn($array, 'json');
		}else{
			$_GET['jsonpcallback'] = $jsonp;
			$this->ajaxReturn($array, 'jsonp');
		}
	}
}
