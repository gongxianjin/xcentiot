<div class="visa team clear">
    <p class="visa_name"><a style="color: #3e3e3e" href="<?php echo Yii::app()->createUrl('about/index',array('aid'=>80));?>">团队风采</a><span class="visa_name_en">Team</span></p>

    <div id="tabs3">
        <ul class="visa_nav">
            <?php foreach($articles as $k=>$v):?>
            <li><a href="#tabs-<?php echo $k+1; ?>" title=""><?php echo $v->pca->csc_name?></a></li>
            <?php endforeach;?>
        </ul>

        <div id="tabs_container" class="team_content">
            <!--tabs-1-->
            <?php foreach($articles as $key=>$item):?>

            <div id="tabs-<?php echo $key+1?>" >
                <div class="team_pic f_l"><a href="#"><img src="<?php echo $item->csc_img?>" width="400" height="313" /></a></div>
                <div id="fsD<?php echo $key+1?>" class="focusv" >
                    <div id="D1pic<?php echo $key+1?>" class="fPic">
                        <?php foreach($imgs[$key] as $val):?>
                        <div class="fcon" >
                            <a target="_blank" href="<?php echo Yii::app()->createUrl('about/index',array('aid'=>84));?>"><img src="<?php echo $val;?>" style="opacity: 1; "></a>
                            <span class="shadow"><a target="_blank" href="#"><h3><?php echo $item->csc_name;?></h3><p><?php echo $item->csc_desc; ?></p></a></span>
                        </div>
                        <?php endforeach;?>


                    </div>
                    <div class="fbg">
                        <div class="D1fBt" id="D1fBt<?php echo $key+1?>" style=" display:none">

                            <a href="javascript:void(0)" hidefocus="true" target="_self" class=""><i>1</i></a>
                            <a href="javascript:void(0)" hidefocus="true" target="_self" class=""><i>2</i></a>
                            <a href="javascript:void(0)" hidefocus="true" target="_self" class="current"><i>3</i></a>
                            <a href="javascript:void(0)" hidefocus="true" target="_self" class=""><i>4</i></a>
                        </div>
                    </div>
                    <span class="prev"></span>
                    <span class="next"></span>
                </div>
                <script type="text/javascript">
                Qfast.add('widgets', { path: "/assets/home/js/terminator2.2.min.js", type: "js", requires: ['fx'] });
                    Qfast(false, 'widgets', function () {
                        K.tabs({
                            id: 'fsD<?php echo $key+1?>',   //焦点图包裹id
                            conId: "D1pic<?php echo $key+1?>",  //** 大图域包裹id
                            tabId:"D1fBt<?php echo $key+1?>",
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
            </div>
            <?php endforeach;?>
            <!--end tabs-1-->



        </div>

    </div>

    <script type="text/javascript" >
        $(function(){
        	$('#tabs3').tabulous({effect: 'scale'});
        })
    </script>
</div>