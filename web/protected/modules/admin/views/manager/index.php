<!-- 当前位置 -->
<div id="urHere"><?php echo Yii::app()->params['mb_nav_first']?><b>&gt;</b><strong>网站管理员</strong></div>
<div id="mainBox">
	<h3><a href="<?php echo $this->createUrl($this->id.'/add')?>" class="actionBtn">添加管理员</a>网站管理员</h3>
	<div class="filter">
		<form class="search-form" action="<?php echo $this->createUrl($this->id.'/'.$this->action->id)?>">
<!--			<select name="cat_id">-->
<!--				<option value="0">未分类</option>-->
<!--				<option value="1">电子数码</option>-->
<!--				<option value="4">- 智能手机</option>-->
<!--			</select>-->
			<input type="text" size="20" value="<?php echo Yii::app()->request->getParam('sword')?>" class="inpMain" name="sword" placeholder="用户名/手机号/姓名"/>
			<input type="button" value="筛选" class="btnGray" id="search"/>
		</form>
	</div>
	<table class="tableBasic" border="0" cellpadding="8" cellspacing="0" width="100%">
		<tbody>
			<tr>
				<th align="center" width="30">编号</th>
				<th align="left">用户名</th>
				<th align="center">手机号</th>
				<th align="center">姓名</th>
				<th align="center">用户组</th>
				<th align="center">状态</th>
				<th align="center">最后登录时间</th>
				<th align="center">操作</th>
			</tr>
			<?php foreach ($users as $key=>$item):?>
			<tr>
				<td align="center"><?php echo $key+1?></td>
				<td><?php echo $item->csc_user?></td>
				<td align="center"><?php echo $item->csc_phone?></td>
				<td align="center"><?php echo $item->csc_tname?></td>
				<td align="center"><?php echo $item->role->csc_name?></td>
				<td align="center" <?php if($item->csc_locked) echo 'style="color:red;"'?>><?php echo $lock[$item->csc_locked]?></td>
				<td align="center"><?php echo $item->csc_login_time?></td>
				<td align="center">
					<a href="<?php echo $this->createUrl($this->id.'/edit',array('ids'=>$item->csc_id))?>">编辑</a> | 
					<a href="<?php echo $this->createUrl($this->id.'/del',array('ids'=>$item->csc_id))?>" class="del" warning="确认删除?">删除</a>
				</td>
			</tr>
			<?php endforeach;?>
			
		</tbody>
	</table>
	<div class="pager">
	<?php $this->widget('CLinkPager',array(
			'firstPageLabel' => '首页',
			'lastPageLabel' => '末页',
			'prevPageLabel' => '上一页',
			'nextPageLabel' => '下一页',
			'pages' => $pages,
			'maxButtonCount'=>8,
			'header'=>'记录总数：'.$pages->itemCount. '&nbsp;&nbsp;',
         ));?>
	</div>
</div>