<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends CController
{
	/**
	 * @var string the default layout for the controller view. Defaults to '//layouts/column1',
	 * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
	 */
	public $layout = '//layouts/main';
	/**
	 * @var array context menu items. This property will be assigned to {@link CMenu::items}.
	 */
	public $menu=array();
	/**
	 * @var array the breadcrumbs of the current page. The value of this property will
	 * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
	 * for more details on how to specify this property.
	 */
	public $breadcrumbs=array();

	public $title = '';
	public $keywords = '';
	public $description;
	public $site_id;//城市站点id
	public $nav;



	//构造
	public function __construct($id, $module=null){

		parent::__construct($id, $module);

		$site = Yii::app()->params['site'];

		$this->title = $site['title'];
		$this->keywords = $site['keywords'];
		$this->description = $site['description'];

		$this->nav = $id;

	}

	/**
	 * Ajax方式返回数据到客户端
	 * @access protected
	 * @param mixed $data 要返回的数据
	 * @param String $type AJAX返回数据格式
	 * @return void
	 */
	protected function ajaxReturn($data,$type='') {
		if(empty($type)) $type = 'JSON';
		switch (strtoupper($type)){
			case 'JSON' :
				// 返回JSON数据格式到客户端 包含状态信息
				header('Content-Type:application/json; charset=utf-8');
				exit(json_encode($data));
			case 'XML'  :
				// 返回xml格式数据
				header('Content-Type:text/xml; charset=utf-8');
				exit(xml_encode($data));
			case 'JSONP':
				// 返回JSON数据格式到客户端 包含状态信息
				header('Content-Type:application/json; charset=utf-8');
				$handler  =   isset($_GET['jsonpcallback']) ? $_GET['jsonpcallback'] : 'jsonpcallback';
				exit($handler.'('.json_encode($data).');');
			case 'EVAL' :
				// 返回可执行的js脚本
				header('Content-Type:text/html; charset=utf-8');
				exit($data);
		}
	}

	public function jsonMsg($code, $msg, $data='', $forwardUrl='', $translation=null){
		$jsonp = Yii::app()->request->getParam('jsonp');
			
		$array = array(
			'code' => $code,
			'msg' => $msg,
		);
		if($data){
			$array['data'] = $data;
		}
		if($forwardUrl){
			$array['forward'] = $forwardUrl;
		}

		if($code!=200 && $translation) $translation->rollback(); // 事务操作失败后回滚
		if($code==200 && $translation) $translation->commit(); // 事务操作成功后提交事务

		if(!$jsonp){
			$this->ajaxReturn($array, 'json');
		}else{
			$_GET['jsonpcallback'] = $jsonp;
			$this->ajaxReturn($array, 'jsonp');
		}
	}

	public function loadCssOrJs($source, $type='css', $pos = CClientScript::POS_END){
		static $resource;
		$resource = !isset($resource) && !$resource ? array() : $resource;

		if(in_array($source, $resource)) return;

		$resource[] = $source;
		switch ($type){
			case 'css':
				Yii::app()->getClientScript()->registerCssFile(Yii::app()->baseUrl.'/assets'.$source);
				break;
			case 'stylesheet':
				Yii::app()->getClientScript()->registerCss(rand(100, 10000), file_get_contents($source));
				break;
			case 'js':
				Yii::app()->getClientScript()->registerScriptFile(Yii::app()->baseUrl.'/assets'.$source, $pos);
				break;
			case 'script':
				$script = require $source;
				Yii::app()->getClientScript()->registerScript(rand(100, 10000), $script, $pos);
				break;
			default: $pos = false; break;
		}
	}

	/**
	 * 获取分类
	 * Enter description here ...
	 * @param unknown_type $id
	 */
	public function categoryMbs($id){
		$cate = Category::model()->find('csc_id=:id',array(':id'=>$id));
		$cate_path = $cate ? $cate->csc_cate_path : '0';

		$cond = new CDbCriteria();
		$ids = explode(',', $cate_path);

		$cond->addInCondition('csc_id', $ids);
		$cond->addCondition('csc_show=1');

		$cate_path = '\''.str_replace(',', '\',\'', $cate_path).'\'';

		$cond->order = 'FIELD(`csc_id`, '.$cate_path.')';

		// 查询所有节点
		$data = Category::model()->findAll($cond);

		return $data;
	}


	/**
	 * 获取地区面包屑
	 * Enter description here ...
	 * @param unknown_type $id
	 */
	public function pcaMbs($id){
		$pca = PCA::model()->findByPk($id);
		if(!$pca) return;
		$data[] = $pca;
		//
		//		if($pca->parent){
		//			$data[] = $pca->parent;
		//			self::pcaMbs($pca->parent->csc_id);
		//		}
		//		$data = array_reverse($data);

		if ($pca->csc_type=='city'){//市
			array_unshift($data, $pca->parent);
		}elseif($pca->csc_type=='area'){
			array_unshift($data, $pca->parent->parent,$pca->parent);
		}
		return $data;
	}


	/**
	 * 获取城市列表信息
	 * @param Int $cid
	 * @param Int $pid
	 */
	function getPCAList($type='province', $pid=0){
		$model = PCA::model();
		$data = $model->findAll('csc_parent_id=:pid and csc_type=:type',array(':pid'=>$pid,':type'=>$type));
		return !is_array($data) ? array() : $data;
	}

	/**
	 * 根据参数获取城市地区列表
	 */
	public function actionPcalist(){
		$province_id = Yii::app()->request->getParam('province_id');
		$city_id = Yii::app()->request->getParam('city_id');

		if(!$province_id || !$province_id && !$city_id){
			$this->jsonMsg(400, '参数有误');
		}
		$data = $arr = array();

		if($province_id && !$city_id){
			$data['type'] = 'province';
			$pac = $this->getPCAList('city', $province_id);
			foreach($pac as $k=>$v){
				$arr[$k]['csc_code'] = $v->csc_code;
				$arr[$k]['csc_id'] = $v->csc_id;
				$arr[$k]['csc_name'] = $v->csc_name;
				$arr[$k]['csc_pinyin'] = $v->csc_pinyin;
			}
			$data['item'] =$arr;
		}else if($province_id && $city_id){
			$data['type'] = 'city';
			$pac = $this->getPCAList('area', $city_id);
			foreach($pac as $k=>$v){
				$arr[$k]['csc_code'] = $v->csc_code;
				$arr[$k]['csc_id'] = $v->csc_id;
				$arr[$k]['csc_name'] = $v->csc_name;
				$arr[$k]['csc_pinyin'] = $v->csc_pinyin;
			}
			$data['item'] = $arr;
		}
		$this->jsonMsg(200, 'OK', $data);
	}

	/**
	 * 获取订单支付种类
	 * @param String $order_id
	 * @param Array $pay_type
	 */
	protected function getOrderPayType($order_id, $pay_type){
		if('M_' == substr($order_id, 0, 2)){
			$order_id = substr($order_id, 2);
		}

		$shipaddress_info = OrderMail::model()->find('csc_order_id=:pid',array(':pid'=>$order_id));
		//dump($shipaddress_info);exit;

		if (!empty($shipaddress_info)){
			$shipping = Shipping::model()->find('csc_id=:sid',array(':sid'=>$shipaddress_info->csc_mail_id));
			$cod_regions   = unserialize($shipping->csc_cod_regions);
			$cod_usable = true;//默认可用

			if (is_array($cod_regions) && !empty($cod_regions)){
				/* 取得支持货到付款地区的所有下级地区 */
				$all_regions = array();
				foreach ($cod_regions as $region_id => $region_name)
				{
					$all_regions = array_merge($all_regions, CSXCore::get_descendant($region_id));
				}
				/* 查看订单中指定的地区是否在可货到付款的地区列表中，如果不在，则不显示货到付款的付款方式 */
				if (!in_array($shipaddress_info['csc_region_id'], $all_regions))
				{
					$cod_usable = false;
				}
			}else{
				$cod_usable = false;
			}

			if (!$cod_usable){
				if ($pay_type['cash_delivery'] == '货到付款')
				{
					unset($pay_type['cash_delivery']);
				}
			}
		}else{
			$this->exception('订单信息有误');
		}

		return $pay_type;
	}



	/**
	 * 检测库存
	 * Enter description here ...
	 */
	protected  function Checkstock($order_id){
		if(!$order_id){
			return false;
		}
		//减去相对应的库存
		$cuk_order = array();
		if(strstr($order_id, 'M_')){//合并订单
			$cuk_order = Order::model()->findAll("csc_merge_id='{$order_id}'");
		}else{//非合并订单
			$cuk_order[] = Order::model()->findByPk($order_id);
		}
		$num = '';
		foreach ($cuk_order as $cob_order){
			foreach ($cob_order->ordergoods as $goods){
				if(isset($goods->good) && isset($goods->good->spec_default)){
					$num = $goods->good->spec_default->csc_stock-$goods->csc_num;
					if($num<0){
						return false;
					}
				}
			}
		}

		return true;
	}

	/**
	 * 检查商品是否支持货到付款
	 * Enter description here ...
	 */
	public function Checkcash($order_id){
		if(!$order_id){
			return false;
		}
		//减去相对应的库存
		$cuk_order = array();
		if(strstr($order_id, 'M_')){//合并订单
			$cuk_order = Order::model()->findAll("csc_merge_id='{$order_id}'");
		}else{//非合并订单
			$cuk_order[] = Order::model()->findByPk($order_id);
		}

		foreach ($cuk_order as $order){
			foreach ($order->ordergoods as $goods){
				if(!$goods->good->csc_cash){
					return false;
				}
				if($order->ordermail && $shipping = $order->ordermail->shipping){
					//配送方式货到付款区域
					$addre = unserialize($shipping->csc_cod_regions);
						
					if(!array_key_exists($order->ordermail->csc_region_id, $addre)){//检测订单地址是否在货到付款范围
						$pca = PCA::model()->findByPk($order->ordermail->csc_region_id);
						if(!array_key_exists($pca->parent->csc_id, $addre)){
							if(!array_key_exists($pca->parent->parent->csc_id, $addre)){
								return false;
							}
						}

					}
				}
			}
		}

		return true;
	}

	/**
	 * 自定义错误消息
	 * @param String $msg
	 * @param Int $code
	 * @throws CHttpException
	 */
	public function exception($msg, $code=800){
		$msg = str_replace(dirname(Yii::app()->basePath), '', $msg);
		throw new CHttpException($code, $msg);exit;
	}

	// 添加操作日志记录
	protected function addOperLog($log, $dubug=false){
		if(!$log) return;

		$data = new OperLog();
		$data->csc_id = getPrimaryKey($data);
		$data->csc_user_id = Yii::app()->session['sysuser_id'];
		$data->csc_username = trim(Yii::app()->session['sysuser_tname']);
		$data->csc_username = $data->csc_username ? $data->csc_username : Yii::app()->session['sysuser_user'];
		$data->csc_log = $log;
		$data->csc_guest_ip = Yii::app()->request->userHostAddress;

		if(!$data->save() && $dubug){
			dump($data->getErrors());exit;
		}

	}

	public function GetMoreArt($pinyin){
		$cmodel = Category::model();
		$fmodel = Faq::model();
		$cat = $cmodel->find('csc_pinyin = \''.$pinyin.'\' ');
		$critera = new CDbCriteria();
		$critera->addCondition('csc_cate_id = :cid');
		$critera->params['cid'] = $cat->csc_id;
		$critera->order = 'csc_create desc';
		$count = $fmodel->count($critera);
		$pager = new CPagination($count);
		$pager->pageSize = 3;
		$pager->applyLimit($critera);
		$comdate = $fmodel->findAll($critera);
		return $comdate;
	}

	public function GetOneArt($pinyin,$fname){
		$cmodel = Category::model();
		$fmodel = Faq::model();
		$cat = $cmodel->find('csc_pinyin = \''.$pinyin.'\' ');
		if($fname){
			$comdate = $fmodel->find('csc_cate_id = \''.$cat->csc_id.'\' OR csc_name = \''.$fname.'\' ');
		}else{
			$comdate = $fmodel->find('csc_cate_id = \''.$cat->csc_id.'\'');
		}
		return $comdate;
	}

}