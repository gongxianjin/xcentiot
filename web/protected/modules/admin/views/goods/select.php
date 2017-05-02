<div id="mainBox">
	<div class="filter">
		<form class="search-form" action="<?php echo $this->createUrl($this->id.'/'.$this->action->id)?>">
			<input type="text" size="30" value="<?php echo Yii::app()->request->getParam('sword')?>" class="inpMain" name="sword" placeholder="教师名"/>
			<input type="button" value="筛选" class="btnGray" id="search"/>
		</form>
	</div>
	<table cellspacing="0" cellpadding="8" border="0" width="100%" class="tableBasic iframSelect">
		<tbody>
		<tr>
			<th align="center" width="60">编号</th>
			<th align="center" width="150">教师名称</th>
			<th align="center"  width="100">价格</th>
			<th align="center" width="100">已售数量</th>
			<th width="150" align="center">创建时间</th>
			<th width="150" align="center">更新时间</th>
			<th width="50" align="center">排序</th>
			<th width="50" align="center">选择</th>
		</tr>
		<?php foreach($goods as $k=>$v):?>
			<tr id="<?php echo $v->csc_id?>" name="<?php echo $v->csc_name?>">
				<td align="center"><?php echo $k+1;?></td>
				<td><?php echo $v->csc_name?></td>
				<td><?php echo $v->csc_price?></td>
				<td><?php echo $v->csc_sale_num;?></td>
				<td><?php echo $v->csc_create?></td>
				<td><?php echo $v->csc_update_date?></td>
				<td><?php echo $v->csc_sort?></td>
				<td align="center" class="csx_pointer">点我</td>
			</tr>
		<?php endforeach;?>
		</tbody>
	</table>
</div>
