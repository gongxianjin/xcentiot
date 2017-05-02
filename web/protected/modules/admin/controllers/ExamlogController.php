<?php
/**
 * 成绩反馈元控制器
 * */
class ExamlogController extends Controller{
	/**
	 * 初始化方法
	 * Enter description here ...
	 * @param unknown_type $id
	 * @param unknown_type $module
	 */
	public function __construct($id, $module=null){
		parent::__construct($id, $module);
		$this->todo = '成绩反馈管理';
	}
	//成绩列表
    public function actionIndex(){
    	$model = new ExamLog();
    	//分页
		$criteria = new CDbCriteria();
		$criteria->order = 'csc_id DESC';
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
      
    //成绩详情
    public function actionEdit(){
    	$id=Yii::app()->request->getParam('ids');
    	$data = ExamLog::model()->findByPk($id);
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
		$model = ExamLog::model();

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

		$this->jsonMsg(200, '删除成功','',$this->createUrl('feedback/index'));

	}
}
