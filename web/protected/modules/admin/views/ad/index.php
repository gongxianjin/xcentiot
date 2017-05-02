
	<div id="urHere"><?php echo Yii::app()->params['mb_nav_first']?><b>&gt;</b><strong>广告管理</strong> </div>
	<div id="mainBox">
	    <h3><a class="actionBtn add" href="<?php echo $this->createUrl($this->id.'/add')?>">添加广告</a>广告列表
	    </h3>
	<div class="filter">
		<form class="search-form" action="<?php echo $this->createUrl($this->id.'/'.$this->action->id)?>">
			<input type="text" class="inpMain selectCate"  readonly="readonly"
       			pos="<?php echo $this->createUrl('adpos/select')?>" title="选择广告位"
       			value="" placeholder="点击选择广告位"/>
			<input type="hidden" name="pid" value=""/>
			<input type="text" size="30" value="<?php echo Yii::app()->request->getParam('sword')?>" class="inpMain" name="sword" placeholder="关键词"/>
			<input type="button" value="筛选" class="btnGray" id="search"/>
		</form>
	</div>
	    <table cellspacing="0" cellpadding="8" border="0" width="100%" class="tableBasic">
	      <tbody>
	      	<tr align="center">
	      		<th width="60">编号</th>
	        	<th>名称</th>
	        	<th width="80">类型</th>
	        	<th width="100">广告位</th>
<!--	        	<th width="100">站点</th>-->
	        	<th width="60">状态 </th>
	        	<th width="80">开始日期 <br>结束日期</th>
	        	<th width="50">排序数字 </th>
	        	<th width="170">联络信息 </th>
	        	<th width="120">操作</th>
	     	</tr>
	     	<?php foreach($ad as $key=>$item):?>
	     	<tr align="center">
		        <td><?php echo $key+1;?></td>
		        <td align="left">
		        	<?php if(!$item->csc_type):?>
		        		<p style="max-width:300px;overflow:hidden;"><a href="<?php echo $item->csc_img?$item->csc_img:$item->csc_img_url?>" target="_blank"><img height="60" src="<?php echo $item->csc_img?$item->csc_img:$item->csc_img_url?>" alt=""/></a></p>
		        	<?php elseif($item->csc_type==1):?>
		        		<p><embed height="60" border="0" align="middle" wmode="opaque" src="<?php echo $item->csc_flash?$item->csc_flash:$item->csc_flash_url?>"></p>
		        	<?php elseif($item->csc_type==2):?>
		        		<p><?php echo $item->csc_code?></p>
		        	<?php elseif($item->csc_type==3):?>
		        		<p><?php echo $item->csc_text?></p>
		        	<?php endif;?>
		        	<?php echo $item->csc_name?>
		        </td>
		        <td><?php echo Yii::app()->params['ad_type'][$item->csc_type]?></td>
		        <td><?php echo $item->pos?$item->pos->csc_name:''?></td>
<!--		        <td>--><?php //echo isset($item->pca)?$item->pca->parent->csc_name.'-'.$item->pca->csc_name:'暂无站点'?><!--</td>-->
		        <td><?php if($item->csc_show==1){echo '显示';}else{echo '不显示';} ?></td>
		        <td><?php echo $item->csc_begin_time.'<br>~<br>'.($item->csc_end_time?$item->csc_end_time:'永久')?></td>
		        <td class="order" pos="<?php echo $this->createUrl('ad/order')?>" ids="<?php echo $item->csc_id?>"><?php echo $item->csc_sort ?></td>
		        <td align="left">
		        	<p><b>联系人：</b><?php echo $item->csc_contactor?></p>
		        	<p><b>电话：</b><?php echo $item->csc_phone?></p>
		        	<p><b>邮箱：</b><?php echo $item->csc_email?></p>
		        </td>
		        <td>
			        <a href="<?php echo $this->createUrl('ad/edit',array('ids'=>$item->csc_id))?>">编辑</a> | 
			        <a href="<?php echo $this->createUrl('ad/del',array('ids'=>$item->csc_id))?>" class="del" warning="确认删除?">删除</a>
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
<?php $this->loadCssOrJs('/static/kindeditor/kindeditor.js', 'js');?>
<?php $this->loadCssOrJs('/static/kindeditor/lang/zh_CN.js', 'js');?>
<?php $this->loadCssOrJs(dirname(__FILE__).'/index.js', 'script')?>