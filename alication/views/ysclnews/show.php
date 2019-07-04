<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Language" content="zh-cn" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta http-equiv="Cache-Control" content="no-siteapp" />
    <meta name="viewport" content="width=device-width, maximum-scale=1.0, initial-scale=1.0,initial-scale=1.0,user-scalable=no" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <title>生鲜乳运输车详情</title>
    <link href="/Content/layui/css/layui.css" rel="stylesheet" />
    <link href="/Content/fhuaui/css/fhuaui.css" rel="stylesheet" />
    <link href="/Content/Font-Awesome/css/font-awesome.css" rel="stylesheet" />
    <script src="/Content/layui/layui.js"></script>
</head>
<body>
    <div class="main-wrap">
        <blockquote class="layui-elem-quote fhui-admin-main_hd">
            <h2>生鲜乳运输车详情 　
                <a class="layui-btn layui-btn-small" onclick="$('#myPrintArea').printArea();"><i class="fa fa-print"></i>打印</a>
            </h2>
        </blockquote>
        <div class="y-role">
            <!--文字列表-->
            <div class="fhui-admin-table-container" id='myPrintArea'>
                <div class="layui-form-item"><center>生鲜乳运输车详情</center></div>
                <table class="layui-table layui-tables" lay-skin="line" boder='1'>
                    <tbody>
                        <tr>
                            <td><b>车牌号</b></td>
                            <td><?php echo $ms['num']; ?></td>
                            <td><b>日运奶量(吨)</b></td>
                            <td><?php echo $ms['yield'] ?></td>
                        </tr>
                        <tr>
                            <td><b>准运证编号</b></td>
                            <td><?php echo $ms['permit'] ?></td>
                            <td><b>发证机关</b></td>
                            <td><?php echo $ms['issuing'] ?></td>
                        </tr>
						<tr>
                            <td><b>核定最大载重(吨)</b></td>
                            <td><?php echo $ms['payload'] ?></td>
                            <td><b>最大运奶距离(千米)</b></td>
                            <td><?php echo $ms['distance'] ?></td>
                        </tr>
						<tr>
                            <td><b>运输车司机姓名</b></td>
                            <td><?php echo $ms['driver']; ?></td>
                            <td><b>联系电话</b></td>
                            <td><?php echo $ms['dtel'] ?></td>
                        </tr>
						<tr>
                            <td><b>运输车所有者</b></td>
                            <td><?php echo $ms['owner']; ?></td>
                            <td><b>联系电话</b></td>
                            <td><?php echo $ms['otel'] ?></td>
                        </tr>
						<tr>
                            <td><b>质量负责人</b></td>
                            <td><?php echo $ms['charge']; ?></td>
                            <td><b>联系电话</b></td>
                            <td><?php echo $ms['ctel'] ?></td>
                        </tr>
						<tr>
                            <td><b>乡镇监管责任人</b></td>
                            <td><?php echo $ms['super']; ?></td>
                            <td><b>单位</b></td>
                            <td><?php echo $ms['uintxz'] ?></td>
                        </tr>
						<tr>
                            <td><b>县级监管责任人</b></td>
                            <td><?php echo $ms['supers']; ?></td>
                            <td><b>单位</b></td>
                            <td><?php echo $ms['uintxj'] ?></td>
                        </tr>
						<tr>
                            <td><b>运输车照片</b></td>
                            <td colspan='3'>
							<?php if($ms['pic']){ ?>
								<img scr='<?php echo $ms['pic']?>' width='300' />
							<?php } ?>
							</td>
                        </tr>
						<tr>
                            <td colspan='4'>
								<fieldset>
									<legend>生鲜乳承运情况-往来奶站</legend>
									<table class="layui-table layui-tables" boder='1'>
										<tr>
											<td><b>奶站名称</b></td>
											<td><b>运输车关系</b></td>
										</tr>
										<?php foreach($c as $v): if($v['types'] == 1){?>
										<tr>
											<td><?php echo $v['stock']?></td>
											<td><?php echo ($v['breed']==1) ? '租用' : '自备';?></td>
										</tr>
										<?php } endforeach; ?>
									</table>
								</fieldset>
							</td>
                        </tr>
						<tr>
                            <td colspan='4'>
								<fieldset>
									<legend>生鲜乳承运情况-往来企业</legend>
									<table class="layui-table layui-tables" boder='1'>
										<tr>
											<td><b>企业名称</b></td>
											<td><b>运输车关系</b></td>
										</tr>
										<?php foreach($c as $v): if($v['types'] == 2){?>
										<tr>
											<td><?php echo $v['stock']?></td>
											<td><?php echo ($v['breed']==1) ? '租用' : '自备';?></td>
										</tr>
										<?php } endforeach; ?>
									</table>
								</fieldset>
							</td>
                        </tr>
						<tr>
                            <td><b>运营状况</b></td>
                            <td><?php if($ms['status']==0){echo '待审';}elseif($ms['status']==1){echo '正常';}elseif($ms['status']==2){echo '未通过';}else{echo '关闭';} ?></td>
                            <td><b>关闭时间</b></td>
                            <td><?php echo ($ms['status']==3) ? date('Y-m-d H:i', $ms['stop']) : '无'; ?></td>
                        </tr>
                    </tbody>
                </table>
                <div style='float:right;'><?php echo '填表人：',get_user($ms['admin_id'])['realname'],' 填表时间：',date('Y-m-d', $ms['add_time']),' ';?></div>
            </div>
            <!--/文字列表-->
        </div>
    </div>
    <script type="text/javascript" src="/Content/js/jquery-1.7.2.min.js"></script>
    <script type="text/javascript" src="/Content/jquery.PrintArea.js"></script>
</body>
</html>