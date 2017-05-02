
	<div id="mainBox">
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
	    <table cellspacing="0" cellpadding="8" border="0" width="100%" class="tableBasic iframSelect">
	      <tbody>
	      	<tr>
	      		<th align="center" width="60">编号</th>
	      		<th align="center" width="100">ID</th>
	        	<th width="150" align="left">广告位名称</th>
	        	<th align="center" width="100">宽度</th>
	        	<th align="center" width="100">高度</th>
	        	<th align="left">描述</th>
	    		<th width="150" align="left">创建时间</th>
	        	<th width="200" align="center"></th>
	     	</tr>
	     	<?php foreach($adpos as $key=>$item):?>
	     	<tr id="<?php echo $item->csc_id?>" name="<?php echo $item->csc_name?>">
		        <td align="center"><?php echo $key+1;?></td>
		        <td><?php echo $item->csc_id?></td>
		        <td><?php echo $item->csc_name?></td>
		        <td><?php echo $item->csc_width?></td>
		        <td><?php echo $item->csc_height;?></td>
		        <td><?php echo $item->csc_desc ?></td>
		        <td><?php echo $item->csc_create ?></td>
		        <td align="center" class="csx_pointer">点我</td>
	    	 </tr>
	    <?php endforeach;?>
	  	  </tbody>
	  	 </table>
   </div>
