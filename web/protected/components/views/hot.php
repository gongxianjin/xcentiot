    <!--本店排行-->
    <div class="l_shop_among">
        <h3>热卖商品</h3>
        <?php foreach($hot_goods as $k=>$v):?>
            <ul>
                <li>
                    <b><?php echo $k+1 ?></b>
                    <a target="_blank" href="<?php echo Yii::app()->createUrl($controller_id.'/view', array('goods_id'=>$v->csc_id))?>"><img src="<?php echo $v->csc_img?>" /></a>
                    <h4><?php echo $v->csc_name?></h4>
                    <p>￥<?php echo $v->csc_market_price?></p>
                    <p>已售出:<span><?php if($v->ext->csc_sale_num){echo $v->ext->csc_sale_num;}else{echo "0";} ?>件</span></p>
                </li>
            </ul>
        <?php endforeach;?>
    </div>