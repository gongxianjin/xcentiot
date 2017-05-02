<div id="D1pic5" class="fPic">
	<?php foreach ($data as $item):?>
    <div class="fcon" style="display: none;">
        <a target="_blank" href="<?php echo $item->csc_url?>"><img src="<?php echo $item->csc_img?$item->csc_img:$item->csc_img_url?>" style="opacity: 1; "></a>
        <span class="shadow"><a target="_blank" href="<?php echo $item->csc_url?>"><?php echo $item->csc_name?></a></span>
    </div>
    <?php endforeach;?>
</div>
<div class="fbg">
    <div class="D1fBt" id="D1fBt5">
    	<?php foreach ($data as $k=>$item):?>
        <a href="javascript:void(0)" hidefocus="true" target="_self" class=""><i><?php echo $k+1?></i></a>
        <?php endforeach;?>
    </div>
</div>