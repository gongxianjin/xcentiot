<p class="z_bottom1">
<?php if(isset($data)&&!empty($data)):?>
    <?php foreach($data as $key=>$v):?>
        <a href="<?php echo $v->csc_url?>"><?php echo $v->csc_text?></a><?php if($key!=(count($data)-1)):?><span>·</span><?php endif;?>
    <?php endforeach;?>
<?php endif;?>
</p>