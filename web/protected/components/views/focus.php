<style>
    #t2 a:hover{color: orange;}
</style>
<div id="t2">
<p class="visa_name">关注焦点<span class="visa_name_en">Focus</span></p>
<ul class="focus_url width_1200 margin_auto">
    <?php $this->Widget('Ad',array('pos'=>'ad_focus','theme'=>'ad_focus','offset'=>0,'num'=>5));?>

</ul>

<div id="tabs2">
    <ul class="visa_nav">
        <li><a href="#tabs-1" title="">费用规划</a></li>
        <li><a href="#tabs-2" title="">赴美流程</a></li>
        <li><a href="#tabs-3" title="">医生医院</a></li>
        <li><a href="#tabs-4" title="">美宝证件</a></li>
    </ul>

<div id="tabs_container">
<!--tabs-1-->
<div id="tabs-1" class="feiyong">
    <?php  $i=1;foreach($article as $key=>$val):?>
    <dl>
        <dt class="fei_0<?php echo $i?>"><span><?php echo $key;?></span></dt>
        <dd>
            <ul>
                <?php foreach($val as $item):?>
                <li><a href="<?php echo Yii::app()->createUrl('index/view',array('id'=>$item->csc_id,'cate'=>'9'))?>"><?php echo $item->csc_name?></a></li>
                <?php endforeach;?>


            </ul>
        </dd>
    </dl>
        <?php $i++;?>
    <?php endforeach;?>

    <dl class="liucheng2 gonglue">
        <dt>费用攻略:</dt>
        <dd>
            <ul>
                <?php foreach($feiyong as $v):?>
                <li><a href="<?php echo Yii::app()->createUrl('index/view',array('id'=>$v->csc_id,'cate'=>'9')) ?>"><?php echo $v->csc_name;?> </a></li>
                <?php endforeach;?>


            </ul>
        </dd>
    </dl>
</div>
<!--end tabs-1-->
    <!----赴美流程--->
<div id="tabs-2">
    <?php $this->Widget('Ad',array('pos'=>'focus_luicheng','theme'=>'focus_fumei'));?>
</div>

<div id="tabs-3">
    <div class="yiyuan f_l">
        <?php if(isset($yisheng)):?>
        <?php foreach($yisheng as $k=>$v):?>
        <a href="<?php echo Yii::app()->createUrl('doctor/index');?>" <?php if($k=='0'):?>class="cur"<?php endif;?>><?php echo $v->csc_name?></a>
        <?php endforeach;?>
        <?php endif;?>
    </div>

    <div class="doctor f_l">

        <?php foreach($yisheng as $k=>$v):?>
        <span <?php if($k!='0'):?>style="display: none"<?php endif;?>>
        <a href="<?php echo Yii::app()->createUrl('doctor/index');?>"><img src="<?php echo $v->csc_img?>" width="180" height="105" /></a>
        <h3><a href="<?php echo Yii::app()->createUrl('doctor/index');?>"><?php echo $v->csc_name?></a></h3>
        <p><a href="<?php echo Yii::app()->createUrl('doctor/index');?>"><?php echo Helper::truncate_utf8_string($v->csc_content,80)?></a></p>
        </span>

        <?php endforeach;?>
    </div>
    <style>
        .yiyuanname a{
            border: #ccc solid 1px;
            border-radius: 5px;
            -webkit-border-radius: 5px;
        }
    </style>

    <div class="yiyuanname f_l">
        <?php if(isset($yiyuan)):?>
        <?php foreach($yiyuan as $k=>$v):?>
            <a href="<?php echo Yii::app()->createUrl('hospital/view',array('id'=>$v->csc_id))?>" <?php if($k=='0'):?>class="cur"<?php endif;?>><?php echo Helper::truncate_utf8_string($v->csc_name,6,'')?></a>
        <?php endforeach;?>
        <?php endif;?>
    </div>
    <div class="yiyuancont f_l">
        <?php foreach($yiyuan as $k=>$v):?>
        <span <?php if($k!='0'):?>style="display: none"<?php endif;?>>
        <a href="<?php echo Yii::app()->createUrl('hospital/view',array('id'=>$v->csc_id))?>"><img src="<?php echo $v->csc_img?>" width="218" height="259" /></a>
        <p><?php echo Helper::truncate_utf8_string($v->csc_content,150)?></p>
        </span>
        <?php endforeach;?>
    </div>

</div>
    <script>
        $(function(){
            $(".yiyuan a").hover(function () {
                $(this).css('background-color','#76b836');
                $(this).siblings().css('background-color','');
                $(".doctor span").eq($(this).index()).css('display','inline');
                $(".doctor span").eq($(this).index()).siblings().css('display','none');
            }).mouseout(function () {
                $(this).css('background-color','');
            });
            $(".yiyuanname a").hover(function () {
                $(this).css('background-color','#76b836');
                $(this).siblings().css('background-color','');
                $(".yiyuancont span").eq($(this).index()).css('display','inline');
                $(".yiyuancont span").eq($(this).index()).siblings().css('display','none');
            }).mouseout(function () {
                $(this).css('background-color','');
            });
        });
    </script>
<div id="tabs-4">
    <div id="tab4">
        <div class="tabList f_l">
            <ul>
                <?php foreach($faq as $k=>$v):?>
                <li <?php if($k=='0'):?>class="cur"<?php endif;?>><?php echo $v->csc_name;?></li>
                <?php endforeach; ?>
            </ul>
        </div>
        <div class="tabCon f_l">
            <!--frist-->
            <?php foreach($faq as $kk=>$val):?>
            <div <?php if($kk=='0'):?>class="zhengjian cur"<?php else:?>class="zhengjian"<?php endif;?>>
                <h3>证件样图</h3>
                <img src="<?php echo $val->csc_img;?>" width="235" height="196"/>
                <div class="zhengjian_content">
                    <h4>证件说明：</h4>
                    <p><?php echo Helper::truncate_utf8_string($val->csc_content,25);?></p>
                    <h4>证件用途：</h4>
                    <p><?php echo $val->csc_desc;?></p>
                </div>
            </div>
            <?php endforeach;?>
            <!--end frist-->

        </div>
    </div>


</div><!--End tabs container-->

</div><!--End tabs-->
<script type="text/javascript" >
    $(document).ready(function($) {
        $('#tabs2').tabulous({effect: 'scale'});

    });
</script>

</div>
</div>