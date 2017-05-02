<div id="urHere">
 <?php echo Yii::app()->params['mb_nav_first']?><b>&gt;</b><strong>文章列表</strong>
</div>
<div id="mainBox">
    <h3>
        <a class="actionBtn" href="<?php echo $this->createUrl("article/index")?>">文章列表</a><?php if($this->action->id=='edit'){echo '编辑文章';}else{echo '添加文章';}?>
    </h3>
    <form enctype="multipart/form-data" method="post" action="<?php echo $this->createUrl($this->id.'/'.$this->action->id)?>" class="csx_submit_form">
        <table cellspacing="0" cellpadding="8" border="0" width="100%" class="tableBasic" id="form">
            <tbody>
            <tr>
                <td width="90" align="right">文章名称</td>
                <td>
                    <input type="text" class="inpMain" name="name" size="80" value="<?php echo isset($faq)?$faq->csc_name:''?>"/>
                </td>
            </tr>
            <tr>
                <td width="90" align="right">文章副标题</td>
                <td>
                    <input type="text" class="inpMain" name="subtitle" size="150" value="<?php echo isset($faq)?$faq->csc_subtitle:''?>"/>
                </td>
            </tr>
            <tr>
                <td align="right">文章分类</td>
                <td>
                    <input type="text" class="inpMain selectCate" size="40" readonly="readonly"
					pos="<?php echo $this->createUrl('category/select')?>" title="选择分类" 
					value="<?php 
						if(isset($faq) && isset($cate)){
							foreach($cate as $v){
								if($v->csc_id==$faq->csc_cate_id){
									echo $v->csc_name;
								}
							}
						}
					?>" placeholder="点击选择分类"/>
				<input type="hidden" name="cate_id" value="<?php echo  isset($faq)?$faq->csc_cate_id:''?>"/>
                </td>
            </tr>
            <!--<tr>
                <td align="right">城市选择</td>
                <td>
                    <select id="provice" class="wby2">

                        <option value="0">省份</option>
                        <?php /*if(isset($pca)) foreach($pca as $item):*/?>
                            <option <?php /*if($sf->csc_id==$item->csc_id):*/?>selected="selected"<?php /*endif;*/?>  value="<?php /*echo $item->csc_id*/?>"><?php /*echo $item->csc_name*/?></option>
                        <?php /*endforeach;*/?>

                    </select>

                    <select id="city" name="city" class="wby2">
                        <option>城市</option>
                        <option <?php /*if(isset($city)&&!empty($city)):*/?>selected="selected" value="<?php /*echo $city->csc_id*/?>" <?php /*endif;*/?>><?php /*echo $city->csc_name */?></option>
                        <?php /*if(isset($citys)): foreach($citys as $item):*/?>
                            <option <?php /*if($city->csc_id==$item->csc_id):*/?>selected="selected"<?php /*endif;*/?>  value="<?php /*echo $item->csc_id*/?>"><?php /*echo $item->csc_name*/?></option>
                        <?php /*endforeach;*/?>
                        <?php /*endif;*/?>

                    </select>
                </td>
            </tr>-->
            <tr>
                <td align="right">图片</td>
                <td>
                    <input type="text" class="inpMain" size="40" style="visibility:hidden;height:1px;padding:0 5px;"/>
                    <input type="hidden" name="img" value="<?php echo isset($faq)?$faq->csc_img:''?>"/>
                    <div class="simpleUImg noheader">
                        <?php if(isset($faq->csc_img)):?><img width="110" height="110" src="<?php echo $faq->csc_img?>" alt=""><?php endif;?>
                    </div>
                </td>
            </tr>
            <tr>
                <td width="100" align="right">简介描述</td>
                <!-- editor -->
                <td>
                    <textarea class="editor_id" style="width:700px;height:100px;" name="desc">
                        <?php echo isset($faq)?$faq->csc_desc:''?>
                    </textarea>
                </td>
                <!-- /editor -->
            </tr>
            <tr>
                <td valign="top" align="right">文章内容</td>
                <!-- editor -->
                <td>
                    <textarea class="editor_id" style="width:700px;height:300px;" name="content">
                        <?php echo isset($faq)?$faq->csc_content:''?>
                    </textarea>
                </td>
                <!-- /editor -->
            </tr>
