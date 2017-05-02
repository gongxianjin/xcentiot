<?php if(isset($data)&&!empty($data)):?>
<?php foreach ($data as $item):?>
        <li>
            <div class="z_fLinkImg1">
                <div class="z_fLinkImg2">
                    <a href="<?php echo $item->csc_url?>" target="_blank">
                        <img src="<?php echo $item->csc_img?$item->csc_img:$item->csc_img_url?>"/>
                    </a>
                </div>
            </div>
        </li>
<?php endforeach;?>
<?php endif;?>

