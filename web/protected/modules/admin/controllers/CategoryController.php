<?php
/**
 * 分类控制器
 * @author Jacen
 * */
class CategoryController extends Controller{
	
	/**
	 * 初始化方法
	 * @param String $id
	 * @param Mixed $module
	 */
	public function __construct($id, $module=null){
		parent::__construct($id, $module);
	}

	
	/**
	 * 检测顶级分类信息
	 */
	protected function checkTopCate(){
		// 查询顶级分类
		$data = Category::model()->findAll();
		$default_cate = Yii::app()->params['category_type'];
	
		$rd = array();
		if(is_array($data)){
			foreach ($data as $item){
				$rd[] = $item->csc_id;
			}
		}

		foreach ($default_cate as $k=>$v){
			$_k = explode('-', $k);
			$num = count($_k);
			$_ck = $_k[$num-1];
			if(!in_array($_ck, $rd)){
				$parent_id = 0;
				$cate_path = '0';
				$sort = 0;
				switch ($num){
					case 1:
						$sort = $_k[0];
						break;
					case 2:
						$sort = $_k[1];
						$parent_id = $_k[0];
						$check = $this->getparent($parent_id);
						if(!$check){
							continue;
						}
						$cate_path = $check->csc_cate_path;
						break;
					case 3:
						$sort = $_k[2];
						$parent_id = $_k[1];
						$check = $this->getparent($parent_id);
						if(!$check){
							continue;
						}
						$cate_path = $check->csc_cate_path;
						break;
				}
				// 默认分类不存在，写入默认记录
				$category = new Category();
				$category->csc_id = $_ck;
				$category->csc_name = $v;
				$category->csc_parent_id = $parent_id;
				$category->csc_cate_path = $cate_path.','.$category->csc_id.',';
				$category->csc_show = 1;
				$category->csc_sort = $sort;

				if(!$category->validate()){
					$error = implode('', current($category->getErrors()));
					exit($error);
				}
				if(!$category->save()){
					$error = implode('', current($category->getErrors()));
					exit($error);
				}
			}
		}
	}
	
	public function getparent($id){
		$data = Category::model()->findByPk($id);
		return $data;
	}
	
	//分类列表
    public function actionIndex(){
    	$this->checkTopCate();
    	
    	$topID = Yii::app()->request->getParam('pid');
    	$topID = $topID ? $topID : '0';
    	$model = new Category();
    	//分页
		$criteria = new CDbCriteria(); 
		$criteria->addCondition('csc_parent_id=:pid');
		$criteria->params[':pid']=$topID; 
		$count = $model->count($criteria);
		$pager = new CPagination($count);
		$pager->pageSize = Yii::app()->params['pages'];
		$pager->applyLimit($criteria);
		$criteria->order =  'csc_sort asc';
    	$cate = $model->findAll($criteria);

    	$mbs = $this->categoryMbs($topID);
    	return $this->render('index', array(
    		'cate' => $cate,
    		'mbs' => $mbs,
    		'pages'=>$pager,
    	));
    }
	
