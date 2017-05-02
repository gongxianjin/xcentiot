<!-- 当前位置 -->
<div id="urHere"><?php echo Yii::app()->params['mb_nav_first']?><b>&gt;</b><strong>有奖留言</strong> </div>
<div id="mainBox">
	<h3><a class="actionBtn" href="<?php echo $this->createUrl("feedback/index")?>">留言列表</a>反馈详情</h3>
	<form method="post" action="<?php echo $this->createUrl($this->id.'/del')?>" class="csx_submit_form">
		<table cellspacing="0" cellpadding="8" border="0" width="100%" class="tableBasic">
			<tbody>
			<tr>
				<td width="100" align="right">来源IP</td>
				<td><span><?php echo $data->csc_guest_ip?></span></td>
			</tr>
			<tr>
				<td width="100" align="right">用户名</td>
				<td><span><?php echo isset($data->user)?$data->user->csc_username:''?></span></td>
			</tr>
			<tr>
				<td width="100" align="right">手机</td>
				<td><?php echo $data->user->csc_phone?></td>
			</tr>
<!--			<tr>-->
<!--				<td width="100" align="right">邮箱</td>-->
<!--				<td>--><?php //echo $data->user->csc_email?><!--</td>-->
<!--			</tr>-->
<!--			<tr>-->
<!--				<td width="100" align="right">公司名称</td>-->
<!--				<td>--><?php //echo $data->user->csc_company?><!--</td>-->
<!--			</tr>-->
<!--			<tr>-->
<!--				<td width="100" align="right">家庭地址</td>-->
<!--				<td>--><?php //echo $data->user->csc_address?><!--</td>-->
<!--			</tr>-->
			<tr>
				<td width="100" align="right">反馈主题</td>
				<td><span><?php echo  $data->csc_subject?></span></td>
			</tr>
			<tr>
				<td width="100" align="right">反馈内容</td>
				<td><span><?php echo  $data->csc_content?></span></td>
			</tr>
			<tr>
				<td width="100" align="right">反馈日期</td>
				<td><span><?php echo $data->csc_create?></span></td>
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
