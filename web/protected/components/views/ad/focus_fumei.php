<ul class="fumei">
    <?php foreach($data as $i=>$v):?>
        <li style="background: url(<?php echo $v->csc_img?>);width: 117px;height: 116px;float: left;margin:0 25px;"><a style="cursor: default" pos="<?php echo $v->csc_url?>"><p style="position: absolute;left: <?php echo $i*167+50?>px"><?php echo $v->csc_name;?></p></a></li>
    <?php endforeach;?>
</ul>