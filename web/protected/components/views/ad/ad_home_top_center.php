<ul>
<?php foreach ($data as $item):?>
	<li>
	<?php if(!$item->csc_type):?>
		<a href="<?php echo $item->csc_url?>" target="_blank">
			<img width="<?php echo $w?>" height="<?php echo $h?>" src="<?php echo $item->csc_img?$item->csc_img:$item->csc_img_url?>"/>
		</a>
	<?php elseif($item->csc_type == 1):?>
		<a href="<?php echo $item->csc_url?>" target="_blank">
			<embed width="<?php echo $w?>" height="<?php echo $h?>" border="0" align="middle" wmode="opaque" src="<?php echo $item->csc_flash?$item->csc_flash:$item->csc_flash_url?>"/>
		</a>
	<?php elseif($item->csc_type==2):?>
		<a href="<?php echo $item->csc_url?>" target="_blank" <?php echo $class?>>
			<?php echo $item->csc_code?>
		</a>
	<?php elseif($item->csc_type==3):?>
		<a href="<?php echo $item->csc_url?>" target="_blank">
			<span <?php echo $class?>><?php echo $item->csc_text?></span>
		</a>
	<?php endif;?>
	</li>
<?php endforeach;?>
</ul>