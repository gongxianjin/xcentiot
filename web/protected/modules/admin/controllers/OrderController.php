<?php
/**
 * 预约反馈元控制器
 * */
class OrderController extends Controller{
	/**
	 * 初始化方法
	 * Enter description here ...
	 * @param unknown_type $id
	 * @param unknown_type $module
	 */
	public function __construct($id, $module=null){
		parent::__construct($id, $module);
		$this->todo = '预约反馈管理';
	}
	//预约列表
    public function actionIndex(){
    	$model = new ExamOrder();
    	//分页
		$criteria = new CDbCriteria();
		$criteria->order = 'csc_id DESC';
		$count = $model->count($criteria);
		$pager = new CPagination($count);
		$pager->pageSize = Yii::app()->params['pages'];
		$pager->applyLimit($criteria);
    	$order = $model->findAll($criteria);

    	return $this->render('index', array(
    		'order' => $order,
    		'pages'=>$pager,
    	));
    }
      
    //预约详情
    public function actionEdit(){
    	$id=Yii::app()->request->getParam('ids');
    	$data = ExamOrder::model()->findByPk($id);
    	return $this->render('add',array(
    		'data'=>$data,
    	));
    }
 
    
	/**
	 * 删除反馈意见
	 * Enter description here ...
	 */
	public function actionDel(){

		$id = trim(Yii::app()->request->getParam('ids'));
		$model = ExamOrder::model();

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

		$this->jsonMsg(200, '删除成功','',$this->createUrl('order/index'));

	}
}
