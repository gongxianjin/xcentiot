<div class="mag-banner">
    <img class="banner-img-size" src="<?php echo yii::app()->request->baseurl?>/assets/home/images/hello.png" />
</div>


<div class="gtco-section">
    <div class="gtco-container">
        <div class="row">
            <div class="col-md-6 animate-box">
                <h2>在线留言</h2>
                <form class="form-horizontal" onsubmit="return false;" method="post"  action="<?php echo Yii::app()->createUrl('contract/submit')?>">
                    <div class="row form-group">
                        <div class="col-md-12">
                            <input type="text" id="name" name="username" class="form-control" placeholder="姓名" onblur="javascript: nameBlur(this.value);">
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="col-md-12">
                            <input type="text" id="phone" name="phone"  class="form-control" placeholder="电话" onblur="javascript:phonenumberBlur(this.value);">
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="col-md-12">
                            <input type="text" id="subject" name="subject" class="form-control" placeholder="主题" onblur="javascript:subjectBlur(this.value);">
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-12">
                            <textarea name="message" id="message" cols="30" rows="10" class="form-control" placeholder="想了解什么内容？" onblur="javascript:messageBlur(this.value);"></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <input type="submit" value="在线留言" class="btn btn-primary" style="margin-left:20px;padding:8px 150px;" >
                    </div>
                </form>
            </div>

            <div class="col-md-5 col-md-push-1 animate-box">
                <div class="gtco-contact-info">
                    <h2>联系方式</h2>
                    <ul>
                        <li class="address"><?php echo Yii::app()->params['site']['address']?></li>
                        <li class="phone"><a href="tel://<?php echo Yii::app()->params['site']['phone']?>"><?php echo Yii::app()->params['site']['phone']?></a></li>
                        <li class="email"><a href="mailto:<?php echo Yii::app()->params['site']['client_mail']?>"><?php echo Yii::app()->params['site']['client_mail']?></a></li>
                    </ul>
                </div>
                <div>
                    <!--百度地图容器-->
                    <div class="baidumap" id="map"></div>
                </div>
            </div>

        </div>

    </div>
</div>

<!--引用百度地图API-->
<script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=G2GhQqtYaww59vZZujLyNZ6O"></script>
<script type="text/javascript">
    //创建和初始化地图函数：
    function initMap(){
        createMap();//创建地图
        setMapEvent();//设置地图事件
        addMapControl();//向地图添加控件
        addMapOverlay();//向地图添加覆盖物
    }
    function createMap(){
        map = new BMap.Map("map");
        map.centerAndZoom(new BMap.Point(104.0628640000,30.5450980000),16);
    }
    function setMapEvent(){
        map.enableScrollWheelZoom();
        map.enableKeyboard();
        map.enableDragging();
        map.enableDoubleClickZoom()
    }
    function addClickHandler(target,window){
        target.addEventListener("click",function(){
            target.openInfoWindow(window);
        });
    }
    function addMapOverlay(){
        var markers = [
            {content:"成都市高新区益州大道中段1800号移动互联创业大厦G5栋301",title:"先讯物联",imageOffset: {width:-46,height:-21},position:{lat:30.5450980000,lng:104.0628640000}},
        ];
        for(var index = 0; index < markers.length; index++ ){
            var point = new BMap.Point(markers[index].position.lng,markers[index].position.lat);
            var marker = new BMap.Marker(point,{icon:new BMap.Icon("http://api.map.baidu.com/lbsapi/createmap/images/icon.png",new BMap.Size(20,25),{
                imageOffset: new BMap.Size(markers[index].imageOffset.width,markers[index].imageOffset.height)
            })});
            var label = new BMap.Label(markers[index].title,{offset: new BMap.Size(25,5)});
            var opts = {
                width: 200,
                title: markers[index].title,
                enableMessage: false
            };
            var infoWindow = new BMap.InfoWindow(markers[index].content,opts);
            marker.setLabel(label);
            addClickHandler(marker,infoWindow);
            map.addOverlay(marker);
        };
    }
    //向地图添加控件
    function addMapControl(){
        var scaleControl = new BMap.ScaleControl({anchor:BMAP_ANCHOR_BOTTOM_LEFT});
        scaleControl.setUnit(BMAP_UNIT_IMPERIAL);
        map.addControl(scaleControl);
        var navControl = new BMap.NavigationControl({anchor:BMAP_ANCHOR_TOP_LEFT,type:BMAP_NAVIGATION_CONTROL_LARGE});
        map.addControl(navControl);
        var overviewControl = new BMap.OverviewMapControl({anchor:BMAP_ANCHOR_BOTTOM_RIGHT,isOpen:true});
        map.addControl(overviewControl);
    }
    var map;
    initMap();
</script>

<?php $this->loadCssOrJs('/home/js/jquery.min.js','js')?>
<?php $this->loadCssOrJs('/static/layer-v1.8.5/layer/layer.min.js', 'js');?>
<?php $this->loadCssOrJs(dirname(__FILE__).'/index.js','script')?>
