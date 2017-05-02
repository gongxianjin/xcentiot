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
	public $layout = '/layouts/wap';
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

	public $nav;

	public $todo;

	public $title = "极客数学";

	public $returnPage = '';//用于页面返回

	public function __construct($id, $module=null){

		parent::__construct($id, $module);

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

	//获取面包屑
	public function categoryMbs($id){
		$cate = Category::model()->find('csc_id=:id',array(':id'=>$id));
		$cate_path = $cate ? $cate->csc_cate_path : '0';

		$cond = new CDbCriteria();
		$ids = explode(',', $cate_path);

		$cond->addInCondition('csc_id', $ids);

		$cate_path = '\''.str_replace(',', '\',\'', $cate_path).'\'';

		$cond->order = 'FIELD(`csc_id`, '.$cate_path.')';

		// 查询所有节点
		$data = Category::model()->findAll($cond);

		return $data;
	}

	// 检测单元操作权限
	public function checkOperModule($c, $a='index'){
		if(!$a || !$a) return false;

		$ingnore_controller = array('index', 'user', 'gd');
		$ingnore_action = array('select', 'order');

		if(in_array($c, $ingnore_controller) || in_array($a, $ingnore_action)) return true;

		$master = Yii::app()->params['default_master'];
		if(Yii::app()->session['sysuser_user'] == $master['user']) return true;

		static $G_POWER;

		if(!$G_POWER){
			$G_POWER = Sysrole::model()->find('csc_id=:cid', array(':cid'=>Yii::app()->session['sysuser_role_id']));
		}

		return $G_POWER && stristr($G_POWER->csc_power_id, $c.'-'.$a) ? true :false;
	}

	// 添加操作日志记录
	protected function addOperLog($log, $dubug=false){
		if(!$log) return;

		$data = new OperLog();
		$data->csc_user_id = Yii::app()->session['sysuser_id'];
		$data->csc_username = trim(Yii::app()->session['sysuser_tname']);
		$data->csc_username = $data->csc_username ? $data->csc_username : Yii::app()->session['sysuser_user'];
		$data->csc_log = $log;
		$data->csc_guest_ip = Yii::app()->request->userHostAddress;

		if(!$data->save() && $dubug){
			dump($data->getErrors());
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
			$comdate = $fmodel->find('csc_cate_id = \''.$cat->csc_id.'\' AND csc_name = \''.$fname.'\' ');
		}else{
			$comdate = $fmodel->find('csc_cate_id = \''.$cat->csc_id.'\'');
		}
		return $comdate;
	}


}