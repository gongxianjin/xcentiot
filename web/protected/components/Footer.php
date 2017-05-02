<?php
Yii::import('zii.widgets.CPortlet');
class Footer extends CPortlet
{
	public $title = null;

	protected function renderContent()
	{
		// 分公司
		$branch_company = Adposition::model()->findByPk('branch_company');
		$branch_imgs = AdMeta::model()->findAll('csc_pos_id = :csc_pos_id' , array(':csc_pos_id'=>$branch_company->csc_id));
		$branchs = array(
			'width' => $branch_company->csc_width, // 分公司图片宽
			'height' => $branch_company->csc_height, // 分公司图片高
			'branch_imgs' => $branch_imgs, // 分公司图片
		);
		
		// 友情链接
		$friendly_links = Adposition::model()->findByPk('friendly_links');
		$links = AdMeta::model()->findAll('csc_pos_id = :csc_pos_id' , array(':csc_pos_id'=>$friendly_links->csc_id));
		// 客服QQ
		$client = Yii::app()->params['site']['client_qq'];
		$client = explode(',', $client);
		foreach($client as $k=>$v){
			$qq[$k] = "tencent://message/?uin=".$v."&Site=/&Menu=yes";
		}
		$this->render('footer' , array( 
			'links' => $links,
			'branchs' => $branchs,
			'qq' => $qq,
		));
	}
	

}