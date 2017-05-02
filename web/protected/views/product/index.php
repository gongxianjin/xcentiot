
<div class="mag-banner">
    <img class="banner-img-size" src="<?php echo yii::app()->request->baseurl?>/assets/home/images/product.png" />
</div>

<!-- section start -->
<!-- ================ -->
<div id="gtco-features">
    <div class="container">
        <h1 class="text-center title" id="portfolio">产品展示</h1>
        <div class="separator"></div>
        <p class="lead text-center">为客人做出满意的产品，是我们事业的动力；您的满意是我们的起点，我们没有最好，只有更好；对您的服务永无止境，我们乐意付出汗水，换来产品的效益...</p>
        <br>
        <div class="row object-non-visible" data-animation-effect="fadeIn">
            <div class="col-md-12">
                <!-- portfolio items start -->
                <div class="isotope-container row grid-space-20">
                    <?php foreach($faqs as $key=>$item):?>
                    <div class="col-sm-6 col-md-3 isotope-item web-design">
                        <div class="image-box">
                            <div class="overlay-container">
                                <a class="overlay" data-toggle="modal" data-target="#project-<?php echo $key?>">
                                    <img src="<?php echo $item->csc_img?>" alt="" style="width:262.5px;">
                                </a>
                            </div>
                            <a class="btn btn-default btn-block" data-toggle="modal" data-target="#project-<?php echo $key?>">查看更多</a>
                        </div>
                        <!-- Modal -->
                        <div class="modal fade" id="project-<?php echo $key?>" tabindex="-1" role="dialog" aria-labelledby="project-<?php echo $key?>-label" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                        <h4 class="modal-title" id="project-<?php echo $key?>-label"><?php echo $item->csc_name?></h4>
                                    </div>
                                    <div class="modal-body">
                                        <h3><?php echo $item->csc_subtitle?></h3>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <?php echo BaseApi::delContentImg($item->csc_content)?>
                                            </div>
                                            <div class="col-md-6">
                                                <a class="overlay" data-toggle="modal" data-target="#project-<?php echo $key?>">
                                                    <img src="<?php $img = BaseApi::getContentImg($item->csc_desc); echo $img[0]?>" alt="" width="400px;">
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Modal end -->
                    </div>
                    <?php endforeach;?>

                    <div class="pages">
                        <?php $this->widget('Pager',array(
                            'firstPageLabel' => '首页',
                            'lastPageLabel' => '末页',
                            'prevPageLabel' => '上一页',
                            'nextPageLabel' => '下一页',
                            'pages' => $pages,
                            'maxButtonCount'=>8,
                            'header'=>'记录总数：'.$pages->itemCount. '&nbsp;&nbsp;',
                        ));?>
                    </div>

                </div>
                <!-- portfolio items end -->
            </div>
        </div>
    </div>
</div>
<!-- section end -->
