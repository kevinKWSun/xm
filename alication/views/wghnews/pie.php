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
   <div id="pie" style="height: 350px"></div>
	<script type="text/javascript" src="http://echarts.baidu.com/gallery/vendors/echarts/echarts-all-3.js"></script>
	<script type="text/javascript" src="http://echarts.baidu.com/gallery/vendors/echarts-stat/ecStat.min.js"></script>
	<script type="text/javascript" src="http://echarts.baidu.com/gallery/vendors/echarts/extension/dataTool.min.js"></script>
	<script type="text/javascript" src="http://echarts.baidu.com/gallery/vendors/echarts/map/js/china.js"></script>
	<script type="text/javascript" src="http://echarts.baidu.com/gallery/vendors/echarts/map/js/world.js"></script>
	<script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=ZUONbpqGBsYGXNIYHicvbAbM"></script>
	<script type="text/javascript" src="http://echarts.baidu.com/gallery/vendors/echarts/extension/bmap.min.js"></script>
    <script>
		var dom = document.getElementById("pie");
		var myChart = echarts.init(dom);
		var app = {};
		option = null;
		// Generate data
		var category = [];
		var dottedBase = +new Date();
		var lineData = [];
		var barData = [];
		for (var i = 0; i < 20; i++) {
			var date = new Date(dottedBase += 3600 * 24 * 1000);
			category.push([
				date.getFullYear(),
				date.getMonth() + 1,
				date.getDate()
			].join('-'));
			var b = Math.random() * 200;
			var d = Math.random() * 200;
			barData.push(b)
			lineData.push(d + b);
		}
		option = {
			backgroundColor: '#060f4c',
			legend: {
				// orient: 'vertical',
				// top: 'middle',
				//bottom: 10,
				//left: 'center',
				data: [<?php foreach($farm as $k => $v):?><?php echo "'".$k."',";?><?php endforeach;?>],
				textStyle: {
					color: '#FFFFFF'
				},
				orient: 'vertical',
				x: 'left',
				//top: 40,
				//left: 50,
			},
			series: [{
				type: 'pie',
				radius: ['35%', '55%'],
				silent: true,
				data: [{
					value: 10,
					itemStyle: {
						normal: {
							color: '#050f58',
							borderColor: '#162abb',
							borderWidth: 2,
							shadowBlur: 50,
							shadowColor: 'rgba(21,41,185,.75)'
						}
					}
				}]
			}, {
				type: 'pie',
				radius: ['35%', '55%'],
				silent: true,
				label: {
					normal: {
						show: false,
					}
				},
				data: [{
					value: 1,
					itemStyle: {
						normal: {
							color: '#050f58',
							shadowBlur: 50,
							shadowColor: 'rgba(21,41,185,.75)'
						}
					}
				}]
			},{
				name: '比例',
				type: 'pie',
				radius: ['39%', '52%'],
				hoverAnimation: true,
				data: [
				<?php foreach($farm as $k => $v):?>
				{
					value: <?php echo count($v);?>,
					name: "<?php echo $k;?>",
					/* itemStyle: {
						normal: {
							label: {
								show: true,
								textStyle: {
									fontSize: 15,
									fontWeight: "bold"
								},
								position: "center"
							},
							color: new echarts.graphic.LinearGradient(0, 0, 0, 1, [{
								offset: 0,
								color: 'rgba(5,1,255,1)'
							}, {
								offset: 1,
								color: 'rgba(15,15,90,1)'
							}])
						}
					}, */
					label: {
						normal: {
							position: 'outside',
							textStyle: {
								color: '#fff',
								fontSize: 14
							},
							//formatter: '{b}: 1,120\n\n{a}: {c}%'
							formatter: '{b}(数量): {c}'
						}
					},
					labelLine: {
						normal: {
							show: true,
							length: 20,
							length2: 30,
							smooth: false,
							lineStyle: {
								width: 1,
								color: "#2141b5"
							}
						}
					}
				}
				<?php echo ',';endforeach;?>
				]
			},{
				name: '',
				type: 'pie',
				clockWise: true,
				hoverAnimation: true,
				radius: [200, 200],
				label: {
					normal: {
						position: 'center'
					}
				},
				data: [{
					value: 0,
					label: {
						normal: {
							//formatter: '38',
							textStyle: {
								color: '#fe8b53',
								fontSize: 25,
								fontWeight: 'bold'
							}
						}
					}
				},{
					tooltip: {
						show: false
					},
					label: {
						normal: {
							formatter: '\n养殖场',
							textStyle: {
								color: '#bbeaf9',
								fontSize: 14
							}
						}
					}
				}]
			}]
		};
		if (option && typeof option === "object") {
			myChart.setOption(option, true);
		}
    </script>
</body>
</html>