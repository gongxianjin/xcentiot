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
	public $layout = '/layouts/admin';
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
	
	public $todo; // 废弃不用

	public $news = false;

	public $tests = false;


	//基本权限配置
	protected $oper_meta_set = array(
		
		//权限管理
		'sysrole'=>array(
			'arlias'=>'权限管理',
			'items'=>array(
				'index'=>'管理列表', 'add'=>'添加角色', 'edit'=>'编辑角色','del'=>'删除角色', 'initrole'=>'导入权限',
			),
		),
		
		//系统设置
		'setup'=>array(
			'arlias'=>'系统设置',
			'items'=>array(
				'index'=>'设置列表',
			),
		),
		
		//会员管理
//		'member'=>array(
//			'arlias'=>'会员管理',
//			'items'=>array(
//				'index'=>'会员列表', 'add'=>'添加会员', 'edit'=>'编辑会员','del'=>'删除会员', 'edit_recharge'=>'会员充值', 'edit_reset'=>'重置会员时间', 'reg'=>'会员注册信息', 'business_room'=>'会员商务室',
//			),
//		),

		//管理员管理
		'manager'=>array(
			'arlias'=>'管理员管理',
			'items'=>array(
				'index'=>'管理员列表', 'add'=>'添加管理员', 'edit'=>'编辑管理员','del'=>'删除管理员'
			),
		),
		
		//分类管理
		'category'=>array(
			'arlias'=>'分类管理',
			'items'=>array(
				'index'=>'分类列表', 'add'=>'添加分类', 'edit'=>'编辑分类', 'del'=>'删除分类', 'order'=>'分类排序',
			),
		),
		
		//广告管理
		'ad'=>array(
			'arlias'=>'广告管理',
			'items'=>array(
				'index'=>'广告列表', 'add'=>'添加广告', 'edit'=>'编辑广告', 'del'=>'删除广告', 'order'=>'广告排序',
			),
		),

        //广告位管理
        'adpos'=>array(
            'arlias'=>'广告位管理',
            'items'=>array(
                'index'=>'广告位列表', 'add'=>'添加广告位', 'edit'=>'编辑广告位', 'del'=>'删除广告位', 'order'=>'广告位排序',
            ),
        ),
		
		//教师管理
//		'goods'=>array(
//			'arlias'=>'教师管理',
//			'items'=>array(
//				'index'=>'教师列表', 'add'=>'添加教师', 'edit'=>'编辑教师', 'del'=>'删除教师', 'order'=>'教师排序',
//			),
//		),

		//教师扩展管理
//		'goodsinfo'=>array(
//			'arlias'=>'教师扩展管理',
//			'items'=>array(
//				'index'=>'教师扩展列表', 'add'=>'添加教师扩展', 'edit'=>'编辑教师扩展', 'del'=>'删除教师扩展', 'order'=>'教师扩展排序',
//			),
//		),

		//专题管理
/*		'special'=>array(
			'arlias'=>'专题管理',
			'items'=>array(
				'index'=>'专题列表', 'add'=>'添加专题', 'edit'=>'编辑专题', 'del'=>'删除专题',
			),
		),*/
		
		//文章管理
		'article'=>array(
			'arlias'=>'文章管理',
			'items'=>array(
				'index'=>'文章列表', 'add'=>'添加文章', 'edit'=>'编辑文章', 'del'=>'删除文章',
			),
		),
		
		//搜索词管理
//		'hotkeyword'=>array(
//			'arlias'=>'搜索词管理',
//			'items'=>array(
//				'index'=>'搜索词列表', 'add'=>'添加搜索词', 'del'=>'删除搜索词',
//			),
//		),
		
		//网站页面管理
//		'service'=>array(
//			'arlias'=>'网站页面管理',
//			'items'=>array(
//				'index'=>'网站页面列表', 'add'=>'添加网站页面', 'edit'=>'编辑网站页面', 'del'=>'删除网站页面',
//				'pagelist'=>'网站首页轮播图管理', 'page'=>'添加网站首页轮播图管理', 'pageedit'=>'编辑网站首页轮播图管理', 'pagedel'=>'删除网站首页轮播图管理',
//		        'uploadrange'=>'上传排行榜', 'delrange'=>'删除排行榜', 'downrange'=>'下载排行榜',
//		        'bidpush'=>'招标信息定时推送管理', 'push'=>'招标信息自定义推送', 'ecruit'=>'招聘行业分类管理',
//		        'yestodayprice'=>'昨日成交金额', 'yestodaypriceexport'=>'昨日成交金额导出'
//			),
//		),
//
		//相关阅读管理
//		'aboutread'=>array(
//			'arlias'=>'相关阅读管理',
//			'items'=>array(
//				'index'=>'相关阅读列表', 'add'=>'添加相关阅读', 'edit'=>'编辑相关阅读', 'del'=>'删除相关阅读',
//			),
//		),
		
		//竞标中心管理
//		'bid'=>array(
//			'arlias'=>'竞标中心管理',
//			'items'=>array(
//				'index'=>'竞标中心列表', 'add'=>'添加竞标中心', 'edit'=>'编辑竞标中心', 'del'=>'删除竞标中心',
//			),
//		),
		
		//投诉管理
//		'complain'=>array(
//			'arlias'=>'投诉管理',
//			'items'=>array(
//				'index'=>'投诉列表', 'add'=>'添加投诉', 'edit'=>'编辑投诉', 'del'=>'删除投诉',
//			),
//		),
/* 		//互助计划管理
        'customers'=>array(
            'arlias'=>'互助计划管理',
            'items'=>array(
				'index'=>'计划列表', 'del'=>'删除计划',
            ),
        ),*/

		//捐助管理
/*		'donorman'=>array(
			'arlias'=>'捐助管理',
			'items'=>array(
				'del'=>'删除捐助',
			),
		),*/

		/*//求助管理
		'appealman'=>array(
			'arlias'=>'求助管理',
			'items'=>array(
				'index'=>'求助列表', 'del'=>'删除求助',
			),
		),*/

        //反馈管理
        'feedback'=>array(
            'arlias'=>'反馈管理',
            'items'=>array(
				'index'=>'反馈列表', 'del'=>'删除反馈',
            ),
        ),
        
/*        'feiyong'=>array(
            'arlias'=>'费用评估',
            'items'=>array(
        		'index'=>'费用评估列表','del'=>'删除费用评估',
            ),
        ),*/
        
        //余料分享管理
//		'expectshare'=>array(
//			'arlias'=>'余料分享管理',
//			'items'=>array(
//				'index'=>'余料分享列表', 'del'=>'删除余料分享',
//			),
//		),
//
		//操作日志管理
		'operlog'=>array(
			'arlias'=>'操作日志管理',
			'items'=>array(
				'index'=>'操作日志列表', 'del'=>'删除操作日志',
			),
		),
	);
	
	public function __construct($id, $module=null){
		// 禁止 admin 访问后台
		if(stristr($_SERVER['PHP_SELF'], 'admin')){
			$this->redirect(array('admin/'));
		}

//		$textslog = ExamLog::model()->findAll('csc_create>:ctime',array('ctime'=>Yii::app()->session['sysuser_time']));
//		if(!empty($textslog)){
//			$this->tests = true;
//		}
//
//		$textsorder = ExamOrder::model()->findAll('csc_create>:ctime',array('ctime'=>Yii::app()->session['sysuser_time']));
//		if(!empty($textsorder)){
//			$this->news = true;
//		}


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
	
	public function runAction($action){

		if(!$this->checkOperModule($this->id, $action->id)){
				
			if(Yii::app()->request->isAjaxRequest){
				$this->jsonMsg(400, '权限不足，联系管理员');
			}
			$this->redirect($this->createUrl('admin/index/no'), true);exit;
		}

		parent::runAction($action);
	}

	// 检测单元操作权限
	public function checkOperModule($c, $a='index'){
		if(!$c || !$a) return false;

		$ingnore_controller = array('index', 'user', 'gd');
		$ingnore_action = array('select', 'order');

		if(in_array($c, $ingnore_controller) || in_array($a, $ingnore_action)) return true;

		$master = Yii::app()->params['default_master'];
		if(Yii::app()->session['sysuser_user'] == $master['user']) return true;

		static $G_POWER;

		if(!$G_POWER){
			$G_POWER = Sysrole::model()->findByPk(Yii::app()->session['sysuser_role_id']);
		}
		return $G_POWER && stristr($G_POWER->csc_power_id, $c.'-'.$a) ? true :false;
	}

	// 添加操作日志记录
	protected function addOperLog($log, $dubug=false){
		if(!$log) return;

		$data = new OperLog();
		$data->csc_id = getPrimaryKey();
		$data->csc_user_id = Yii::app()->session['sysuser_id'];
		$data->csc_username = trim(Yii::app()->session['sysuser_tname']);
		$data->csc_username = $data->csc_username ? $data->csc_username : Yii::app()->session['sysuser_user'];
		$data->csc_log = $log;
		$data->csc_guest_ip = Yii::app()->request->userHostAddress;

		if(!$data->save() && $dubug){
			dump($data->getErrors());
		}

	}

}