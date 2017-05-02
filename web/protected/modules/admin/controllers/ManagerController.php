<?php
/**
 * 管理员操作控制器
 * Enter description here ...
 * @author Administrator
 *
 */
class ManagerController extends Controller
{
	/**
	 * 初始化方法
	 * Enter description here ...
	 * @param unknown_type $id
	 * @param unknown_type $module
	 */
	public function __construct($id, $module=null){
		parent::__construct($id, $module);
		$this->todo = '管理员管理';
	}
	//管理员首页
	public function actionIndex(){
		
		$df_user = Yii::app()->params['default_master'];
		$sword = Yii::app()->request->getParam('sword');
		$model = Sysuser::model();
		
		//分页
		$criteria = new CDbCriteria(); 
		$criteria->addCondition('csc_user!=\''.$df_user['user'].'\'');
		$count = $model->count($criteria);

		//筛选条件
		if($sword){
			$criteria->addCondition('locate(:sword,csc_user) OR locate(:sword,csc_phone)');
			$criteria->params['sword'] = $sword;
		}
		
		$pager = new CPagination($count);
		$pager->pageSize = Yii::app()->params['pages'];
		$pager->applyLimit($criteria);
         
		$users = $model->findAll($criteria); //根据条件查询
        return $this->render('index',array(
        	'users'=>$users,
        	'lock' => Yii::app()->params['lock'],
        	"pages" => $pager
        ));
    }

	public function actionAdd(){
		$sys = Sysrole::model()->findAll();
		if(Yii::app()->request->isPostRequest){
			$model = new Sysuser('create');

			$model->csc_tname = Yii::app()->request->getParam('user_tname');
			$model->csc_password = Yii::app()->request->getParam('password');
			$model->csc_pwd = Yii::app()->request->getParam('password_confirm');
			$model->csc_phone = Yii::app()->request->getParam('phone');
			$model->csc_locked = Yii::app()->request->getParam('locked');
            $model->csc_role_id = Yii::app()->request->getParam('role_id');
            $model->csc_user = Yii::app()->request->getParam('user_name');


			$model->csc_password = BaseApi::system_md5($model->csc_password);
			$model->csc_pwd = BaseApi::system_md5($model->csc_pwd);
			
			if(!$model->validate()){
				$error = implode('', current($model->getErrors()));
				$this->jsonMsg(500, $error);
			}
			
			if(!$model->save()){
				$error = implode('', current($model->getErrors()));
				$this->jsonMsg(502, '添加失败'.$error);
			}
			
			$log = '添加管理员：'.$model->csc_user;
			$this->addOperLog($log);
			
			$this->jsonMsg(200, '添加成功', '', $this->createUrl('manager/index'));
		}
		$this->render('add' , array(
			'sys' => $sys,
		));
	}
	
	public function actionEdit(){
		$sys = Sysrole::model()->findAll();
		$id = yii::app()->request->getParam('ids');
		$model = new Sysuser('update');
		$user = $model->find("csc_id=:id",array(':id'=>$id));
		if(!$user){
			$this->redirect('/manager');exit;
		}
		
		if(Yii::app()->request->isPostRequest){
			$model->csc_id = $id;
			$model->csc_tname = Yii::app()->request->getParam('user_tname');
			$model->csc_phone = Yii::app()->request->getParam('phone');
			$model->csc_locked = Yii::app()->request->getParam('locked');
			$model->csc_role_id = Yii::app()->request->getParam('role_id');
			$model->csc_user = $user->csc_user;
			
			if(Yii::app()->request->getParam('password')){
				$model->csc_password = Yii::app()->request->getParam('password');
				$model->csc_pwd = Yii::app()->request->getParam('password_confirm');
			}
			
			if(!$model->validate()){
				$error = implode('', current($model->getErrors()));
				$this->jsonMsg(500, $error);
			}
			
			if($model->csc_password){
				$model->csc_password = BaseApi::system_md5($model->csc_password);
				$model->csc_pwd = $model->csc_password;
			}else{
				$model->csc_password = $user->csc_password;
				$model->csc_pwd = $user->csc_password;
			}
			
			$model->setIsNewRecord(false);
			if(!$model->save()){
				$error = implode('', current($model->getErrors()));
				$this->jsonMsg(502, '修改失败'.$error);
			}
			
			$log = '编辑管理员信息：'.$model->csc_user;
			$this->addOperLog($log);
			
			$this->jsonMsg(200, '修改成功', '', $this->createUrl('manager/index'));
		}
		$this->render('add',array(
			'user'=>$user,
			'sys'=>$sys,
		));
	}
	
	//删除管理员
    public function actionDel(){
    	//获取管理员id
    	$id = Yii::app()->request->getParam( 'ids' );
    	if(is_null($id)){
    		$this->jsonMsg(500, '参数有误');
    	}
    	
    	$model = Sysuser::model();
    	//删除多个
    	if(is_array($id)){
    		foreach ($id as $v){
    			$del = $model->deleteAll("csc_id=:id",array(':id'=>$v));
    		}
    		
    	}else{
    			$del = $model->deleteAll("csc_id=:id",array(':id'=>$id));
    	}
    	if(!$del){
    		$this->jsonMsg(501, '删除失败');
    	}
    	
    	$log = '删除了管理员，id为 ：'.$id;
		$this->addOperLog($log);
		
    	$this->jsonMsg(200, '删除成功');
    }
   
	
}