<div id="urHere"><?php echo Yii::app()->params['mb_nav_first']?><b>&gt;</b><strong>店铺管理</strong></div>
<div id="mainBox">
	<h3><a class="actionBtn" href="<?php echo $this->createAbsoluteUrl('store/')?>">返回列表</a>店铺详情</h3>
	
	<form action="<?php echo $this->createUrl($this->id."/verify")?>" class="csx_submit_form">
	<?php if($store->csc_logo):?><img src="<?php echo $store->csc_logo?>"/><?php endif;?>
	<table cellspacing="0" cellpadding="8" border="0" width="100%" class="tableBasic">
		<tbody>
			<tr>
				<td width="100" align="right">店铺名称</td>
				<td><input type="text" class="inpMain" size="40" name="user_name " value="<?php echo $store->csc_name?>" readonly='readonly'></td>
				
				<td width="100" align="right">店主姓名</td>
				<td><input type="text" class="inpMain" size="40" name="user_tname " value="<?php echo $store->csc_store_name?>" readonly='readonly'></td>
			</tr>
			<tr>
				<td width="100" align="right">店铺电话</td>
				<td><input type="text" class="inpMain" size="40" name="user_name " value="<?php echo $store->csc_store_phone?>" readonly='readonly'></td>
				
				<td width="100" align="right">店铺信用值</td>
				<td><input type="text" class="inpMain" size="40" name="user_tname " value="<?php echo $store->csc_grate?>" readonly='readonly'></td>
			</tr>
			
			<tr>
				<td width="100" align="right">店铺地址</td>
				<td><input type="text" class="inpMain" size="40" name="user_name " value="<?php echo $store->csc_region?>" readonly='readonly'></td>
				
				<td width="100" align="right">店铺详情地址</td>
				<td><input type="text" class="inpMain" size="40" name="user_tname " value="<?php echo $store->csc_address?>" readonly='readonly'></td>
			</tr>
			
			<tr>
				<td width="100" align="right">好评率</td>
				<td><input type="text" class="inpMain" size="40" name="user_name " value="<?php echo $store->csc_grate?>" readonly='readonly'></td>
				
				<td width="100" align="right">评论总数</td>
				<td><input type="text" class="inpMain" size="40" name="user_tname " value="<?php echo $store->csc_com_num?>" readonly='readonly'></td>
			</tr>
			
			<tr>
				<td width="100" align="right">店铺信用值</td>
				<td><input type="text" class="inpMain" size="40" name="user_name " value="<?php echo $store->csc_credit?>" readonly='readonly'></td>
				
				<td width="100" align="right">店铺二级域名</td>
				<td><input type="text" class="inpMain" size="40" name="user_tname " value="<?php echo $store->csc_domain?>" readonly='readonly'></td>
			</tr>
			
			<tr>
				<td width="100" align="right">店铺审核状态</td>
				<td><input type="text" class="inpMain" size="40" name="user_name " <?php if($store->csc_state==0){echo "style='color:red;' value='未审核'";}else{echo "value='已审核'";}?> readonly='readonly'></td>
				
				<td width="100" align="right">店铺认证信息</td>
				<td><input type="text" class="inpMain" size="40" name="user_tname " value="<?php if($store->csc_certification==1){echo '实名认证';}elseif($store->csc_certification==2){echo '手机认证';}?>" readonly='readonly'></td>
			</tr>
			
			<tr>
				<td width="100" align="right">营业执照</td>
				<td><input type="hidden" class="inpMain" size="40" name="user_name " value="<?php echo $store->csc_certify_yyzz?>" readonly='readonly'>
					<?php if(isset($store->csc_certify_yyzz)):?><a class="inpMain" href="<?php echo $store->csc_certify_yyzz?>">点击查看</a><?php endif;?>
				</td>
				
				<td width="100" align="right">店铺信息变更日期</td>
				<td><input type="text" class="inpMain" size="40" name="user_tname " value="<?php echo $store->csc_mcreate?>" readonly='readonly'></td>
			</tr>
			
			<tr>
				<td width="100" align="right">排序数字</td>
				<td><input type="text" class="inpMain" size="40" name="user_name " value="<?php echo $store->csc_sort?>" readonly='readonly'></td>
				
				<td width="100" align="right">店铺推荐</td>
				<td><input type="text" class="inpMain" size="40" name="user_tname " value="<?php echo $store->csc_recomm?>" readonly='readonly'></td>
			</tr>
			
			<tr>
				<td width="100" align="right">身份证</td>
				<td><input type="hidden" class="inpMain" size="40" name="user_name " value="<?php echo $store->csc_certify_sfz?>" readonly='readonly'>
					<?php if(isset($store->csc_certify_sfz)):?><a class="inpMain" href="<?php echo $store->csc_certify_sfz?>">点击查看</a><?php endif;?>
				</td>
				
				<td width="100" align="right">组织机构</td>
				<td><input type="hidden" class="inpMain" size="40" name="user_tname " value="<?php echo $store->csc_certify_zzjg?>" readonly='readonly'>
					<?php if(isset($store->csc_certify_zzjg)):?><a class="inpMain" href="<?php echo $store->csc_certify_zzjg?>">点击查看</a><?php endif;?>
				</td>
			</tr>
			
			<tr>
				<td width="100" align="right">创建时间</td>
				<td colspan=""><input type="text" class="inpMain" size="40" name="user_name " value="<?php echo $store->csc_create?>" readonly='readonly'></td>
				
				<td width="100" align="right">店铺描述</td>
				<td><input type="text" class="inpMain" size="40" name="user_tname " value="<?php echo $store->csc_desc?>" readonly='readonly'></td>
			</tr>
			
			<tr>
				<td>&nbsp;</td>
				<td colspan="3">
					<input type="hidden" value="<?php echo Yii::app()->request->getParam('ids')?>" name="ids"/> 
					<?php if($store->csc_state==0){?>
					<input type="submit"  class="btn ajax-post" target-form="csx_submit_form" style='background-color:green;' value='审核'/>
					<?php }else{?>
					<input type="submit"  class="btn ajax-post" target-form="csx_submit_form" style='background-color:red;' value='已审核'/>
					<?php }?>
					<a class="btn" href="<?php echo $this->createUrl('store/index')?>">返回</a>
					<span class="error"></span>
				</td>
				
			</tr>
		</tbody>
	</table>
	</form>
</div>