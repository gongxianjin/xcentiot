	<div id="mainBox">
	    <?php if(count($mbs)):?>
	    <h3>
		    <a href="<?php echo $this->createUrl('category/select')?>" style="font-size:16px;">顶级分类</a>
		    <?php foreach ($mbs as $item):?>
				<span style="font-size:16px;">&gt;</span> <a href="<?php echo $this->createUrl('category/select', array('pid'=>$item->csc_id))?>" style="font-size:16px;"><?php echo $item->csc_name?></a>
			<?php endforeach;?>
	    </h3>
	    <?php endif;?>
	    <?php if(!$cate):?>
	    <div class="warning">该分类下没有分类了！</div>
	    <?php endif;?>
	    <table cellspacing="0" cellpadding="8" border="0" width="100%" class="tableBasic iframSelect">
	      <tbody>
	      	<tr>
	      		<th align="center" width="60">编号</th>
	        	<th width="150" align="left">分类名称</th>
	        	<th align="left">英文</th>
	        	<th align="left">父级分类</th>
	        	<th align="left">是否显示</th>
	    		<th width="60" align="center">排序</th>
	    		<th align="center"></th>
	     	</tr>
	     	<?php foreach($cate as $key=>$item):?>
	     	<tr id="<?php echo $item->csc_id?>" name="<?php echo $item->csc_name?>" pinyin="<?php echo $item->csc_pinyin?>" link="<?php echo $item->csc_link?>" parent_id="<?php echo $item->csc_parent_id?>" cate_path="<?php echo $item->csc_cate_path?>">
		        <td align="center"><?php echo $key+1;?></td>
		        <td><a href="<?php echo $this->createUrl('category/select', array('pid'=>$item->csc_id))?>"><?php echo $item->csc_name?></a></td>
		        <td><?php echo $item->csc_pinyin?></td>
		        <td><?php echo $item->parent?$item->parent->csc_name:''?></td>
		        <td><?php if($item->csc_show==1){echo '显示';}else{echo '不显示';} ?></td>
		        <td align="center"><?php echo $item->csc_sort;?></td>
		        <td align="center" class="csx_pointer">点我</td>
	    	 </tr>
	    <?php endforeach;?>
	  	  </tbody>
	  	 </table>
   </div>
