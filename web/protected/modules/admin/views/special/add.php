<!-- 当前位置 -->
<div id="urHere"><?php echo Yii::app()->params['mb_nav_first']?><b>&gt;</b><strong>专题活动信息管理</strong></div>
<div id="mainBox">
    <h3><a class="actionBtn" href="<?php echo $this->createUrl("special/index")?>">活动列表</a><?php if($this->action->id=='edit'){echo '编辑';}else{echo '抽奖区间设置';}?></h3>
    <form method="post" action="<?php echo $this->createUrl($this->id.'/'.$this->action->id)?>" class="csx_submit_form" enctype="multipart/form-data">
        <table cellspacing="0" cellpadding="8" border="0" width="100%" class="tableBasic">
            <tbody>

<!--            <tr>
                <td width="100" align="right">专题类型</td>
                <td><select class="inpMain"  name="csc_type" id="type">
                        <option value="2" <?php /*if(isset($special) && $special->csc_type==2):*/?>selected="selected"<?php /*endif*/?>>简单专题页面</option>
                        <option value="1" <?php /*if(isset($special) && $special->csc_type==1):*/?>selected="selected"<?php /*endif*/?>>完整专题页面</option>
                    </select>
                </td>
            </tr>-->

            <tr>
                <td width="100" align="right">抽奖号最小值</td>
                <td><input id="name" type="text" class="inpMain" size="40" name="amin" value="<?php echo isset($setting)?$setting->amin:''?>"></td>
            </tr>
            <tr>
                <td width="100" align="right">抽奖号最小值</td>
                <td><input id="name" type="text" class="inpMain" size="40" name="amax" value="<?php echo isset($setting)?$setting->amax:''?>"></td>
            </tr>
<!--
            <tr class="wanzheng" style="display: none">
                <td align="right" >上传完整专题</td>
                <td>
                    <input type="text" class="inpMain" size="40" style="visibility:hidden;height:1px;padding:0 5px;"/>
                    <input type="hidden" id="file" name="file" value="<?php /*echo isset($special)?$special->csc_path:''*/?>"/>


                    <div class="simpleUFile ">
                        <?php /*if(isset($special->csc_path)):*/?><span id="path"><?php /*echo $special->csc_path*/?></span>
                        <?php /*else:*/?><input type="button" value="上传">
                        <?php /*endif;*/?>
                    </div>
                </td>
            </tr>-->

<!--            <tr class="jiandan">
                <td valign="top" align="right">简单专题内容</td>
                <td>
                    <textarea id="editor_id" name="csc_tpl" style="width:700px;height:300px;"><?php /*echo isset($special)?$special->csc_tpl:''*/?></textarea>
                </td>
            </tr>
-->

            <tr>
                <td></td>
                <td>
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
<?php $this->loadCssOrJs('/static/kindeditor/themes/default/default.css');?>
<?php $this->loadCssOrJs('/static/kindeditor/kindeditor.js', 'js');?>
<?php $this->loadCssOrJs(dirname(__FILE__).'/add.js', 'script')?>

