<script type="text/javascript">
    //下拉菜单
    function ShowMenu(obj,noid){
        var block = document.getElementById(noid);
        var n = noid.substr(noid.length-1);
        if(noid.length==4){
            var ul = document.getElementById(noid.substring(0,3)).getElementsByTagName("ul");
            var h2 = document.getElementById(noid.substring(0,3)).getElementsByTagName("h2");
            for(var i=0; i<h2.length;i++){
                h2[i].innerHTML = h2[i].innerHTML.replace("+","-");
                h2[i].style.color = "";
            }
            //obj.style.color = "#FF0000";
            for(var i=0; i<ul.length; i++){if(i!=n){ul[i].className = "no";}}
        }else{
            var span = document.getElementById("menu").getElementsByTagName("span");
            var h1 = document.getElementById("menu").getElementsByTagName("h1");
            for(var i=0; i<h1.length;i++){
                h1[i].innerHTML = h1[i].innerHTML.replace("+","-");
                h1[i].style.color = "";
            }
            //obj.style.color = "#0000FF";
        for(var i=0; i<span.length; i++){if(i!=n){span[i].className = "no";}}
        }
        if(block.className == "no"){
            block.className = "";
            obj.innerHTML = obj.innerHTML.replace("-","+");
        }else{
            block.className = "no";
            obj.style.color = "";
        }
    }
    //-->
</script>
<div class="section_left_name"><?php echo $cate_name?></div>
<div id="menu">
<?php foreach($father as $k=>$v){?>
    <h1 onClick="javascript:ShowMenu(this,'NO<?php echo $k?>')"> <tt class="menu_navname f_l"><?php echo $v->csc_name?></tt>       <tt class="pot f_r">></tt></h1>
    <span id="NO<?php echo $k?>" class="no">
    <?php foreach($son[$k] as $key=>$value){?>
        <a href="<?php echo Yii::app()->createUrl('liucheng/inside' , array('cid'=>$value->csc_id))?>"><h2 onClick="javascript:ShowMenu(this,'NO<?php echo $k?><?php echo $key?>')"> <tt class="menu_navname f_l"><?php echo $value->csc_name?></tt>       <tt class="pot f_r">></tt></h2></a>
    <?php }?>
    </span>
<?php }?>
</div>