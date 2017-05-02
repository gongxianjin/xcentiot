	<div id="urHere"><?php echo Yii::app()->params['mb_nav_first']?><b>&gt;</b><strong>教师信息管理</strong> </div>
	<div id="mainBox">
	    <h3>
	    	<a class="actionBtn add" href="<?php echo $this->createUrl("goods/add")?>">添加教师</a>
	   		 教师列表
	    </h3>
	    
	    <div class="filter">
	    	<form class="search-form" action="<?php echo $this->createUrl($this->id.'/'.$this->action->id)?>">
				<input type="text" size="30" value="<?php echo Yii::app()->request->getParam('sword')?>" class="inpMain" name="sword" placeholder="名称"/>
				<input type="button" value="筛选" class="btnGray" id="search"/>
			</form>
		</div>
	    
<!--	<form action="" name="myform" method="post">-->
	    <table cellspacing="0" cellpadding="8" border="0" width="100%" class="tableBasic" style="table-layout: fixed;">
	      <tbody>
	      	<tr align="center">
	      		<th width="50">编号</th>
	        	<th width="100">教师名</th>
				<th width="150">年级</th>
				<th width="100">学科</th>
				<th width="100">校区</th>
				<th width="50">排序</th>
	        	<th>发布日期</th>
				<th>更新日期</th>
	        	<th>操作</th>
	     	</tr>
	     	<?php foreach($models as $k=>$v):?>
	     	<tr align="center">
		        <td>
	     		<input type="hidden" value="<?php echo $v->csc_id?>" class="ids"/>
	     		<?php echo $k+1?>
	     		</td>
	        	<td  width="250"><?php echo $v->csc_name?></td>
				<td>
					<?php foreach($cate as $item){
						if($item->csc_id==$v->csc_gd){
							echo $item->csc_name;
						}
					}?>
				</td>
				<td>
					<?php foreach($cate as $item){
						if($item->csc_id==$v->csc_sj){
							echo $item->csc_name;
						}
					}?>
				</td>
				<td  width="250"><?php echo $v->csc_school?></td>
				<td class="order" pos="<?php echo $this->createUrl('goods/order')?>" ids="<?php echo $v->csc_id?>"><?php echo $v->csc_sort ?></td>
				<td><?php echo $v->csc_create?></td>
	        	<td><?php echo $v->csc_update_date?></td>
		        <td>
<!--					<a href="--><?php //echo $this->createUrl('goodsinfo/index',array('ids'=>$v->csc_id))?><!--">扩展管理</a>-->
		        	<a href="<?php echo $this->createUrl('goods/edit',array('ids'=>$v->csc_id))?>">修改</a>
					<a href="<?php echo $this->createUrl('goods/del',array('ids'=>$v->csc_id))?>" class="del" warning="确认删除?">删除</a>
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
<?php $this->loadCssOrJs('/static/layer-v1.8.5/layer/lib.js', 'js');?>
<?php $this->loadCssOrJs('/static/layer-v1.8.5/layer/layer.min.js', 'js');?>
<?php $this->loadCssOrJs(dirname(__FILE__).'/index.js', 'script')?>