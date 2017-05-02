
	<div id="urHere"><?php echo Yii::app()->params['mb_nav_first']?><b>&gt;</b><strong>文章管理</strong> </div>
	<div id="mainBox">
	    <h3><a class="actionBtn add" href="<?php echo $this->createUrl($this->id.'/add')?>">添加文章</a>文章列表
	    </h3>
	<div class="filter">
		<form class="search-form" action="<?php echo $this->createUrl($this->id.'/'.$this->action->id)?>">
<!--			<select name="cat_id">-->
<!--				<option value="0">未分类</option>-->
<!--				<option value="1">电子数码</option>-->
<!--				<option value="4">- 智能手机</option>-->
<!--			</select>-->
            <td align="right">文章分类</td>
            <td>
                <input type="text" class="inpMain selectCate" size="40" readonly="readonly"
                       pos="<?php echo $this->createUrl('category/select')?>" title="选择分类"
                       value="<?php
                       if(isset($old) && isset($cate)){
                            echo $old->csc_name;
                       }

                       ?>" placeholder="点击选择分类"/>
                <input type="hidden" name="cate_id" value="<?php echo  isset($art)?$art->csc_cate_id:''?>"/>
            </td>

            <input type="text" size="30" value="<?php echo Yii::app()->request->getParam('sword')?>" class="inpMain" name="sword" placeholder="文章/作者"/>
			<input type="button" value="筛选" class="btnGray" id="search"/>
		</form>
	</div>
	    <table cellspacing="0" cellpadding="8" border="0" width="100%" class="tableBasic">
	      <tbody>
	      	<tr>
	      		<th align="center" width="60">编号</th>
	        	<th align="left" width="250">标题</th>
	        	<th align="left" width="500">副标题</th>
	        	<th align="center" width="150">分类</th>
	        	<th align="left" width="300">外链 </th>
	        	<th align="left" width="300">链接 </th>
	        	<th align="center" width="80">排序 </th>
	        	<th align="left" width='230'>发布日期</th>
	        	<th align="center" width="150">操作</th>
	     	</tr>
	     	<?php foreach($faq as $key=>$item):?>
	     	<tr>
		        <td align="center"><?php echo $key+1;?></td>
		        <td><?php echo $item->csc_name?></td>
				<td><?php echo $item->csc_subtitle?></td>
		        <td align="center">
		        <?php foreach($cate as $v){
		        	if($v->csc_id==$item->csc_cate_id){
		        		echo $v->csc_name;
		        	}
		        }?>
		        </td>
		        <td><?php echo $item->csc_link?></td>
		        <td><?php echo ($item->csc_cate_id == 6 )? $this->createUrl('/about/index/cid/6/', array('id'=>$item->csc_id)): ''?></td>
				<td class="order" pos="<?php echo $this->createUrl('article/order')?>" ids="<?php echo $item->csc_id?>"><?php echo $item->csc_sort ?></td>
		        <td><?php echo $item->csc_create?></td>
		        <td align="center">
			        <a href="<?php echo $this->createUrl('article/edit',array('ids'=>$item->csc_id))?>">编辑</a> | 
			        <a href="<?php echo $this->createUrl('article/del',array('ids'=>$item->csc_id))?>" class="del" warning="确认删除?">删除</a>
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
    <?php $this->loadCssOrJs('/static/kindeditor/kindeditor.js', 'js');?>
    <?php $this->loadCssOrJs('/static/kindeditor/lang/zh_CN.js', 'js');?>
    <?php $this->loadCssOrJs('/static/layer-v1.8.5/layer/lib.js', 'js');?>
    <?php $this->loadCssOrJs('/static/layer-v1.8.5/layer/layer.min.js', 'js');?> 

    <?php $this->loadCssOrJs(dirname(__FILE__).'/add_index.js', 'script')?>
    <?php $this->loadCssOrJs(dirname(__FILE__).'/index.js', 'script')?>