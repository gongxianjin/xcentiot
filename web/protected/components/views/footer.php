
<footer id="gtco-footer" role="contentinfo" class="z_contact">
    <div class="gtco-container">
        <div class="row row-pb-md">
            <div class="col-md-4 gtco-widget">
                <h3><?php echo Yii::app()->params['site']['title']?></h3>
                <p><?php echo Yii::app()->params['site']['client_mail']?></p>
                <p><?php echo Yii::app()->params['site']['phone']?></p>
                <p><?php echo Yii::app()->params['site']['address']?></p>
            </div>
            <div class="col-md-2 col-sm-4 col-xs-6 col-md-push-1">
                <ul class="gtco-footer-links">
                    <li><a href="<?php echo Yii::app()->createUrl('site/index/')?>">首页</a></li>
                </ul>
            </div>
            <div class="col-md-2 col-sm-4 col-xs-6 col-md-push-1">
                <ul class="gtco-footer-links">
                    <li><a href="<?php echo Yii::app()->createUrl('solution/index/')?>">解决方案</a></li>
                    <li><a href="<?php echo Yii::app()->createUrl('product/index/')?>">产品展示</a></li>
                </ul>
            </div>

            <div class="col-md-2 col-sm-4 col-xs-6 col-md-push-1">
                <ul class="gtco-footer-links">
                    <li><a href="<?php echo Yii::app()->createUrl('about/index/')?>">关于我们</a></li>
                </ul>
            </div>

            <div class="col-md-2 col-sm-4 col-xs-6 col-md-push-1">
                <ul class="gtco-footer-links">
                    <li> <a href="<?php echo Yii::app()->createUrl('contract/index/')?>">联系我们</a></li>
                </ul>
            </div>

        </div>

        <div class="row copyright z_footer">
            <div class="col-md-12 z_container new_pc_index_footer">
<!--                <dl>-->
<!--                    <span>友情链接：</span>-->
<!--                    --><?php //$this->Widget('Ad' , array('pos'=>'friendly_links' , 'theme'=>'ad_corper'))?>
<!--                </dl>-->
                <p>
                    <small class="block"><?php echo Yii::app()->params['site']['copy']?> <?php echo Yii::app()->params['site']['record']?></small>
                </p>
            </div>
        </div>

    </div>
</footer>
</div>

<div class="gototop js-top">
    <a href="#" class="js-gotop"><i class="icon-arrow-up"></i></a>
</div>


</body>
</html>


