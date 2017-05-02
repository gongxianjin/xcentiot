<div class="visa width_1200 margin_auto clear">
<p class="visa_name"><a style="color: #3e3e3e" href="<?php echo Yii::app()->createUrl('guide/index');?>">签证通关指导</a><span class="visa_name_en">Guide</span></p>
<style>
    #tab2 .tabCon .qianzheng ul li a:hover{color: orange;}
</style>

<div id="tabs">
<ul class="visa_nav">
    <li><a href="#tabs-1" title="">签证案例</a></li>
    <li><a href="#tabs-2" title="">签证流程</a></li>
    <li><a href="#tabs-3" title="">材料准备</a></li>
    <li><a href="#tabs-4" title="">面签要诀</a></li>
    <li><a href="#tabs-5" title="">通关入境</a></li>
</ul>

<div id="tabs_container">
<!--case-->
<div id="tabs-1">
    <div id="tab">
        <div class="tabList f_l">
            <ul>
                <?php foreach($faq as $k=>$v):?>
                <li <?php if($k=='成都市'): ?>class="cur"<?php endif;?>><?php echo $k?></li>
                <?php endforeach;?>
            </ul>
        </div>

        <div class="tabCon f_l">
            <!--frist-->

            <!--end frist-->
            <?php foreach($faq as $key=>$val): ?>
                <!--有时候会有bug----cur--->
            <div style="display: <?php if($key=='成都市'):?>inline<?php else:?>none<?php endif;?>" class="wenda <?php if($key=='成都市'):?>hx cur<?php endif; ?>">
                <a href="<?php echo Yii::app()->createUrl('guide/index');?>" class="f_l"><img src="<?php echo $val->csc_img?>" width="188" height="239"></a>
                <div class="case_ziliao f_l ">
                    <p class="case_ziliao_user"><?php echo date('Y.m.d',strtotime($val->csc_update))?><span></span><?php echo $val->csc_name; ?></p>
                    <h3 class="f_l">关键材料:</h3>身份证、护照原件、申请人材料
                    <h3>核心问答:</h3>
                    <ul class="news_cont_list">
                        <?php foreach($core[$key] as $v):?>
                        <li><a href="<?php echo Yii::app()->createUrl('index/view',array('id'=>$v->csc_id,'cate'=>'8'))?>"><span class="f_l"><?php echo Helper::truncate_utf8_string($v->csc_name,17);?></span> <span class="f_r"><?php echo date('m-d',strtotime($v->csc_create));?></span></a></li>
                        <?php endforeach;?>
                    </ul>
                </div>
                <div class="case_ziliao case_fenxi f_l">
                    <h3 >案例分析:</h3>

                    <p><a style="color: #808080;" href="<?php echo Yii::app()->createUrl('guide/index');?>"><?php echo Helper::truncate_utf8_string($val->csc_content,100); ?></a></p>


                </div>
            </div>
            <?php endforeach;?>


        </div>
    </div>
</div>
<!--end case-->
<!--liucheng-->
<div id="tabs-2">
    <ul class="liucheng">
        <li class="step_01"></li>
        <li class="step_02"></li>
        <li class="step_03"></li>
        <li class="step_04"></li>
        <li class="step_05"></li>
    </ul>
