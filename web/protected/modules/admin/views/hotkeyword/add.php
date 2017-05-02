<!-- 当前位置 -->
<div id="urHere"><?php echo Yii::app()->params['mb_nav_first']?><b>&gt;</b><strong>添加搜索词</strong></div>
<div id="mainBox">
	<h3><a class="actionBtn" href="<?php echo $this->createUrl("hotkeyword/index")?>">搜索词列表</a><?php if($this->action->id=='edit'){echo '编辑搜索词';}else{echo '添加搜索词';}?></h3>
	<form method="post" action="<?php echo $this->createUrl($this->id.'/'.$this->action->id)?>" class="csx_submit_form">
	<table cellspacing="0" cellpadding="8" border="0" width="100%" class="tableBasic">
		<tbody>
			<tr>
				<td width="80" align="right">关键词名称</td>
				<td><input type="text" class="inpMain" size="40" name="name" <?php if(isset($cate)){echo "value='$cate->csc_name'";}?>></td>
			</tr>
			<tr>
				<td align="right">类型</td>
				<td>
					<select name="type">
						<option value="sumar">超市</option>
						<option value="group">都京团</option>
						<option value="greens">网上菜市</option>
						<option value="appliances">家电城</option>
						<option value="clothing">服装城</option>
						<option value="decoration">家装城</option>
					</select>
				</td>
			</tr>
			<tr>
				<td></td>
				<td>
					<input type="hidden" name="ids" <?php if(isset($cate)){echo "value='$cate->csc_id'";}?>>
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
<?php $this->loadCssOrJs(dirname(__FILE__).'/add.js', 'script')?>

