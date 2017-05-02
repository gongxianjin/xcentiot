<?php foreach ($data as $key=>$item):?>
	<?php if($item->csc_type==3):?>
	<a href="<?php echo $item->csc_url?>"><?php echo $item->csc_name?></a><?php if($key != count($data)-1):?>|<?php endif;?>
	<?php endif;?>
<?php endforeach;?>