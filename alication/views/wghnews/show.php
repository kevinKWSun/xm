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
    <title>网格化监管信息详情</title>
    <link href="/Content/layui/css/layui.css" rel="stylesheet" />
    <link href="/Content/fhuaui/css/fhuaui.css" rel="stylesheet" />
    <link href="/Content/Font-Awesome/css/font-awesome.css" rel="stylesheet" />
    <script src="/Content/layui/layui.js"></script>
</head>
<body>
    <div class="main-wrap">
        <blockquote class="layui-elem-quote fhui-admin-main_hd">
            <h2>网格化监管信息详情 　
                <a class="layui-btn layui-btn-small" onclick="$('#myPrintArea').printArea();"><i class="fa fa-print"></i>打印</a>
            </h2>
        </blockquote>
        <div class="y-role">
            <!--文字列表-->
            <div class="fhui-admin-table-container" id='myPrintArea'>
                <div class="layui-form-item"><center>网格化监管信息详情</center></div>
                <table class="layui-table layui-tables" lay-skin="line" boder='1'>
                    <tbody>
                        <tr>
                            <td><b>编号</b></td>
                            <td><?php echo $ms['num'] ?></td>
                            <td><b>网格名称</b></td>
                            <td><?php echo $ms['name']; ?></td>
                        </tr>
                        <tr>
                            <td><b>地址</b></td>
                            <td colspan='3'><?php echo $ms['area'] ?></td>
						</tr>
						<tr>
                            <td><b>监管对象</b></td>
                            <td colspan='3'><?php echo $ms['jgdx'] ?></td>
                        </tr>
						<tr>
                            <td><b>监管责任单位</b></td>
                            <td><?php echo $ms['unit']; ?></td>
                            <td><b>监管责任人</b></td>
                            <td><?php echo $ms['admin']; ?></td>
                        </tr>
						<tr>
                            <td><b>监管责任人职务</b></td>
                            <td><?php echo $ms['jname']; ?></td>
                            <td><b>联系方式</b></td>
                            <td><?php echo $ms['tel'] ?></td>
                        </tr>
						<tr>
                            <td><b>管辖区域</b></td>
                            <td colspan='3' height='350'><div id="mapDiv" style="width:100%; height: 350px"></div></td>
						</tr>
						<tr>
                            <td><b>监管对象</b></td>
                            <td colspan='3'><?php echo $ms['jgdx'] ?></td>
                        </tr>
                    </tbody>
                </table>
                <div style='float:right;'><?php echo '填表人：',get_user($ms['admin_id'])['realname'], ' 填报单位：',$ms['tunit'] ,' 填表时间：',date('Y-m-d', $ms['add_time']),' ';?></div>
            </div>
            <!--/文字列表-->
        </div>
    </div>
    <script type="text/javascript" src="/Content/js/jquery-1.7.2.min.js"></script>
    <script type="text/javascript" src="/Content/jquery.PrintAreas.js"></script>
	<script type="text/javascript" src="http://api.tianditu.com/api?v=4.0"></script>
	<script>
		$(function(){
			var map;
			var zoom = 12;
			//初始化地图对象
			map = new T.Map("mapDiv");
			//设置显示地图的中心点和级别
			map.centerAndZoom(new T.LngLat(<?php echo explode('|', $ms['gxarea'])[0]?>), zoom);
			var points = [];
			<?php foreach(explode('|', $ms['gxarea']) as $v):?>
			points.push(new T.LngLat(<?php echo $v ?>));
			<?php endforeach;?>
			//创建面对象
			var polygon = new T.Polygon(points,{
				color: "red", weight: 2, opacity: 0.5, fillColor: "#FFFFFF", fillOpacity: 0.5
			});
			//向地图上添加面
			map.addOverLay(polygon);
		});
	</script>
</body>
</html>