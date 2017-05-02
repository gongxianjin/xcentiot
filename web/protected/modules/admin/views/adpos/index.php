
	<div id="urHere"><?php echo Yii::app()->params['mb_nav_first']?><b>&gt;</b><strong>广告位管理</strong> </div>
	<div id="mainBox">
	    <h3><a class="actionBtn add" href="<?php echo $this->createUrl($this->id.'/add')?>">添加广告位</a>广告位列表
	    </h3>
	    <div class="filter">
		<form class="search-form" action="<?php echo $this->createUrl($this->id.'/'.$this->action->id)?>">
<!--			<select name="cat_id">-->
<!--				<option value="0">未分类</option>-->
<!--				<option value="1">电子数码</option>-->
<!--				<option value="4">- 智能手机</option>-->
<!--			</select>-->
			<input type="text" size="30" value="<?php echo Yii::app()->request->getParam('sword')?>" class="inpMain" name="sword" placeholder="广告名/广告位"/>
			<input type="button" value="筛选" class="btnGray" id="search"/>
		</form>
		</div>
	    <table cellspacing="0" cellpadding="8" border="0" width="100%" class="tableBasic">
	      <tbody>
	      	<tr>
	      		<th align="center" width="60">编号</th>
	      		<th align="center" width="100">ID</th>
	        	<th width="150" align="left">广告位名称</th>
	        	<th align="center" width="100">宽度</th>
	        	<th align="center" width="100">高度</th>
	        	<th align="left">描述</th>
	    		<th width="150" align="left">创建时间</th>
	        	<th width="200" align="center">操作</th>
	     	</tr>
	     	<?php foreach($adpos as $key=>$item):?>
	     	<tr>
		        <td align="center"><?php echo $key+1;?></td>
		        <td><?php echo $item->csc_id?></td>
		        <td><a href="<?php echo $this->createUrl('ad/index', array('pid'=>$item->csc_id))?>"><?php echo $item->csc_name?></a></td>
		        <td><?php echo $item->csc_width?></td>
		        <td><?php echo $item->csc_height;?></td>
		        <td><?php echo $item->csc_desc ?></td>
		        <td><?php echo $item->csc_create ?></td>
		        <td align="center">
			        <a href="<?php echo $this->createUrl('adpos/edit',array('ids'=>$item->csc_id))?>">编辑</a> | 
			        <a href="<?php echo $this->createUrl('adpos/del',array('ids'=>$item->csc_id))?>" class="del" warning="确认删除?">删除</a>
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
