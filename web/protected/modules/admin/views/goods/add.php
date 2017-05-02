<!-- 当前位置 -->
<div id="urHere"><?php echo Yii::app()->params['mb_nav_first']?><b>&gt;</b><strong>教师信息管理</strong></div>
<div id="mainBox">
	<h3><a class="actionBtn" href="<?php echo $this->createUrl("goods/index")?>">教师列表</a><?php if($this->action->id=='edit'){echo '编辑';}else{echo '添加';}?></h3>
	<form method="post" action="<?php echo $this->createUrl($this->id.'/'.$this->action->id)?>" class="csx_submit_form">
	<table cellspacing="0" cellpadding="8" border="0" width="100%" class="tableBasic">
		<tbody>
			<tr>
				<td width="80" align="right">教师名</td>
				<td><input type="text" class="inpMain" size="40" name="name" <?php if(isset($model)){echo "value='$model->csc_name'";}?>></td>
			</tr>
			<tr>
				<td align="right" >图片</td>
				<td>
					<input type="text" class="inpMain" size="40" style="visibility:hidden;height:1px;padding:0 5px;"/>
					<input type="hidden" name="img" value="<?php echo isset($model)?$model->csc_img:''?>"/>
					<div class="simpleUImg noheader">
						<?php if(isset($model->csc_img)):?><img width="110" height="110" src="<?php echo $model->csc_img?>" alt=""><?php endif;?>
					</div>
				</td>
			</tr>
            <tr>
                <td align="right">年级</td>
                <td>
                    <input type="text" class="inpMain selectCate" size="40" readonly="readonly"
                           pos="<?php echo $this->createUrl('category/select')?>" title="选择分类"
                           value="<?php
                           if(isset($model) && isset($cate)){
                               foreach($cate as $v){
                                   if($v->csc_id==$model->csc_gd){
                                       echo $v->csc_name;
                                   }
                               }
                           }
                           ?>" placeholder="点击选择分类"/>
                    <input type="hidden" name="gd" value="<?php echo  isset($model->csc_gd)?$model->csc_gd:''?>"/>
                </td>
            </tr>
            <tr>
            <tr>
                <td align="right">学科</td>
                <td>
                    <input type="text" class="inpMain selectCate" size="40" readonly="readonly"
                           pos="<?php echo $this->createUrl('category/select')?>" title="选择分类"
                           value="<?php
                           if(isset($model) && isset($cate)){
                               foreach($cate as $v){
                                   if($v->csc_id==$model->csc_sj){
                                       echo $v->csc_name;
                                   }
                               }
                           }
                           ?>" placeholder="点击选择分类"/>
                    <input type="hidden" name="sj" value="<?php echo  isset($model->csc_sj)?$model->csc_sj:''?>"/>
                </td>
            </tr>
            <tr>
                <td align="right">校区</td>
                <td><input type="text" class="inpMain" size="40" name="school" value="<?php echo isset($model)?$model->csc_school:''?>" ></td>
            </tr>
            <tr>
                <td width="100" align="right">简介描述</td>
                <!-- editor -->
                <td>
                    <textarea class="editor_id" name="desc" style="width:700px;height:300px;">
                        <?php echo isset($model)?$model->csc_desc:''?>
                    </textarea>
                </td>
                <!-- /editor -->
            </tr>
            <tr>
                <td align="right">排序</td>
                <td><input type="text" class="inpMain" size="40" name="sort" value="<?php echo isset($model)?$model->csc_sort:''?>"></td>
            </tr>
            <tr>
                <td align="right">是否推荐</td>
                <td>
                    <?php if($this->action->id=='edit'):?>
                        <?php if($model->csc_recom_point==0):?>
                            <label class="inpMain"><input name="recom_point" type="radio" value="1"/>推荐</label>
                            <label class="inpMain"><input name="recom_point" type="radio" value="0" checked="checked"/>不推荐 </label>
                        <?php else:?>
                            <label class="inpMain"><input name="recom_point" type="radio" value="1" checked="checked"/>推荐 </label>
                            <label class="inpMain"><input name="recom_point" type="radio" value="0"/>不推荐 </label>
                        <?php endif;?>
                    <?php else:?>
                        <label class="inpMain"><input name="recom_point" type="radio" value="1" />推荐 </label>
                        <label class="inpMain"><input name="recom_point" type="radio" value="0" checked="checked"/>不推荐 </label>
                    <?php endif;?>
                </td>
            </tr>
			<tr>
				<td></td>
				<td>
					<input type="hidden" name="ids" value="<?php echo isset($model)?$model->csc_id:''?>">
					<input type="submit" value="提交" class="btn ajax-post" target-form="csx_submit_form">
					<span class="error"></span>
				</td>
			</tr>
		</tbody>
	</table>
	</form>
</div>
<?php $this->loadCssOrJs('/static/layer-v1.8.5/layer/lib.js', 'js');?>
<?php $this->loadCssOrJs('/static/layer-v1.8.5/layer/layer.min.js', 'js');?>
<?php $this->loadCssOrJs('/static/kindeditor/lang/zh_CN.js', 'js');?>
<?php $this->loadCssOrJs('/static/kindeditor/kindeditor.js', 'js');?>
<?php $this->loadCssOrJs(dirname(__FILE__).'/add_editor.js', 'script')?>
<?php $this->loadCssOrJs(dirname(__FILE__).'/add.js', 'script')?>

