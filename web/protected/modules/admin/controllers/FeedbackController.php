<?php
/**
 * 留言反馈元控制器
 * */
class FeedbackController extends Controller{
	/**
	 * 初始化方法
	 * Enter description here ...
	 * @param unknown_type $id
	 * @param unknown_type $module
	 */
	public function __construct($id, $module=null){
		parent::__construct($id, $module);
		$this->todo = '留言反馈管理';
	}
	//留言列表
    public function actionIndex(){
    	$model = new Feedback();
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
      
    //留言详情
    public function actionEdit(){
    	$id=Yii::app()->request->getParam('ids');
    	$data = Feedback::model()->findByPk($id);
    	return $this->render('add',array(
    		'data'=>$data,
    	));
    }
 
    
	/**
	 * 删除反馈意见
	 * Enter description here ...
	 */
	public function actionDel(){
		$ids = Yii::app()->request->getParam('ids');
		$data = Feedback::model()->findByPk($ids);
		if(!$data->delete()) $this->jsonMsg(454, '删除失败');
		$this->jsonMsg(200, '删除成功','',$this->createUrl('feedback/index'));
		
	}
}