<!--            <tr>
                <td align="right">视频链接</td>
                <td>
                    <input type="text" class="inpMain" name="video" size="100" value='<?php /*echo isset($faq)?$faq->csc_video:""*/?>'>
                </td>
            </tr>-->
            <tr>
                <td align="right">外部链接</td>
                <td>
                    <input type="text" class="inpMain" name="link" size="50" value="<?php echo isset($faq)?$faq->csc_link:''?>">
                </td>
            </tr>
            <tr>
                <td align="right">SEO标题</td>
                <td>
                    <input type="text" class="inpMain" name="seo_title" size="50" value="<?php echo isset($faq)?$faq->csc_seo_title:''?>">
                </td>
            </tr>
            <tr>
                <td align="right">SEO关键字</td>
                <td>
                    <input type="text" class="inpMain" name="seo_keywords" size="50" value="<?php echo isset($faq)?$faq->csc_seo_keywords:''?>">
                </td>
            </tr>
            <tr>
                <td align="right">SEO描述内容</td>
                <td>
                    <input type="text" class="inpMain" name="seo_description" size="50" value="<?php echo isset($faq)?$faq->csc_seo_description:''?>">
                </td>
            </tr>
            <tr>
                <td align="right">排序</td>
                <td>
                    <input type="text" class="inpMain" name="sort" size="50" value="<?php echo isset($faq)?$faq->csc_sort:0?>">
                </td>
            </tr>
            <tr>
                <td align="right">是否推荐</td>
                <td>
                    <?php if($this->action->id=='edit'):?>
                        <?php if($faq->csc_best==0):?>
                            <label class="inpMain"><input name="best" type="radio" value="1"/>推荐</label>
                            <label class="inpMain"><input name="best" type="radio" value="0" checked="checked"/>不推荐 </label>
                        <?php else:?>
                            <label class="inpMain"><input name="best" type="radio" value="1" checked="checked"/>推荐 </label>
                            <label class="inpMain"><input name="best" type="radio" value="0"/>不推荐 </label>
                        <?php endif;?>
                    <?php else:?>
                        <label class="inpMain"><input name="best" type="radio" value="1" />推荐 </label>
                        <label class="inpMain"><input name="best" type="radio" value="0" checked="checked"/>不推荐 </label>
                    <?php endif;?>
                </td>
            </tr>
            <tr>
                <td align="right">是否显示</td>
                <td>
                    <?php if($this->action->id=='edit'):?>
                        <?php if($faq->csc_show==0):?>
                            <label class="inpMain"><input name="show" type="radio" value="1"/>显示</label>
                            <label class="inpMain"><input name="show" type="radio" value="0" checked="checked"/>不显示 </label>
                        <?php else:?>
                            <label class="inpMain"><input name="show" type="radio" value="1" checked="checked"/>显示 </label>
                            <label class="inpMain"><input name="show" type="radio" value="0"/>不显示 </label>
                        <?php endif;?>
                    <?php else:?>
                        <label class="inpMain"><input name="show" type="radio" value="1" />显示 </label>
                        <label class="inpMain"><input name="show" type="radio" value="0" checked="checked"/>不显示 </label>
                    <?php endif;?>
                </td>
            </tr>
            <tr>
                <td width="100" align="right">日期</td>
                <td>
                    <input type="text" class="inpMain laydate laydate-icon" size="17" name="time" value="<?php echo isset($faq)&& $faq->csc_time ?$faq->csc_time :''?>" >
                </td>
             </tr>
            <tr>
                <td></td>
                <td>
                    <input type="hidden" value="<?php echo isset($faq)?$faq->csc_id:''?>" name="ids">
                    <input type="submit" value="提交" class="btn ajax-post" target-form="csx_submit_form">
                    <span class="error"></span>
                </td>
            </tr>
            </tbody>
        </table>
    </form>
</div>



<?php $this->loadCssOrJs('/static/kindeditor/kindeditor.js', 'js');?>
<?php $this->loadCssOrJs('/static/kindeditor/lang/zh_CN.js', 'js');?>
<?php $this->loadCssOrJs('/static/layer-v1.8.5/layer/lib.js', 'js');?>
<?php $this->loadCssOrJs('/static/layer-v1.8.5/layer/layer.min.js', 'js');?>
<?php $this->loadCssOrJs('/static/laydate-v1.1/laydate/laydate.js', 'js');?>
<?php $this->loadCssOrJs(dirname(__FILE__).'/add_editor.js', 'script')?>
<?php $this->loadCssOrJs(dirname(__FILE__).'/add.js', 'script')?>
<?php $this->loadCssOrJs(dirname(__FILE__).'/contact.js', 'script')?>