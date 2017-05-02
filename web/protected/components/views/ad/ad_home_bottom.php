<?php foreach ($data as $k=>$item):?>
	<?php if($k = 0){?>
	<li class="f_l">
		<a href="<?php echo $item->csc_url?>" target="_blank">
			<img width="<?php echo $w?>" height="<?php echo $h?>" src="<?php echo $item->csc_img?$item->csc_img:$item->csc_img_url?>"/>
		</a>
		<a href="#"><?php echo $item->csc_name?></a>
	</li>
	<?php }else{?>
	<li class="f_r" style="margin-right:15px;">
		<a href="<?php echo $item->csc_url?>" target="_blank">
			<img width="<?php echo $w?>" height="<?php echo $h?>" src="<?php echo $item->csc_img?$item->csc_img:$item->csc_img_url?>"/>
		</a>
		<a href="#"><?php echo $item->csc_name?></a>
	</li>
	<?php }?>
<?php endforeach;?>