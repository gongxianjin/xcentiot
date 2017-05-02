<ul id="slides" class="rongyu_content" style="width: 202px;height: 248px;">
    <?php if(isset($data)&&!empty($data)):?>
        <?php foreach ($data as $item):?>
            <li style="background:url('<?php echo $item->csc_img?>');width: 202px;height: 248px;"><a href="#" target="_blank"><?php echo $item->csc_name;?></a></li>
        <?php endforeach;?>
    <?php endif;?>

</ul>