<div id="carousel-example-generic" class="carousel slide" data-ride="carousel" data-interval="4000">
    <?php $this->widget('Ad',array('pos'=>'ad_banner','theme'=>'ad_banner'));?>
</div>

<div id="gtco-features-2">
    <div class="gtco-container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2 text-center gtco-heading">
                <h2><a href="http://www.xcentiot.com/solution/detail/id/2.html">无线温湿度环境监控系统</a></h2>
                <p>GSP无线系列温湿度监控系统具有出色的准确性和稳定性，广泛应用于家居、办公场所、酒店、仓储物流、农业生产、食品、医药、化工、气象、环保、电子、实验室等多种领域。</p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="feature-left animate-box" data-animate-effect="fadeInLeft">
						<span class="icon">
							<i class="icon-check"></i>
						</span>
                    <div class="feature-copy">
                        <h3>云存储</h3>
                        <p>◆数据实时上传到云端，保证数据安全完整不易丢失，安全性能优越。</p>
                    </div>
                </div>

                <div class="feature-left animate-box" data-animate-effect="fadeInLeft">
						<span class="icon">
							<i class="icon-check"></i>
						</span>
                    <div class="feature-copy">
                        <h3>实时稳定</h3>
                        <p>◆高稳定性的WiFi连接方案，自动重启机制，定时心跳包和服务器保持连接，断网重连，断服务器重连，工作异常重启。</p>
                    </div>
                </div>

                <div class="feature-left animate-box" data-animate-effect="fadeInLeft">
						<span class="icon">
							<i class="icon-check"></i>
						</span>
                    <div class="feature-copy">
                        <h3>独立方便</h3>
                        <p>◆无需改变原有的使用环境，无需布线，傻瓜式配置和安装，非常方便地扩展安装任意数量的测量节点。</p>
                    </div>
                </div>

                <div class="feature-left animate-box" data-animate-effect="fadeInLeft">
						<span class="icon">
							<i class="icon-check"></i>
						</span>
                    <div class="feature-copy">
                        <h3>全方位报警</h3>
                        <p>◆支持先讯物联温湿度监控报警平台的接入，可扩展本地声光报警和远程网页报警、短信报警，支持内网和外网服务器对接。</p>
                    </div>
                </div>

            </div>

            <div class="col-md-6">
                <div class="gtco-video gtco-bg" style="background-image: url(<?php echo yii::app()->request->baseurl?>/assets/home/images/img_1.jpg); ">
                    <a href="http://player.youku.com/player.php/sid/XMjY3MTYzOTc4OA==/v.swf" class="popup-vimeo"><i class="icon-video2"></i></a>
                    <div class="overlay"></div>
                </div>
            </div>
        </div>
    </div>
</div>


<div id="gtco-services">
    <div class="gtco-container">

        <div class="row animate-box">
            <div class="col-md-8 col-md-offset-2 text-center gtco-heading">
                <h2>服 务 案 列</h2>
            </div>
        </div>
        <div class="row animate-box">
            <div class="gtco-tabs">
                <ul class="gtco-tab-nav">
                    <li class="active"><a href="#" data-tab="1"><span class="icon visible-xs"><i class="icon-command"></i></span><span class="hidden-xs"><?php echo $bestproduct[0]['csc_name']?></span></a></li>
                    <li><a href="#" data-tab="2"><span class="icon visible-xs"><i class="icon-bar-graph"></i></span><span class="hidden-xs"><?php echo $bestproduct[1]['csc_name']?></span></a></li>
                    <li><a href="#" data-tab="3"><span class="icon visible-xs"><i class="icon-bag"></i></span><span class="hidden-xs"><?php echo $bestproduct[2]['csc_name']?></span></a></li>
                    <li><a href="#" data-tab="4"><span class="icon visible-xs"><i class="icon-box"></i></span><span class="hidden-xs"><?php echo $bestproduct[3]['csc_name']?></span></a></li>
                </ul>

                <!-- Tabs -->
                <div class="gtco-tab-content-wrap">

                    <div class="gtco-tab-content tab-content active" data-tab-content="1">
                        <div class="col-md-6">
                            <div class="icon icon-xlg">
                                <a href="<?php echo $this->createUrl('/product');?>"><img src="<?php echo $bestproduct[0]['csc_img']?>" alt="<?php echo $bestproduct[0]['csc_name']?>"></a>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <h2><?php echo $bestproduct[0]['csc_name']?></h2>
                            <p><?php echo BaseApi::delContentImg($bestproduct[0]['csc_desc'])?></p>
                        </div>
                    </div>

                    <div class="gtco-tab-content tab-content" data-tab-content="2">
                        <div class="col-md-6">
                            <div class="icon icon-xlg">
                                <a href="<?php echo $this->createUrl('/product');?>"><img src="<?php echo $bestproduct[1]['csc_img']?>" alt="<?php echo $bestproduct[1]['csc_name']?>"></a>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <h2><?php echo $bestproduct[1]['csc_name']?></h2>
                            <p><?php echo BaseApi::delContentImg($bestproduct[1]['csc_desc'])?></p>
                        </div>
                    </div>

                    <div class="gtco-tab-content tab-content" data-tab-content="3">
                        <div class="col-md-6">
                            <div class="icon icon-xlg">
                                <a href="<?php echo $this->createUrl('/product');?>"><img src="<?php echo $bestproduct[2]['csc_img']?>" alt="<?php echo $bestproduct[2]['csc_name']?>"></a>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <h2><?php echo $bestproduct[2]['csc_name']?></h2>
                            <p><?php echo BaseApi::delContentImg($bestproduct[2]['csc_desc'])?></p>
                        </div>
                    </div>

                    <div class="gtco-tab-content tab-content" data-tab-content="4">
                        <div class="col-md-6">
                            <div class="icon icon-xlg">
                                <a href="<?php echo $this->createUrl('/product');?>"><img src="<?php echo $bestproduct[3]['csc_img']?>" alt="<?php echo $bestproduct[3]['csc_name']?>"></a>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <h2><?php echo $bestproduct[3]['csc_name']?></h2>
                            <p><?php echo BaseApi::delContentImg($bestproduct[3]['csc_desc'])?></p>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>
</div>


<?php $this->loadCssOrJs(dirname(__FILE__).'/index.js','script')?>
