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
    <title>出库信息详情</title>
    <link href="/Content/layui/css/layui.css" rel="stylesheet" />
    <link href="/Content/fhuaui/css/fhuaui.css" rel="stylesheet" />
    <link href="/Content/Font-Awesome/css/font-awesome.css" rel="stylesheet" />
    <script src="/Content/layui/layui.js"></script>
</head>
<body>
    <div class="main-wrap">
        <blockquote class="layui-elem-quote fhui-admin-main_hd">
            <h2>出库信息详情 　
                <a class="layui-btn layui-btn-small" onclick="$('#myPrintArea').printArea();"><i class="fa fa-print"></i>打印</a>
            </h2>
        </blockquote>
        <div class="y-role">
            <!--文字列表-->
            <div class="fhui-admin-table-container" id='myPrintArea'>
                <div class="layui-form-item"><center>出库信息详情</center></div>
                <table class="layui-table layui-tables" lay-skin="line" boder='1'>
                    <tbody>
                        <tr>
                            <td><b>名称</b></td>
                            <td><?php echo explode(' ', $ms['bname'])[0];?></td>
                            <td><b>数量及单位</b></td>
                            <td><?php echo $ms['output_num']?><?php echo explode(' ', $ms['bname'])[2]; ?></td>
                        </tr>
                        <tr>
                            <td><b>生产厂家</b></td>
                            <td><?php echo explode(' ', $ms['bname'])[1]; ?></td>
                            <td><b>批号</b></td>
                            <td><?php echo explode(' ', $ms['bname'])[3]; ?></td>
                        </tr>
						<tr>
                            <td><b>出库时间</b></td>
                            <td><?php echo date('Y-m-d', $ms['output_time']); ?></td>
                            <td><b>领用人员</b></td>
                            <td><?php echo $ms['leading_person']; ?></td>
                        </tr>
						<tr>
                            <td><b>领用单位</b></td>
                            <td><?php echo $ms['leading_name']; ?></td>
                            <td><b>用途</b></td>
                            <td><?php echo $this->config->item('use')[$ms['purpose']]; ?></td>
                        </tr>
						<tr>
                            <td><b>状态</b></td>
                            <td colspan='3'><?php if($ms['status'] == 1){echo '通过';}elseif($ms['status'] == 2){echo '未通过';}else{echo '待审';} ?></td>
                        </tr>
						<tr>
                            <td><b>备注</b></td>
                            <td colspan='3'>
							<?php echo $ms['remark'] ?>
							</td>
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