<!--problem-->
<style>
    #t5 a:hover{color: orange;}
</style>
        <div class="visa problem clear" id="t5">
        	<a href="<?php echo Yii::app()->createAbsoluteUrl('core/')?>"><p class="visa_name">核心问题<span class="visa_name_en">Ｑuestion</span></p></a>
            <div class="problem_content width_1200 margin_auto">
            <?php foreach($core as $k=>$v){?>
            	<dl>
                	<dt class="problem_tab_0<?php echo $k+1?>"><h2><a style="color: #ffffff" href="<?php echo Yii::app()->createUrl('index/list',array('cid'=>$v->csc_id))?>"> <?php echo $v->csc_name?></a></h2></dt>
                    <dd>
                    	<ul class="news_cont_list clear">
                    	<?php foreach($models[$k] as $key=>$value){?>
                    	<li><a href="<?php echo Yii::app()->createUrl('core/view' , array('id'=>$value->csc_id))?>"><span class="f_l"><?php echo Helper::truncate_utf8_string($value->csc_name,18)?></span> <span class="f_r"><?php echo date('Y-m' , strtotime($value->csc_create))?></span></a></li>
                        <?php }?>
                  		</ul> 
                    </dd>
                </dl>
            <?php }?>
            </div>
        </div>
<!--end problem-->