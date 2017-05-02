<!-- 当前位置 -->
		<div id="urHere"><?php echo Yii::app()->params['mb_nav_first']?><b>&gt;</b><strong>广告管理</strong> </div>
		<div id="mainBox">
            <h3><a class="actionBtn" href="<?php echo $this->createUrl("ad/index")?>">广告列表</a><?php if($this->action->id=='edit'){echo '编辑广告';}else{echo '添加广告';}?></h3>
    <form method="post" action="<?php echo $this->createUrl($this->id.'/'.$this->action->id)?>" class="csx_submit_form">
     <table cellspacing="0" cellpadding="8" border="0" width="100%" class="tableBasic" id="form">
      <tbody>

      <tr>
			<td width="100" align="right">广告名称</td>
			<td><input type="text" class="inpMain" size="40" name="name" value="<?php echo isset($ad)&& $ad->csc_name ? $ad->csc_name :''?>" ></td>
			
			<td width="100" align="right">广告位</td>
			<td>
				<input id="pos_name" type="text" class="inpMain selectCate" size="40" readonly="readonly"
	       			pos="<?php echo $this->createUrl('adpos/select')?>" title="选择广告位"
	       			value="<?php echo isset($ad)?$ad->pos->csc_name :''?>" placeholder="点击选择广告位"/>
				<input type="hidden" name="pos_id" value="<?php echo isset($ad)?$ad->csc_pos_id:''?>"/>
			</td>
	  </tr>
	  <tr>
			<td width="100" align="right">投放日期</td>
			<td>
			<input type="text" class="inpMain laydate laydate-icon" size="17" name="begin_time" value="<?php echo isset($ad)&& $ad->csc_begin_time ?$ad->csc_begin_time :''?>" >&nbsp;~&nbsp;
			<input type="text" class="inpMain laydate laydate-icon" size="17" name="end_time" value="<?php echo isset($ad)&& $ad->csc_end_time ?$ad->csc_end_time :''?>" >
			</td>
			
			<td width="100" align="right">广告链接</td>
			<td><input type="text" class="inpMain" size="40" name="url" value="<?php echo isset($ad)&& $ad->csc_url ?$ad->csc_url :'/'?>" ></td>
	  </tr>
	  <tr>
			<td width="100" align="right">类型</td>
			<td>
				<select name="type">
				<?php foreach (Yii::app()->params['ad_type'] as $key=>$val):?>
					<option value="<?php echo $key?>" <?php if(isset($ad) && $ad->csc_type==$key):?>selected="selected"<?php endif;?>><?php echo $val?></option>
				<?php endforeach;?>
				</select>
			</td>
	  </tr>
	  <tr class="ad_meta">
			<td width="100" align="right">图片</td>
			<td colspan="3">
				<div class="simpleUImg <?php echo isset($ad) && $ad->csc_img?'header':'noheader'?>" style="width:98%;"><?php if(isset($ad) && $ad->csc_img):?><img width="108" src="<?php echo $ad->csc_img?>" alt=""/><?php endif;?></div>
				<input type="hidden" name="img" value="<?php echo isset($ad)?$ad->csc_img:''?>"/>
				<input type="text" class="inpMain" name="img_url" value="<?php echo isset($ad)?$ad->csc_img_url:''?>" size="40" placeholder="图片链接: http://"/>
			</td>
	  </tr>
	  <tr class="ad_meta">
			<td width="100" align="right">Flash</td>
			<td colspan="3">
				<input value=" +上传附件 " id="simpleUFlash"/>
				<div class="simpleUFlash <?php echo (isset($ad) && $ad->csc_flash)?'sflash':'nosflash'?>"><?php if(isset($ad) && $ad->csc_flash):?>
					<embed height="100" border="0" align="middle" wmode="opaque" src="<?php echo $ad->csc_flash?>">
				<?php endif;?></div>
				<input type="hidden" name="flash" value="<?php echo isset($ad)?$ad->csc_flash:''?>"/>
				<input type="text" class="inpMain" name="flash_url" value="<?php echo isset($ad)?$ad->csc_flash_url:''?>" size="40" placeholder="flash链接: http://"/>
			</td>
	  </tr>
	  <tr class="ad_meta">
			<td width="100" align="right">代码</td>
			<td colspan="3">
				<input type="text" class="inpMain" name="code" size="40" value="<?php echo isset($ad)?$ad->csc_code:''?>"/>
			</td>
	  </tr>
	  <tr class="ad_meta">
			<td width="100" align="right">文字</td>
			<td colspan="3">
				<input type="text" class="inpMain" name="text" size="40" value="<?php echo isset($ad)?$ad->csc_text:''?>"/>
			</td>
	  </tr>
	  
	  
	  
	  <tr>
			<td width="100" align="right">是否显示</td>
			<td>
				<label class="inpMain"><input name="show" type="radio" value="1" checked="checked"/>显示 </label>
				<label class="inpMain"><input name="show" type="radio" value="0"/>不显示 </label>
			</td>
			<td width="100" align="right">排序</td>
			<td><input type="text" class="inpMain" size="40" name="sort" value="<?php echo isset($ad)&& $ad->csc_sort ?$ad->csc_sort : 0?>" ></td>
	  </tr>
	  <tr>
			<td width="100" align="right">联系人</td>
			<td><input type="text" class="inpMain" size="40" name="contactor" value="<?php echo isset($ad) && $ad->csc_contactor ?$ad->csc_contactor :''?>" ></td>
			
			<td width="100" align="right">邮箱</td>
			<td><input type="text" class="inpMain" size="40" name="email" value="<?php echo isset($ad)&& $ad->csc_email ?$ad->csc_email :''?>" ></td>
	  </tr>
	  <tr>
			<td width="100" align="right">电话</td>
			<td><input type="text" class="inpMain" size="40" name="phone" value="<?php echo isset($ad)&& $ad->csc_phone ?$ad->csc_phone :''?>" ></td>
			
			
	  </tr>
      
      <tr>
       <td></td>
       <td>
       <input type="hidden" name="ids" value="<?php echo isset($ad)&& $ad->csc_id ?$ad->csc_id :''?>" >
        <input type="submit" value="提交" class="btn ajax-post" target-form="csx_submit_form">
        <span class="error"></span>
       </td>
      </tr>
     </tbody></table>
    </form>
  </div>

<?php $this->loadCssOrJs('/static/kindeditor/themes/default/default.css');?>
<?php $this->loadCssOrJs('/static/kindeditor/kindeditor.js', 'js');?>
<?php $this->loadCssOrJs('/static/layer-v1.8.5/layer/lib.js', 'js');?>
<?php $this->loadCssOrJs('/static/layer-v1.8.5/layer/layer.min.js', 'js');?>
<?php $this->loadCssOrJs('/static/laydate-v1.1/laydate/laydate.js', 'js');?>
<?php $this->loadCssOrJs(dirname(__FILE__).'/add.js', 'script')?>