    //添加分类
    public function actionAdd(){
    	$pid = Yii::app()->request->getParam('pid');
    	
    	if(Yii::app()->request->isPostRequest){
    		$model = new Category('add');
    		$model->csc_name=Yii::app()->request->getParam('name');
    		$model->csc_parent_id=Yii::app()->request->getParam('parent_id');
//			$model->csc_special_id=Yii::app()->request->getParam('special_id');
    		$model->csc_show=Yii::app()->request->getParam('show');
//    		$model->csc_recom=Yii::app()->request->getParam('recom');
    		$model->csc_link=Yii::app()->request->getParam('link');
    		$model->csc_sort=Yii::app()->request->getParam('sort');
    		$model->csc_pinyin = Yii::app()->request->getParam('pinyin');
    		$model->csc_id = getPrimaryKey($model);
    		$model->csc_logo = Yii::app()->request->getParam('logo');
//    		$model->csc_seo_title = Yii::app()->request->getParam('logo');
//    		$model->csc_seo_keywords = Yii::app()->request->getParam('seo_keywords');
    		$model->csc_seo_description = Yii::app()->request->getParam('seo_description');
    		
    		//设置分类路径
            $parent = $model->findByPk($model->csc_parent_id);
            $p = $parent ? $parent->csc_cate_path : '0,';
            $model->csc_cate_path = $p.$model->csc_id.',';
			
            //上传分类logo
    		if($model->csc_logo){
				$copyStatus = BaseApi::copyTempFile($model->csc_logo, 'cate_logo');
				if(!$copyStatus['status']){
					$this->jsonMsg(504, '文件处理失败:'.$copyStatus['msg']);
				}
				$model->csc_logo = $copyStatus['path'];
				if(!$model->save()){
					$error = implode('', current($model->getErrors()));
					$this->jsonMsg(505, '添加失败'.$error);
				}
			}

    		//验证
    		if(!$model->validate()){
				$error = implode('', current($model->getErrors()));
				$this->jsonMsg(500, $error);
			}
			if(!$model->save()){
				$error = implode('', current($model->getErrors()));
				$this->jsonMsg(502, '添加失败'.$error);
			}
			
			$log = '添加分类：'.$model->csc_name;
			$this->addOperLog($log);
			
			$this->jsonMsg(200, '添加成功', '', $this->createUrl('category/index', array('pid'=>$model->csc_parent_id)));
    	}
    	
    	$pcate = false;
		if($pid){
			// 查询分类
			$pcate = Category::model()->findByPk($pid);
		}
		
    	return $this->render('add', array('pcate'=>$pcate));
    }
    
    
    //编辑分类
    public function actionEdit(){
    	$id = Yii::app()->request->getParam('ids');
    	$model = new Category('edit');
    	$cate = $model->find('csc_id=:id',array(':id'=>$id));
    	if(Yii::app()->request->isPostRequest){
			$cate->csc_name=Yii::app()->request->getParam('name');
    		$cate->csc_parent_id=Yii::app()->request->getParam('parent_id');
//			$cate->csc_special_id=Yii::app()->request->getParam('special_id');
    		$cate->csc_show=Yii::app()->request->getParam('show');
//    		$cate->csc_recom=Yii::app()->request->getParam('recom');
    		$cate->csc_link=Yii::app()->request->getParam('link');
    		$cate->csc_sort=Yii::app()->request->getParam('sort');
    		$cate->csc_pinyin = Yii::app()->request->getParam('pinyin');
    		$logo = Yii::app()->request->getParam('logo');
	   		$cate->csc_seo_title = Yii::app()->request->getParam('seo_title');
	   		$cate->csc_seo_keywords = Yii::app()->request->getParam('seo_keywords');
    		$cate->csc_seo_description = Yii::app()->request->getParam('seo_description');
    		
    		
    		//设置分类路径
    		$parent = $model->find('csc_id=:id',array(':id'=>$cate->csc_parent_id));
    		$p = $parent ? $parent->csc_cate_path : '0,';
    		$cate->csc_cate_path = $p.$cate->csc_id.',';
    		
    		$cate->setScenario('edit');
    		
    		$transaction = Yii::app()->db->beginTransaction();
    		//修改分类logo
    		if($logo && $logo!=$cate->csc_logo){
    			$old_header = $cate->csc_logo;
    			$copyStatus = BaseApi::copyTempFile($logo, 'cate_logo');
    			if(!$copyStatus['status']){
    				$this->jsonMsg(504, '文件处理失败:'.$copyStatus['msg'], '', $transaction);
    			}
    			$cate->csc_logo = $copyStatus['path'];
    			if(!$cate->save()){
    				$error = implode('', current($cate->getErrors()));
    				$this->jsonMsg(505, '添加失败'.$error, '', '', $transaction);
    			}
    			// 删除旧文件
    			BaseApi::delFile($old_header);
    		}
    		
			//$cate->csc_id = getPrimaryKey($cate);
    		
    		//验证
			if(!$cate->save()){
				$error = implode('', current($cate->getErrors()));
				$this->jsonMsg(502, '编辑失败'.$error);
			}
			
			// 更新子分类路径
			// 查找所有子分类
			$cond = new CDbCriteria();
			$cond->addCondition('csc_id!=\''.$cate->csc_id.'\'');
			$cond->addCondition('locate(\''.$cate->csc_id.'\', csc_cate_path)');
			$cond->order = 'csc_cate_path asc';

			$data = $model->findAll($cond);
			foreach ($data as $item){
				// 查询父级节点
				//设置分类路径
				$parent = $model->find('csc_id=:id',array(':id'=>$item->csc_parent_id));
				$p = $parent ? $parent->csc_cate_path : '0,';
				$item->csc_cate_path = $p.$item->csc_id.',';
				$item->save();
			}
			
			$log = '编辑分类：'.$cate->csc_name;
			$this->addOperLog($log);
			
			$this->jsonMsg(200, '编辑成功', '', $this->createUrl('category/index', array('pid'=>$cate->csc_parent_id)), $transaction);
    		
    	}
    	return $this->render('add',array(
    		'cate'=>$cate,
    	));
    }
    //删除分类
    public function actionDel(){
    	$ids = Yii::app()->request->getParam('ids');
    	$del = array();

    	$ids = explode(',', $ids);
    	$cond = new CDbCriteria();
    	// 连同子条件一起查询
    	foreach ($ids as $k=>$id){
    		$cond->addCondition('locate(:k_'.$k.', csc_cate_path)', 'OR');
    		$cond->params['k_'.$k] = ','.$id.',';
    	}

    	$data = Category::model()->findAll($cond);
    	$trans = Yii::app()->db->beginTransaction();
    	foreach($data as $item){
    		$del[] = $item->csc_logo;
    		if(!$item->delete()){
    			$error = implode('', current($item->getErrors()));
    			$this->jsonMsg(500, '删除失败：'.$error, '', '', $trans);
    		}
    	}

    	// 删除logo文件
    	foreach ($del as $img){
    		BaseApi::delFile($img);
    	}
    	$log = '删除分类';
		$this->addOperLog($log);

    	$this->jsonMsg(200, '删除成功', '', '', $trans);
    }
    
