<div id="urHere"><?php echo Yii::app()->params['mb_nav_first']?><b>&gt;</b><strong>互助管理</strong> </div>
	<div id="mainBox">
		<h3>互助列表</h3>
		<table cellspacing="0" cellpadding="8" border="0" width="100%" class="tableBasic">
			<tbody>
			<tr>
				<th align="center" width="60">编号</th>
				<th align="center" >来源IP</th>
				<th align="center" >用户名</th>
				<th align="center" >真实姓名</th>
				<th align="center" >手机号码</th>
				<th align="center" >身份证号</th>
				<th align="center" >加入日期</th>
				<th align="center">操作</th>
			</tr>
			<?php foreach ($feed as $key=>$item):?>
			<tr>
				<td><?php echo $key+1?></td>
				<td><?php echo $item->csc_guest_ip?></td>
				<td><?php echo $item->user->csc_username?></td>
				<td><?php echo $item->csc_tname?></td>
				<td><?php echo $item->csc_phone?></td>
				<td><?php echo $item->csc_identity?></td>
				<td><?php echo $item->csc_create?></td>
				<td align="center">
					<!--<a href="<?php echo $this->createUrl('customers/edit',array('ids'=>$item->csc_id))?>">查看</a>-->
					<?php if($item->csc_lock == 0):?>
						未审核(<a  href="<?php echo $this->createUrl($this->id.'/unlock',array('ids'=>$item->csc_id))?>"  class="del" warning="确认审核?">
							<span style='color:red;'>&nbsp;审核&nbsp;</span></a>)
					<?php else:?>
						审核(<a href="<?php echo $this->createUrl($this->id.'/lock',array('ids'=>$item->csc_id))?>"  class="del" warning="确认取消审核?">
							<span style='color:red;'>&nbsp;取消审核&nbsp;</span></a>)
					<?php endif;?>
					|
					<a href="<?php echo $this->createUrl('customers/del',array('ids'=>$item->csc_id))?>" class="del" warning="确认删除?">删除</a>
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
