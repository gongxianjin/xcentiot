<?php
/**
 * 广告元控制器
 * */
class AdController extends Controller{
	/**
	 * 初始化方法
	 * Enter description here ...
	 * @param unknown_type $id
	 * @param unknown_type $module
	 */
	public function __construct($id, $module=null){
		parent::__construct($id, $module);
		$this->todo = '广告管理';
	}
	//广告列表
	public function actionIndex(){
		$pid = Yii::app()->request->getParam('pid');
			
		$model = AdMeta::model();
		//分页
		$criteria = new CDbCriteria();

		$sword = Yii::app()->request->getParam('sword');

		if ($sword){
			$criteria->addCondition('locate(:sword,csc_name)');
			$criteria->params['sword'] = $sword;
		}
		if($pid){
			$criteria->addCondition('csc_pos_id=:pid');
			$criteria->params['pid'] = $pid;
		}

		$count = $model->count($criteria);

		$pager = new CPagination($count);
		$pager->pageSize = Yii::app()->params['pages'];
		$pager->applyLimit($criteria);

		$criteria->order = 'csc_sort asc,csc_create desc';

		$ad = $model->findAll($criteria);
			
		//获取广告位的name
		$adpos = Adposition::model()->findAll();
		return $this->render('index', array(
    		'ad' => $ad,
    		'pages'=>$pager,
    		'adpos'=>$adpos,
		));
	}

	//添加广告
	public function actionAdd(){
		if(Yii::app()->request->isPostRequest){
			$model = new AdMeta();
			$model->csc_name=Yii::app()->request->getParam('name');
			$model->csc_pos_id=Yii::app()->request->getParam('pos_id');
			$model->csc_begin_time=Yii::app()->request->getParam('begin_time');
			$model->csc_site_id = Yii::app()->request->getParam('site');
			$model->csc_url = Yii::app()->request->getParam('url');
			$model->csc_type = Yii::app()->request->getParam('type');
			$model->csc_show = Yii::app()->request->getParam('show');
			$model->csc_sort = (Int)Yii::app()->request->getParam('sort');
			$model->csc_contactor = Yii::app()->request->getParam('contactor');
			$model->csc_email = Yii::app()->request->getParam('email');
			$model->csc_phone = Yii::app()->request->getParam('phone');
			$model->csc_id = getPrimaryKey($model);

			$img = Yii::app()->request->getParam('img');
			$img_url = Yii::app()->request->getParam('img_url');

			$flash = Yii::app()->request->getParam('flash');
			$flash_url = Yii::app()->request->getParam('flash_url');

			$code = Yii::app()->request->getParam('code');
			$text = Yii::app()->request->getParam('text');

			$end_time = Yii::app()->request->getParam('end_time');
			$model->csc_end_time = $end_time ? $end_time : null;

			$model->csc_img = $img;
			$model->csc_img_url = $img_url;
			$model->csc_flash = $flash;
			$model->csc_flash_url = $flash_url;
			$model->csc_code = $code;
			$model->csc_text = $text;

			//验证
			if(!$model->validate()){
				$error = implode('', current($model->getErrors()));
				$this->jsonMsg(500, $error);
			}

			$transaction = Yii::app()->db->beginTransaction();
			/**
			 * 这里上传广告，然后在加入model里
			 */
			if(!$model->save()){
				$error = implode('', current($model->getErrors()));
				$this->jsonMsg(502, '添加失败'.$error, '', $transaction);
			}

			// 移动文件
			if($model->csc_img){
				$copyStatus = BaseApi::copyTempFile($model->csc_img, 'ad/img');
				if(!$copyStatus['status']){
					BaseApi::delFile($model->csc_img);
					$this->jsonMsg(504, '文件处理失败:'.$copyStatus['msg'], '', $transaction);
				}
				$model->csc_img = $copyStatus['path'];
			}
			if($model->csc_flash){
				$copyStatus = BaseApi::copyTempFile($model->csc_flash, 'ad/flash');
				if(!$copyStatus['status']){
					BaseApi::delFile($model->csc_flash);
					$this->jsonMsg(504, '文件处理失败:'.$copyStatus['msg'], '', $transaction);
				}
				$model->csc_flash = $copyStatus['path'];
			}

			if(!$model->save()){
				$error = implode('', current($model->getErrors()));
				$this->jsonMsg(502, '添加失败'.$error, '', $transaction);
			}

			$transaction->commit();

			$log = '添加广告：'.$model->csc_name;
			$this->addOperLog($log);

			$this->jsonMsg(200, '添加成功', '', $this->createUrl('ad/index', array('pid'=>$model->csc_pos_id)));

		}
		return $this->render('add',array(
    		'site_data' => $site_data,
		));
	}


