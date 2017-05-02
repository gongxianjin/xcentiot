<!-- 当前位置 -->
		<div id="urHere"><?php echo Yii::app()->params['mb_nav_first']?><b>&gt;</b><strong>广告位管理</strong> </div>
		<div id="mainBox">
            <h3><a class="actionBtn" href="<?php echo $this->createUrl("adpos/index")?>">广告位列表</a><?php if($this->action->id=='edit'){echo '编辑广告位';}else{echo '添加广告位';}?></h3>
    <form method="post" action="<?php echo $this->createUrl($this->id.'/'.$this->action->id)?>" class="csx_submit_form">
     <table cellspacing="0" cellpadding="8" border="0" width="100%" class="tableBasic">
      <tbody>
       <tr>
       <td width="80" align="right">ID</td>
       <td>
        <input type="text" class="inpMain" size="40" name="id" <?php if($this->action->id=='edit'){echo "value='$adpos->csc_id' readonly";}?>>
       </td>
      </tr>
      <tr>
       <td width="80" align="right">广告位名称</td>
       <td>
        <input type="text" class="inpMain" size="40" name="name" <?php if($this->action->id=='edit'){echo "value='$adpos->csc_name'";}?>>
       </td>
      </tr>
      <tr>
       <td width="80" align="right">宽度</td>
       <td>
        <input type="text" class="inpMain" size="20" name="width" <?php if($this->action->id=='edit'){echo "value='$adpos->csc_width'";}?>>
       </td>
      </tr>
	<tr>
		<td align="right">高度</td>
		<td>
			<input type="text" class="inpMain" size="20"  name="height" <?php if($this->action->id=='edit'){echo "value='$adpos->csc_height'";}?>>
		</td>
	</tr>
      
      <tr>
       <td align="right">描述</td>
      		<td>
      		 <input type="text" class="inpMain" size="60"  name="desc" <?php if($this->action->id=='edit'){echo "value='$adpos->csc_desc'";}?>>
			</td>
		</tr>
      <tr>
       <td></td>
       <td>
       <input type="hidden" name="ids" <?php if($this->action->id=='edit'){echo "value='$adpos->csc_id'";}?> >
        <input type="submit" value="提交" class="btn ajax-post" target-form="csx_submit_form">
        <span class="error"></span>
       </td>
      </tr>
     </tbody></table>
    </form>
       </div>
