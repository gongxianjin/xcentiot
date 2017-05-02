<?php foreach ($data as $item):?>
    <a href="<?php echo $item->csc_url?>" class="ha_me_a" app_target="_blank">
        <i class="ha_me_i i4"></i><?php echo $item->csc_name?><span class="lh_right">&gt;</span>
    </a>
<?php endforeach;?>
