<div id="urHere"><?php echo Yii::app()->params['mb_nav_first']?><b>&gt;</b><strong>网站管理员</strong></div>
<div id="mainBox">
	<h3><a class="actionBtn" href="<?php echo $this->createAbsoluteUrl('manager/')?>">返回列表</a>网站管理员</h3>
	
	<form action="<?php echo $this->createUrl($this->id.'/'.$this->action->id)?>" class="csx_submit_form">
	<table cellspacing="0" cellpadding="8" border="0" width="100%" class="tableBasic">
		<tbody>
			<tr>
				<td width="100" align="right">用户名</td>
				<td><input type="text" class="inpMain" size="40" name="user_name" 
				<?php if(yii::app()->getController()->getAction()->id =='edit'){echo "value='$user->csc_user' readonly='readonly'";}?>
				></td>
			</tr>
			<tr>
				<td width="100" align="right">姓名</td>
				<td><input type="text" class="inpMain" size="40" name="user_tname" 
				<?php if(yii::app()->getController()->getAction()->id =='edit'){echo "value='$user->csc_tname'";}?>
				></td>
			</tr>
			<tr>
				<td width="100" align="right">手机号码</td>
				<td><input type="text" class="inpMain" size="40" name="phone" 
				<?php if(yii::app()->getController()->getAction()->id =='edit'){echo "value='$user->csc_phone'";}?>
				></td>
			</tr>
			<tr>
				<td align="right">用户组</td>
				<td><select class="inpMain" name="role_id">
						<?php foreach ($sys as $k=>$v):?>
							<option value="<?php echo $v['csc_id']?>" <?php if(isset($user) && $user['csc_role_id']==$v['csc_id']):?>selected="selected"<?php endif;?>><?php echo $v['csc_name']?></option>
						<?php endforeach;?>
					</select></td>
			</tr>
			<tr>
				<td align="right">状态</td>
				<td><select class="inpMain" name="locked">
					<?php foreach (Yii::app()->params['lock'] as $k=>$v):?>
						<option value="<?php echo $k?>" <?php if(yii::app()->getController()->getAction()->id =='edit' && $k==$user->csc_locked):?>selected="selected"<?php endif;?>><?php echo $v?></option>
					<?php endforeach;?>
				</select></td>
			</tr>
			<tr>
				<td align="right">密码</td>
				<td><input type="password" class="inpMain" size="40" name="password"></td>
			</tr>
			<tr>
				<td align="right">确认密码</td>
				<td><input type="password" class="inpMain" size="40" name="password_confirm"></td>
			</tr>
			<tr>
				<td></td>
				<td>
					<input type="hidden" value="<?php echo Yii::app()->request->getParam('ids')?>" name="ids"/> 
					<input type="submit" value="提交" class="btn ajax-post" target-form="csx_submit_form"/>
					<span class="error"></span>
				</td>
			</tr>
		</tbody>
	</table>
	</form>
</div>