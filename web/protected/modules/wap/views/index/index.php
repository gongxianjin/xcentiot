<!--<nav id="nav">
    <a style="display:none;"><span></span></a>
    <span style="margin-left: 40%">极客与数学</span>
</nav>-->
<!--<div class="T_topbanner">
    <div class="main_visual">
        <div class="flicking_con">
            <div class="flicking_inner">
            </div>
        </div>
        <div class="main_image">
            <ul>
                <?php /*$this->Widget('Ad', array('pos'=>'wap_banner', 'theme'=>'wp_banner'))*/?>
            </ul>
            <a href="javascript:;" id="btn_prev"></a>
            <a href="javascript:;" id="btn_next"></a>
        </div>
    </div>
</div>-->
<div class="T_topbanner">
    <?php $this->Widget('Ad', array('pos'=>'wap_banner', 'theme'=>'wp_banner','num'=>'1','offset'=>'0'))?>
</div>
<style>
    .t_butbox input{
        height: 40px;
        background-color: #004467;
        display:block;
        width: 100%;
        color: #fff;
        line-height: 28px;
        font-size: 20px;
        text-align: center;
        margin: 50px 0 20px 0px;
        border-radius:6px;
        border:none;
    }
</style>
<form method="post" action="<?php echo $this->createUrl('index/award')?>" onsubmit="return submitform();">
<div class="t_zhuce">
    <div class="xing"><span>姓名：</span><input type="text" placeholder="请输入姓名"  name="name" /></div>
    <div class="xing"><span>电话：</span><input type="text"  id="phonenumber" placeholder="请输入电话"  name="tel"  onblur="javascript:phonenumberBlur(this.value);"/></div>
    <div class="xing"><span>地点：</span><input id="checkMsg" value="--请选择--" readonly  name="type"/>
        <strong></strong>
        <div class="downbox">
            <?php foreach($act_address as $item):?>
            <p><?php echo $item?></p>
            <?php endforeach;?>
        </div>
    </div>
    <div class="t_butbox" style="margin:0;"><input type="submit" value="提 交" ></div>
</div>
</form>
<div class="bottom">
    注：中奖用户请于11月14日—11月20日到指定校区领取礼品。逾期自动作废。
</div>


<?php $this->loadCssOrJs(dirname(__FILE__).'/index.js','script')?>


<div class="z-dcc">
    <div class="z-dcccon" style="height:60px;">
        <dl>
            <span class="z-dcc1"></span>
            <span class="z-dcc2" style="color:green;">确定</span>
        </dl>
    </div>
</div>