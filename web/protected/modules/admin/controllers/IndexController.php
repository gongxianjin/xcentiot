<?php
/**
 * 后台首页控制器
 */
class IndexController extends Controller{
    public $layout = '/layouts/admin';
	//登录
    public function actionIndex(){

    	$connection = Yii::app()->db;
    	$sql = 'select VERSION() as mv';
    	$command = $connection->createCommand($sql);
    	$result = $command->queryAll();
    	
    	$sysuser = Sysuser::model()->find('csc_id=:id', array(':id'=>Yii::app()->session['sysuser_id']));
    	
    	$oper_log = OperLog::model()->findAll('1 order by csc_create DESC limit 6');
    	
        return $this->render('index', array(
        	'mysql_version'=>$result[0]['mv'],
        	'oper_log' => $oper_log,
        	'sysuser' => $sysuser,
        ));
    }
   
}
