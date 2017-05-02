<div class="section_left_menu contact clear">
    <h2>联系方式：</h2>
    <ul>
        <li class="contact_t1">免费呼叫中心：<?php echo $tel?></li>
        <li class="contact_t2">24小时手机咨询：<?php echo $phone?></li>
        <li class="contact_t3">QQ/微信咨询：<?php echo $qq?></li>
        <li class="contact_t3">美国资讯热线：<?php echo Yii::app()->params['site']['telm']?></li>
    </ul>
    <?php $this->Widget('Ad' , array('pos'=>'two_dimension_code' , 'theme'=>'ad_logo'))?>
</div>