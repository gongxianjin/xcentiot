<?php
/**
 * 文章管理控制器
 * */
class ArticleController extends Controller{
	//文章列表
	public function actionIndex(){

		$model = new Faq();
		//分页
		$criteria = new CDbCriteria();
		$sword = Yii::app()->request->getParam('sword');
        $cate_id = Yii::app()->request->getParam('cate_id');

        $old = Category::model()->find('csc_id=:cid',array(':cid'=>$cate_id));

        if($cate_id){
            $criteria->addCondition('locate(:cid,csc_cate_path)');
            $criteria->params['cid'] = ','.$cate_id.',';
            $art = $model->find($criteria);
        }
		if ($sword){
			$criteria->addCondition('locate(:sword,csc_name)');
			$criteria->params['sword'] = $sword;
		}

		$count = $model->count($criteria);
		$pager = new CPagination($count);
		$pager->pageSize = Yii::app()->params['pages'];
		$pager->applyLimit($criteria);
		//排序
		$criteria->order = 'csc_sort ASC,csc_create DESC';
		$model = $model->findAll($criteria);
		$cate = Category::model()->findAll();
		return $this->render('index', array(
            'old' => $old,
            'art' => $art,
    		'faq' => $model,
    		'cate'=>$cate,
    		'pages'=>$pager,
		));
	}

	//添加文章
	public function actionAdd(){
		if(Yii::app()->request->isPostRequest){
			$model = new Faq();
			$model->csc_name=Yii::app()->request->getParam('name');
			$model->csc_subtitle = Yii::app()->request->getParam('subtitle');
			$model->csc_cate_id = Yii::app()->request->getParam('cate_id');
			$model->csc_cate_path = Category::model()->findByPk($model->csc_cate_id)->csc_cate_path;
			$model->csc_content = Yii::app()->request->getParam('content');
			$model->csc_desc = Yii::app()->request->getParam('desc');
//			$model->csc_video = Yii::app()->request->getParam('video');
			$model->csc_link = Yii::app()->request->getParam('link');
//			$model->csc_pca_id = Yii::app()->request->getParam('city');
			$model->csc_sort = Yii::app()->request->getParam('sort');
			$model->csc_best = Yii::app()->request->getParam('best');
			$model->csc_show = Yii::app()->request->getParam('show');
			$model->csc_time=Yii::app()->request->getParam('time');
			//SEO
//			$model->csc_seo_title = Yii::app()->request->getParam('seo_title');
//			$model->csc_seo_keywords = Yii::app()->request->getParam('seo_keywords');
//			$model->csc_seo_description = Yii::app()->request->getParam('seo_description');
			//获得图片
			$img = Yii::app()->request->getParam('img');

			//开启事务
			$transaction = Yii::app()->db->beginTransaction();
			//content内图片处理
			if($model->csc_content){
				$contentImg = BaseApi::getContentImg($model->csc_content);
				//新上传的图片移至正式目录
				Yii::app()->params['img_upload_dir'];
				$uploadImgNew = array();
				foreach ($contentImg as $v){
					$copyStatus = BaseApi::copyTempFile(trim($v), 'article/content');
					if(!$copyStatus['status']){
						$uploadImgNew[] = trim($v);
					}else{
						$uploadImgNew[] = $copyStatus['path'];
					}
				}
				//内容更新
				$model->csc_content = BaseApi::updateContentImg($model->csc_content, $contentImg, $uploadImgNew);
			}
			//desc内图片处理
			if($model->csc_desc){
				$contentImg = BaseApi::getContentImg($model->csc_desc);
				//新上传的图片移至正式目录
				Yii::app()->params['img_upload_dir'];
				$uploadImgNew = array();
				foreach ($contentImg as $v){
					$copyStatus = BaseApi::copyTempFile(trim($v), 'article/desc');
					if(!$copyStatus['status']){
						$uploadImgNew[] = trim($v);
					}else{
						$uploadImgNew[] = $copyStatus['path'];
					}
				}
				//内容更新
				$model->csc_desc = BaseApi::updateContentImg($model->csc_desc, $contentImg, $uploadImgNew);
			}
			//移动文件
			if($img){
				$copyStatus = BaseApi::copyTempFile($img, 'article/img');
				if(!$copyStatus['status']){
					BaseApi::delFile($img);
					$this->jsonMsg(503, '文章文件处理失败:'.$copyStatus['msg'], '', $transaction);
				}
				//获得上传后图片路径
				$model->csc_img = $copyStatus['path'];
				//生成中缩略图
                $thumb_config = Yii::app()->params['img_thumb']['article'];
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
				
			$log = '添加文章：'.$model->csc_name;
			$this->addOperLog($log);
				
			$this->jsonMsg(200, '添加成功', '', $this->createUrl('article/index'));
				
		}
		return $this->render('add',array(
        ));
	}


	//编辑文章
	public function actionEdit(){
//        $pca = PCA::model()->findAll('csc_parent_id=:pid',array(
//            ':pid' => 0,
//        ));

		//获得csc_id
		$id = Yii::app()->request->getParam('ids');
		if(!$id){
			$this->jsonMsg(501, '参数有误');
		}
		//获得数据
		$model = Faq::model()->findByPk($id);
		if(!$model){
			$this->jsonMsg(502, '数据有误');
		}

//        $sword = $model->csc_pca_id;
//        $city = PCA::model()->findByPk($sword);
//        $sf = PCA::model()->find('csc_id=:pid',array(
//            ':pid' => $city->csc_parent_id,
//        ));

		$cate = Category::model()->findAll();
		if(Yii::app()->request->isPostRequest){

            //var_dump($_POST);die;
			$model->csc_name=Yii::app()->request->getParam('name');
			$model->csc_subtitle = Yii::app()->request->getParam('subtitle');
			$model->csc_cate_id = Yii::app()->request->getParam('cate_id');
			$model->csc_cate_path = Category::model()->findByPk($model->csc_cate_id)->csc_cate_path;
			//$model->csc_content = Yii::app()->request->getParam('content');
			//$model->csc_desc = Yii::app()->request->getParam('desc');
//			$model->csc_video = Yii::app()->request->getParam('video');
			$model->csc_link=Yii::app()->request->getParam('link');
//            $model->csc_pca_id=Yii::app()->request->getParam('city');
			$model->csc_sort=Yii::app()->request->getParam('sort');
			$model->csc_best = Yii::app()->request->getParam('best');
			$model->csc_show = Yii::app()->request->getParam('show');
			$model->csc_time=Yii::app()->request->getParam('time');
			//SEO
//			$model->csc_seo_title = Yii::app()->request->getParam('seo_title');
//			$model->csc_seo_keywords = Yii::app()->request->getParam('seo_keywords');
//			$model->csc_seo_description = Yii::app()->request->getParam('seo_description');

			//开启事务
			$transaction = Yii::app()->db->beginTransaction();
			//content图片处理


            //图片处理
            $new_content = Yii::app()->request->getParam('content');
            $oldImg = BaseApi::getContentImg($model->csc_content);
            $contentImg = BaseApi::getContentImg($new_content);

            $uploadImg = array_diff($contentImg, $oldImg);
            $delImg = array_diff($oldImg, $contentImg);
            // 新上传的图片移至正式目录
            $tps = Yii::app()->params['img_upload_dir'];

            $uploadImgNew = array();
            foreach ($uploadImg as $v){
                $copyStatus = BaseApi::copyTempFile(trim($v), 'article/content');
                if(!$copyStatus['status']){
                    $uploadImgNew[] = $v;
                }else{
                    $uploadImgNew[] = $copyStatus['path'];
                }
            }

			// 内容更新
			$model->csc_content = BaseApi::updateContentImg($new_content, $uploadImg, $uploadImgNew);
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
				$copyStatus = BaseApi::copyTempFile(trim($v), 'article/desc');
				if(!$copyStatus['status']){
					$uploadImgNew[] = $v;
				}else{
					$uploadImgNew[] = $copyStatus['path'];
				}
			}
			// 内容更新
			$model->csc_desc = BaseApi::updateContentImg($new_content, $uploadImg, $uploadImgNew);
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
				$copyStatus = BaseApi::copyTempFile($img, 'article/img');
				if(!$copyStatus['status']){
					BaseApi::delFile($img);
					$this->jsonMsg(503, '文章图片文件处理失败:'.$copyStatus['msg'], '', $transaction);
				}
				$model->csc_img = $copyStatus['path'];
				//生成中缩略图
				$thumb_config = Yii::app()->params['img_thumb']['article'];
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

			$log = '编辑文章：'.$model->csc_name;
			$this->addOperLog($log);
				
			$this->jsonMsg(200, '编辑成功', '', $this->createUrl('article/index'));

		}
		return $this->render('add',array(
//            'sf' => $sf,
//            'city' => $city,
//            'pca' => $pca,
    		'faq'=>$model,
    		'cate'=>$cate,
		));
	}

