<?php
/**
 * 权限管理
 * Enter description here ...
 * @author Administrator
 *
 */
class SysroleController extends Controller {
	
	/**
	 * 初始化方法
	 * Enter description here ...
	 * @param unknown_type $id
	 * @param unknown_type $module
	 */
	public function __construct($id, $module=null){
		parent::__construct($id, $module);
	}

	/**
	 * 角色列表
	 * Enter description here ...
	 */
	public function actionIndex(){
		$memberModel = Sysrole::model();
		$sysrole = $memberModel->findAll();
		$this->render('index',array(
			'sysrole' => $sysrole,
		));
	} 
	
	/**
	 * 组装权限数据
	 * Enter description here ...
	 * @param unknown_type $ar
	 */
	public function _find_parent($ar) {
		$return = array();
		foreach($ar as $item){
			if(!isset($return[$item['csc_c_name']])){
				$return[ $item['csc_c_name'] ] = array(
					'csc_c_arlias' => $item['csc_c_arlias'],
					'item' => array(),
				);
			}
			$return[$item['csc_c_name']]['item'][$item['csc_a_name']] = $item['csc_a_arlias'];
		}
		
		return $return;
	}
	/**
	 * 添加角色
	 * Enter description here ...
	 */
	public function actionAdd(){
		$memberPower = Power::model();
		$power = $memberPower->findAll(array('order'=>'csc_id ASC'));
		$power = $this->_find_parent($power);
		
		if(Yii::app()->request->isPostRequest){
			$name = Yii::app()->request->getParam('name');
			$power_id = Yii::app()->request->getParam('power_id');
			$power_l='';
			foreach ($power_id as $k=>$power_i){
				$power_l .=$power_i.'|';
			}
			$power_l=substr($power_l,0,-1);
			$memberSysrole = new Sysrole();
			$memberSysrole->csc_id = getPrimaryKey($memberSysrole);
    		$memberSysrole->csc_name = $name;
    		$memberSysrole->csc_power_id = $power_l;
			if(!$memberSysrole->save()){
				$error = implode('', current($model->getErrors()));
				$this->jsonMsg(502, '添加失败'.$error, '', $transaction);
			}
			
			$this->addOperLog('添加角色'.$name);
			
			$this->jsonMsg(200, '添加成功', '', $this->createUrl('sysrole/index'));
		}
		$this->render('edit',array(
			'power' => $power,
		));
	}

	public function actionEdit(){
		 
		$ids = Yii::app()->request->getParam('ids');
		if(!$ids){
			$this->jsonMsg(400, '参数错误'.$ids);
		}
		
		$memberSysrole = Sysrole::model();
		$memberPower = Power::model();
		
		$data = $memberSysrole->findbyPk($ids);
		if(!$data){
			$this->jsonMsg(401, '修改用户信息有误');
		}
		$cname = $aname = array();
		$cname=explode("|",$data['csc_power_id']);
		$return = array();
		foreach ($cname as $v){
			$ls_l = explode('-', $v);
			if(!isset($return[$ls_l[0]])){
				$return[ $ls_l[0] ] = array(

				);
			}
			$return[ $ls_l[0] ][$ls_l[1]] = $ls_l[1];
		}
		
		$power=$memberPower->findAll();
		$power = $this->_find_parent($power); 
		
		if(Yii::app()->request->isPostRequest){
			$csc_name = Yii::app()->request->getParam('name');
			$power_id = Yii::app()->request->getparam('power_id');
			$power_l='';
			foreach ($power_id as $k=>$power_i){
				$power_l .=$power_i.'|';

			}
			$power_l=substr($power_l,0,-1);
			$data->csc_name = $csc_name;
			$data->csc_power_id = $power_l;
			
			if(!$data->save()){
				$this->jsonMsg(300, '修改失败');
			}
			
			$this->addOperLog('角色信息修改：'.$csc_name);
			
			$this->jsonMsg(200, '角色重置成功', '', $this->createUrl('sysrole/index'));
		}

		$this->render('edit',array(
			'data' => $data,
			'cname' => $cname,
			'power' => $power,
		));
	}

	public function actionDel(){
		$ids = Yii::app()->request->getParam('ids');
		if(!$ids){
			$this->jsonMsg(400, '参数错误'.$ids);
		}
		$sysrole = Sysrole::model()->findByPk($ids);
		if(!$sysrole){
			$this->jsonMsg(401, '没有找到数据');
		}
		if(!$sysrole->delete()){
			$this->jsonMsg(251, '删除失败');
		}
		$this->addOperLog('删除角色信息:'.$sysrole->csc_name);
		
		$this->jsonMsg(200, '操作成功', '', $this->createUrl('member/index'));
	}

	
	
	/**
	 * 导入基本权限
	 * Enter description here ...
	 */
	public function actionInitrole(){
	    
		Yii::app()->db->createCommand()->truncateTable('xc_power');
		
		foreach ($this->oper_meta_set as $key=>$val){
			foreach ($val['items'] as $k=>$item){
				$model = new Power();
				$model->csc_c_name = $key;
				$model->csc_c_arlias = $val['arlias'];
				$model->csc_a_name = $k;
				$model->csc_a_arlias = $item;
				$model->save();
			}
		}
		header('Content-Type:text/html;charset=UTF-8');
		$this->redirect(array('sysrole/'));  
    	exit; 
	}
}