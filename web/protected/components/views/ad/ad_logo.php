<?php foreach ($data as $item):?>
	<a href="<?php echo $item->csc_url?>"><img width="<?php echo $w?>" height="<?php echo $h?>" src="<?php echo $item->csc_img?$item->csc_img:$item->csc_img_url?>"/></a>
<?php endforeach;?>