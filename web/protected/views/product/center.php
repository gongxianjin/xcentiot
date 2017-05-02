<!-- conttent -->
<div class="z_allContainer z_written">
    <div class="z_container z_wtBox">
        <!-- left -->
        <div class="z_wtL">
            <dt class="z_wtTitle"><span class="active"><?php echo $sword?></span></dt>

            <div class="z_wtsT"><?php echo $result->csc_name?></div>
            <?php if($result->csc_img):?><div><img src="<?php echo $result->csc_img?>" /></div><?php endif;?>
            <?php echo $result->csc_content?>
            <a href="<?php echo Yii::app()->createUrl('news/index',array('cid'=>'91'));?>" >MORE >></a>

            <div class="z_kczs">
                <ul>
                    <?php if(isset($article)) foreach($article as $key=>$v):?>
                        <?php if(isset($v)&&$v!=null):?>
                        <li>
                            <a href="<?php echo Yii::app()->createUrl('news/detail',array('id'=>$v->csc_id))?>">
                                <div class="z_kczsL">
                                    <?php  if($v->csc_img):?><img src="<?php echo $v->csc_img?>" alt="<?php echo $v->csc_name?>"><?php endif;?>
                                </div>
                                <div class="z_kczsR">
                                    <dt><?php  if(isset($v)&&$v!=null) echo $v->csc_name?></dt>
                                    <p><?php  if(isset($v)&&$v!=null) echo mb_substr($v->csc_content,0,100,'utf-8')?></p>
                                    <span><?php if(isset($v)&&$v!=null) echo date('Y-m-d',strtotime($v->csc_create))?></span>
                                </div>
                            </a>
                        </li>
                        <?php endif;?>
                    <?php endforeach;?>
                </ul>
            </div>

            <div class="z_kczs">
                <ul>
                    <?php if(isset($articles)) foreach($articles as $key=>$item):?>
                        <li>
                            <a href="<?php echo Yii::app()->createUrl('news/detail',array('id'=>$item->csc_id))?>">
                                <div class="z_kczsL">
                                    <img src="<?php echo $item->csc_img?>" alt="<?php echo $item->csc_name?>">
                                </div>
                                <div class="z_kczsR">
                                    <dt><?php echo $item->csc_name?></dt>
                                    <p><?php echo $item->csc_desc?></p>
                                    <span><?php echo date('Y-m-d',strtotime($item->csc_create))?></span>
                                </div>
                            </a>
                        </li>
                    <?php endforeach;?>
                </ul>
                <div class="z_peags">
                    <?php $this->widget('Pager',array(
                        'firstPageLabel'=>'首页',
                        'lastPageLabel'=>'末页',
                        'prevPageLabel'=>'上一页',
                        'nextPageLabel'=>'下一页',
                        'pages'=>$pages,
                        'maxButtonCount'=>8,
                        'header'=>'记录总数：'.$pages->itemCount.'&nbsp;&nbsp;',
                    ))?>
                </div>
            </div>

        </div>
        <!-- right -->
        <div class="z_wtR">

            <div class="z_wtNav">
                <ul>
                    <li class="active"  class="z_returnHome"><a href="/">返回首页</a></li>
                </ul>
            </div>

            <dl class="z_wtRcon">
                <dt class="z_wtRt"><span><a href="#">院系专业</a></span><a href="#">更多>></a></dt>
                <div class="wtRcon z_major z_major0">
                    <a href="#"><img src="./images/t002.png" alt=""></a>
                    <dt><a href="#">工商管理专业</a></dt>
                    <p>本专业以市场、行业需求为导向根据
                        岗位群需求，面向美与健康生活服务
                        产业和国内中小型...</p>
                    <div class="z_majorOC0"></div>
                </div>
                <div class="wtRcon z_major z_major1">
                    <a href="#"><img src="./images/t002.png" alt=""></a>
                    <dt><a href="#">工商管理专业</a></dt>
                    <p>本专业以市场、行业需求为导向根据
                        岗位群需求，面向美与健康生活服务
                        产业和国内中小型...</p>
                    <div class="z_majorOC1"></div>
                </div>
                <div class="wtRcon z_major z_major2">
                    <a href="#"><img src="./images/t002.png" alt=""></a>
                    <dt><a href="#">工商管理专业</a></dt>
                    <p>本专业以市场、行业需求为导向根据
                        岗位群需求，面向美与健康生活服务
                        产业和国内中小型...</p>
                    <div class="z_majorOC2"></div>
                </div>
            </dl>

            <dl class="z_wtRcon">
                <dt class="z_wtRt"><span><a href="#">师资力量</a></span><a href="#">更多>></a></dt>
                <div class="wtRcon z_teacher">
                    <ul>
                        <li class="btnHover z_teacher1">
                            <a href="#">
                                <img src="./images/th1.png" alt="">
                                <div class="z_teacherN">
                                    <dt>黄平平</dt>
                                    <p>工商管理系</p>
                                </div>
                            </a>
                        </li>
                        <li class="btnHover z_teacher1">
                            <a href="#">
                                <img src="./images/th2.png" alt="">
                                <div class="z_teacherN">
                                    <dt>马经义</dt>
                                    <p>工商管理系</p>
                                </div>
                            </a>
                        </li>
                    </ul>
                </div>
            </dl>

            <div class="z_wtRcon z_tv">
                <dt>最新视频</dt>
                <div class="auotVideo">
                    <embed src="http://www.tudou.com/v/xB3vR6bxp4w/&autoPlay=false&JSEnabled=true/v.swf"autostart="true" allowFullScreen="true" quality="high" width="320" height="185" align="middle" allowScriptAccess="always" type="application/x-shockwave-flash">
                    </embed>
                </div>
            </div>
        </div>
    </div>

    <!-- 弹出层 -->
    <div class="z_teacherD">
        <div class="z_container z_teacherDC">
            <div class="z_tccTop"></div>
            <div class="z_coloseTh"><span>colse</span></div>
            <div class="z_thcon">

                <div class="z_teacherImg">
                    <div class="ladyScroll ladyScroll03">
                        <a class="prev" href="javascript:void(0)"></a>
                        <div class="scrollWrap">
                            <div class="dlList">

                                <dl>
                                    <div class="z_teacherImg1">
                                        <div class="z_teacherImg2">
                                            <img src="images/th5.png">
                                        </div>
                                    </div>
                                </dl>

                                <dl>
                                    <div class="z_teacherImg1">
                                        <div class="z_teacherImg2">
                                            <img src="images/b2.jpg">
                                        </div>
                                    </div>
                                </dl>

                            </div>
                        </div>
                        <a class="next" href="javascript:void(0)"></a>
                    </div>
                </div>

                <div class="z_tjs">
                    <div class="z_tjsL"><div><div>吴杉</div></div></div>
                    <div class="z_tjsR">
                        <p>投资理财专业助教，毕业于英国艾克赛特大学，货币与银行专业硕士，现教授《资金运营》、《财务管理》、《财务会计》、《财务软件综合运用》等课程。</p>
                        <h3>企业及行业经历：</h3>
                        <p>曾任职于中国银行四川省分行投资部门和国际结算部门，有丰富的实践经验。</p>
                        <h3>个人成就：</h3>
                        <p>2013年参编教材《金融学》，已出版并用于教学使用</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- 弹出层 end -->
</div>

<!-- conttent End -->


