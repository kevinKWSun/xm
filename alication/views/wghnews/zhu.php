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
    <title>大数据分析评估</title>
    <link href="/Content/layui/css/layui.css" rel="stylesheet" />
    <link href="/Content/fhuaui/css/fhuaui.css" rel="stylesheet" />
    <link href="/Content/Font-Awesome/css/font-awesome.css" rel="stylesheet" />
</head>
<body style="height: 100%; margin: 0">
	<div id="zhu" style="height: 350px"></div>
	<script type="text/javascript" src="http://echarts.baidu.com/gallery/vendors/echarts/echarts-all-3.js"></script>
	<script type="text/javascript" src="http://echarts.baidu.com/gallery/vendors/echarts-stat/ecStat.min.js"></script>
	<script type="text/javascript" src="http://echarts.baidu.com/gallery/vendors/echarts/extension/dataTool.min.js"></script>
	<script type="text/javascript" src="http://echarts.baidu.com/gallery/vendors/echarts/map/js/china.js"></script>
	<script type="text/javascript" src="http://echarts.baidu.com/gallery/vendors/echarts/map/js/world.js"></script>
	<script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=ZUONbpqGBsYGXNIYHicvbAbM"></script>
	<script type="text/javascript" src="http://echarts.baidu.com/gallery/vendors/echarts/extension/bmap.min.js"></script>
    <script>
		var dom = document.getElementById("zhu");
		var myChart = echarts.init(dom);
		var app = {};
		option = null;
		app.title = '坐标轴刻度与标签对齐';
		option = {
			backgroundColor: '#060f4c',
			color: ['#339899'],
			tooltip : {
				trigger: 'axis',
				axisPointer : {            // 坐标轴指示器，坐标轴触发有效
					type : 'shadow'        // 默认为直线，可选为：'line' | 'shadow'
				}
			},
			grid: {
				left: '3%',
				right: '4%',
				bottom: '3%',
				containLabel: true
			},
			xAxis : [
				{
					type : 'category',
					data : [<?php foreach($farm as $k => $v):?><?php echo "'".$k."',";?><?php endforeach;?>],
					axisTick: {
						alignWithLabel: true
					},
					axisLine: {
						lineStyle: {
							color: '#fff'
						}
					}
				}
			],
			yAxis : [
				{
					type : 'value',
					axisLine: {
						lineStyle: {
							color: '#fff'
						}
					}
				}
			],
			series : [
				{
					name:'数量',
					type:'bar',
					barWidth: '60%',
					data:[<?php foreach($farm as $k => $v):?><?php echo count($v),',';?><?php endforeach;?>],
					itemStyle: {
						normal: {
							barBorderRadius: 5,
							color: new echarts.graphic.LinearGradient(
								0, 0, 0, 1,
								[
									{offset: 0, color: '#14c8d4'},
									{offset: 1, color: '#43eec6'}
								]
							)
						}
					}
				}
			]
		};
		if (option && typeof option === "object") {
			myChart.setOption(option, true);
		}
    </script>
</body>
</html>