<?php
/**
 *  成绩扩展信息管理控制器
 */
class ExaminfoController extends Controller
{
	/**
	 *  成绩信息扩展首页
	 */
	public function actionIndex()
	{
		//获得csc_id
		$id = Yii::app()->request->getParam('ids');
		if(!$id){
			$this->jsonMsg(501, '参数有误');
		}
		$criteria = new CDbCriteria();
		$model = ExamInfo::model();
		//csc_name关键字搜索
		$sword = Yii::app()->request->getParam('sword');
		if ($sword){
			$criteria->addCondition('locate(:sword,csc_name)');
			$criteria->params['sword'] = $sword;
		}
		//分页
		$count = $model->count($criteria);
		$pager = new CPagination($count);
		$pager->pageSize = Yii::app()->params['pages'];
		$pager->applyLimit($criteria);
		//排序
		$criteria->order = 'csc_sort ASC,csc_create DESC';
		$criteria->condition = 'csc_exam_id = '.$id;
		$models = $model->findAll($criteria);
		return $this->render('index', array(
    		'models' => $models,
    		'pages' => $pager,
			'ids' => $id,
		));
	}
	/**
	 * 添加 成绩信息扩展
	 */
	public function actionAdd(){
		//获得csc_id
		$id = Yii::app()->request->getParam('ids');
		//获得数据
		$Exam = Exam::model()->findByPk($id);
		$csc_name = $Exam->csc_name;
		$csc_Exam_id = $Exam->csc_id;
		if (Yii::app()->request->isPostRequest){
			//获得数据
			$model = new ExamInfo('add');
			$model->csc_id = getPrimaryKey($model);
			$model->csc_exam_id = Yii::app()->request->getParam('exam_id');
			$model->csc_name = Yii::app()->request->getParam('name');
			$model->csc_answer = Yii::app()->request->getParam('answer');
			$model->csc_content = Yii::app()->request->getParam('content');
			$model->csc_sort = Yii::app()->request->getParam('sort');

			//开启事务
			$transaction = Yii::app()->db->beginTransaction();

			//name内图片处理
			if($model->csc_name){
				$contentImg = BaseApi::getContentImg($model->csc_name);
				//新上传的图片移至正式目录
				Yii::app()->params['img_upload_dir'];
				$uploadImgNew = array();
				foreach ($contentImg as $v){
					$copyStatus = BaseApi::copyTempFile(trim($v), 'examinfo/name');
					if(!$copyStatus['status']){
						$uploadImgNew[] = trim($v);
					}else{
						$uploadImgNew[] = $copyStatus['path'];
					}
				}
				//题目更新
				$model->csc_name = BaseApi::updateContentImg($model->csc_name, $contentImg, $uploadImgNew);
			}

			//content内图片处理
			if($model->csc_content){
				$contentImg = BaseApi::getContentImg($model->csc_content);
				//新上传的图片移至正式目录
				Yii::app()->params['img_upload_dir'];
				$uploadImgNew = array();
				foreach ($contentImg as $v){
					$copyStatus = BaseApi::copyTempFile(trim($v), 'examinfo/content');
					if(!$copyStatus['status']){
						$uploadImgNew[] = trim($v);
					}else{
						$uploadImgNew[] = $copyStatus['path'];
					}
				}
				//内容更新
				$model->csc_content = BaseApi::updateContentImg($model->csc_content, $contentImg, $uploadImgNew);
			}
			//写入数据
			if(!$model->save()){
				$error = implode('', current($model->getErrors()));
				$this->jsonMsg(502, '添加失败'.$error, '', $transaction);
			}
			//提交事务
			$transaction->commit();

			//查找 成绩名称
			$Exam = Exam::model()->findByPk($model->csc_exam_id);
			$Exam_name = $Exam->csc_name;
			//添加操作日志
			$log = '新增'.$Exam_name.' 科目内信息：'.$model->csc_name;
			$this->addOperLog($log);
			$this->jsonMsg(200, '添加成功', '', $this->createUrl('exam/index'));
		}
		$this->render('add' , array(
			'csc_name' => $csc_name,
			'csc_exam_id' => $csc_Exam_id,
		));
	}
	/**
	 * 修改 成绩
	 */
	public function actionEdit(){
		//获得csc_id
		$id = Yii::app()->request->getParam('ids');
		if(!$id){
			$this->jsonMsg(501, '参数有误');
		}
		//获得数据
		$model = ExamInfo::model()->findByPk($id);
		if(!$model){
			$this->jsonMsg(502, '数据有误');
		}
		if (Yii::app()->request->isPostRequest){
			//获得数据
			$model->csc_exam_id = Yii::app()->request->getParam('exam_id');
//			$model->csc_name = Yii::app()->request->getParam('name');
			$model->csc_answer = Yii::app()->request->getParam('answer');
			$model->csc_sort = Yii::app()->request->getParam('sort');

			//开启事务
			$transaction = Yii::app()->db->beginTransaction();

			//name图片处理
			$new_name = Yii::app()->request->getParam('name');
			$oldImg = BaseApi::getContentImg($model->csc_name);
			$contentImg = BaseApi::getContentImg($new_name);
			$uploadImg = array_diff($contentImg, $oldImg);
			array_diff($oldImg, $contentImg);
			//新上传的图片移至正式目录
			Yii::app()->params['img_upload_dir'];
			$uploadImgNew = array();
			foreach ($uploadImg as $v){
				$copyStatus = BaseApi::copyTempFile(trim($v), 'examinfo/name');
				if(!$copyStatus['status']){
					$uploadImgNew[] = $v;
				}else{
					$uploadImgNew[] = $copyStatus['path'];
				}
			}
			// 内容更新
			$model->csc_name = BaseApi::updateContentImg($new_name, $uploadImg, $uploadImgNew);

			//content图片处理
			$new_content = Yii::app()->request->getParam('content');
			$oldImg = BaseApi::getContentImg($model->csc_content);
			$contentImg = BaseApi::getContentImg($new_content);
			$uploadImg = array_diff($contentImg, $oldImg);
			array_diff($oldImg, $contentImg);
			//新上传的图片移至正式目录
			Yii::app()->params['img_upload_dir'];
			$uploadImgNew = array();
			foreach ($uploadImg as $v){
				$copyStatus = BaseApi::copyTempFile(trim($v), 'Examinfo/content');
				if(!$copyStatus['status']){
					$uploadImgNew[] = $v;
				}else{
					$uploadImgNew[] = $copyStatus['path'];
				}
			}
			// 内容更新
			$model->csc_content = BaseApi::updateContentImg($new_content, $uploadImg, $uploadImgNew);
			//写入数据
			if(!$model->save()){
				$error = implode('', current($model->getErrors()));
				$this->jsonMsg(503, '添加失败'.$error, '', $transaction);
			}
			//提交事务
			$transaction->commit();

			//查找 成绩名称
			$Exam = Exam::model()->findByPk($model->csc_exam_id);
			$Exam_name = $Exam->csc_name;
			//添加操作日志
			$log = '修改'.$Exam_name.' 成绩内信息：'.$model->csc_name;
			$this->addOperLog($log);
			$this->jsonMsg(200, '更新成功', '', $this->createUrl('Exam/index'));
		}
		$this->render('add', array(
			'model'=>$model,
		));
	}
	/**
	 * 删除 成绩
	 */
	public function actionDel(){
		//获得csc_id
		$id = Yii::app()->request->getParam('ids');
		if(!$id){
			$this->jsonMsg(501, '参数有误');
		}
		//获得数据
		$model = ExamInfo::model()->findByPk($id);
		if(!$model->delete()){
			$this->jsonMsg(502, '删除失败');
		}
		//删除note图片
		$delimg = BaseApi::getContentImg($model->csc_content);
		foreach($delimg as $v){
			BaseApi::delFile($v);
		}
		//查找 成绩名称
		$Exam = Exam::model()->findByPk($model->csc_exam_id);
		$Exam_name = $Exam->csc_name;
		//删除记录
		$log = '删除'.$Exam_name.' 成绩内信息: '.$model->csc_name;
		$this->addOperLog($log);
		$this->jsonMsg(200, '删除成功');
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
		$Examinfo = Examinfo::model()->find('csc_id=:id', array(':id'=>$ids));
		if(!$Examinfo){
			$this->jsonMsg(401, '没有找到您要数据');
		}
		$Examinfo->csc_sort = $num;
		if(!$Examinfo->save()){
			$error = implode('', current($Examinfo->getErrors()));
			$this->jsonMsg(500, '系统错误'.$error);
		}
		//查找 成绩名称
		$Exam = Exam::model()->findByPk($Examinfo->csc_exam_id);
		$Exam_name = $Exam->csc_name;
		//操作记录
		$log = '更改 成绩'.$Exam_name.'内排序：'.$Examinfo->csc_name;
		$this->addOperLog($log);
		$this->jsonMsg(200, '操作成功');
	}
}