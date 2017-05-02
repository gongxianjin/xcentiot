<div id="urHere"><?php echo Yii::app()->params['mb_nav_first']?></div>

<div style="padding-top: 18px;" id="mainBox">
	
	<div class="last_login">上次登录时间： <?php echo $sysuser->csc_login_time?>&nbsp;&nbsp;&nbsp;&nbsp;IP：<?php echo $sysuser->csc_login_ip?></div>

	<table cellspacing="0" cellpadding="0" border="0" width="100%" class="indexBoxTwo">
		<tbody>
			<tr>
				<td width="65%" valign="top" class="pr">
					<div class="indexBox">
						<div class="boxTitle">网站基本信息</div>
						<ul>
							<li>
								<table cellspacing="0" cellpadding="8" border="0" width="100%" class="tableBasic">
									<tbody>
										<tr>
											<td width="120">单页面数：</td>
											<td><strong>6</strong></td>
											<td width="100">文章总数：</td>
											<td><strong>10</strong></td>
										</tr>
										<tr>
											<td>商品总数：</td>
											<td><strong>15</strong></td>
											<td>系统语言：</td>
											<td><strong>zh_cn</strong></td>
										</tr>
										<tr>
											<td>系统版本：</td>
											<td><strong>v1.0 Beta 2015-1-30</strong></td>
											<td>编码：</td>
											<td><strong>UTF-8</strong></td>
										</tr>
									</tbody>
								</table>
							</li>
						</ul>
					</div>
				</td>
				<td valign="top" class="pl">
					<div class="indexBox">
					<div class="boxTitle">管理员 登录记录</div>
						<ul>
							<li>
								<table cellspacing="0" cellpadding="6" border="0" width="100%" class="tableBasic">
									<tbody>
										<tr>
											<th width="45%">IP地址</th>
											<th width="55%">操作日期</th>
										</tr>
										<tr>
											<td align="center"><?php echo $sysuser->csc_login_ip?></td>
											<td align="center"><?php echo $sysuser->csc_login_time?></td>
										</tr>
									</tbody>
								</table>
							</li>
						</ul>
					</div>
				</td>
			</tr>
		</tbody>
	</table>
	<div class="indexBox">
		<div class="boxTitle">服务器信息</div>
		<ul>
			<li>
				<table cellspacing="0" cellpadding="8" border="0" width="100%" class="tableBasic">
					<tbody>
						<tr>
							<td width="120">服务器操作系统:</td>
							<td><?php echo PHP_OS?></td>
							<td width="100">Web 服务器:</td>
							<td><?php echo $_SERVER['SERVER_SOFTWARE']?></td>
						</tr>
						<tr>
							<td>PHP 版本:</td>
							<td><?php echo PHP_VERSION?></td>
							<td>MySQL 版本:</td>
							<td><?php echo $mysql_version?></td>
						</tr>
						<tr>
							<td>安全模式:</td>
							<td><?php echo (boolean) ini_get('safe_mode') ? '是' : '否'?></td>
							<td>安全模式GID:</td>
							<td><?php echo (boolean) ini_get('safe_mode_gid') ? '是' : '否'?></td>
						</tr>
						<tr>
							<td>Socket 支持:</td>
							<td><?php echo function_exists('fsockopen') ? '是' : '否'?></td>
							<td>时区设置:</td>
							<td><?php echo function_exists("date_default_timezone_get") ? date_default_timezone_get() : '默认时区'?></td>
						</tr>
						<tr>
							<td>GD 版本:</td>
							<td><?php echo extension_loaded("gd") ? '是' : '否'?></td>
							<td>Zlib 支持:</td>
							<td><?php echo function_exists('gzclose') ? '是' : '否'?></td>
						</tr>
						<tr>
							<td>文件上传的最大大小:</td>
							<td><?php echo ini_get('upload_max_filesize')?></td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
						</tr>
					</tbody>
				</table>
			</li>
		</ul>
	</div>
	<br>
	<?php if(count($oper_log)):?>
	<div class="indexBox">
		<div class="boxTitle">操作日志</div>
		<ul>
			<li>
				<table cellspacing="0" cellpadding="6" border="0" width="100%" class="tableBasic">
					<tbody>
						<tr>
							<th width="10%">用户</th>
							<th width="30%">操作</th>
							<th width="10%">IP</th>
							<th width="10%">日期</th>
						</tr>
						<?php foreach ($oper_log as $item):?>
						<tr>
							<td align="center"><?php echo $item->csc_username?></td>
							<td><?php echo $item->csc_log?></td>
							<td align="center"><?php echo $item->csc_guest_ip?></td>
							<td align="center"><?php echo $item->csc_create?></td>
						</tr>
						<?php endforeach;?>
					</tbody>
				</table>
			</li>
		</ul>
	</div>
	<?php endif;?>
	
</div>
