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
    <title>散养户基本信息详情</title>
    <link href="/Content/layui/css/layui.css" rel="stylesheet" />
    <link href="/Content/fhuaui/css/fhuaui.css" rel="stylesheet" />
    <link href="/Content/Font-Awesome/css/font-awesome.css" rel="stylesheet" />
    <script src="/Content/layui/layui.js"></script>
</head>
<body>
    <div class="main-wrap">
        <blockquote class="layui-elem-quote fhui-admin-main_hd">
            <h2>散养户基本信息详情 　
                <a class="layui-btn layui-btn-small" onclick="$('#myPrintArea').printArea();"><i class="fa fa-print"></i>打印</a>
            </h2>
        </blockquote>
        <div class="y-role">
            <!--文字列表-->
            <div class="fhui-admin-table-container" id='myPrintArea'>
                <div class="layui-form-item"><center>散养户基本信息详情</center></div>
                <table class="layui-table layui-tables" lay-skin="line" boder='1'>
                    <tbody>
                        <tr>
                            <td><b>散养户名称</b></td>
                            <td><?php echo $ms['num']; ?></td>
                            <td><b>联系电话</b></td>
                            <td><?php echo $ms['phone'] ?></td>
                        </tr>
                        <tr>
                            <td><b>身份证号</b></td>
                            <td><?php echo $ms['idcard'] ?></td>
                            <td><b>一卡通号</b></td>
                            <td><?php echo $ms['card'] ?></td>
                        </tr>
						<tr>
                            <td><b>地址</b></td>
                            <td><?php echo $ms['area'] ?></td>
                            <td><b>监管兽医</b></td>
                            <td><?php echo $ms['vname'] ?></td>
                        </tr>
						<tr>
                            <td><b>有无摄像头</b></td>
                            <td><?php echo ($ms['camera']==1) ? '有' : '无'; ?></td>
                            <td><b>备注</b></td>
                            <td><?php echo $ms['remark'] ?></td>
                        </tr>
						<tr>
                            <td><b>图片</b></td>
                            <td colspan='3'>
							<?php foreach(explode(',', $ms['pic']) as $k => $v): ?>
							<img layer-pid="<?php echo $k+1;?>" layer-src="<?php echo $v;?>" src="<?php echo $v;?>" alt="">
							<?php endforeach; ?>
							</td>
                        </tr>
						<tr>
                            <td><b>运营状况</b></td>
                            <td><?php if($ms['status']==0){echo '待审';}elseif($ms['status']==1){echo '正常';}elseif($ms['status']==2){echo '未通过';}else{echo '关闭';} ?></td>
                            <td><b>关闭时间</b></td>
                            <td><?php echo ($ms['status']==3) ? date('Y-m-d H:i', $ms['stop']) : '无'; ?></td>
                        </tr>
                        <tr>
                            <td colspan='4'>
                                <fieldset style='border: 1px solid #e6e6e6;'>
                                    <legend>畜禽信息</legend>
                                    <table class="layui-table layui-tables" lay-skin="line" boder='1'>
                                        <tbody>
                                            <tr>
                                                <td>畜禽种类</td>
                                                <td>畜禽品种</td>
                                                <td>存栏数量</td>
                                            </tr>
                                            <?php foreach ($m as $k => $v):?>
                                            <tr>
                                                <td><?php echo $this->config->item('breed')[$v['breed']] ?></td>
                                                <td><?php echo $this->config->item('variety')[$v['types']] ?></td>
                                                <td><?php echo $v['stock'],$this->config->item('unit')[$v['unit']] ?></td>
                                            </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </fieldset>
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