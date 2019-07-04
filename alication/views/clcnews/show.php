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
    <title>无害化处理厂详情</title>
    <link href="/Content/layui/css/layui.css" rel="stylesheet" />
    <link href="/Content/fhuaui/css/fhuaui.css" rel="stylesheet" />
    <link href="/Content/Font-Awesome/css/font-awesome.css" rel="stylesheet" />
    <script src="/Content/layui/layui.js"></script>
</head>
<body>
    <div class="main-wrap">
        <blockquote class="layui-elem-quote fhui-admin-main_hd">
            <h2>无害化处理厂详情 　
                <a class="layui-btn layui-btn-small" onclick="$('#myPrintArea').printArea();"><i class="fa fa-print"></i>打印</a>
            </h2>
        </blockquote>
        <div class="y-role">
            <!--文字列表-->
            <div class="fhui-admin-table-container" id='myPrintArea'>
                <div class="layui-form-item"><center>无害化处理厂详情</center></div>
                <table class="layui-table layui-tables" lay-skin="line" boder='1'>
                    <tbody>
                        <tr>
                            <td><b>处理厂名称</b></td>
                            <td><?php echo $ms['name']; ?></td>
                            <td><b>地址</b></td>
                            <td><?php echo $ms['area'] ?></td>
                        </tr>
                        <tr>
                            <td><b>负责人</b></td>
                            <td><?php echo $ms['charge'] ?></td>
                            <td><b>联系电话</b></td>
                            <td><?php echo $ms['phone'] ?></td>
                        </tr>
						<tr>
                            <td><b>畜主身份证</b></td>
                            <td><?php echo $ms['xm'] ?></td>
                            <td><b>一卡通号</b></td>
                            <td><?php echo $ms['card'] ?></td>
                        </tr>
						<tr>
                            <td><b>处理方式</b></td>
                            <td><?php echo $this->config->item('mode')[$ms['mode']]; ?></td>
                            <td><b>日处理能力</b></td>
                            <td><?php echo $ms['volum'] ?> 吨</td>
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