<?php
/**
 * 广告位控制器
 * */
class AdposController extends Controller{
	/**
	 * 初始化方法
	 * Enter description here ...
	 * @param unknown_type $id
	 * @param unknown_type $module
	 */
	public function __construct($id, $module=null){
		parent::__construct($id, $module);

		$this->todo = '广告位管理';
	}
	//广告位列表
	public function actionIndex(){
		$model = new Adposition();
		//分页
		$criteria = new CDbCriteria();

		$sword = Yii::app()->request->getParam('sword');

		if ($sword){
			$criteria->addCondition('locate(:sword,csc_name) OR locate(:sword,csc_id)');
			$criteria->params['sword'] = $sword;
		}
		$count = $model->count($criteria);

		$pager = new CPagination($count);
		$pager->pageSize = Yii::app()->params['pages'];
		$pager->applyLimit($criteria);
		$adpos = $model->findAll($criteria);
			
		return $this->render('index', array(
    		'adpos' => $adpos,
    		'pages' => $pager,
		));
	}

	//添加广告位
	public function actionAdd(){
		if(Yii::app()->request->isPostRequest){
			$model = new Adposition('add');
			$model->csc_name=Yii::app()->request->getParam('name');
			$model->csc_width=Yii::app()->request->getParam('width');
			$model->csc_height=Yii::app()->request->getParam('height');
			$model->csc_desc = Yii::app()->request->getParam('desc');
			$model->csc_id = Yii::app()->request->getParam('id');
			//验证
			if(!$model->validate()){
				$error = implode('', current($model->getErrors()));
				$this->jsonMsg(500, $error);
			}
			if(!$model->save()){
				$error = implode('', current($model->getErrors()));
				$this->jsonMsg(502, '添加失败'.$error);
			}

			$log = '添加广告位：'.$model->csc_name;
			$this->addOperLog($log);

			$this->jsonMsg(200, '添加成功', '', $this->createUrl('adpos/index'));

		}
		return $this->render('add');
	}


	//编辑广告位
	public function actionEdit(){
		$id=Yii::app()->request->getParam('ids');
		$model = new Adposition('edit');
		$adpos = $model->find('csc_id=:id',array(':id'=>$id));
		if(Yii::app()->request->isPostRequest){
			if($adpos->csc_name!=Yii::app()->request->getParam('name')){
				$adpos->csc_name=Yii::app()->request->getParam('name');
			}

			$adpos->csc_id = Yii::app()->request->getParam('id');
			$adpos->csc_width=Yii::app()->request->getParam('width');
			$adpos->csc_height=Yii::app()->request->getParam('height');
			$adpos->csc_desc=Yii::app()->request->getParam('desc');

			//验证
			if(!$adpos->save()){
				$error = implode('', current($adpos->getErrors()));
				$this->jsonMsg(502, '编辑失败'.$error);
			}

			$log = '编辑广告位：'.$adpos->csc_name;
			$this->addOperLog($log);

			$this->jsonMsg(200, '编辑成功', '', $this->createUrl('adpos/index'));

		}
		return $this->render('add',array(
    		'adpos'=>$adpos,
		));
	}
	//删除广告位
	public function actionDel(){
		$id = Yii::app()->request->getParam('ids');
			
		$adpos = Adposition::model()->findByPk($id);
		if(!$adpos){
			$this->jsonMsg(501, '参数有误');
		}
			
		// 查询是否有广告
		$num = AdMeta::model()->countByAttributes(array('csc_pos_id'=>$id));
		if($num){
			$this->jsonMsg(400, '广告位已绑定广告，不能删除');
		}
			
		if(!$adpos->delete()){
			$this->jsonMsg(502, '删除失败');
		}
			
		$log = '删除广告位：'.$adpos->csc_name;
		$this->addOperLog($log);

		$this->jsonMsg(200, '删除成功');
	}

	//广告位列表
	public function actionSelect(){
		$model = new Adposition();
		$adpos = $model->findAll();
			
		$this->layout = '/layouts/admin_select';
		return $this->render('select', array(
    		'adpos' => $adpos,
		));
	}
}
