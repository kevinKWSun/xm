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
    <title>屠宰企业信息详情</title>
    <link href="/Content/layui/css/layui.css" rel="stylesheet" />
    <link href="/Content/fhuaui/css/fhuaui.css" rel="stylesheet" />
    <link href="/Content/Font-Awesome/css/font-awesome.css" rel="stylesheet" />
    <script src="/Content/layui/layui.js"></script>
</head>
<body>
    <div class="main-wrap">
        <blockquote class="layui-elem-quote fhui-admin-main_hd">
            <h2>屠宰企业信息详情 　
                <a class="layui-btn layui-btn-small" onclick="$('#myPrintArea').printArea();"><i class="fa fa-print"></i>打印</a>
            </h2>
        </blockquote>
        <div class="y-role">
            <!--文字列表-->
            <div class="fhui-admin-table-container" id='myPrintArea'>
                <div class="layui-form-item"><center>屠宰企业信息详情</center></div>
                <table class="layui-table layui-tables" lay-skin="line" boder='1'>
                    <tbody>
                        <tr>
                            <td><b>屠宰企业</b></td>
                            <td><?php echo $ms['num']; ?></td>
                            <td><b>邮政编码</b></td>
                            <td><?php echo $ms['zipcode']; ?></td>
                        </tr>
                        <tr>
                            <td><b>法人代表</b></td>
                            <td><?php echo $ms['legal'] ?></td>
                            <td><b>组织机构代码</b></td>
                            <td><?php echo $ms['orgcode'] ?></td>
                        </tr>
						<tr>
                            <td><b>地址</b></td>
                            <td colspan='3'><?php echo $ms['area'] ?></td>
                        </tr>
						<tr>
                            <td><b>工商注册日期</b></td>
                            <td><?php echo date('Y-m-d', $ms['zctime']); ?></td>
                            <td><b>负责人</b></td>
                            <td><?php echo $ms['charge']; ?></td>
                        </tr>
						<tr>
                            <td><b>负责人电话</b></td>
                            <td><?php echo $ms['phone'] ?></td>
                            <td><b>屠宰种类</b></td>
                            <td><?php foreach(explode(',',$ms['type']) as $c){echo $this->config->item('animal')[$c],' ';} ?></td>
                        </tr>
						<tr>
                            <td><b>企业类型</b></td>
                            <td><?php echo $this->config->item('species')[$ms['species']]; ?></td>
                            <td><b>年屠宰能力</b></td>
                            <td><?php echo $ms['volum']; ?></td>
                        </tr>
						<tr>
                            <td><b>上年度屠宰量</b></td>
                            <td><?php echo $ms['last_volum'] ?></td>
                            <td><b>驻厂兽医</b></td>
                            <td><?php echo $ms['real_name'], ' / ', $ms['phone']; ?></td>
                        </tr>
						<tr>
                            <td><b>违规违法记录</b></td>
                            <td colspan='3'><?php echo $ms['remark'] ? $ms['remark'] : '无';?></td>
                        </tr>
						<tr>
                            <td><b>安全承诺书</b></td>
                            <td colspan='3'>
							<img src="<?php echo $ms['commit_letter'];?>" alt="" width='300'>
							</td>
                        </tr>
						<tr>
                            <td><b>防疫合格证</b></td>
                            <td colspan='3'>
							<img src="<?php echo $ms['prevent_cert'];?>" alt="" width='300'>
							</td>
                        </tr>
						<tr>
                            <td><b>排污许可证</b></td>
                            <td colspan='3'>
							<img src="<?php echo $ms['sewage_permit'];?>" alt="" width='300'>
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