</div>
<!--end liucheng-->
<!--cailiao-->
<div id="tabs-3" class="cailiao">

    <div id="tab6" style="width: 100%;">
        <div class="tabList f_l" style="width:1149px;height: 273px;overflow: hidden;">
            <ul>
                <li style="border:0;width:300px;overflow: hidden;"><ul><li>指导准备国内材料</li></ul></li>
                <?php foreach($cail[0] as $v):?>
                <li><?php echo $v->csc_name;?></li>
                <?php endforeach;?>

            </ul>
            <ul>
                <li style="border:0;width:300px;overflow: hidden;"><ul><li>为您准备美国材料</li></ul></li>
                <?php foreach($cail[1] as $v):?>
                    <li><?php echo Helper::truncate_utf8_string($v->csc_name,5,'');?></li>
                <?php endforeach;?>
                <li style="border: none;"></li>
            </ul>
        </div>
        <div class="tabCon f_l" style="float:right;margin-top: -290px;">
            <!--frist-->
            <div class="cur">
                <h3>材料图样</h3>
                <a href="<?php echo Yii::app()->createUrl('guide/index');?>"><img src="/assets/home/images/cailiao.jpg" width="171" height="219"></a>
            </div>
            <!--end frist-->

            <?php foreach($cail[0] as $v):?>
            <div >
                <h3>材料图样</h3>
                <img src="<?php echo $v->csc_img?>" width="171" height="219">
                <span><a href="<?php echo Yii::app()->createUrl('guide/index');?>">点击索取</a></span>
            </div>
            <?php endforeach;?>

            <div >
                <h3>材料图样</h3>
                <img src="/assets/home/images/cailiao.jpg" width="171" height="219">
                <span><a href="<?php echo Yii::app()->createUrl('guide/index');?>">点击索取</a></span>
            </div>
            <?php foreach($cail[1] as $v):?>
                <div >
                    <h3>材料图样</h3>
                    <img src="<?php echo $v->csc_img?>" width="171" height="219">
                    <span><a href="<?php echo Yii::app()->createUrl('guide/index');?>">点击索取</a></span>
                </div>
            <?php endforeach;?>




        </div>
    </div>
</div>
<!--end cailiao-->
<!--mianshi-->
<div id="tabs-4">
    <div id="tab2">
        <div class="tabList f_l">
            <ul>
                <?php foreach($article as $i=>$v):?>
                <li <?php if($i=='0'):?>class="cur"<?php endif;?>><?php echo $v->csc_name?></li>
                <?php endforeach;?>

            </ul>
        </div>
        <div class="tabCon f_l">
            <!--frist-->
            <?php foreach($article as $a=>$val):?>
            <div <?php if($a=='0'):?> class="cur"<?php endif;?>>
                <div class="yibiao f_l">
                    <h3><?php echo $val->csc_name;?></h3>
                    <p><?php echo Helper::truncate_utf8_string($val->csc_content,220);?></p>
                </div>
                <div class=" yibiao qianzheng f_l">
                    <h3>签证攻略</h3>
                    <ul>
                        <?php foreach($qianzheng[0] as $v):?>
                            <li><a href="<?php echo Yii::app()->createUrl('guide/view',array('id'=>$v->csc_id,'cate'=>'8'))?>"><?php echo Helper::truncate_utf8_string($v->csc_name,13)?></a></li>
                        <?php endforeach;?>
                    </ul>
                </div>
            </div>
            <?php endforeach;?>
            <!--end frist-->

        </div>
    </div>

</div>

<!--end mianshi-->
<!--tongguan-->
<div id="tabs-5">
    <div id="tab3">
        <div class="tabList f_l">
            <ul>
                <?php foreach($art as $kk=>$val):?>
                <li <?php if($kk=0):?>class="cur"<?php endif;?>><?php echo $val->csc_name?></li>
                <?php endforeach;?>
            </ul>
        </div>
        <div class="tabCon f_l">
            <!--frist-->
            <?php foreach($art as $b=>$v):?>
            <div <?php if($b=='0'):?>class="tongguan cur"<?php else:?>class="tongguan"<?php endif;?>>
                <a href="<?php echo Yii::app()->createUrl('guide/index');?>"><img src="<?php echo $v->csc_img?>" height="270" width="203"></a>
                <div class="liucheng2">
                    <h3>流程说明:</h3>
                    <p>
                        <?php echo Helper::truncate_utf8_string($v->csc_content,150);?>
                    </p>
                </div>
                <div class="liucheng2 gonglue">
                    <h3>通关攻略:</h3>
                    <ul>
                        <?php foreach($tongguan[0] as $v):?>
                            <li><a href="<?php echo Yii::app()->createUrl('guide/view',array('id'=>$v->csc_id,'cate'=>'8'))?>"><?php echo Helper::truncate_utf8_string($v->csc_name,10)?> </a></li>
                        <?php endforeach;?>
                    </ul>
                </div>
            </div>
            <?php endforeach;?>
            <!--end frist-->


        </div>
    </div>


</div>
<!--end tongguang-->
</div><!--End tabs container-->

</div><!--End tabs-->

<script type="text/javascript" >
    $(document).ready(function($) {
        $('#tabs').tabulous({effect: 'scale'});
    });
</script>

</div>