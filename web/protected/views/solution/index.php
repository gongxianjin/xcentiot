
<div class="mag-banner">
    <img class="banner-img-size" src="<?php echo yii::app()->request->baseurl?>/assets/home/images/solution_bg.png" />
</div>

<div id="gtco-features">
    <div class="gtco-container">
        <div class="row">

            <?php foreach($faqs as $item):?>
            <div class="col-md-4 col-sm-4">
                <div class="feature-center animate-box" data-animate-effect="fadeIn">
                    <img src="<?php echo $item->csc_img?>" alt="">
                    <h3><?php echo $item->csc_name;?></h3>
                    <p><a href="<?php echo $this->createUrl('solution/detail',array('id'=>$item->csc_id))?>" class="btn btn-primary">查看更多</a></p>
                </div>
            </div>
            <?php endforeach;?>


        </div>
    </div>
</div>




