<?php
/**
 * 搜索词控制器
 * */
class HotkeywordController extends Controller{
	//搜索词列表
    public function actionIndex(){
    	$setupapi = new SetupApi();
    	$hot_keyword = $setupapi->getInfo($this->get_hot_keyword());
		
    	$hot_keyword = $hot_keyword ? $hot_keyword : array();
    	
		$i = 0;
		$data = array();
		
		foreach($hot_keyword as $k=>$v){
			foreach($v as $kk=>$vv){
				$data[$i]['name'] = $vv;
				$data[$i]['key'] = $kk;
				
				if($k == 'sumar'){
					$data[$i]['type'] = '超市';
					$data[$i]['type_key'] = 'sumar';
				}elseif($k == 'group'){
					$data[$i]['type'] = '团购';
					$data[$i]['type_key'] = 'group';
				}elseif($k == 'greens'){
					$data[$i]['type'] = '菜市';
					$data[$i]['type_key'] = 'greens';
				}elseif($k == 'appliances'){
					$data[$i]['type'] = '家电';
					$data[$i]['type_key'] = 'appliances';
				}elseif($k == 'clothing'){
					$data[$i]['type'] = '服装';
					$data[$i]['type_key'] = 'clothing';
				}elseif($k == 'decoration'){
					$data[$i]['type'] = '家装';
					$data[$i]['type_key'] = 'decoration';
				}
				$i++;
			}
		}
		
    	return $this->render('index', array(
    		'data' => $data,
    	));
    }
	
    //添加搜索词
    public function actionAdd(){
    	if(Yii::app()->request->isPostRequest){
			$name=Yii::app()->request->getParam('name');
			$type=Yii::app()->request->getParam('type');
			
			$setupapi = new SetupApi();
    		$hot_keyword = $setupapi->getInfo($this->get_hot_keyword());
			
			if(isset($hot_keyword[$type])){
				if(!in_array($name, $hot_keyword[$type])){
					$hot_keyword[$type][] = $name;
					$setupapi->setInfo($this->get_hot_keyword(), $hot_keyword);
				}
			}else{
				$hot_keyword[$type][] = $name;
				$setupapi->setInfo($this->get_hot_keyword(), $hot_keyword);
			}
			
			
			$this->jsonMsg(200, '添加成功', '', $this->createUrl('hotkeyword/'));
    	}	
    	return $this->render('add');
    }
    
    //删除搜索词
    public function actionDel(){
		$type = array('sumar', 'group', 'greens', 'appliances', 'clothing', 'decoration');
		
		$key=Yii::app()->request->getParam('key');
		$type_key=Yii::app()->request->getParam('type_key');
		if(!in_array($type_key, $type) ){
    		$this->jsonMsg(501, '参数有误');
    	}
		
    	$setupapi = new SetupApi();
    	$hot_keyword = $setupapi->getInfo($this->get_hot_keyword());
		unset($hot_keyword[$type_key][$key]);
		
		$setupapi->setInfo($this->get_hot_keyword(), $hot_keyword);
			
    	$this->jsonMsg(200, '删除成功');
    }
    public function get_hot_keyword(){
    	return hot_keyword;
    }
}
