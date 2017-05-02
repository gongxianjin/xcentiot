<div class="mag-banner">
    <img class="banner-img-size" src="<?php echo yii::app()->request->baseurl?>/assets/home/images/solution_bg.png" />
</div>


<div class="gtco-section">
    <div class="gtco-container">
        <div class="row animate-box">
            <div class="col-md-8 col-md-offset-2 text-center gtco-heading gtco-heading-sm">
                <h2>产品<h2>
            </div>
        </div>
        <div class="row animate-box">
            <div class="col-md-6">
                <img src="<?php $img = BaseApi::getContentImg($article->csc_desc); echo $img[0];?>" alt="<?php echo $article->csc_name?>">
            </div>
            <div class="col-md-6">
                <p><?php echo BaseApi::delContentImg($article->csc_desc);?></p>
            </div>
        </div>
    </div>
</div>

<div class="gtco-cover gtco-cover-sm">
    <div class="overlay"></div>
</div>

<div id="gtco-team" class="gtco-section">
    <div class="gtco-container">
        <div class="row animate-box">
            <div class="col-md-8 col-md-offset-2 text-center gtco-heading">
                <h2>应用</h2>
            </div>
        </div>
        <div class="row animate-box">
            <div class="col-md-12">
                <p><?php echo $article->csc_content;?></p>
            </div>
        </div>
    </div>
</div>


