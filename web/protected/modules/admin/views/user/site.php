<!-- 当前位置 -->
<div id="urHere">先讯 管理中心<b>&gt;</b><strong>网站管理员</strong> </div>
<div id="mainBox">
    <h3><a class="actionBtn" href="/master">返回</a>切换站点</h3>
    <form action="<?php echo $this->createUrl($this->id.'/'.$this->action->id)?>" class="csx_submit_form">
        <table cellspacing="0" cellpadding="8" border="0" width="100%" class="tableBasic">
            <tbody>
            <tr>
                <td align="right">选择站点</td>
                <td>
                    <?php foreach (Yii::app()->params['master_site'] as $k=>$v):?>
                        <label class="inpMain"><input type="radio" class="inpMain" name="site" value="<?php echo $k?>" <?php if(isset($cate)&&$cate->csc_show==$k || !isset($cate)&&$k):?>checked="checked"<?php endif;?>><?php echo $v?></label>
                    <?php endforeach;?>
                </td>
            </tr>
            <tr>
                <td></td>
                <td>
                    <input type="submit" value="提交" class="btn ajax-post" target-form="csx_submit_form"/>
                    <span class="error"></span>
                </td>
            </tr>
            </tbody></table>
    </form>

</div>

