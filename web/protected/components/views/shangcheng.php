<div class="visa shangcheng clear">
    <p class="visa_name"><a style="color: #3e3e3e" href="<?php echo Yii::app()->createUrl('shop/index');?>">美宝商城</a><span class="visa_name_en">Shop</span></p>
    <div class="shangchegn_content width_1200 margin_auto">
        <div class="shangcheng_left f_l">
            <h2>海外正品团购</h2>
            <p>扫描进入微店抢购</p>
            <?php $this->Widget('Ad' , array('pos'=>'two_dimension_code' , 'theme'=>'ad_logo'))?>
<!--            <img src="/assets/home/images/weixin.jpg" width="165" height="165" />-->
        </div>

        <div id="fsD6" class="focus_shangcheng">
            <?php $this->Widget('Ad',array('pos'=>'shop_banner','theme'=>'shop_banner'));?>


        </div>
        <script type="text/javascript">
            Qfast(false, 'widgets', function () {
                K.tabs({
                    id: 'fsD6',   //焦点图包裹id
                    conId: "D1pic6",  //** 大图域包裹id
                    tabId:"D1fBt6",
                    tabTn:"a",
                    conCn: '.fcon', //** 大图域配置class
                    auto: 1,   //自动播放 1或0
                    effect: 'fade',   //效果配置
                    eType: 'click', //** 鼠标事件
                    pageBt:true,//是否有按钮切换页码
                    bns: ['.prev', '.next'],//** 前后按钮配置class
                    interval: 3000  //** 停顿时间
                })
            })
        </script>
        <table class="group clear" cellpadding="0" cellspacing="0">
            <tr>
                <?php foreach($goods as $v):?>
                <td><a href="<?php echo Yii::app()->createUrl('shop/view',array('id'=>$v->csc_id));?>"><img src="<?php echo $v->csc_img?>" width="159" height="130" /></a>
                    <p class="group_name f_l"><a href="<?php echo Yii::app()->createUrl('shop/view',array('id'=>$v->csc_id));?>"><?php echo $v->csc_name?></a></p>
                    <p class="group_price f_l">￥<?php echo $v->csc_price?></p>
                </td>
                <?php endforeach;?>

            </tr>
        </table>
    </div>

</div>