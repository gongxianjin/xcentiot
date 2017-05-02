<?php foreach ($data as $item):?>
	<li>
        <a href="<?php echo $item->csc_url?>"><img src="<?php echo $item->csc_img?$item->csc_img:$item->csc_img_url?>" width="<?php echo $w?>" height="<?php echo $h?>" /></a>
        <p><a href="<?php echo $item->csc_url?>"><?php echo $item->csc_contactor?></a></p>
    </li>
<?php endforeach;?>