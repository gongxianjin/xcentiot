<div class="z-subBanner">
	<?php if(isset($data)&&!empty($data)):?>
		<?php foreach ($data as $item):?>
		 <a href="<?php echo $item->csc_url?>"><div style="background: url(<?php echo $item->csc_img?>)no-repeat center;background-size: auto 245px"></div></a>
		<?php endforeach;?>
	<?php endif;?>
</div>
 