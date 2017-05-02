<div id="urHere"><?php echo Yii::app()->params['mb_nav_first']?><b>&gt;</b><strong>搜索词管理</strong> </div>
	<div id="mainBox">
	    <h3><a class="actionBtn add" href="<?php echo $this->createUrl($this->id.'/add')?>">添加搜索词</a>搜索词列表</h3>
	    <?php if(!$data):?>
	    <div class="warning">未添加搜索词</div>
	    <?php endif;?>
	    <table cellspacing="0" cellpadding="8" border="0" width="100%" class="tableBasic">
	      <tbody>
	      	<tr>
	      		<th align="center" width="60">编号</th>
	        	<th width="150" align="left">搜索词名称</th>
	        	<th align="left">类型</th>
	        	<th width="200" align="center">操作</th>
	     	</tr>
	     	<?php foreach($data as $key=>$item):?>
				<tr>
					<td align="center"><?php echo $key+1;?></td>
					<td><?php echo $item['name']?></td>
					<td><?php echo $item['type']?></td>
					<td align="center">
						<a href="<?php echo $this->createUrl('hotkeyword/del',array('key'=>$item['key'], 'type_key'=>$item['type_key']))?>" class="del" warning="确认删除?">删除</a>
					</td>
				 </tr>
			<?php endforeach;?>
	  	  </tbody>
	  	 </table>
	  	 
   </div>
