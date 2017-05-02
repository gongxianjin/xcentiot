<ul>
<?php if(isset($data)&&!empty($data)):?>
<?php foreach ($data as $item):?>
            <li><a href="<?php echo $item->csc_url?>"><img src="<?php echo $item->csc_img?$item->csc_img:$item->csc_img_url?>" alt=""></a></li>
<?php endforeach;?>
<?php endif;?>
 </ul>