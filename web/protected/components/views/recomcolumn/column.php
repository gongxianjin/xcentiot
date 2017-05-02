<div class="jrth">
    <div class="jrth_t">
    	<p class="jrthui">今日特惠</p>
    	<!-- <li><a href="#" style="text-decoration: underline">全部</a></li> -->
        <ul class="suoy"><?php foreach ($data as $item):?>
            <li><a href="javascript:;"><?php echo $item['cate']->csc_name?></a></li>
            <?php endforeach;?>
        </ul>
    </div>
    <div class="jrth_box">
    	<?php foreach($data as $item):?>
	    <ul class="jrth_b">
	    	<?php foreach ($item['goods'] as $g):?>
	    	<li>
	        	<a href="<?php echo Yii::app()->createUrl('goods/view', array('goods_id'=>$g->csc_id))?>" target="_blank"><img src="<?php echo $g->csc_img_thumb?>" width="200" height="175" /></a>
	            <div class="neizhi">
	            	<p><a href="<?php echo Yii::app()->createUrl('goods/view', array('goods_id'=>$g->csc_id))?>" target="_blank"><?php echo $g->csc_name?></a></p>
	                <p class="elbb"><a href="<?php echo Yii::app()->createUrl('goods/view', array('goods_id'=>$g->csc_id))?>">￥<?php echo $g->csc_price?></a><span style="text-decoration:line-through">￥<?php echo $g->csc_market_price?></span></p>
	                <p class="houhu">
	                	<span class="shier"><?php echo $g->ext->csc_sale_num?>人已购买</span>
	                	<a href="<?php echo Yii::app()->createUrl('goods/view', array('goods_id'=>$g->csc_id))?>" target="_blank"><input class="gmai" value="立即购买" type="button"/></a>
	                </p>
	            </div>
	        </li>
	        <?php endforeach;?>
	    </ul>
		<?php endforeach;?>
		
    </div>
</div>
<?php $this->loadCssOrJs(dirname(dirname(__FILE__)).'/js/column.js', 'script')?>