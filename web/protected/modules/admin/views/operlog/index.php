
	<div id="urHere"><?php echo Yii::app()->params['mb_nav_first']?><b>&gt;</b><strong>操作日志管理</strong> </div>
	<div id="mainBox">
	    <div class="filter">
		<form class="search-form" id="search-form" action="<?php echo $this->createUrl($this->id.'/'.$this->action->id)?>">
<!--			<select name="cat_id">-->
<!--				<option value="0">未分类</option>-->
<!--				<option value="1">电子数码</option>-->
<!--				<option value="4">- 智能手机</option>-->
<!--			</select>-->
			<input type="text" class="laydate laydate-icon" size="17" name="begin_time" value="<?php echo Yii::app()->request->getParam('begin_time')?>" placeholder="开始日期">
				&nbsp;~&nbsp;
			<input type="text" class="laydate laydate-icon" size="17" name="end_time" value="<?php echo Yii::app()->request->getParam('end_time')?>" placeholder="结束日期">
			<input type="text" size="30" value="<?php echo Yii::app()->request->getParam('sword')?>" class="inpMain" name="sword" placeholder="关键词"/>
			<input type="button" value="筛选" class="btnGray" id="search"/>
		</form>
		</div>
	    <table cellspacing="0" cellpadding="8" border="0" width="100%" class="tableBasic">
	      <tbody>
	      	<tr align="center">
	      		<th width="26"></th>
	      		<th width="30">编号</th>
	      		<th width="100">操作员</th>
	        	<th align="left">操作内容</th>
	        	<th width="180">日期</th>
	        	<th width="100">操作</th>
	     	</tr>
	     	<?php foreach($data as $key=>$item):?>
	     	<tr align="center">
		        <td><input type="checkbox" value="<?php echo $item->csc_id?>" class="ids"/></td>
		        <td><?php echo $key+1;?></td>
		        <td><?php echo $item->csc_username?></td>
		        <td align="left"><?php echo $item->csc_log?></td>
		        <td><?php echo $item->csc_create ?></td>
		        <td>
			        <a href="<?php echo $this->createUrl('operlog/del',array('ids'=>$item->csc_id))?>" class="del" warning="确认删除?">删除</a>
			    </td>
	    	 </tr>
	    <?php endforeach;?>
	  	  </tbody>
	  	  <?php if (count($data)):?>
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

<?php $this->loadCssOrJs('/static/laydate-v1.1/laydate/laydate.js', 'js');?>
<?php $this->loadCssOrJs(dirname(__FILE__).'/index.js', 'script')?>