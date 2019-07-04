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
    <title>入库信息详情</title>
    <link href="/Content/layui/css/layui.css" rel="stylesheet" />
    <link href="/Content/fhuaui/css/fhuaui.css" rel="stylesheet" />
    <link href="/Content/Font-Awesome/css/font-awesome.css" rel="stylesheet" />
    <script src="/Content/layui/layui.js"></script>
</head>
<body>
    <div class="main-wrap">
        <blockquote class="layui-elem-quote fhui-admin-main_hd">
            <h2>入库信息详情 　
                <a class="layui-btn layui-btn-small" onclick="$('#myPrintArea').printArea();"><i class="fa fa-print"></i>打印</a>
            </h2>
        </blockquote>
        <div class="y-role">
            <!--文字列表-->
            <div class="fhui-admin-table-container" id='myPrintArea'>
                <div class="layui-form-item"><center>入库信息详情</center></div>
                <table class="layui-table layui-tables" lay-skin="line" boder='1'>
                    <tbody>
                        <tr>
                            <td><b>物资名称</b></td>
                            <td><?php echo get_wzmc()[$ms['cate']][$ms['cate_name']]; ?></td>
                            <td><b>数量及单位</b></td>
                            <td><?php echo $ms['num'] ?></td>
                        </tr>
                        <tr>
                            <td><b>生产厂家</b></td>
                            <td><?php echo get_company()[$ms['cate_name']][$ms['manufacturer']]; ?></td>
                            <td><b>批号</b></td>
                            <td><?php echo $ms['batch_num'] ?></td>
                        </tr>
						<tr>
                            <td><b>入库时间</b></td>
                            <td><?php echo date('Y-m-d', $ms['input_time']); ?></td>
                            <td><b>有效时间</b></td>
                            <td><?php echo date('Y-m-d', $ms['expiry_time']); ?></td>
                        </tr>
						<tr>
                            <td><b>签收人</b></td>
                            <td><?php echo $ms['sign_person']; ?></td>
                            <td><b>签收单位</b></td>
                            <td><?php echo $ms['sign_uint'] ?></td>
                        </tr>
						<tr>
                            <td><b>物资类别</b></td>
                            <td><?php echo get_wzlb()[$ms['cate']]; ?></td>
                            <td><b>状态</b></td>
                            <td><?php if(($ms['expiry_time']-time()) < 0){echo '过期';}else{echo '正常';} ?></td>
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