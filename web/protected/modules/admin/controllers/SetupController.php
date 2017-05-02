<?php
/**
 * 系统设置控制器
 * Enter descriptionription here ...
 * @author Administrator
 *
 */
class SetupController extends Controller
{
	public function actionIndex(){
        $site = Yii::app()->params['site'];
		if(Yii::app()->request->isPostRequest){
            $site['title'] = Yii::app()->request->getParam('title');
            $site['keyword'] = Yii::app()->request->getParam('keyword');
            $site['description'] = Yii::app()->request->getParam('description');
			$site['copy'] = Yii::app()->request->getParam('copy');
            $site['address'] = Yii::app()->request->getParam('address');
            $site['school'] = Yii::app()->request->getParam('school');
            $site['record'] = Yii::app()->request->getParam('record');
//            $site['tax'] = Yii::app()->request->getParam('tax');
//            $site['tel'] = Yii::app()->request->getParam('tel');
//            $site['qq'] = Yii::app()->request->getParam('qq');
			$site['phone'] = Yii::app()->request->getParam('phone');
			$site['client_phone'] = Yii::app()->request->getParam('client_phone');
            $site['client_mail'] = Yii::app()->request->getParam('client_mail');

			$site['vision'] = Yii::app()->request->getParam('vision');
			$site['mission'] = Yii::app()->request->getParam('mission');
			$site['motto'] = Yii::app()->request->getParam('motto');
			$site['values'] = Yii::app()->request->getParam('values');
			$site['slogan'] = Yii::app()->request->getParam('slogan');
			$site['email'] = Yii::app()->request->getParam('email');
			$site['wechat'] = Yii::app()->request->getParam('wechat');

			$site['crate'] = Yii::app()->request->getParam('crate');

			$site['gd_type']=explode('|',Yii::app()->request->getParam('gd_type'));

			$site['act_address']=explode('|',Yii::app()->request->getParam('act_address'));

			if(!SetupApi::setInfo('site_setup' , array('site'=>$site))){
                $this->jsonMsg(501, '失败成功！','',Yii::app()->createUrl('admin/setup/index'));
            }
			$this->jsonMsg(200, '设置成功！','',Yii::app()->createUrl('admin/setup/index'));
		}
		$this->render('index',array(
			'site' => $site,
		));
	}
	/**
	 * @description_METHOD 清除缓存
	 */
	function actionClear(){
		// 缓存根目录
		$root_dir = Yii::app()->basepath.DIRECTORY_SEPARATOR.'runtime';
		$b_cmd = 'mkdir '.$root_dir;
		if('linux' != strtolower(PHP_OS)){
			$cmd = 'rd /s /q "'.$root_dir.'"';
		}else{
			$cmd = 'rm -rf "'.$root_dir.'"';
		}
		system($cmd);
		system($b_cmd);
		$this->redirect('/admin');exit;
	}
}