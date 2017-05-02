<!-- 当前位置 -->
<div id="urHere"><?php echo Yii::app()->params['mb_nav_first']?><b>&gt;</b><strong>科目信息管理</strong></div>
<div id="mainBox">
	<h3>
        <a class="actionBtn" href="<?php echo $this->createUrl("exam/index")?>">科目列表</a>
        <?php if($this->action->id=='edit'){echo '编辑';}else{echo '添加';}?>
    </h3>
	<form method="post" action="<?php echo $this->createUrl($this->id.'/'.$this->action->id)?>" class="csx_submit_form">
	<table cellspacing="0" cellpadding="8" border="0" width="100%" class="tableBasic">
		<tbody>
            <tr>
                <td align="right">科目</td>
                <td>
                    <?php if($this->action->id == 'edit'){echo $model->info->csc_name;}else{echo $csc_name;}?>
                    <input type="hidden" name="exam_id" value="<?php if($this->action->id == 'edit'){echo $model->csc_exam_id;}else{echo $csc_exam_id;}?>"/>
                </td>
            </tr>
            <tr>
                <td width="80" align="right">扩展信息名</td>
                <!-- editor -->
                <td>
                    <textarea class="editor_id" style="width:700px;height:300px;" name="name">
                        <?php echo isset($model)?$model->csc_name:''?>
                    </textarea>
                </td>
                <!-- /editor -->
            </tr>
            <tr>
                <td width="80" align="right">扩展信息答案</td>
                <td><input type="text" class="inpMain" size="40" name="answer" <?php if(isset($model)){echo "value='$model->csc_answer'";}?>></td>
            </tr>
            <tr>
                <td width="100" align="right">内容</td>
                <!-- editor -->
                <td>
                    <textarea class="editor_id" style="width:700px;height:300px;" name="content">
                        <?php echo isset($model)?$model->csc_content:''?>
                    </textarea>
                </td>
                <!-- /editor -->
            </tr>
            <tr>
                <td align="right">排序</td>
                <td><input type="text" class="inpMain" size="40" name="sort" value="<?php echo isset($model)?$model->csc_sort:''?>"></td>
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

