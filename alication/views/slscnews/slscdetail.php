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
    <title>饲料生产企业详情</title>
    <link href="/Content/layui/css/layui.css" rel="stylesheet" />
    <link href="/Content/fhuaui/css/fhuaui.css" rel="stylesheet" />
    <link href="/Content/Font-Awesome/css/font-awesome.css" rel="stylesheet" />
    <script src="/Content/layui/layui.js"></script>
</head>
<body>
    <div class="main-wrap">
        <blockquote class="layui-elem-quote fhui-admin-main_hd">
            <h2>饲料生产企业详情 　
                <a class="layui-btn layui-btn-small" onclick="$('#myPrintArea').printArea();"><i class="fa fa-print"></i>打印</a>
				<a class="layui-btn layui-btn-small do-action" data-type="doGoBack" data-href="/yznews/index"><i class="fa fa-mail-reply"></i>返回上一页</a>
            </h2>
        </blockquote>
        <div class="y-role">
            <!--文字列表-->
            <div class="fhui-admin-table-container" id='myPrintArea'>
                <div class="layui-form-item"><center>饲料生产企业详情</center></div>
                <table class="layui-table layui-tables" lay-skin="line" boder='1'>
                    <tbody>
                        <tr>
                            <td><b>企业名称</b></td>
                            <td><?php echo $ms['name']; ?></td>
                            <td><b>编号</b></td>
                            <td><?php echo 'YTSLSC' . str_pad($ms['id'],6,'0',STR_PAD_LEFT); ?></td>
                        </tr>
                        <tr>
                            <td><b>生产许可证</b></td>
                            <td><?php echo $ms['license']; ?></td>
                            <td><b>有效期</b></td>
                            <td><?php if($ms['license_time']) { echo date('Y-m-d', $ms['license_time']); } ?></td>
                        </tr>
						<tr>
                            <td><b>工商执照</b></td>
                            <td><?php echo $ms['reg']; ?></td>
                            <td><b>成立日期</b></td>
                            <td><?php if($ms['reg_time']) { echo date('Y-m-d', $ms['reg_time']); } ?></td>
                        </tr>
						<tr>
                            <td><b>注册地址</b></td>
                            <td><?php echo $ms['reg_area']; ?></td>
                            <td><b>邮编</b></td>
                            <td><?php echo $ms['zipcode']; ?></td>
                        </tr>
						<tr>
                            <td><b>生产地址</b></td>
                            <td><?php echo $ms['produce_area']; ?></td>
                            <td><b>邮编</b></td>
                            <td><?php echo $ms['postcode']; ?></td>
                        </tr>
						<tr>
                            <td><b>经度</b></td>
                            <td><?php echo $ms['lng']; ?></td>
                            <td><b>纬度</b></td>
                            <td><?php echo $ms['lat']; ?></td>
                        </tr>
						<tr>
                            <td><b>法人</b></td>
                            <td><?php echo $ms['legal_name']; ?></td>
                            <td><b>联系电话</b></td>
                            <td><?php echo $ms['legal_phone']; ?></td>
                        </tr>
						<tr>
                            <td><b>负责人</b></td>
                            <td><?php echo $ms['real_name']; ?></td>
                            <td><b>联系电话</b></td>
                            <td><?php echo $ms['phone']; ?></td>
                        </tr>
						<tr>
							<td><b>身份证号</b></td>
                            <td><?php echo $ms['idcard']; ?></td>
							<td colspan="2"></td>
						</tr>
						<tr>
                            <td><b>有无动物源性产品</b></td>
                            <td><?php echo $ms['origin']; ?></td>
                            <td><b>动物源性原料来源地</b></td>
                            <td><?php echo $ms['source']; ?></td>
                        </tr>
						<tr>
                            <td><b>主要销售地区</b></td>
                            <td><?php echo $ms['sale_addr']; ?></td>
                            <td><b>销售形式</b></td>
                            <td><?php echo $ms['sale_type']; ?></td>
                        </tr>
						<tr>
                            <td><b>产品品种</b></td>
                            <td><?php echo $ms['varieties']; ?></td>
                            <td><b>有无定制产品</b></td>
                            <td><?php echo $ms['made']; ?></td>
                        </tr>
						<tr>
                            <td><b>运营状况</b></td>
                            <td><?php if($ms['status']==0){echo '待审';}elseif($ms['status']==1){echo '正常';}elseif($ms['status']==2){echo '未通过';}else{echo '关闭';} ?></td>
                            <td><b>关闭时间</b></td>
                            <td><?php echo ($ms['status']==3) ? date('y-m-d :H:i', $ms['stop']) : '无'; ?></td>
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