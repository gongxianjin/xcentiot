<div id="urHere"><?php echo Yii::app()->params['mb_nav_first']?><b>&gt;</b><strong>网站相关设置</strong></div>
<div id="mainBox">
	<h3>网站相关设置</h3>
	<table cellspacing="0" cellpadding="8" border="0" width="100%" class="tableBasic">
		<tbody>
			<tr>
				<td width="100" align="right">网站标题</td>
				<td><input type="text" class="inpMain" size="40" name="title" value="<?php echo isset($site['title'])?$site['title']:''?>"></td>
			</tr>
			<tr>
				<td align="right">关键词</td>
				<td><input type="text" class="inpMain" size="40" name="keyword" value="<?php echo isset($site['keyword'])?$site['keyword']:''?>"></td>
			</tr>
			<tr>
				<td align="right">描述</td>
				<td>
					<textarea rows="5" cols="50" name="description"><?php echo isset($site['description'])?$site['description']:''?></textarea>
				</td>
			</tr>
			<tr>
				<td align="right">备案</td>
				<td><input type="text" class="inpMain" size="40" name="record" value="<?php echo isset($site['record'])?$site['record']:''?>"></td>
			</tr>
			<tr>
				<td align="right">版权所有</td>
				<td><input type="text" class="inpMain" size="40" name="copy" value="<?php echo isset($site['copy'])?$site['copy']:''?>"></td>
			</tr>
			<tr>
				<td align="right">地址</td>
				<td><input type="text" class="inpMain" size="40" name="address" value="<?php echo isset($site['address'])?$site['address']:''?>"></td>
			</tr>
			<!--<tr>
				<td align="right">校名</td>
				<td><input type="text" class="inpMain" size="40" name="school" value="<?php /*echo isset($site['school'])?$site['school']:''*/?>"></td>
			</tr>-->
			<tr>
				<td align="right">热线</td>
				<td><input type="text" class="inpMain" size="40" name="phone" value="<?php echo isset($site['phone'])?$site['phone']:''?>"></td>
			</tr>
			<!--<tr>
				<td align="right">愿景</td>
				<td><input type="text" class="inpMain" size="40" name="vision" value="<?php /*echo isset($site['vision'])?$site['vision']:''*/?>"></td>
			</tr>
			<tr>
				<td align="right">使命</td>
				<td><input type="text" class="inpMain" size="40" name="mission" value="<?php /*echo isset($site['mission'])?$site['mission']:''*/?>"></td>
			</tr>
			<tr>
				<td align="right">校训</td>
				<td><input type="text" class="inpMain" size="40" name="motto" value="<?php /*echo isset($site['motto'])?$site['motto']:''*/?>"></td>
			</tr>
			<tr>
				<td align="right">价值观</td>
				<td><input type="text" class="inpMain" size="40" name="values" value="<?php /*echo isset($site['values'])?$site['values']:''*/?>"></td>
			</tr>
			<tr>
				<td align="right">口号</td>
				<td><input type="text" class="inpMain" size="40" name="slogan" value="<?php /*echo isset($site['slogan'])?$site['slogan']:''*/?>"></td>
			</tr>
			<tr>
				<td align="right">累计续班率</td>
				<td><input type="text" class="inpMain" size="40" name="crate" value="<?php /*echo isset($site['crate'])?$site['crate']:''*/?>"></td>
			</tr>-->
			<tr>
				<td align="right">邮编</td>
				<td><input type="text" class="inpMain" size="40" name="email" value="<?php echo isset($site['email'])?$site['email']:''?>"></td>
			</tr>
			<tr>
				<td align="right">官方微信</td>
				<td><input type="text" class="inpMain" size="40" name="wechat" value="<?php echo isset($site['wechat'])?$site['wechat']:''?>"></td>
			</tr>
			<tr>
				<td align="right"> 客服热线(|间隔)</td>
				<td><input type="text" class="inpMain" size="80" name="client_phone" value="<?php echo isset($site['client_phone'])?$site['client_phone']:''?>"></td>
			</tr>
			<tr>
				<td align="right"> 客服邮箱(|间隔)</td>
				<td><input type="text" class="inpMain" size="80" name="client_mail" value="<?php echo isset($site['client_mail'])?$site['client_mail']:''?>"></td>
			</tr>
			<!--<tr>
				<td align="right">年级(|间隔)</td>
				<td><?php /*$gd_type = $site['gd_type'];*/?>
					<textarea rows="5" cols="50" name="gd_type"><?php /*if($gd_type):*/?><?php /*foreach($gd_type as $k=>$v):$count = count($gd_type);*/?><?php /*echo $v;*/?><?php /*if($k+1 != $count):*/?><?php /* echo '|';*/?><?php /*endif;*/?><?php /*endforeach;*/?><?php /*endif;*/?></textarea>
				</td>
			</tr>
			<tr>
				<td align="right">活动地点(|间隔)</td>
				<td><?php /*$act_address = $site['act_address'];*/?>
					<textarea rows="5" cols="50" name="act_address"><?php /*if($act_address):*/?><?php /*foreach($act_address as $k=>$v):$count = count($act_address);*/?><?php /*echo $v;*/?><?php /*if($k+1 != $count):*/?><?php /* echo '|';*/?><?php /*endif;*/?><?php /*endforeach;*/?><?php /*endif;*/?></textarea>
				</td>
			</tr>-->
			<tr>
				<td></td>
				<td>
					<input type="submit" value="提交" pos="<?php echo $this->createUrl($this->id.'/'.$this->action->id)?>" class="btn ajax-post" target-form="csx_submit_form"/>
					<span class="error"></span>
				</td>
			</tr>
		</tbody>
	</table>
</div>
<?php $this->loadCssOrJs('/static/kindeditor/themes/default/default.css');?>
<?php $this->loadCssOrJs('/static/kindeditor/kindeditor.js', 'js');?>
<?php $this->loadCssOrJs('/static/kindeditor/lang/zh_CN.js', 'js');?>
<?php $this->loadCssOrJs('/admin/js/jquery.min.js', 'js');?>
<?php $this->loadCssOrJs('/static/jquery.SuperSlide.2.1.1.js', 'js');?>
<?php $this->loadCssOrJs('/home/js/common.js', 'js');?>
<?php $this->loadCssOrJs('/home/js/jquery.lhPublic.js', 'js');?>
<?php $this->loadCssOrJs(dirname(__FILE__).'/index.js', 'script')?>

