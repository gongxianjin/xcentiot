<?php
/**
 * 教师管理控制器
 */
class GoodsController extends Controller
{
	/**
	 * 教师管理首页
	 */
	public function actionIndex()
	{
		$criteria = new CDbCriteria();
		$model = Goods::model();
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
		$models = $model->findAll($criteria);
		$cate = Category::model()->findAll();
		return $this->render('index', array(
    		'models' => $models,
    		'pages' => $pager,
			'cate'=> $cate,
		));
	}
	/**
	 * 添加教师
	 */
	public function actionAdd(){
		if (Yii::app()->request->isPostRequest){
			//获得数据
			$model = new Goods();
			$model->csc_name = Yii::app()->request->getParam('name');
//			$model->csc_cate_id = Yii::app()->request->getParam('cate_id');
			$model->csc_desc = Yii::app()->request->getParam('desc');
//			$model->csc_term = Yii::app()->request->getParam('term');
			$model->csc_gd = Yii::app()->request->getParam('gd');
			$model->csc_sj = Yii::app()->request->getParam('sj');
			$model->csc_school = Yii::app()->request->getParam('school');
//			$model->csc_note = Yii::app()->request->getParam('note');
			$model->csc_sort = Yii::app()->request->getParam('sort');
 			$model->csc_recom_point = Yii::app()->request->getParam('recom_point');
//			$model->csc_sale_num = Yii::app()->request->getParam('sale_num');
//			$model->csc_price = Yii::app()->request->getParam('price');
			//获得图片
			$img = Yii::app()->request->getParam('img');

			//开启事务
			$transaction = Yii::app()->db->beginTransaction();
			//desc内图片处理
			if($model->csc_desc){
				$contentImg = BaseApi::getContentImg($model->csc_desc);
				//新上传的图片移至正式目录
				Yii::app()->params['img_upload_dir'];
				$uploadImgNew = array();
				foreach ($contentImg as $v){
					$copyStatus = BaseApi::copyTempFile(trim($v), 'goods/desc');
					if(!$copyStatus['status']){
						$uploadImgNew[] = trim($v);
					}else{
						$uploadImgNew[] = $copyStatus['path'];
					}
				}
				//内容更新
				$model->csc_desc = BaseApi::updateContentImg($model->csc_desc, $contentImg, $uploadImgNew);
			}
			//note内图片处理
			if($model->csc_note){
				$contentImg = BaseApi::getContentImg($model->csc_note);
				//新上传的图片移至正式目录
				Yii::app()->params['img_upload_dir'];
				$uploadImgNew = array();
				foreach ($contentImg as $v){
					$copyStatus = BaseApi::copyTempFile(trim($v), 'goods/note');
					if(!$copyStatus['status']){
						$uploadImgNew[] = trim($v);
					}else{
						$uploadImgNew[] = $copyStatus['path'];
					}
				}
				//内容更新
				$model->csc_note = BaseApi::updateContentImg($model->csc_note, $contentImg, $uploadImgNew);
			}
			//移动文件
			if($img){
				$copyStatus = BaseApi::copyTempFile($img, 'goods/img');
				if(!$copyStatus['status']){
					BaseApi::delFile($img);
					$this->jsonMsg(503, '图片文件处理失败:'.$copyStatus['msg'], '', $transaction);
				}
				//获得上传后图片路径
				$model->csc_img = $copyStatus['path'];
				//生成中缩略图
				$thumb_config = Yii::app()->params['img_thumb']['goods'];
				$thumb = $thumb_config['thumb'];
				$thumb_img = BaseApi::createThumb($model->csc_img, $thumb['width'], $thumb['height']);
				if(!$thumb_img['status']){
					BaseApi::delFile($img);
					$this->jsonMsg(504, '缩略图(中)文件生成失败:'.$thumb_img['msg'], '', $transaction);
				}
				$model->csc_img_thumb = $thumb_img['path'];
				//生成小缩略图
				$small = $thumb_config['small'];
				$thumb_img = BaseApi::createThumb($model->csc_img, $small['width'], $small['height'] , '_thumb_min');
				if(!$thumb_img['status']){
					BaseApi::delFile($img);
					$this->jsonMsg(505, '缩略图(小)文件生成失败:'.$thumb_img['msg'], '', $transaction);
				}
				$model->csc_img_thumb_min = $thumb_img['path'];
			}
			//写入数据
			if(!$model->save()){
				$error = implode('', current($model->getErrors()));
				$this->jsonMsg(506, '添加失败'.$error, '', $transaction);
			}
			//提交事务
			$transaction->commit();

			//添加操作日志
			$log = '新增教师：'.$model->csc_name;
			$this->addOperLog($log);
			$this->jsonMsg(200, '添加成功', '', $this->createUrl('goods/index'));
		}
		$this->render('add');
	}
	/**
	 * 修改教师
	 */
	public function actionEdit(){
		//获得csc_id
		$id = Yii::app()->request->getParam('ids');
		if(!$id){
			$this->jsonMsg(501, '参数有误');
		}
		//获得数据
		$model = Goods::model()->findByPk($id);
		if(!$model){
			$this->jsonMsg(502, '数据有误');
		}
		if (Yii::app()->request->isPostRequest){
			//获得数据
			$model->csc_name = Yii::app()->request->getParam('name');
			$model->csc_sort = Yii::app()->request->getParam('sort');
 			$model->csc_recom_point = Yii::app()->request->getParam('recom_point');
//			$model->csc_sale_num = Yii::app()->request->getParam('sale_num');
//			$model->csc_price = Yii::app()->request->getParam('price');
//			$model->csc_cate_id = Yii::app()->request->getParam('cate_id');
			$model->csc_term = Yii::app()->request->getParam('term');
			$model->csc_gd = Yii::app()->request->getParam('gd');
			$model->csc_sj = Yii::app()->request->getParam('sj');
			$model->csc_school = Yii::app()->request->getParam('school');
			//开启事务
			$transaction = Yii::app()->db->beginTransaction();
			//desc图片处理
			$new_content = Yii::app()->request->getParam('desc');
			$oldImg = BaseApi::getContentImg($model->csc_desc);
			$contentImg = BaseApi::getContentImg($new_content);
			$uploadImg = array_diff($contentImg, $oldImg);
			array_diff($oldImg, $contentImg);
			// 新上传的图片移至正式目录
			Yii::app()->params['img_upload_dir'];
			$uploadImgNew = array();
			foreach ($uploadImg as $v){
				$copyStatus = BaseApi::copyTempFile(trim($v), 'goods/desc');
				if(!$copyStatus['status']){
					$uploadImgNew[] = $v;
				}else{
					$uploadImgNew[] = $copyStatus['path'];
				}
			}
			// 内容更新
			$model->csc_desc = BaseApi::updateContentImg($new_content, $uploadImg, $uploadImgNew);
			//note图片处理
			$new_content = Yii::app()->request->getParam('note');
			$oldImg = BaseApi::getContentImg($model->csc_note);
			$contentImg = BaseApi::getContentImg($new_content);
			$uploadImg = array_diff($contentImg, $oldImg);
			array_diff($oldImg, $contentImg);
			// 新上传的图片移至正式目录
			Yii::app()->params['img_upload_dir'];
			$uploadImgNew = array();
			foreach ($uploadImg as $v){
				$copyStatus = BaseApi::copyTempFile(trim($v), 'goods/note');
				if(!$copyStatus['status']){
					$uploadImgNew[] = $v;
				}else{
					$uploadImgNew[] = $copyStatus['path'];
				}
			}
			// 内容更新
			$model->csc_note = BaseApi::updateContentImg($new_content, $uploadImg, $uploadImgNew);
			//获得新图片
			$img = Yii::app()->request->getParam('img');
			//处理商品图片
			if($img != $model->csc_img){
				//删除旧缩略图
				$d_img = array($model->csc_img, $model->csc_img_thumb, $model->csc_img_thumb_min);
				foreach ($d_img as $v){
					BaseApi::delFile($v);
				}
				//复制图片到正式目录
				$copyStatus = BaseApi::copyTempFile($img, 'goods/img');
				if(!$copyStatus['status']){
					BaseApi::delFile($img);
					$this->jsonMsg(503, '商品图片文件处理失败:'.$copyStatus['msg'], '', $transaction);
				}
				$model->csc_img = $copyStatus['path'];
				//生成中缩略图
				$thumb_config = Yii::app()->params['img_thumb']['goods'];
				$thumb = $thumb_config['thumb'];
				$thumb_img = BaseApi::createThumb($model->csc_img, $thumb['width'], $thumb['height']);
				if(!$thumb_img['status']){
					BaseApi::delFile($img);
					$this->jsonMsg(504, '缩略图(中)文件生成失败:'.$thumb_img['msg'], '', $transaction);
				}
				$model->csc_img_thumb = $thumb_img['path'];
				//生成小缩略图
				$small = $thumb_config['small'];
				$thumb_img = BaseApi::createThumb($model->csc_img, $small['width'], $small['height'] , '_thumb_min');
				if(!$thumb_img['status']){
					BaseApi::delFile($img);
					$this->jsonMsg(505, '缩略图(小)文件生成失败:'.$thumb_img['msg'], '', $transaction);
				}
				$model->csc_img_thumb_min = $thumb_img['path'];
			}
			//写入数据
			if(!$model->save()){
				$error = implode('', current($model->getErrors()));
				$this->jsonMsg(506, '添加失败'.$error, '', $transaction);
			}
			//提交事务
			$transaction->commit();

			//添加操作日志
			$log = '更新教师：'.$model->csc_name;
			$this->addOperLog($log);
			$this->jsonMsg(200, '更新成功', '', $this->createUrl('goods/index'));
		}
		$cate = Category::model()->findAll();
		$this->render('add', array(
			'model'=>$model,
			'cate'=>$cate,
		));
	}
	/**
	 * 删除教师
	 */
	public function actionDel(){
		//获得csc_id
		$id = Yii::app()->request->getParam('ids');
		if(!$id){
			$this->jsonMsg(501, '参数有误');
		}
		//获得数据
		$model = Goods::model()->findByPk($id);
		if(!$model->delete()){
			$this->jsonMsg(502, '删除失败');
		}
		//删除教师扩展
		Goodsinfo::model()->deleteAll('csc_goods_id=:csc_goods_id' , array(':csc_goods_id'=>$id));
		//删除教师扩展note图片
		$delimg = BaseApi::getContentImg(Goodsinfo::model()->csc_content);
		foreach($delimg as $v){
			BaseApi::delFile($v);
		}
		//删除desc图片
		$delimg = BaseApi::getContentImg($model->csc_desc);
		foreach($delimg as $v){
			BaseApi::delFile($v);
		}
		//删除note图片
		$delimg = BaseApi::getContentImg($model->csc_note);
		foreach($delimg as $v){
			BaseApi::delFile($v);
		}
		//删除图片
		$d_img = array($model->csc_img, $model->csc_img_thumb, $model->csc_img_thumb_min);
		foreach ($d_img as $v){
			BaseApi::delFile($v);
		}
		//删除记录
		$log = '删除教师: '.$model->csc_name;
		$this->addOperLog($log);
		$this->jsonMsg(200, '删除成功');
	}
	/**
	 * 选择教师
	 */
	public function actionSelect(){
		$goods = Goods::model()->findAll();
		$this->layout = '/layouts/admin_select';
		return $this->render('select', array(
			'goods' => $goods,
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
		$goods = Goods::model()->find('csc_id=:id', array(':id'=>$ids));
		if(!$goods){
			$this->jsonMsg(401, '没有找到您要数据');
		}
		$goods->csc_sort = $num;
		if(!$goods->save()){
			$error = implode('', current($goods->getErrors()));
			$this->jsonMsg(500, '系统错误'.$error);
		}
		$log = '更改教师排序：'.$goods->csc_name;
		$this->addOperLog($log);
		$this->jsonMsg(200, '操作成功');
	}
}