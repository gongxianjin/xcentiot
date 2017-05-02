<?php
/**
 * 互助计划控制器
 * */
class CustomersController extends Controller{

	//互助计划列表
    public function actionIndex(){
    	$model = new Customers();
    	//分页
		$criteria = new CDbCriteria(); 
		$count = $model->count($criteria);
		$pager = new CPagination($count);
		$pager->pageSize = Yii::app()->params['pages'];
		$pager->applyLimit($criteria);
    	$feed = $model->findAll($criteria);
    	return $this->render('index', array(
    		'feed' => $feed,
    		'pages'=>$pager,
    	));
    }
      
    //互助计划详情
    public function actionEdit(){
    	$id=Yii::app()->request->getParam('ids');
    	$data = Customers::model()->findByPk($id);
    	return $this->render('add',array(
    		'data'=>$data,
    	));
    }
 
    
	/**
	 * 删除互助计划
	 * Enter description here ...
	 */
	public function actionDel(){
		$ids = Yii::app()->request->getParam('ids');
		$data = Customers::model()->findByPk($ids);
		if(!$data->delete()) $this->jsonMsg(454, '删除失败');
		$this->jsonMsg(200, '删除成功','',$this->createUrl('customers/index'));
		
	}

	// 设置为未审核
	public function actionLock(){
		$id = trim(Yii::app()->request->getParam('ids'));
		$model = Customers::model();
		$id = $id ? explode(',', $id) : false;
		if(false === $id){
			$this->jsonMsg(501, '参数有误');
		}
		$cond = new CDbCriteria();
		$cond->addInCondition('csc_id', $id);
		$adpos = $model->findAll($cond);
		foreach ($adpos as $item){
			if($item->csc_lock==0){
				if(!$item->save()){
					$this->jsonMsg(310, '设置失败');
				}
			}else{
				$item->csc_lock = 0;
				if(!$item->save()){
					$this->jsonMsg(310, '设置失败');
				}
			}
		}
		$this->jsonMsg(200, '设置成功', '', $this->createUrl('strategy/'));
	}
	//设置为审核
	public function actionUnlock(){
		$id = trim(Yii::app()->request->getParam('ids'));
		$model = Customers::model();
		$id = $id ? explode(',', $id) : false;
		if(false === $id){
			$this->jsonMsg(501, '参数有误');
		}
		$cond = new CDbCriteria();
		$cond->addInCondition('csc_id', $id);
		$adpos = $model->findAll($cond);
		foreach ($adpos as $item){
			if($item->csc_lock==1){
				if(!$item->save()){
					$this->jsonMsg(310, '设置失败');
				}
			}else{
				$item->csc_lock = 1;
				if(!$item->save()){
					$this->jsonMsg(310, '设置失败');
				}
			}
		}
		$this->jsonMsg(200, '设置成功', '', $this->createUrl('strategy/'));
	}

}
