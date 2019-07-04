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
    <title>动物诊疗机构信息详情</title>
    <link href="/Content/layui/css/layui.css" rel="stylesheet" />
    <link href="/Content/fhuaui/css/fhuaui.css" rel="stylesheet" />
    <link href="/Content/Font-Awesome/css/font-awesome.css" rel="stylesheet" />
    <script src="/Content/layui/layui.js"></script>
</head>
<body>
    <div class="main-wrap">
        <blockquote class="layui-elem-quote fhui-admin-main_hd">
            <h2>动物诊疗机构详情 　
                <a class="layui-btn layui-btn-small" onclick="$('#myPrintArea').printArea();"><i class="fa fa-print"></i>打印</a>
            </h2>
        </blockquote>
        <div class="y-role">
            <!--文字列表-->
            <div class="fhui-admin-table-container" id='myPrintArea'>
                <div class="layui-form-item"><center>动物诊疗机构详情</center></div>
                <table class="layui-table layui-tables" lay-skin="line" boder='1'>
                    <tbody>
                        <tr>
                            <td><b>机构名称</b></td>
                            <td><?php echo $ms['num']; ?></td>
                            <td><b>机构类型</b></td>
                            <td><?php echo $this->config->item('yytype')[$ms['type']]; ?></td>
                        </tr>
                        <tr>
                            <td><b>法人代表</b></td>
                            <td><?php echo $ms['leader'] ?></td>
                            <td><b>联系电话</b></td>
                            <td><?php echo $ms['phone'] ?></td>
                        </tr>
						<tr>
                            <td><b>地址</b></td>
                            <td colspan='3'><?php echo $ms['area'] ?></td>
                        </tr>
						<tr>
                            <td><b>执业兽医人数</b></td>
                            <td><?php echo $ms['number'] ?></td>
                            <td><b>是否狂犬病定点门诊</b></td>
                            <td><?php echo ($ms['point']==1) ? '是' : '否'; ?></td>
                        </tr>
						<tr>
                            <td><b>许可证编号</b></td>
                            <td><?php echo $ms['license'] ?></td>
                            <td><b>发证日期</b></td>
                            <td><?php echo date('Y-m-d',$ms['ftime']); ?></td>
                        </tr>
						<tr>
                            <td><b>主要仪器设备</b></td>
                            <td colspan='3'><?php echo $ms['remark'] ?></td>
                        </tr>
						<tr>
                            <td><b>诊疗许可证</b></td>
                            <td colspan='3'>
							<img src="<?php echo $ms['pic'];?>" alt="" width='300'>
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