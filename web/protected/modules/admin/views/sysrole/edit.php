<div id="urHere"><?php echo Yii::app()->params['mb_nav_first']?><b>&gt;</b><strong>权限管理</strong></div>
<div id="mainBox">
	<h3><a class="actionBtn" href="<?php echo $this->createAbsoluteUrl('sysrole/')?>">返回列表</a>角色信息</h3>
	
	<form action="<?php echo $this->createUrl($this->id.'/'.$this->action->id)?>" class="csx_submit_form">
	<table cellspacing="0" cellpadding="8" border="0" width="100%" class="tableBasic">
		<tbody>
			<tr>
				<td width="100" align="right">角色名称</td>
				<td><input type="text" class="inpMain" size="40" name="name" value="<?php if(isset($data)) echo $data['csc_name']?>"></td>
			</tr>
			<tr>
				<td width="100" align="right">权限信息</td>
				<td><ul>
						<?php foreach($power as $key=>$val):?>
							<li class="li_p">
								<p style="background:#eee;"><?php echo $val['csc_c_arlias']?>:</p>
								<div style="line-height:24px;padding: 10px 0 20px 16px;">
									<?php foreach ($val['item'] as $k=>$v):?>
										<label style="display:inline-block;width:160px;">
											<input type="checkbox" <?php if(isset($cname) && in_array($key.'-'.$k, $cname)):?>checked="checked"<?php endif;?> value="<?php echo $key?>-<?php echo $k?>" name="power_id[]"><?php echo $v?>
										</label>
									<?php endforeach;?>
								</div>
							</li>
						<?php endforeach;?>
					</ul>
				</td>
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
<?php $this->loadCssOrJs('/static/layer-v1.8.5/layer/lib.js', 'js');?>
<?php $this->loadCssOrJs('/static/layer-v1.8.5/layer/layer.min.js', 'js');?>
<?php $this->loadCssOrJs(dirname(__FILE__).'/add.js', 'script')?>