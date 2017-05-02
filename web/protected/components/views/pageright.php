<dl class="z_wtRcon">
    <dt class="z_wtRt"><span><a href="<?php echo Yii::app()->createUrl('depart/major',array('cid'=>$cid))?>">院系专业</a></span><a href="<?php echo Yii::app()->createUrl('depart/major',array('cid'=>$cid))?>">更多>></a></dt>
    <?php foreach($article as $key=>$item):?>
    <div class="wtRcon z_major z_major<?php echo $key?>">
        <a href="<?php echo Yii::app()->createUrl('depart/major',array('cid'=>$cid))?>"><img src="<?php echo $item->csc_img?>" alt=""></a>
        <dt><a href="<?php echo Yii::app()->createUrl('depart/major',array('cid'=>$cid))?>"><?php echo $item->csc_name?></a></dt>
        <p><?php if($item->csc_desc) echo mb_substr($item->csc_desc,0,200,'UTF-8')?></p>
        <div class="z_majorOC<?php echo $key?>"></div>
    </div>
    <?php endforeach;?>
</dl>

<dl class="z_wtRcon">
    <dt class="z_wtRt"><span><a href="<?php echo Yii::app()->createUrl('depart/teacher',array('cid'=>$cid));?>">师资力量</a></span><a href="<?php echo Yii::app()->createUrl('depart/teacher',array('cid'=>$cid));?>">更多>></a></dt>
    <div class="wtRcon z_teacher">
        <ul>
            <?php foreach($teacher as $item):?>
            <li class="btnHover z_teacher1 z_detail" pos="<?php echo Yii::app()->createUrl('depart/teacher',array('id'=>$item->csc_id))?>">
                <a href="#">
                    <img src="<?php echo $item->csc_img?>" alt="">
                    <div class="z_teacherN">
                        <dt><?php echo $item->csc_name?></dt>
                        <p><?php echo mb_substr($item->csc_subtitle,0,15,'UTF-8')?></p>
                    </div>
                </a>
            </li>
            <?php endforeach;?>
        </ul>
    </div>
</dl>

<div class="z_wtRcon z_tv">
    <dt>最新视频</dt>
    <div class="auotVideo">
        <embed src="http://www.tudou.com/v/xB3vR6bxp4w/&autoPlay=false&JSEnabled=true/v.swf"autostart="true" allowFullScreen="true" quality="high" width="320" height="185" align="middle" allowScriptAccess="always" type="application/x-shockwave-flash">
        </embed>
    </div>
</div>

<!-- 弹出层 -->
<div class="z_teacherD z_teacherD3">
    <div class="z_container z_teacherDC">
        <div class="z_tccTop"></div>
        <div class="z_coloseTh"><span>colse</span></div>
        <div class="z_thcon">
            <div class="z_teacherImg">
                <div class="ladyScroll ladyScroll03">
                    <a class="prev" href="javascript:void(0)"></a>
                    <div class="scrollWrap">
                    </div>
                    <a class="next" href="javascript:void(0)"></a>
                </div>
            </div>
            <div class="z_tjs">
                <div class="z_tjsL"><div><div class="tname"></div></div></div>
                <div class="z_tjsR">
                </div>
            </div>
        </div>
    </div>
</div>
<!-- 弹出层 end -->

<?php $this->loadCssOrJs(dirname(__FILE__).'/index.js','script')?>