	//编辑广告
	public function actionEdit(){
		$id=Yii::app()->request->getParam('ids');
		$ad = AdMeta::model()->findByPk($id);
		if(Yii::app()->request->isPostRequest){
			$ad->csc_name=Yii::app()->request->getParam('name');
			$ad->csc_pos_id=Yii::app()->request->getParam('pos_id');
			$ad->csc_begin_time=Yii::app()->request->getParam('begin_time');
			$ad->csc_site_id = Yii::app()->request->getParam('site');
			$ad->csc_url = Yii::app()->request->getParam('url');
			$ad->csc_type = Yii::app()->request->getParam('type');
			$ad->csc_show = Yii::app()->request->getParam('show');
			$ad->csc_sort = (Int)Yii::app()->request->getParam('sort');
			$ad->csc_contactor = Yii::app()->request->getParam('contactor');
			$ad->csc_email = Yii::app()->request->getParam('email');
			$ad->csc_phone = Yii::app()->request->getParam('phone');
			$ad->scenario = 'edit';

			$end_time = Yii::app()->request->getParam('end_time');
			$ad->csc_end_time = $end_time ? $end_time : null;

			$transaction = Yii::app()->db->beginTransaction();
			/**
			 * 这里上传广告，然后在加入model里，修改广告数据
			 */
			//验证
			if(!$ad->save()){
				$error = implode('', current($ad->getErrors()));
				$this->jsonMsg(502, '编辑失败'.$error);
			}

			$img = Yii::app()->request->getParam('img');
			$img_url = Yii::app()->request->getParam('img_url');

			$flash = Yii::app()->request->getParam('flash');
			$flash_url = Yii::app()->request->getParam('flash_url');

			$code = Yii::app()->request->getParam('code');
			$text = Yii::app()->request->getParam('text');

			$end_time = Yii::app()->request->getParam('end_time');
			$ad->csc_end_time = $end_time ? $end_time : null;

			$old_img = $ad->csc_img;
			$old_flash = $ad->csc_flash;

			$ad->csc_img = $img;
			$ad->csc_img_url = $img_url;
			$ad->csc_flash = $flash;
			$ad->csc_flash_url = $flash_url;
			$ad->csc_code = $code;
			$ad->csc_text = $text;

			if($ad->csc_img && stristr($img, '/temp/')){
				$copyStatus = BaseApi::copyTempFile($ad->csc_img, 'ad/img');
				if(!$copyStatus['status']){
					BaseApi::delFile($ad->csc_img);
					$this->jsonMsg(504, '文件处理失败:'.$copyStatus['msg'], '', $transaction);
				}
				$ad->csc_img = $copyStatus['path'];
			}

			if($ad->csc_flash && stristr($flash, '/temp/')){
				$copyStatus = BaseApi::copyTempFile($ad->csc_flash, 'ad/flash');
				if(!$copyStatus['status']){
					BaseApi::delFile($ad->csc_flash);
					$this->jsonMsg(504, '文件处理失败:'.$copyStatus['msg'], '', $transaction);
				}
				$ad->csc_flash = $copyStatus['path'];
			}

			if(stristr($img, '/temp/')){
				BaseApi::delFile($old_img);
			}
			if(stristr($flash, '/temp/')){
				BaseApi::delFile($old_flash);
			}

			if(!$ad->save()){
				$error = implode('', current($ad->getErrors()));
				$this->jsonMsg(502, '编辑失败'.$error, '', $transaction);
			}

			$transaction->commit();

			$log = '编辑广告：'.$ad->csc_name;
			$this->addOperLog($log);

			$this->jsonMsg(200, '编辑成功', '', $this->createUrl('ad/index', array('pid'=>$ad->csc_pos_id)));

		}
		return $this->render('add',array(
    		'site_data' => $site_data,
    		'ad'=>$ad,
		));
	}

	//删除广告
	public function actionDel(){
		$id=Yii::app()->request->getParam('ids');
		$ad = AdMeta::model()->find("csc_id=:id",array(":id"=>$id));
		if(!$ad){
			$this->jsonMsg(501, '参数有误');
		}
			
		// 删除文件
		BaseApi::delFile($ad->csc_img);
		BaseApi::delFile($ad->csc_flash);
			
		if(!$ad->delete()){
			$this->jsonMsg(502, '删除失败');
		}
			
		$log = '删除广告：'.$ad->csc_name;
		$this->addOperLog($log);

		$this->jsonMsg(200, '删除成功');
	}

	public function actionOrder(){
		$ids = Yii::app()->request->getParam('ids');
		$num = Yii::app()->request->getParam('num');
			
		if(!$ids){
			$this->jsonMsg(400, '参数错误');
		}
			
		$data = AdMeta::model()->find('csc_id=:id', array(':id'=>$ids));
		if(!$data){
			$this->jsonMsg(401, '没有找到您要数据');
		}
		
		$data->csc_sort = $num;
		if(!$data->save()){
			$error = implode('', current($data->getErrors()));
			$this->jsonMsg(500, '系统错误'.$error);
		}

		$log = '更改广告排序：'.$data->csc_name;
		$this->addOperLog($log);

		$this->jsonMsg(200, '操作成功');
	}
}
