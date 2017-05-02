<?php
/**
 * 操作日志控制器
 * */
class OperlogController extends Controller{
	
	/**
	 * 初始化方法
	 * Enter description here ...
	 * @param unknown_type $id
	 * @param unknown_type $module
	 */
	public function __construct($id, $module=null){
		parent::__construct($id, $module);
		
		$this->todo = '操作日志管理';
	}
	
    public function actionIndex(){
    	$begin_time = Yii::app()->request->getParam('begin_time');
    	$end_time = Yii::app()->request->getParam('end_time');
    	$sword = trim(Yii::app()->request->getParam('sword'));
    	
    	if($begin_time && strtotime($begin_time)){
    		$begin_time = strtotime($begin_time);
    	}
    	
    	if($end_time && strtotime($end_time)){
    		$end_time = strtotime($end_time);
    	}
    	
    	if($begin_time && $end_time && $begin_time>$end_time){
    		list($begin_time, $end_time) = array($end_time, $begin_time);
    	}
    	
    	$begin_time = $begin_time ? date('Y-m-d', $begin_time) : $begin_time;
    	$end_time = $end_time ? date('Y-m-d', $end_time) : $end_time;
    	
    	
    	$model = OperLog::model();
    	//分页
		$criteria = new CDbCriteria();
		$criteria->order = 'csc_create desc';
		
		if($begin_time){
			$criteria->addCondition('datediff(csc_create,:stime)>=0');
			$criteria->params[':stime'] = $begin_time;
		}
		
		if($end_time){
			$criteria->addCondition('datediff(csc_create,:etime)<=0');
			$criteria->params[':etime'] = $end_time;
		}
		
		if($sword){
			$criteria->addCondition('locate(:name, csc_log)');
			$criteria->params[':name'] = $sword;
		}
		
		$count = $model->count($criteria);
		
		$pager = new CPagination($count);
		$pager->pageSize = Yii::app()->params['pages'];
		$pager->applyLimit($criteria);
    	$data = $model->findAll($criteria);
    	
    	return $this->render('index', array(
    		'data' => $data,
    		'pages' => $pager,
    	));
    }
    
    public function actionDel(){
    	$id = trim(Yii::app()->request->getParam('ids'));
    	$model = OperLog::model();
    	
    	$id = $id ? explode(',', $id) : false;
    	if(false === $id){
	    	$this->jsonMsg(501, '参数有误');
    	}
    	
    	$cond = new CDbCriteria();
    	$cond->addInCondition('csc_id', $id);
    	
    	$adpos = $model->findAll($cond);
    	foreach ($adpos as $item){
	    	$item->delete();
    	}
    	
    	$this->jsonMsg(200, '删除成功', '', $this->createUrl('operlog/'));
    }
}
