<!-- 内页 -->
<div class="z-row z-sBrief">
    <div class="z-container">
        <h2><?php echo $article->csc_name?></h2>
        <?php echo $article->csc_desc?>
    </div>
</div>
<div class="z-row z-BriefNav z-BriefNav2">
    <div class="z-container"><a href="<?php echo $this->createUrl('/site');?>">首页</a>&gt;<a href="<?php echo $this->createUrl('site/detail',array('cid'=>'1'));?>">极客学</a> </div>
</div>
<div class="z-container z-details">
    <div class="z-detailsC">
        <?php echo $article->csc_content?>
        <!-- 分享 S -->
        <div class="z-row z-shaer">
            <ul>
                <li class="z-share1"><a class="jiathis_button_tsina"></a></li>
                <li class="z-share2"><a class="jiathis_button_weixin"></a></li>
                <li class="z-share3"><a class="jiathis_button_cqq"></a></li>
                <li class="z-share4"><a class="jiathis_button_tieba"></a></li>
            </ul>
            <!-- JiaThis Button BEGIN -->
            <script type="text/javascript" src="http://v3.jiathis.com/code/jia.js" charset="utf-8"></script>
            <!-- JiaThis Button END -->
        </div>
        <!-- 分享 E -->
    </div>
</div>