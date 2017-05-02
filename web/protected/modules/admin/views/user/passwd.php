<!-- 当前位置 -->
		<div id="urHere">先讯 管理中心<b>&gt;</b><strong>网站管理员</strong> </div>
		<div id="mainBox">
    <h3><a class="actionBtn" href="manager.php">返回列表</a>修改密码</h3>
            <form action="<?php echo $this->createUrl($this->id.'/'.$this->action->id)?>" class="csx_submit_form">
     <table cellspacing="0" cellpadding="8" border="0" width="100%" class="tableBasic">
      <tbody>
      <tr>
       <td align="right">原密码</td>
       <td>
        <input type="password" class="inpMain" size="40" name="oldpwd">
       </td>
      </tr>
      <tr>
       <td align="right">新密码</td>
       <td>
        <input type="password" class="inpMain" size="40" name="newpwd">
       </td>
      </tr>
      <tr>
       <td align="right">确认密码</td>
       <td>
        <input type="password" class="inpMain" size="40" name="password_confirm">
       </td>
      </tr>
      <tr>
       <td></td>
       <td>
        <input type="hidden" value="<?php echo Yii::app()->session['sysuser_id'];?>" name="ids"/> 
		<input type="submit" value="提交" class="btn ajax-post" target-form="csx_submit_form"/>
		<span class="error"></span>
       </td>
      </tr>
     </tbody></table>
    </form>
             
 </div>

