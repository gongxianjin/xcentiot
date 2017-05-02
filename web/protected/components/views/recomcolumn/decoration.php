
	<ul class="jrtj_b">
	<?php foreach ($data as $item):?>
		<li>
			<a href="<?php echo Yii::app()->createUrl('decoration/view', array('goods_id'=>$val->csc_id))?>"><img src="<?php echo $item->csc_img_thumb?>" width="115" height="115" /></a>
			<p class="kaluo"><a href="<?php echo Yii::app()->createUrl('decoration/view', array('goods_id'=>$item->csc_id))?>"><?php echo $item->csc_name?></a></p>
			<p class="lqw">￥<?php echo $item->csc_price?></p>
			
		</li>
	<?php endforeach;?>
	</ul>