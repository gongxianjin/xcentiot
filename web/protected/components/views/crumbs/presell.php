<ul class="spxqy_t">
<?php foreach ($crumb as $key=>$item):?>
	<?php if($key==0):?>
	<li class="sxqjiaj"><a target="_blank" href="<?php echo Yii::app()->createUrl('presell/index', array('cid'=>$item->csc_id))?>"><?php echo $item->csc_name?></a></li>
	<?php else:?>
    <li>&gt; <a target="_blank" href="<?php echo Yii::app()->createUrl('presell/index', array('cid'=>$item->csc_id))?>"><?php echo $item->csc_name?></a></li>
    <?php endif;?>
<?php endforeach;?>
	<?php if($this->name):?>
	<li>&gt; <a href="<?php echo Yii::app()->createUrl('presell/index', array('cid'=>$goods_id))?>"><?php echo $this->name?></a></li>
	<?php endif;?>
</ul>