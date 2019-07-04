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
    <title>兽药经营企业详情</title>
    <link href="/Content/layui/css/layui.css" rel="stylesheet" />
    <link href="/Content/fhuaui/css/fhuaui.css" rel="stylesheet" />
    <link href="/Content/Font-Awesome/css/font-awesome.css" rel="stylesheet" />
    <script src="/Content/layui/layui.js"></script>
</head>
<body>
    <div class="main-wrap">
        <blockquote class="layui-elem-quote fhui-admin-main_hd">
            <h2>兽药经营企业详情 　
                <a class="layui-btn layui-btn-small" onclick="$('#myPrintArea').printArea();"><i class="fa fa-print"></i>打印</a>
				<a class="layui-btn layui-btn-small do-action" data-type="doGoBack" data-href="/jymessage/index"><i class="fa fa-mail-reply"></i>返回上一页</a>
            </h2>
        </blockquote>
        <div class="y-role">
            <!--文字列表-->
            <div class="fhui-admin-table-container" id='myPrintArea'>
                <div class="layui-form-item"><center>兽药经营企业详情</center></div>
                <table class="layui-table layui-tables" lay-skin="line" boder='1'>
                    <tbody>
                        <tr>
                            <td><b>企业名称</b></td>
                            <td><?php echo $ms['name']; ?></td>
                            <td><b>编号</b></td>
                            <td><?php echo 'YTSLJY' . str_pad($ms['id'],6,'0',STR_PAD_LEFT); ?></td>
                        </tr>
                        <tr>
                            <td><b>注册地址</b></td>
                            <td><?php echo $ms['reg_area']; ?></td>
							 <td><b>成立日期</b></td>
                            <td><?php if($ms['estab_time'] > 0){ echo date('Y-m-d', $ms['estab_time']); } ?></td>
                   
                        </tr>
						<tr>
							<td><b>经度</b></td>
                            <td><?php echo $ms['lng']; ?></td>
							<td><b>纬度</b></td>
                            <td><?php echo $ms['lat']; ?></td>
						</tr>
						<tr>
							<td><b>邮编</b></td>
                            <td><?php echo $ms['lng']; ?></td>
							<td><b>仓库地址</b></td>
                            <td><?php echo $ms['lat']; ?></td>
						</tr>
						<tr>
							<td><b>经营许可证编号</b></td>
                            <td><?php echo $ms['lng']; ?></td>
							<td><b>发证日期</b></td>
                            <td><?php echo $ms['lat']; ?></td>
						</tr>
						<tr>
							<td><b>有效期至</b></td>
                            <td><?php echo $ms['lng']; ?></td>
							<td colspan="2"></td>
						</tr>
						<tr>
                            <td><b>法人</b></td>
                            <td><?php echo $ms['legal_name']; ?></td>
                            <td><b>联系电话</b></td>
                            <td><?php echo $ms['legal_phone']; ?></td>
                        </tr>
						<tr>
                            <td><b>兽药许可证编号</b></td>
                            <td><?php echo $ms['license']; ?></td>
                            <td><b>发证时间</b></td>
                            <td><?php if($ms['license_begin'] > 0) { echo date('Y-m-d', $ms['license_begin']); } ?></td>
                        </tr>
						<tr>
                            <td><b>有效期至</b></td>
                            <td><?php if($ms['license_time'] > 0) { echo date('Y-m-d', $ms['license_time']); } ?></td>
							<td colspan="2"></td>
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
	<script src="/Content/myjs/global.js"></script>
    <script src="/Content/myjs/modify.js"></script>
</body>
</html>