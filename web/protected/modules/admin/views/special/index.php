<!-- 当前位置 -->
<div id="urHere"><?php echo Yii::app()->params['mb_nav_first']?><b>&gt;</b><strong>专题活动页面管理</strong></div>
<div id="mainBox">
    <h3>
        <a href="<?php echo $this->createUrl($this->id.'/add')?>" class="actionBtn add">抽奖设置</a>
        <a href="<?php echo $this->createUrl($this->id.'/export')?>"  class="actionBtn add" style="margin-right:20px;">导出用户</a>活动列表</h3>
    <div class="filter">
        <form class="search-form" action="<?php echo $this->createUrl($this->id.'/'.$this->action->id)?>">
            <input type="text" size="20" value="<?php echo $sword?>" class="inpMain" name="sword" placeholder="抽奖号"/>
            <input type="button" value="筛选" class="btnGray" id="search"/>
        </form>
    </div>
    <table class="tableBasic" border="0" cellpadding="8" cellspacing="0" width="100%">
        <tbody>
        <tr>
            <th align="center" width="80">编号</th>
            <th align="center" width="200">用户名</th>
            <th align="center" width="300">手机号</th>
            <th align="center">抽奖号</th>
            <th align="center">活动类型</th>
            <th align="center">参加时间</th>
            <th align="center" width="80">操作</th>
        </tr>
        <?php foreach ($special as $key=>$item):?>
            <tr>
                <td align="center"><?php echo $key+1?></td>
                <td><?php echo $item->csc_name?></td>
<!--                <td align="center">--><?php //echo Helper::truncate_utf8_string($item->csc_tpl,100,'......')?><!--</td>-->
                <td align="center"><?php echo $item->csc_phone?></td>
                <td align="center"><?php echo $item->csc_award?></td>
                <td align="center"><?php echo $item->csc_type?></td>
                <td align="center"><?php echo $item->csc_create?></td>
                <td align="center">
<!--                    <a href="--><?php //echo $this->createUrl($this->id.'/edit',array('ids'=>$item->csc_id))?><!--">编辑</a> |-->
                    <a href="<?php echo $this->createUrl($this->id.'/del',array('ids'=>$item->csc_id))?>" class="del" warning="确认删除?">删除</a>
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