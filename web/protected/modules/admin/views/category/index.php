<div id="urHere"><?php echo Yii::app()->params['mb_nav_first']?><b>&gt;</b><strong>分类管理</strong> </div>
	<div id="mainBox">
	    <h3><a class="actionBtn add" href="<?php echo $this->createUrl($this->id.'/add',array('pid'=>Yii::app()->request->getParam('pid')))?>">添加分类</a>分类列表
	    <a href="<?php echo $this->createUrl('category/')?>" style="font-size:16px;">顶级分类</a>
	    <?php foreach ($mbs as $item):?>
			<span style="font-size:16px;">&gt;</span> <a href="<?php echo $this->createUrl('category/index', array('pid'=>$item->csc_id))?>" style="font-size:16px;"><?php echo $item->csc_name?></a>
		<?php endforeach;?>
	    </h3>
	    <?php if(!$cate):?>
	    <div class="warning">该分类下没有分类了！</div>
	    <?php endif;?>
	    <table cellspacing="0" cellpadding="8" border="0" width="100%" class="tableBasic">
	      <tbody>
	      	<tr>
	      		<th align="center" width="60">编号</th>
	        	<th width="150" align="left">分类名称</th>
	        	<th align="left">英文</th>
	        	<th align="left">父级分类</th>
	        	<th align="left">是否显示</th>
	    		<th width="60" align="center">排序</th>
	        	<th width="100" align="center">操作</th>
	     	</tr>
	     	<?php foreach($cate as $key=>$item):?>
	     	<tr>
		        <td align="center"><?php echo $key+1;?></td>
		        <td><a href="<?php echo $this->createUrl('category/index', array('pid'=>$item->csc_id))?>"><?php echo $item->csc_name?></a></td>
		        <td><?php echo $item->csc_pinyin?></td>
		        <td><?php echo $item->parent?$item->parent->csc_name:''?></td>
		        <td><?php if($item->csc_show==1){echo '显示';}else{echo '不显示';} ?></td>
		        <td align="center" ids="<?php echo $item->csc_id?>" pos="<?php echo $this->createUrl('category/order')?>" class="order"><?php echo $item->csc_sort;?></td>
		        <td align="center"> 
			        <a href="<?php echo $this->createUrl('category/edit',array('ids'=>$item->csc_id))?>">编辑</a> | 
			        <a href="<?php echo $this->createUrl('category/del',array('ids'=>$item->csc_id))?>" class="del" warning="确认删除(该分类下子分类一并删除)?">删除</a>
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
