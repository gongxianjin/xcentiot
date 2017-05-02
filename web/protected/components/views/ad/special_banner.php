
<!--banner--><div class="top_banner">
    <?php foreach($data as $v):?> 
        <a target="_blank" href="<?php echo $v->csc_url;?>"><img src="<?php echo $v->csc_img?>"  style="width: 100%;height: 100%;" /></a>
    </div> 
    <?php endforeach;?>
</div><!--//banner//-->