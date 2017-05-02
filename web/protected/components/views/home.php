<style>
    #t7 a:hover{
        color: orange;
    }
</style>
<div class="visa home clear" id="t7">
<p class="visa_name"><a href="<?php echo Yii::app()->createUrl('home/index')?>" style="color: #3e3e3e;"> 旅美之家<span class="visa_name_en">Home</span></a></p>
<div class="home_content width_1200 margin_auto">
<!--left-->

<div class="home_left">
    <div id="fsD5" class="focus_home">
        <?php $this->Widget('Ad' , array('pos'=>'ad_home_top' , 'theme'=>'ad_home_top'))?>
    </div>
    <script type="text/javascript">
        Qfast(false, 'widgets', function () {
            K.tabs({
                id: 'fsD5',   //焦点图包裹id
                conId: "D1pic5",  //** 大图域包裹id
                tabId:"D1fBt5",
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
    <div class="focus_home_name clear"><a href="#"></a></div>
    <ul class="home_list clear">
        <?php $this->Widget('Ad' , array('pos'=>'ad_home_bottom' , 'theme'=>'ad_home_bottom'))?> 
    </ul>
</div>
<!--end left-->
<!--center-->
<div class="home_center f_l">
    <div id="tab5">
        <div class="tabList f_l">
            <ul>
                <p class="tab_blank f_l"></p>
                <?php foreach($category as $k=>$v):?>
                <li <?php if($k=='0'):?> class="cur"<?php endif;?> ><?php echo $v->csc_name;?></li>
                <?php endforeach;?>
            </ul>
        </div>
        <div class="tabCon f_l">
            <!--frist-->
            <?php foreach($article as $key=>$item):?>
            <div <?php if($key=='0'):?>class=" cur"<?php endif;?>>
                <ul class="home_list clear">
                    <?php foreach($item as $val):?>
                    <li ><a href="<?php echo Yii::app()->createUrl('home/view',array('id'=>$val->csc_id,'cate'=>5))?>"><img src="<?php echo $val->csc_img?>" width="182" height="104"/></a><h3><a href="<?php echo Yii::app()->createUrl('home/view',array('id'=>$val->csc_id,'cate'=>5))?>"><?php echo $val->csc_name;?></a></h3></li>
                    <?php endforeach;?>
                </ul>
            </div>
            <?php endforeach;?>
            <!--end frist-->


        </div>
    </div>

</div>
    <script>
        $(function () {
          $(".tabList li").click(function () {
              //alert($(this).index());
//              alert($(".home_right").eq($(this).index()).css('display'));
              $(".home_right").eq($(this).index()-1).css('display','inline');
              $(".home_right").eq($(this).index()-1).siblings('.home_right').css('display','none');
          });
        })
    </script>
<!--end center-->
<!--right-->
    <?php foreach($category as $i=>$the):?>
    <div class="home_right f_l" <?php if($i==0):?>style="display: inline"<?php else:?>style="display: none"<?php endif;?>>
        <h3><?php echo $tc[$i]?></h3>
        <ul class="taocan_url">
            <?php foreach($art[$i] as $a=>$item):?>
            <li>
                <a href="<?php echo Yii::app()->createUrl('home/view',array('id'=>$item->csc_id,'cate'=>5))?>"><img src="<?php echo $item->csc_img_thumb_min?>" width="64" height="60" onMouseover="shake(this,'onmouseout')"  /></a>
                <p><a href="<?php echo Yii::app()->createUrl('home/view',array('id'=>$item->csc_id,'cate'=>5))?>"><?php echo Helper::truncate_utf8_string($item->csc_name,13)?></a>
<!--                    <span class="taocan_prict">￥198.00</span>-->
<!--                    月销200笔.-->
                </p>
                <div class="taocan_num"><?php echo $a+1;?></div>
            </li>
            <?php endforeach;?>

        </ul>
        <div class="qianzheng taocan_list  clear">
            <ul>
                <?php foreach($faq[$i] as $v):?>
                <li><a href="<?php echo Yii::app()->createUrl('home/view',array('id'=>$v->csc_id,'cate'=>5))?>"><?php echo Helper::truncate_utf8_string($v->csc_name,10); ?> </a></li>
                <?php endforeach;?>
            </ul>
        </div>

    </div>
    <?php endforeach;?>
<!--end right-->
</div>

</div>



