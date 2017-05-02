<ul class="shangjia_list" style="margin-top: 40px;">
    <?php if(isset($data)&&!empty($data)):?>
    <?php foreach($data as $k=>$v){?>
        <li style="width: 212px;height: 121px;margin-left: 10px;"><img src="<?php echo $v->csc_img?>" width="212" height="121" /></li>
    <?php }?>
    <?php endif;?>
</ul>
