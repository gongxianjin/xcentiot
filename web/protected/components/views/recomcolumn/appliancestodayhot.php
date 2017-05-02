<p class="bao" style="height: auto;">今日爆款</p>
<ul class="zxin">
<?php foreach($data as $v):?>
	<li>
		<a href="<?php echo Yii::app()->createUrl('goods/view', array('goods_id'=>$v->csc_id))?>" target="_blank" title="<?php echo $v->csc_name?>"><img src="<?php echo $v->csc_img?>" width="135" height="135" /></a>
		<p class="zhon"><a href="<?php echo Yii::app()->createUrl('goods/view', array('goods_id'=>$v->csc_id))?>" title="<?php echo $v->csc_name?>"><?php echo BaseApi::getSummary($v->csc_name, 12)?></a></p>
		<p class="zhon"><a href="<?php echo Yii::app()->createUrl('goods/view', array('goods_id'=>$v->csc_id))?>">爆款价：<b class="jge">￥<?php echo $v->csc_price?></b></a></p>
	</li>
<?php endforeach;?> 
</ul>