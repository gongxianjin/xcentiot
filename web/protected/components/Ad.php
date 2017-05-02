<?php
Yii::import('zii.widgets.CPortlet');
class Ad extends CPortlet
{
    public $pos; // 广告位编号
    public $class; // 广告元呈现样式 ex: class="xx" or style="xx"
    public $w; // 广告呈现宽度
    public $h; // 广告呈现高度
    public $theme = 'ad'; // 布局模板名称
    public $site_id; //城市站点
    public $offset; // 列表偏移量
    public $num=1; // 获取总数   offset num 必须组合使用
    
 	
    protected function renderContent(){
    	$this->pos = (String)$this->pos;
    	if(!$this->pos) return;


    	if(!is_null($this->offset) && $this->num){


    		static $pos;
    		static $data;
    		if($data && isset($data[$this->pos])){
    			
    			$this->w = $data[$this->pos][0]->pos->csc_width;
    			$this->h = $data[$this->pos][0]->pos->csc_height;
    			if($this->offset>=0 && $this->num>0){
    				$_data = array();
    				foreach ($data[$this->pos] as $key=>$item){
    					if($key>=$this->offset && count($_data)<$this->num){
    						$_data[] = $item;
    					}
    				}
    			}
    		
    			$this->theme = 'ad/'.$this->theme;
		        $this->render($this->theme, array(
		        	'data'=>$_data, 'class'=>$this->class, 'w'=>$this->w, 'h'=>$this->h,
		        ));
		        return;
    		}
    	}
    	
    	if(!$this->w && !$this->h){
    		
    		// 查询广告位POS
    		$pos[$this->pos] = Adposition::model()->find('csc_id=\''.$this->pos.'\'');
    		if(!$pos[$this->pos]) return ;
    		
    		$this->w = $pos[$this->pos]->csc_width;
    		$this->h = $pos[$this->pos]->csc_height;
    		
    	}
    	
    	$time = date('Y-m-d');
    	
    		
    	$cond = new CDbCriteria();
    	$cond->addCondition('csc_pos_id=:pos_id and csc_begin_time<=:stime and (csc_end_time is null or csc_end_time>=:etime)');
    	$cond->addCondition('csc_show=1');
    	$cond->params = array(
    		':pos_id'=>$this->pos, ':stime'=>$time, 'etime'=>$time
    	);
    	
    	
    	$cookie= Yii::app()->request->getCookies();
		$this->site_id = $cookie['site_id']->value;
    	if($this->site_id){
    		$cond->addCondition('csc_site_id=:site OR csc_site_id=0');
    		$cond->params[':site'] =  $this->site_id;
    	}
    	$cond->order = 'csc_sort asc';
    	
    	$data[$this->pos] = AdMeta::model()->findAll($cond);
    
    	if(!is_null($this->offset) && $this->num>0){
    		$_data = array();
    		foreach ($data[$this->pos] as $key=>$item){
    			if($key>=$this->offset && count($_data)<$this->num){
    				$_data[] = $item;
    			}
    		}
    	}else{
    		$_data = $data[$this->pos];
    	}
		foreach($_data as $key=>$item){
			if($item->csc_url=='/'){
				$_data[$key]->csc_url = 'javascript:;';
			}
		}
    	$this->theme = 'ad/'.$this->theme;
        $this->render($this->theme, array(
        	'data'=>$_data, 'class'=>$this->class, 'w'=>$this->w, 'h'=>$this->h,
        ));
        
    }
}