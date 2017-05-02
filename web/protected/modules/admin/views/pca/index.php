
	<div id="urHere"><?php echo Yii::app()->params['mb_nav_first']?><b>&gt;</b><strong>城市管理</strong> </div>
	<div id="mainBox">
	    <h3>城市列表</h3>
	<div class="filter">
		<form class="search-form" action="<?php echo $this->createUrl($this->id.'/'.$this->action->id)?>">
		
			<input type="text" size="30" value="<?php echo Yii::app()->request->getParam('sword')?>" class="inpMain" name="sword" placeholder="关键词"/>
			<input type="button" value="筛选" class="btnGray" id="search"/>
		</form>
	</div>
	<style>
		.prc span{margin-left:10px;}
		.img{background:url(<?php echo Yii::app()->baseUrl?>/assets/admin/images/tv-expandable.gif) no-repeat center;cursor: pointer;}
		.img.on{background:url(<?php echo Yii::app()->baseUrl?>/assets/admin/images/tv-collapsable.gif) no-repeat center;cursor: pointer;}
	</style>
	    <table cellspacing="0" cellpadding="8" border="0" width="100%" class="tableBasic">
	      <tbody>
	      	<tr align="center">
	        	<th width="790">地区名称</th>
	        	<th width="200">拼音</th>
	        	<th width="120">操作</th>
	     	</tr>
	     	<?php foreach ($province as $prc):?>
	     	<tr class="prc">
				<td ids="<?php echo $prc->csc_id?>">
					<span class="img">&nbsp;&nbsp;&nbsp;</span>
		     		<span><?php echo $prc->csc_name?></span>
	     		</td>
				<td><?php echo $prc->csc_pinyin?></td>
				<td></td>
			</tr>
	     	<?php endforeach;?>
	  	  </tbody>
	  	 </table>
	  	 
   </div>
<?php $this->loadCssOrJs('/static/layer-v1.8.5/layer/lib.js', 'js');?>

<?php $this->loadCssOrJs(dirname(__FILE__).'/index.js', 'script')?>