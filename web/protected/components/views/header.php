<div id="page">

<header id="gtco-header" class="gtco-cover gtco-cover-sm header" role="banner" style="background-image:url(<?php echo yii::app()->request->baseurl?>/assets/home/images/home_version_bg1.jpg);">

    <nav class="gtco-nav" role="navigation">
        <div class="gtco-container">
            <div class="row">
                <div class="col-xs-2">
                    <div id="gtco-logo">
                        <a href="/"><img src="<?php echo yii::app()->request->baseurl?>/assets/home/images/logo1.png">
                        </a>
                    </div>
                </div>
                <div class="col-xs-8 text-center menu-1">
                    <ul>
                        <li <?php if(Yii::app()->controller->id == 'site'):?>class="active"<?php endif?>>
                            <a href="<?php echo Yii::app()->createUrl('site/')?>">首页</a>
                        </li>

                        <li <?php if(Yii::app()->controller->id == 'solution'):?>class="active"<?php endif?>>
                            <a href="<?php echo Yii::app()->createUrl('solution/')?>">解决方案</a>
                        </li>

                        <li <?php if(Yii::app()->controller->id == 'product'):?>class="active"<?php endif?>>
                            <a href="<?php echo Yii::app()->createUrl('product/')?>">产品展示</a>
                        </li>

                        <li <?php if(Yii::app()->controller->id == 'about'):?>class="active"<?php endif?> >
                            <a href="<?php echo Yii::app()->createUrl('about/index/')?>">关于我们</a>
                        </li>

                        <li <?php if(Yii::app()->controller->id == 'contract'):?>class="active"<?php endif?>>
                            <a href="<?php echo Yii::app()->createUrl('contract/index/')?>">联系我们</a>
                        </li>

                    </ul>
                </div>
            </div>
        </div>
    </nav>

</header>
