<?php
/**
 *  案例扩展信息管理控制器
 */
class GoodsinfoController extends Controller
{
	/**
	 *  案例信息扩展首页
	 */
	public function actionIndex()
	{
		//获得csc_id
		$id = Yii::app()->request->getParam('ids');
		if(!$id){
			$this->jsonMsg(501, '参数有误');
		}
		$criteria = new CDbCriteria();
		$model = GoodsInfo::model();
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
		$criteria->condition = 'csc_goods_id = '.$id;
		$models = $model->findAll($criteria);
		return $this->render('index', array(
    		'models' => $models,
    		'pages' => $pager,
			'ids' => $id,
		));
	}
	/**
	 * 添加 案例信息扩展
	 */
	public function actionAdd(){
		//获得csc_id
		$id = Yii::app()->request->getParam('ids');
		//获得数据
		$goods = Goods::model()->findByPk($id);
		$csc_name = $goods->csc_name;
		$csc_goods_id = $goods->csc_id;
		if (Yii::app()->request->isPostRequest){
			//获得数据
			$model = new GoodsInfo();
			$model->csc_goods_id = Yii::app()->request->getParam('goods_id');
			$model->csc_name = Yii::app()->request->getParam('name');
			$model->csc_name_en = Yii::app()->request->getParam('name_en');
			$model->csc_content = Yii::app()->request->getParam('content');
			$model->csc_sort = Yii::app()->request->getParam('sort');

			//开启事务
			$transaction = Yii::app()->db->beginTransaction();
			//content内图片处理
			if($model->csc_content){
				$contentImg = BaseApi::getContentImg($model->csc_content);
				//新上传的图片移至正式目录
				Yii::app()->params['img_upload_dir'];
				$uploadImgNew = array();
				foreach ($contentImg as $v){
					$copyStatus = BaseApi::copyTempFile(trim($v), 'goodsinfo/content');
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

			//查找 案例名称
			$goods = Goods::model()->findByPk($model->csc_goods_id);
			$goods_name = $goods->csc_name;
			//添加操作日志
			$log = '新增'.$goods_name.' 案例内信息：'.$model->csc_name;
			$this->addOperLog($log);
			$this->jsonMsg(200, '添加成功', '', $this->createUrl('goods/index'));
		}
		$this->render('add' , array(
			'csc_name' => $csc_name,
			'csc_goods_id' => $csc_goods_id,
		));
	}
	/**
	 * 修改 案例
	 */
	public function actionEdit(){
		//获得csc_id
		$id = Yii::app()->request->getParam('ids');
		if(!$id){
			$this->jsonMsg(501, '参数有误');
		}
		//获得数据
		$model = GoodsInfo::model()->findByPk($id);
		if(!$model){
			$this->jsonMsg(502, '数据有误');
		}
		if (Yii::app()->request->isPostRequest){
			//获得数据
			$model->csc_goods_id = Yii::app()->request->getParam('goods_id');
			$model->csc_name = Yii::app()->request->getParam('name');
			$model->csc_name_en = Yii::app()->request->getParam('name_en');
			$model->csc_sort = Yii::app()->request->getParam('sort');

			//开启事务
			$transaction = Yii::app()->db->beginTransaction();
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
				$copyStatus = BaseApi::copyTempFile(trim($v), 'goodsinfo/content');
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

			//查找 案例名称
			$goods = Goods::model()->findByPk($model->csc_goods_id);
			$goods_name = $goods->csc_name;
			//添加操作日志
			$log = '修改'.$goods_name.' 案例内信息：'.$model->csc_name;
			$this->addOperLog($log);
			$this->jsonMsg(200, '更新成功', '', $this->createUrl('goods/index'));
		}
		$this->render('add', array(
			'model'=>$model,
		));
	}
	/**
	 * 删除 案例
	 */
	public function actionDel(){
		//获得csc_id
		$id = Yii::app()->request->getParam('ids');
		if(!$id){
			$this->jsonMsg(501, '参数有误');
		}
		//获得数据
		$model = GoodsInfo::model()->findByPk($id);
		if(!$model->delete()){
			$this->jsonMsg(502, '删除失败');
		}
		//删除note图片
		$delimg = BaseApi::getContentImg($model->csc_content);
		foreach($delimg as $v){
			BaseApi::delFile($v);
		}
		//查找 案例名称
		$goods = Goods::model()->findByPk($model->csc_goods_id);
		$goods_name = $goods->csc_name;
		//删除记录
		$log = '删除'.$goods_name.' 案例内信息: '.$model->csc_name;
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
		$goodsinfo = Goodsinfo::model()->find('csc_id=:id', array(':id'=>$ids));
		if(!$goodsinfo){
			$this->jsonMsg(401, '没有找到您要数据');
		}
		$goodsinfo->csc_sort = $num;
		if(!$goodsinfo->save()){
			$error = implode('', current($goodsinfo->getErrors()));
			$this->jsonMsg(500, '系统错误'.$error);
		}
		//查找 案例名称
		$goods = Goods::model()->findByPk($goodsinfo->csc_goods_id);
		$goods_name = $goods->csc_name;
		//操作记录
		$log = '更改 案例'.$goods_name.'内排序：'.$goodsinfo->csc_name;
		$this->addOperLog($log);
		$this->jsonMsg(200, '操作成功');
	}
}