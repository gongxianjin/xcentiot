<!-- 当前位置 -->
<div id="urHere"><?php echo Yii::app()->params['mb_nav_first']?><b>&gt;</b><strong>设置</strong></div>
<div id="mainBox">
	<h3>热门关键词</h3>
	<form method="post" action="<?php echo $this->createUrl($this->id.'/'.$this->action->id)?>" class="csx_submit_form">
	<table cellspacing="0" cellpadding="8" border="0" width="100%" class="tableBasic">
		<tbody>
			<tr>
				<td width="80" align="right">热门关键词</td>
				<td>
					<textarea class="inpMain" style="width:420px;height:240px;resize: none;" name="hot_word"><?php echo $gethot?></textarea>
				</td>
			</tr>
			<tr>
				<td></td>
				<td>
					<input type="submit" value="提交" class="btn ajax-post" target-form="csx_submit_form">
					<span class="error"></span>
				</td>
			</tr>
		</tbody>
	</table>
	</form>
</div>

