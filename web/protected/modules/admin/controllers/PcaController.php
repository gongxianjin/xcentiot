<?php
/**
 * 城市管理（切换城市）
 * Enter description here ...
 * @author Administrator
 *
 */
class PcaController extends Controller{
	
	/**
	 * 开通的城市列表
	 * Enter description here ...
	 */
	public function actionIndex(){
		$province = PCA::model()->findAll('csc_type=:type',array(':type'=>'province'));
		
		$this->render('index',array(
			'province' => $province,
		));
	}
	
	/**
	 * 下级分类
	 * Enter description here ...
	 */
	public function actionSelect(){
		$ids = Yii::app()->request->getParam('ids');
		$pca = PCA::model()->findByPk($ids);
		if(!$pca) $this->jsonMsg(11,'参数有误');
		$pca_son = $pca->son;
		$data = array();
		foreach ($pca_son as $item){
			$data[] = $item->attributes;
		}
		
		
		$this->jsonMsg(200,'ok',$data);
	}
	
	/**
	 * 开通关闭站点
	 * Enter description here ...
	 */
	public function actionSite(){
		$ids = Yii::app()->request->getParam('ids');
		$pca = PCA::model()->findByPk($ids);
		if(!$pca){
			echo '<script>alert("参数有误")</script>';exit;
		} 
		
		if($pca->csc_site){
			$p_site = 0;
		}else{
			$p_site = 1;
		}
		$pca->csc_site = $p_site;
		
		if(!$pca->save()){
			echo '<script>alert("修改失败")</script>';exit;
		} 
		$this->redirect(array('pca/index'));  
	}
}
