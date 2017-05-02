<!-- 当前位置 -->
<div id="urHere"><?php echo Yii::app()->params['mb_nav_first']?><b>&gt;</b><strong>测试结果</strong> </div>
<div id="mainBox">
	<h3><a class="actionBtn" href="<?php echo $this->createUrl("examlog/index")?>">测试结果列表</a>反馈详情</h3>
	<form method="post" action="<?php echo $this->createUrl($this->id.'/del')?>" class="csx_submit_form">
		<table cellspacing="0" cellpadding="8" border="0" width="100%" class="tableBasic">
			<tbody>
			<tr>
				<td width="100" align="right">姓名</td>
				<td><span><?php echo $data->csc_name?></span></td>
			</tr>
			<tr>
				<td width="100" align="right">年级</td>
				<td><span><?php echo $data->csc_class?></span></td>
			</tr>
			<tr>
				<td width="100" align="right">联系方式</td>
				<td><?php echo $data->csc_contact?></td>
			</tr>
			<tr>
				<td width="100" align="right">科目</td>
				<td><?php echo $data->info->csc_name?></td>
			</tr>
<!--			<tr>-->
<!--				<td width="100" align="right">公司名称</td>-->
<!--				<td>--><?php //echo $data->user->csc_company?><!--</td>-->
<!--			</tr>-->
<!--			<tr>-->
<!--				<td width="100" align="right">家庭地址</td>-->
<!--				<td>--><?php //echo $data->user->csc_address?><!--</td>-->
<!--			</tr>-->
			<tr>
				<td width="100" align="right">答题记录（题目编号-答案-标准答案）</td>
				<td><span><?php echo  $data->csc_record?></span></td>
			</tr>
			<tr>
				<td></td>
				<td>
					<input type="hidden" name="ids" value="<?php echo isset($data)&& $data->csc_id ?$data->csc_id :''?>" >
					<input type="submit" value="删除" class="btn ajax-post" target-form="csx_submit_form">
					<span class="error"></span>
				</td>
			</tr>
			</tbody>
		</table>
	</form>
</div>