	//删除文章
	public function actionDel(){
		//获得csc_id
		$id = Yii::app()->request->getParam('ids');
		if(!$id){
			$this->jsonMsg(501, '参数有误');
		}
		//获得数据
		$model = Faq::model()->findByPk($id);
		if(!$model->delete()){
			$this->jsonMsg(502, '删除失败');
		}
		//删除content图片
		$delimg = BaseApi::getContentImg($model->csc_content);
		foreach($delimg as $v){
			BaseApi::delFile($v);
		}
		//删除desc图片
		$delimg = BaseApi::getContentImg($model->csc_desc);
		foreach($delimg as $v){
			BaseApi::delFile($v);
		}
		//删除图片
		$d_img = array($model->csc_img, $model->csc_img_thumb, $model->csc_img_thumb_min);
		foreach ($d_img as $v){
			BaseApi::delFile($v);
		}
		 
		$log = '删除文章：'.$model->csc_name;
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
		$model = Faq::model()->find('csc_id=:id', array(':id'=>$ids));
		if(!$model){
			$this->jsonMsg(401, '没有找到您要数据');
		}
		$model->csc_sort = $num;
		if(!$model->save()){
			$error = implode('', current($model->getErrors()));
			$this->jsonMsg(500, '系统错误'.$error);
		}
		$log = '更改文章排序：'.$model->csc_name;
		$this->addOperLog($log);
		$this->jsonMsg(200, '操作成功');
	}
    /*
     * 地图查找分公司
     */
    public function actionPca(){

        $pid = Yii::app()->request->getParam('provice');
        $city = PCA::model()->findAll('csc_parent_id=:pid',array(
            ':pid' => $pid,
        ));
        $str = '';
        foreach($city as $val) {
            $str .= '<option value='.$val['csc_id'].'>'.$val['csc_name'].'</option>';
        }
        echo $str;
    }
}