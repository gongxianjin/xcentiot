<?php if(isset($data)&&!empty($data)):?>
<?php foreach ($data as $item):?>
        <div class="z-sbanner">
            <a href="<?php echo $item->csc_url?>" target="_blank"><div style="background: url(<?php echo $item->csc_img?$item->csc_img:$item->csc_img_url?>)no-repeat 0 0; background-size: auto 520px"></div></a>
        </div>
<?php endforeach;?>
<?php endif;?>

