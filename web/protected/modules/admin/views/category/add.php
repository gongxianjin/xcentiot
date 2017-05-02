<!-- 当前位置 -->
<div id="urHere"><?php echo Yii::app()->params['mb_nav_first']?><b>&gt;</b><strong>分类管理</strong></div>
<div id="mainBox">
	<h3><a class="actionBtn" href="<?php echo $this->createUrl("category/index")?>">分类列表</a><?php if($this->action->id=='edit'){echo '编辑分类';}else{echo '添加分类';}?></h3>
	<form method="post" action="<?php echo $this->createUrl($this->id.'/'.$this->action->id)?>" class="csx_submit_form">
	<table cellspacing="0" cellpadding="8" border="0" width="100%" class="tableBasic">
		<tbody>
			<tr>
				<td width="80" align="right">分类名称</td>
				<td><input type="text" class="inpMain" size="40" name="name" <?php if(isset($cate)){echo "value='$cate->csc_name'";}?>></td>
			</tr>
			<tr>
				<td align="right" >分类logo</td>
				<td>
					<input type="text" class="inpMain" size="40" style="visibility:hidden;height:1px;padding:0 5px;"/>
					<input type="hidden" name="logo" value="<?php echo isset($cate)?$cate->csc_logo:''?>"/>
					<div class="simpleUImg noheader">
						<?php if(isset($cate->csc_logo)):?><img width="110" height="110" src="<?php echo $cate->csc_logo?>" alt=""><?php endif;?>
					</div>
				</td>
			</tr>
			<tr>
				<td width="80" align="right">英文描述</td>
				<td><input type="text" class="inpMain" size="40" name="pinyin" <?php if(isset($cate)){echo "value='$cate->csc_pinyin'";}?>></td>
			</tr>
			<tr>
				<td align="right">分类</td>
				<td>
					<input type="text" class="inpMain selectCate" size="40" readonly="readonly" 
						pos="<?php echo $this->createUrl('category/select')?>" title="选择分类" 
						value="<?php echo isset($cate) ? ($cate->parent?$cate->parent->csc_name:'') : ($pcate?$pcate->csc_name:'')?>" placeholder="点击选择分类"/>
					<input type="hidden" name="parent_id" value="<?php echo isset($cate)?$cate->csc_parent_id:($pcate?$pcate->csc_id:0)?>"/>
				</td>
			</tr>
			<tr>
				<td align="right">是否显示</td>
				<td>
					<?php foreach (Yii::app()->params['category_show'] as $k=>$v):?>
					<label class="inpMain"><input type="radio" class="inpMain" name="show" value="<?php echo $k?>" <?php if(isset($cate)&&$cate->csc_show==$k || !isset($cate)&&$k):?>checked="checked"<?php endif;?>><?php echo $v?></label>
					<?php endforeach;?>
					
				</td>
			</tr>
<!--			<tr>
				<td width="80" align="right">是否推荐</td>
				<td>
					<?php /*foreach (Yii::app()->params['category_recom'] as $k=>$v):*/?>
					<label class="inpMain"><input type="radio" class="inpMain" name="recom" value="<?php /*echo $k*/?>" <?php /*if(isset($cate)&&$cate->csc_recom==$k || !isset($cate)&&!$k):*/?>checked="checked"<?php /*endif;*/?>><?php /*echo $v*/?></label>
					<?php /*endforeach;*/?>
				</td>
			</tr>-->
			<tr>
				<td width="80" align="right">分类链接</td>
				<td>
					<input type="text" class="inpMain" size="40" name="link" value="<?php echo isset($cate)?$cate->csc_link:''?>">
				</td>
			</tr>
			<tr>
				<td width="80" align="right">SEO标题</td>
				<td>
					<input type="text" class="inpMain" size="40" name="seo_title" value="<?php echo isset($cate)?$cate->csc_seo_title:''?>">
				</td>
			</tr>
			<tr>
				<td width="80" align="right">SEO关键字</td>
				<td>
					<input type="text" class="inpMain" size="40" name="seo_keywords" value="<?php echo isset($cate)?$cate->csc_seo_keywords:''?>">
				</td>
			</tr>
			<tr>
				<td width="80" align="right">描述</td>
				<td>
					<textarea type="text" class="inpMain" size="40" name="seo_description"  style="margin: 0px; width: 313px; height: 100px;"><?php echo isset($cate)?$cate->csc_seo_description:''?></textarea>
				</td>
			</tr>
			<tr>
				<td align="right">排序</td>
				<td>
					<input type="text" class="inpMain" size="5" name="sort" value="<?php echo isset($cate)?$cate->csc_sort:1?>">
				</td>
			</tr>
			<tr>
				<td></td>
				<td>
					<input type="hidden" name="ids" value="<?php echo isset($cate)?$cate->csc_id:''?>">
					<input type="submit" value="提交" class="btn ajax-post" target-form="csx_submit_form">
					<span class="error"></span>
				</td>
			</tr>
		</tbody>
	</table>
	</form>
</div>
<?php $this->loadCssOrJs('/static/layer-v1.8.5/layer/lib.js', 'js');?>
<?php $this->loadCssOrJs('/static/layer-v1.8.5/layer/layer.min.js', 'js');?>
<?php $this->loadCssOrJs('/static/kindeditor/themes/default/default.css');?>
<?php $this->loadCssOrJs('/static/kindeditor/kindeditor.js', 'js');?>
<?php $this->loadCssOrJs(dirname(__FILE__).'/add.js', 'script')?>

