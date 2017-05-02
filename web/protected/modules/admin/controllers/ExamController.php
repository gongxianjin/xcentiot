<?php
/**
 * 成绩管理控制器
 */
class ExamController extends Controller
{
	/**
	 * 成绩管理首页
	 */
	public function actionIndex()
	{
		$criteria = new CDbCriteria();
		$model = Exam::model();
		//csc_name关键字搜索
		$sword = Yii::app()->request->getParam('sword');
		if ($sword){
			$criteria->addCondition('locate(:sword,csc_name)');
			$criteria->params['sword'] = $sword;
		}
		$criteria->order = 'csc_sort DESC';
		//分页
		$count = $model->count($criteria);
		$pager = new CPagination($count);
		$pager->pageSize = Yii::app()->params['pages'];
		$pager->applyLimit($criteria);
		$models = $model->findAll($criteria);
		$cate = Category::model()->findAll();
		return $this->render('index', array(
    		'models' => $models,
    		'pages' => $pager,
			'cate'=> $cate,
		));
	}
	/**
	 * 添加成绩
	 */
	public function actionAdd(){
		if (Yii::app()->request->isPostRequest){
			//获得数据
			$model = new Exam('add');
			$model->csc_name = Yii::app()->request->getParam('name');
			$model->csc_sort = Yii::app()->request->getParam('sort');
			$model->csc_id = getPrimaryKey($model);
			//开启事务
			$transaction = Yii::app()->db->beginTransaction();
			//写入数据
			if(!$model->save()){
				$error = implode('', current($model->getErrors()));
				$this->jsonMsg(506, '添加失败'.$error, '', $transaction);
			}
			//提交事务
			$transaction->commit();
			//添加操作日志
			$log = '新增科目：'.$model->csc_name;
			$this->addOperLog($log);
			$this->jsonMsg(200, '添加成功', '', $this->createUrl('exam/index'));
		}
		$this->render('add');
	}
	/**
	 * 修改成绩
	 */
	public function actionEdit(){
		//获得csc_id
		$id = Yii::app()->request->getParam('ids');
		if(!$id){
			$this->jsonMsg(501, '参数有误');
		}
		//获得数据
		$model = Exam::model()->findByPk($id);
		if(!$model){
			$this->jsonMsg(502, '数据有误');
		}
		if (Yii::app()->request->isPostRequest){
			//获得数据
			$model->csc_name = Yii::app()->request->getParam('name');
			$model->csc_sort = Yii::app()->request->getParam('sort');
			//开启事务
			$transaction = Yii::app()->db->beginTransaction();
			//写入数据
			if(!$model->save()){
				$error = implode('', current($model->getErrors()));
				$this->jsonMsg(506, '添加失败'.$error, '', $transaction);
			}
			//提交事务
			$transaction->commit();
			//添加操作日志
			$log = '更新科目：'.$model->csc_name;
			$this->addOperLog($log);
			$this->jsonMsg(200, '更新成功', '', $this->createUrl('exam/index'));
		}
		$cate = Category::model()->findAll();
		$this->render('add', array(
			'model'=>$model,
			'cate'=>$cate,
		));
	}
	/**
	 * 删除成绩
	 */
	public function actionDel(){
		//获得csc_id
		$id = Yii::app()->request->getParam('ids');
		if(!$id){
			$this->jsonMsg(501, '参数有误');
		}
		//获得数据
		$model = Exam::model()->findByPk($id);
		if(!$model->delete()){
			$this->jsonMsg(502, '删除失败');
		}
		//删除成绩扩展
		Examinfo::model()->deleteAll('csc_exam_id=:csc_exam_id' , array(':csc_exam_id'=>$id));
		//删除成绩扩展note图片
		$delimg = BaseApi::getContentImg(Examinfo::model()->csc_content);
		foreach($delimg as $v){
			BaseApi::delFile($v);
		}

		//删除记录
		$log = '删除科目: '.$model->csc_name;
		$this->addOperLog($log);
		$this->jsonMsg(200, '删除成功');
	}
	/**
	 * 选择成绩
	 */
	public function actionSelect(){
		$exams = Exam::model()->findAll();
		$this->layout = '/layouts/admin_select';
		return $this->render('select', array(
			'exam' => $exams,
		));
	}
	/**
	 * 排序
	 */
	public function actionOrder(){
		$ids = Yii::app()->request->getParam('ids');
		$num = Yii::app()->request->getParam('num');
		if(!$ids){
			$this->jsonMsg(400, '参数错误');
		}
		$goods = Exam::model()->find('csc_id=:id', array(':id'=>$ids));
		if(!$goods){
			$this->jsonMsg(401, '没有找到您要数据');
		}
		$goods->csc_sort = $num;
		if(!$goods->save()){
			$error = implode('', current($goods->getErrors()));
			$this->jsonMsg(500, '系统错误'.$error);
		}
		$log = '更改科目排序：'.$goods->csc_name;
		$this->addOperLog($log);
		$this->jsonMsg(200, '操作成功');
	}
}