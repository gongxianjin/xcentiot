<?php
// 自动生成面包屑导航条
Yii::import('zii.widgets.CPortlet');
class Crumbs extends CPortlet
{
    public $title = null;
    public $name; // 商品名称
    public $cate_id; // 分类ID
    public $cate_path; // 分类路径
    public $theme; // 风格
    public $crumbs_url;
    
    
    protected function renderContent()
    {
    	if(!$this->cate_path && !$this->cate_id && $this->crumbs_url) return ;
    	
    	if(!$this->cate_path && $this->cate_id){
    		// 查询分类信息
    		$cate = Category::model()->find('csc_id=:cid', array(':cid'=>$this->cate_id));
    		if(!$cate) return;
    		
    		$this->cate_path = $cate->csc_cate_path;
    	}
    	
    	$this->cate_path = explode(',', $this->cate_path);
    	foreach ($this->cate_path as $k=>$v){
    		$v = trim($v);
    		if(!$v){
    			unset($this->cate_path[$k]);
    		}else{
    			$this->cate_path[$k] = $v;
    		}
    	}
    	
    	$cond = new CDbCriteria();
    	$cond->select = 'csc_id,csc_name,csc_pinyin,csc_link';
    	$cond->addInCondition('csc_id', $this->cate_path);
    	$cond->addCondition('csc_show=1');
    	$cond->order = 'FIELD(`csc_id`, \''.implode('\',\'', $this->cate_path).'\')';
    	
    	$crumb = Category::model()->findAll($cond);
        $this->render($this->theme?$this->theme:strtolower(__CLASS__), array(
        	'crumb'=>$crumb,
        	'goods_id'=>Yii::app()->request->getParam('goods_id'),
            'controller_id'=> Yii::app()->controller->id=="goods"?'sumar':Yii::app()->controller->id,
        ));
    }
}