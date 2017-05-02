<div class="fullSlide fullSlides2">
	<div class="bd">
		<ul>
			<?php if(isset($data)&&!empty($data)):?>
				<?php foreach ($data as $item):?>
					<li><a style="background: url(<?php echo $item->csc_img?>) no-repeat center 0;background-size:auto 550px;" href="<?php echo $item->csc_url?>"></a></li>
				<?php endforeach;?>
			<?php endif;?>
		</ul>
	</div>
	<div class="hd"><ul></ul></div>
</div>