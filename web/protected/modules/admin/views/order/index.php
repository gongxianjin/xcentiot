<div id="urHere"><?php echo Yii::app()->params['mb_nav_first']?><b>&gt;</b><strong>预约反馈</strong> </div>
	<div id="mainBox">
		<h3>预约列表</h3>
		<table cellspacing="0" cellpadding="8" border="0" width="100%" class="tableBasic">
			<tbody>
			<tr>
				<th width="26"></th>
				<th align="center" width="60">编号</th>
				<th align="center" >预约年级</th>
				<th align="center" >预约校区</th>
				<th align="center" >姓名</th>
				<th align="center" >电话</th>
				<th align="center" >邮箱</th>
				<th align="center">操作</th>
			</tr>
			<?php foreach ($order as $key=>$item):?>
			<tr>
				<td><input type="checkbox" value="<?php echo $item->csc_id?>" class="ids"/></td>
				<td><?php echo $key+1?></td>
				<td><?php echo Yii::app()->Params['site']['gd_type'][$item->csc_grade]?></td>
				<td><?php echo $item->cate->csc_name?></td>
				<td><?php echo $item->csc_name?></td>
				<td><?php echo $item->csc_tel?></td>
				<td><?php echo $item->csc_mail?></td>
				<td align="center">
<!--					<a href="--><?php //echo $this->createUrl('feedback/edit',array('ids'=>$item->csc_id))?><!--">查看</a>-->
					<a href="<?php echo $this->createUrl('order/del',array('ids'=>$item->csc_id))?>" class="del" warning="确认删除?">删除</a>
				</td>
			</tr>
			<?php endforeach;?>
			</tbody>
			<?php if (count($order)):?>
				<tbody>
				<tr>
					<td colspan="2" align="center">
						<input type="checkbox" class="check-all"/>全选
					</td>
					<td colspan="4" id="select_btn">
						<h3><a href="<?php echo $this->createUrl($this->id.'/del')?>" class="del_multi" warning="确认删除?">删除</a></h3>
					</td>
				</tr>
				</tbody>
			<?php endif;?>
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
