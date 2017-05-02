<!-- 当前位置 -->
<div id="urHere"><?php echo Yii::app()->params['mb_nav_first']?><b>&gt;</b><strong>权限管理</strong></div>
<div id="mainBox">
	<h3>
		<a href="<?php echo $this->createUrl($this->id.'/add')?>" class="actionBtn add" style="margin-left:760px;">添加角色</a>
		<a href="<?php echo $this->createUrl('sysrole/initrole')?>" class="actionBtn" style="margin-top:5px;">导入基本权限</a>
	角色列表</h3>
<!--	<div class="filter">-->
<!--		<form class="search-form" action="--><?php //echo $this->createUrl($this->id.'/'.$this->action->id)?><!--">-->
<!--			<input type="text" size="20" value="" class="inpMain" name="sword" placeholder="用户名/手机号/姓名"/>-->
<!--			<input type="button" value="筛选" class="btnGray" id="search"/>-->
<!--		</form>-->
<!--	</div>-->
	<table class="tableBasic" border="0" cellpadding="8" cellspacing="0" width="100%">
		<tbody>
			<tr>
				<th align="center" width="80">编号</th>
				<th align="left" width="300">角色名</th>
				<th align="center">权限信息</th>
				<th align="center" width="300">操作</th>
			</tr>
			<?php foreach ($sysrole as $key=>$item):?>
			<tr>
				<td align="center"><?php echo $key+1?></td>
				<td><?php echo $item->csc_name?></td>
				<td align="center"><?php echo $item->csc_power_id?></td>
				<td align="center">
					<a href="<?php echo $this->createUrl($this->id.'/edit',array('ids'=>$item->csc_id))?>">编辑</a> | 
					<a href="<?php echo $this->createUrl($this->id.'/del',array('ids'=>$item->csc_id))?>" class="del" warning="确认删除?">删除</a>
				</td>
			</tr>
			<?php endforeach;?>
		</tbody>
	</table>
	<div class="pager">
	
	</div>
</div>