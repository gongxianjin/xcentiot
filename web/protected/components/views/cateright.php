<?php if(Yii::app()->controller->id == 'depart'):?>
<div class="z_wtNav <?php if(Yii::app()->controller->action->id == 'teacher'):?>z_wtNav2 z_wtNav4<?php elseif(Yii::app()->controller->action->id == 'case'):?>z_wtNav2 z_wtNav3<?php endif;?> ">
<ul>
    <?php foreach ($depart as $item):?>
        <li <?php if($cid == $item->csc_id):?>class="active active2"<?php endif;?>>
            <a <?php if($cid == $item->csc_id):?>class="active"<?php endif;?> href="javascript:void(0);"><?php echo $item->csc_name?></a><span></span>
            <ul>
                <li <?php if(Yii::app()->controller->action->id == 'major'):?>class="active"<?php endif;?> ><a href="<?php echo Yii::app()->createUrl('depart/major',array('cid'=>$item->csc_id))?>">专业</a></li>
                <li <?php if(Yii::app()->controller->action->id == 'teacher'):?>class="active"<?php endif;?> ><a href="<?php echo Yii::app()->createUrl('depart/teacher',array('cid'=>$item->csc_id))?>">师资队伍</a></li>
                <li <?php if(Yii::app()->controller->action->id == 'case'):?>class="active"<?php endif;?> ><a href="<?php echo Yii::app()->createUrl('depart/case',array('cid'=>$item->csc_id))?>">学生作品及荣誉</a></li>
            </ul>
        </li>
    <?php endforeach;?>
    <li class="z_returnHome"><a href="/">返回首页</a></li>
</ul>
</div>
<?php elseif(Yii::app()->controller->id == 'original'):?>
    <div class="z_wtNav">
        <ul>
            <li <?php if($cid == '30'):?>class="active"<?php endif;?>><a href="<?php echo Yii::app()->createUrl('original/index',array('cid'=>'30'))?>">组织机构<span></span></a></li>
            <li <?php if($cid == '31'):?>class="active"<?php endif;?>><a href="<?php echo Yii::app()->createUrl('original/index',array('cid'=>'31'))?>">人事招聘<span></span></a></li>
            <li class="z_returnHome"><a href="/">返回首页</a></li>
        </ul>
    </div>
<?php elseif(Yii::app()->controller->id == 'achieve'):?>
    <div class="z_wtNav">
        <ul>
            <li <?php if($cid == '41'):?>class="active"<?php endif;?>><a href="<?php echo Yii::app()->createUrl('achieve/index',array('cid'=>'41'))?>">课程展示<span></span></a></li>
            <li <?php if($cid == '42'):?>class="active"<?php endif;?>><a href="<?php echo Yii::app()->createUrl('achieve/index',array('cid'=>'42'))?>">学生获奖<span></span></a></li>
            <li <?php if($cid == '43' || Yii::app()->controller->action->id == 'detail'):?>class="active"<?php endif;?>><a href="<?php echo Yii::app()->createUrl('achieve/index',array('cid'=>'43'))?>">教学活动<span></span></a></li>
            <li class="z_returnHome"><a href="/">返回首页</a></li>
        </ul>
    </div>
<?php elseif(Yii::app()->controller->id == 'reform'):?>
    <div class="z_wtNav">
        <ul>
            <li <?php if($cid == '51'):?>class="active"<?php endif;?>><a href="<?php echo Yii::app()->createUrl('reform/index',array('cid'=>'51'))?>">科研<span></span></a></li>
            <li <?php if($cid == '52'):?>class="active"<?php endif;?>><a href="<?php echo Yii::app()->createUrl('reform/index',array('cid'=>'52'))?>">专利<span></span></a></li>
            <li <?php if($cid == '53'):?>class="active"<?php endif;?>><a href="<?php echo Yii::app()->createUrl('reform/index',array('cid'=>'53'))?>">教改项目<span></span></a></li>
            <li <?php if($cid == '54'):?>class="active"<?php endif;?>><a href="<?php echo Yii::app()->createUrl('reform/index',array('cid'=>'54'))?>">研究所<span></span></a></li>
            <li class="z_returnHome"><a href="/">返回首页</a></li>
        </ul>
    </div>
<?php elseif(Yii::app()->controller->id == 'resource'):?>
    <div class="z_wtNav <?php if($cid != '64'):?>z_wtNav2 z_wtNav3<?php endif;?>">
        <ul>
            <li <?php if($cid == '61'):?>class="active"<?php endif;?>><a href="<?php echo Yii::app()->createUrl('resource/index',array('cid'=>'61'))?>">实训基地<span></span></a></li>
            <li <?php if($cid == '62'):?>class="active"<?php endif;?>><a href="<?php echo Yii::app()->createUrl('resource/index',array('cid'=>'62'))?>">工作室<span></span></a></li>
            <li <?php if($cid == '63'):?>class="active"<?php endif;?>><a href="<?php echo Yii::app()->createUrl('resource/index',array('cid'=>'63'))?>">专业图书<span></span></a></li>
            <li <?php if($cid == '64'):?>class="active"<?php endif;?>><a href="<?php echo Yii::app()->createUrl('resource/index',array('cid'=>'64'))?>">博物馆<span></span></a></li>
            <li class="z_returnHome"><a href="/">返回首页</a></li>
        </ul>
    </div>
<?php endif;?>
