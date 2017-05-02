<!-- 当前位置 -->
<div id="urHere"><?php echo Yii::app()->params['mb_nav_first']?><b>&gt;</b><strong>店铺管理</strong></div>
<div id="mainBox">
	<h3>
	<?php if($default_store===true):?>
		<a class="actionBtn" href="javascript:;">默认店铺已开启</a>
	<?php elseif(is_array($default_store)):?>
		<a class="actionBtn del" href="<?php echo $this->createUrl($this->id.'/superstore')?>">开启超级店铺</a>
	<?php endif;?>
		店铺列表</h3>
	<div class="filter">
		<form class="search-form" action="<?php echo $this->createUrl($this->id.'/'.$this->action->id)?>">

			<input type="text" size="20" value="<?php //echo Yii::app()->request->getParam('sword')?>" class="inpMain" name="sword" placeholder="店铺名/店主名/省份证"/>
			<input type="button" value="筛选" class="btnGray" id="search"/>
		</form>
	</div>
	<table class="tableBasic" border="0" cellpadding="8" cellspacing="0" width="100%">
		<tbody>
			<tr>
				<th align="center" width="30">编号</th>
				<th align="left">店铺logo</th>
				<th align="center">店铺名称</th>
				<th align="center">店主名称</th>
				<th align="center">店铺电话</th>
				<th align="center">店铺审核状态</th>
				<th align="center">好评率</th>
				<th align="center">排序数字</th>
				<th align="center">店铺二级域名</th>
				
				<th align="center">操作</th>
			</tr>
			<?php foreach ($stores as $key=>$item):?>
			<tr>
				<td align="center"><?php echo $key+1?></td>
				<td align="center"><?php if($item->csc_logo):?><img src="<?php echo $item->csc_logo;?>" width="80px"><?php endif;?></td>
				<td align="center"><?php echo $item->csc_name;?></td>
				<td align="center" ><?php echo $item->csc_store_name;?></td>
				<td align="center"><?php echo $item->csc_store_phone;?></td>
				<td align="center">
				<?php if($item->csc_state ==1):?>
					已审核
				<?php else:?>
					未审核(<a class='del' href="<?php echo $this->createUrl('store/verify',array('ids'=>$item->csc_user_id))?>"><span style='color:red;'>&nbsp;审核&nbsp;</span></a>)
				<?php endif;?>
				</td>
				<td align="center"><?php echo $item->csc_grate;?></td>
				<td align="center"><?php echo $item->csc_sort;?></td>
				<td align="center"><?php echo $item->csc_domain;?></td>
				
				<td align="center">
					<a href="<?php echo $this->createUrl($this->id.'/examine',array('ids'=>$item->csc_user_id))?>">查看</a> | 
					<a href="<?php echo $this->createUrl($this->id.'/del',array('ids'=>$item->csc_user_id))?>" class="del" warning="确认删除?">删除</a>
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