    public function actionOrder(){
    	$ids = Yii::app()->request->getParam('ids');
    	$num = Yii::app()->request->getParam('num');
    	
    	if(!$ids){
    		$this->jsonMsg(400, '参数错误');
    	}
    	
    	$data = Category::model()->find('csc_id=:id', array(':id'=>$ids));
    	if(!$data){
			$this->jsonMsg(401, '没有找到您要数据');
		}
		
		$data->csc_sort = $num;
		if(!$data->save()){
			$error = implode('', current($data->getErrors()));
			$this->jsonMsg(500, '系统错误'.$error);
		}
		
		$log = '修改分类排序：'.$data->csc_name;
		$this->addOperLog($log);
		
		$this->jsonMsg(200, '操作成功');
    }
    
    public function actionSelect(){
    	$topID = Yii::app()->request->getParam('pid');
    	$topID = $topID ? $topID : '0';
    	
    	$cond = new CDbCriteria();
    	
    	$cond->addCondition('csc_parent_id=:pid');
    	$cond->params[':pid'] = $topID;
    	
    	$cond->order = 'csc_sort asc';
    	
    	$model = Category::model();
    	$cate = $model->findAll($cond);
    	
    	$mbs = $this->categoryMbs($topID);
    	
    	$this->layout = '/layouts/admin_select';
    	
    	return $this->render('select', array(
    		'cate' => $cate,
    		'mbs' => $mbs,
    	));
    }
}
