<?php foreach ($data as $item):?>
	<a class="<?php echo $class?>" href="<?php echo $item->csc_url?>" target="_blank">
		 <?php echo $item->csc_text?>
	</a>
<?php endforeach;?>