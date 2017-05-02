<?php

class ProductController extends Controller
{
	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}
	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
//		#产品展示
		$product = Category::model()->find('csc_name='."'产品展示'");
		$this->title = $product->csc_seo_title;
		$this->keywords = $product->csc_seo_keywords;
		$this->description = $product->csc_seo_description;
		$model = Faq::model();
		$critera = new CDbCriteria();
		$critera->condition = 'csc_cate_id=:cid AND csc_show = 1';
		$critera->order = 'csc_sort';
		$critera->params = array('cid'=>$product->csc_id);
		$count = $model->count($critera);
		$pager  = new CPagination($count);
		$pager->pageSize = 4;
		$pager->applyLimit($critera);
		$comtxt = $model->findAll($critera);
		$this->render('index',array(
				'pages'=>$pager,
				'faqs'=>$comtxt,
		));
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
//			dump($error=Yii::app()->errorHandler->error);exit;
			if(Yii::app()->request->isAjaxRequest){
				echo $error['message'];
			}else{
				$this->render('error', $error);
			}
		}
	}
	
	/**
	 * 整理分类路径
	 */
	public function actionCate(){
		set_time_limit(0);
		$cate = Category::model()->findAll();
		foreach ($cate as $item){
			$flag = false;
			$path = explode(',', $item->csc_cate_path);
			foreach ($path as $k=>$v){
//				if($k==1) $v .= $path[$k+1].$path[$k+1].$path[$k+1];
				if(strlen($v)>32){
					$flag = true;
					$v = str_split($v);
					$v[31] .= ',';
					if(isset($v[63])){
						$v[63] .= ',';
					}
					if(isset($v[95])){
						$v[95] .= ',';
					}
					if(isset($v[127])){
						$v[127] .= ',';
					}
					$path[$k] = trim(implode('', $v), ',');
				}
			}
			if($flag){
				$item->csc_cate_path = implode(',', $path);
				//dump($path);
				dump($item->csc_cate_path);
				if(!$item->save()){
					$error = implode('', current($item->getErrors()));
					$this->exception($error);
				}
			}
		}
		
		$goods = Goods::model()->findAll('csc_add>0');
		foreach ($goods as $item){
			$flag = false;
			$path = explode(',', $item->csc_cate_path);
			foreach ($path as $k=>$v){
				if(strlen($v)>32){
					$flag = true;
					$v = str_split($v);
					$v[31] .= ',';
					
					if(isset($v[63])){
						$v[63] .= ',';
					}
					if(isset($v[95])){
						$v[95] .= ',';
					}
					if(isset($v[127])){
						$v[127] .= ',';
					}
					$path[$k] = trim(implode('', $v), ',');
				}
			}
			if($flag){
				$item->csc_cate_path = implode(',', $path);
				dump($item->csc_cate_path);
				
				if(!$item->save()){
					$error = implode('', current($item->getErrors()));
					$this->exception('商品'.$error);
				}
			}
		}
		
	}

	
	/**
	 * 整理规格
	 */
	public function actionSpec(){
		$spec = GoodsSpec::model()->findAll();
		foreach ($spec as $item){
			$goods = Goods::model()->findByPk($item->csc_goods_id);
			if($goods){
				$goods->csc_spec = $item->csc_id;
				if(!$goods->save()){
					$error = implode('', current($goods->getErrors()));
					$this->exception('商品'.$error);
				}
			}
		}
		
	}
	
	
	/**
	 * 设置城市站点
	 * Enter description here ...
	 */
	public function actionSetsite(){
		$site_id = Yii::app()->request->getParam('site_id');
		$site_id = $site_id?$site_id:Yii::app()->Params['default_site_id'];
		$cookie= new CHttpCookie('site_id', $site_id);
		$cookie->expire = time()+60*60*24*30;  //有限期30天
		Yii::app()->request->cookies['site_id']=$cookie;
		$this->redirect(Yii::app()->request->urlReferrer);
	}

	
	public function actionThumb(){
		set_time_limit(0);
		$_model = Goods::model();
		
		$cond = new CDbCriteria();
		$cond->addCondition('csc_add>0');
		//$cond->select = 'csc_id,csc_name,csc_img,csc_img_thumb,csc_img_thumb_min';
		
		$data = $_model->findAll($cond);
		foreach ($data as $item){
			$old_img = $item->csc_img_thumb_min;
			$old_img_1 = $item->csc_img_thumb;
			
			// 生成缩略图
			$thumb_config = Yii::app()->params['img_thumb'];
			$thumb_config = $thumb_config['recover'];

			$thumb = $thumb_config['thumb'];
			$thumb_img = BaseApi::createThumb($item->csc_img, $thumb['width'], $thumb['height']);
			if(!$thumb_img['status']){
				$this->ajaxReturn(506, '缩略图(中)文件生成失败:'.$thumb_img['msg'], 'eval');
			}
			$item->csc_img_thumb = $thumb_img['path']; // 中等缩略图
			
			$small = $thumb_config['small'];
			$thumb_img = BaseApi::createThumb($item->csc_img, $small['width'], $small['height'], '_thumb_min');
			
			if(!$thumb_img['status']){
				$this->ajaxReturn('缩略图(小)文件生成失败:'.$thumb_img['msg'], 'eval');
			}
			
			$item->csc_img_thumb_min = $thumb_img['path']; // 最小缩略图

			if(!$item->save()){
				$this->ajaxReturn('数据更新失败：'.var_export($item->getErrors()), 'eval');
			}
			
			
//			$this->ajaxReturn($item->csc_id.'---'.$item->csc_img_thumb_min.'---'.$item->csc_img_thumb, 'eval');
		}
	}
	
	function actionThumbmin(){
		set_time_limit(0);
		$album = GoodsAlbum::model()->findAll();
		
		$web_path = dirname(Yii::app()->basePath);
		
		foreach ($album as $item){
			$old_img = $item->csc_img_thumb_min;
			$old_img_1 = $item->csc_img_thumb;
				
			// 生成缩略图
			$thumb_config = Yii::app()->params['img_thumb'];
			$thumb_config = $thumb_config['recover_album'];
			
			if(!file_exists($web_path.$item->csc_img)){
				echo $item->csc_img.'<br>';
				continue;
			}

			$thumb = $thumb_config['thumb'];
			$thumb_img = BaseApi::createThumb($item->csc_img, $thumb['width'], $thumb['height']);
			if(!$thumb_img['status']){
				$this->ajaxReturn(506, '缩略图(中)文件生成失败:'.$thumb_img['msg'], 'eval');
			}
			$item->csc_img_thumb = $thumb_img['path']; // 中等缩略图
			
			$small = $thumb_config['small'];
			$thumb_img = BaseApi::createThumb($item->csc_img, $small['width'], $small['height'], '_thumb_min');
			if(!$thumb_img['status']){
				$this->ajaxReturn('缩略图(小)文件生成失败:'.$thumb_img['msg'], 'eval');
			}
			$item->csc_img_thumb_min = $thumb_img['path']; // 最小缩略图

			if(!$item->save()){
				$this->ajaxReturn('数据更新失败：'.var_export($item->getErrors()), 'eval');
			}
				
				
//			$this->ajaxReturn($item->csc_id.'---'.$item->csc_img_thumb_min.'---'.$item->csc_img_thumb, 'eval');
		}
	}
	
	
	/**
	 * 获取每页新闻列表
	 */
	protected function getList($url, $page=1){
	    if($page>1){
	        $url .= 'page'.$page.'.html';
	    }
	    
	    $regArr = array(
			'href'=>array('a', 'href'),
			'title'=>array('a', 'text'),
		    'source'=>array('span', 'text'),
		);
		
		$rang = '.text';
		$res = Yii::app()->querylist->query($url, $regArr, $rang);
		
		return $res->jsonArr;
	}
    
	/**
	 * 获取内容
	 */
	protected function getContent($url){
	    $rang = '#content';
	    $regArr = array(
	        'desc'=>array('li:eq(1)', 'text'),
	        'content'=>array('li:eq(2)', 'html'),
	        'notice'=>array('li:eq(3)', 'html'),
	        'cate'=>array('.nav-t a:eq(2)', 'text'),
	    );
	    
	    $res = Yii::app()->querylist->query($url, $regArr, $rang);
		return $res->jsonArr;
	}
	
	protected function saveNews($title, $keywords, $content, $time, $cate){
	    $syn_url = 'http://xzl.cosecant.cn/index.php?act=newsinsert';
	    $syn_url = 'http://www.officecd.net/index.php?act=newsinsert';
	    /*
	    '$_POST[title]',
"'$_POST[keywords]', '$_POST[content]', '". gmtime() ."', '". $_SESSION[admin_id] ."','$news_img', '$news_thumb', '$original_img')
	     */
	    $data = array(
	        'title'=>$title,
	        'keywords'=>$keywords,
	        'content'=>$content,
	        'time'=>strtotime($time),
	        'type_name'=>$cate,
	    );
	    
	    $res = Yii::app()->curl->post($syn_url, $data);
	    
		return Yii::app()->curl->getStatus();
	}
	
	function actionPcn(){
	    set_time_limit(0);
		$url = 'http://o.officecd.net/news/';
		
		//$http_code = $this->saveNews('测试文章标题', 'asdfas', 'adsfa3efwef', date('Y-m-d H:i:s'));
		//dump($http_code);exit;
		
		for($i=1138; $i>0; $i--){
		    $list = $this->getList($url, $i);
		    
		    //dump($list);exit;
		    foreach ($list as $item){
		        $_url = dirname($url).$item['href'];
		        
		        $item['source'] = str_replace(array('[', ']'), '', $item['source']);
		        
		        $c = $this->getContent($_url);
		        
		        if(count($c)<=0) continue;
		        $c = $c[0];
		        
		        $time = substr($c['desc'], 0, strrpos($c['desc'], ':')+3);
		        
		        $replace = array('/uploadFile/image/', '/upload/news/');
		        $repl = array('/images/uploadFile/image/', '/images/upload/news/');
		        
		        $c['content'] = str_replace($replace, $repl, $c['content']);
		        
		        $http_code = $this->saveNews($item['title'], $item['source'], $c['content'].$c['notice'], $time, $c['cate']);
		        
		        if($http_code!=200){
		            $ct = array_merge($item, $c);
		            Yii::log("内容同步失败：\n".var_export($ct, true), 'error');
		        }else{
		            Yii::log(var_export($item['title'], true)." 同步成功, 当前页码:{$i}\n", 'error');
		        }
		    }
		}
	}
	
	
	/**
	 * 脚本（设置goods_ext）
	 * Enter description here ...
	 */
	public function actionSetgoodsext(){
		$goods_data = Goods::model()->findAll();
		foreach ($goods_data as $item){
			$goodsext = GoodsExt::model()->findByPk($item->csc_id);
			if($goodsext) continue;
			$goodsext = new GoodsExt();
			$goodsext->csc_goods_id = $item->csc_id;
			$goodsext->save();
		}
	}
	
	/**
	 * 清理商品规格
	 */
	public function actionGoodsspec(){
		set_time_limit(0);
		
		$goodsspec = GoodsSpec::model()->findAll();
		foreach ($goodsspec as $item){
			// 查询商品
			$num = Goods::model()->countByAttributes(array('csc_id'=>$item->csc_goods_id));
			if($num) continue;
			
			$item->delete();
			dump($item->csc_id);
		}
		
		$goods = Goods::model()->findAll();
		foreach ($goods as $item){
			if($item->spec_default) continue;
			
			// 查询商品规格
			foreach ($item->spec as $spec){
				if(false === $item->saveAttributes(array('csc_spec'=>$spec->csc_id))){
					dump($item->getDbError());
				}
				dump($item->csc_id);
				
				break;
			}
		}
		
	}



	/*
     * 搜索
     */
	public function actionSearch(){
		//分页
		$criteria = new CDbCriteria();
		$sword = Yii::app()->request->getParam('search');
		if ($sword!=''){
			$criteria->addCondition('locate(:search,csc_name)');
			$criteria->params['search'] = $sword;
			$count = Faq::model()->count($criteria);
			$pager = new CPagination($count);
			$pager->pageSize = 12;
			$pager->applyLimit($criteria);
			$articles = Faq::model()->findAll($criteria);
			$article= array();
			for($i=0;$i<4;$i++){
				$article[] = array_shift($articles);
			}
			$result = array_shift($article);
			if($result==null){
				$this->redirect(Yii::app()->request->urlReferrer);
			}
			$this->render('center', array(
				//'category'=>$category,
				'article'=>$article,
				'articles'=>$articles,
				'result'=>$result,
				'pages'=>$pager,
				'sword'=>$sword,
			));
		}else{
			//echo "<script language='javascript'>alert('1');</script> ";
			$this->redirect(Yii::app()->request->urlReferrer);
		}

	}


	public function actionDetail(){
		$cid = Yii::app()->request->getParam('cid');
		if(!$cid){
			$cid = 1;
		}
		$comtxt = Faq::model()->find('csc_cate_id=:cid',array('cid'=>$cid));
		$this->render('detail',array(
			'article'=>$comtxt,
		));
	}

	public function actionGd(){
		$sid = Yii::app()->request->getParam('school');
		$gd = Faq::model()->findAll('csc_cate_id=:sid',array(
			':sid' => $sid,
		));
		$str = '';
		foreach($gd as $val) {
			$str .= '<option value='.$val['csc_id'].'>'.$val['csc_name'].'</option>';
		}
		echo $str;
	}

}