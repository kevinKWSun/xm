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
    <title>疫情信息详情</title>
    <link href="/Content/layui/css/layui.css" rel="stylesheet" />
    <link href="/Content/fhuaui/css/fhuaui.css" rel="stylesheet" />
    <link href="/Content/Font-Awesome/css/font-awesome.css" rel="stylesheet" />
    <script src="/Content/layui/layui.js"></script>
</head>
<body>
    <div class="main-wrap">
        <blockquote class="layui-elem-quote fhui-admin-main_hd">
            <h2>疫情信息详情 　
                <a class="layui-btn layui-btn-small" onclick="$('#myPrintArea').printArea();"><i class="fa fa-print"></i>打印</a>
            </h2>
        </blockquote>
        <div class="y-role">
            <!--文字列表-->
            <div class="fhui-admin-table-container" id='myPrintArea'>
                <div class="layui-form-item"><center>疫情信息详情</center></div>
                <table class="layui-table layui-tables" lay-skin="line" boder='1'>
                    <tbody>
                        <tr>
                            <td><b>疫情编号</b></td>
                            <td><?php echo 'YTYQ' . str_pad($ms['id'],6,'0',STR_PAD_LEFT); ?></td>
                            <td><b>报告时间</b></td>
                            <td><?php echo date('Y-m-d', $ms['times']); ?></td>
                        </tr>
                        <tr>
                            <td><b>地点</b></td>
                            <td><?php echo $ms['area'] ?></td>
                            <td><b>单位(个人)</b></td>
                            <td><?php echo $ms['unit'] ?></td>
                        </tr>
						<tr>
                            <td><b>单位(个人)联系方式</b></td>
                            <td colspan='3'><?php echo $ms['tel'] ?></td>
                        </tr>
						<tr>
                            <td><b>疑似的疫病</b></td>
                            <td><?php echo $ms['suspected']; ?></td>
                            <td><b>发病动物种类</b></td>
                            <td><?php echo $this->config->item('fbtype')[$ms['type']]; ?></td>
                        </tr>
						<tr>
                            <td><b>存栏数量</b></td>
                            <td><?php echo $ms['cnumber']; ?></td>
                            <td><b>发病数量</b></td>
                            <td><?php echo $ms['fnumber'] ?></td>
                        </tr><tr>
                            <td><b>死亡数量</b></td>
                            <td><?php echo $ms['number']; ?></td>
                            <td><b>临床症状</b></td>
                            <td><?php echo $ms['symptom'] ?></td>
                        </tr>
						<tr>
                            <td><b>审核状态</b></td>
                            <td colspan='3'><?php if($ms['status']==0){echo '待审';}elseif($ms['status']==1){echo '通过';}elseif($ms['status']==2){echo '未通过';}else{echo '未知';} ?></td>
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