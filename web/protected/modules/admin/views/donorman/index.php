<div id="urHere"><?php echo Yii::app()->params['mb_nav_first']?><b>&gt;</b><strong>留言反馈</strong> </div>
	<div id="mainBox">
		<h3>留言列表</h3>
		<table cellspacing="0" cellpadding="8" border="0" width="100%" class="tableBasic">
			<tbody>
			<tr>
				<th align="center" width="60">编号</th>
				<th align="center" >来源IP</th>
				<th align="center" >姓名</th>
				<th align="center" >手机</th>
				<th align="center" >邮箱</th>
				<th align="center" >微信</th>
				<th align="center" >公司名称</th>
				<th align="center" >合作模式</th>
				<th align="center" >详细地址</th>
				<th align="center" >反馈日期</th>
				<th align="center">操作</th>
			</tr>
			<?php foreach ($feed as $key=>$item):?>
			<tr>
				<td><?php echo $key+1?></td>
				<td><?php echo $item->csc_guest_ip?></td>
				<td><?php echo $item->csc_name?></td>
				<td><?php echo $item->csc_phone?></td>
				<td><?php echo $item->csc_email?></td>
				<td><?php echo $item->csc_weixi?></td>
				<td><?php echo $item->csc_company?></td>
				<td><?php echo $item->csc_hzms?></td>
				<td><?php echo $item->csc_address?></td>
				<td><?php echo $item->csc_create?></td>
				<td align="center">
					<a href="<?php echo $this->createUrl('feedback/edit',array('ids'=>$item->csc_id))?>">查看</a>
					<a href="<?php echo $this->createUrl('feedback/del',array('ids'=>$item->csc_id))?>" class="del" warning="确认删除?">删除</a>
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
