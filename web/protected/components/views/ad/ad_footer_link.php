<dl>
	<?php if(isset($data)&&!empty($data)):?>
		<?php foreach($data as $key=>$v):?>
			<a href="<?php echo $v->csc_url?>"><?php echo $v->csc_text?></a> <?php if($key != (count($data)-1)):?>/<?php endif;?>
		<?php endforeach;?>
	<?php endif;?>
</dl>
