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
</head>
<body style="height: 100%; margin: 0">
    <div id="map" style="height: 650px"></div>
	<script type="text/javascript" src="http://echarts.baidu.com/gallery/vendors/echarts/echarts-all-3.js"></script>
	<script type="text/javascript" src="http://echarts.baidu.com/gallery/vendors/echarts-stat/ecStat.min.js"></script>
	<script type="text/javascript" src="http://echarts.baidu.com/gallery/vendors/echarts/extension/dataTool.min.js"></script>
	<script type="text/javascript" src="http://echarts.baidu.com/gallery/vendors/echarts/map/js/china.js"></script>
	<script type="text/javascript" src="http://echarts.baidu.com/gallery/vendors/echarts/map/js/world.js"></script>
	<script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=ZUONbpqGBsYGXNIYHicvbAbM"></script>
	<script type="text/javascript" src="http://echarts.baidu.com/gallery/vendors/echarts/extension/bmap.min.js"></script>
    <script>
        var dom = document.getElementById("map");
		var myChart = echarts.init(dom);
		var app = {};
		option = null;
		var geoCoordMap = {
			<?php foreach($farm as $k => $v): if($v){foreach($v as $vs):?>
			"<?php echo $k?>":[<?php echo $vs['lng'],',',$vs['lat'];?>]
			<?php echo ',';endforeach;}endforeach;?>
		};
		var convertData = function (data) {
			var res = [];
			for (var i = 0; i < data.length; i++) {
				var geoCoord = geoCoordMap[data[i].name];
				if (geoCoord) {
					res.push({
						name: data[i].name,
						value: geoCoord.concat(data[i].value)
					});
				}
			}
			return res;
		};
		option = {
			backgroundColor: '#060f4c',
			title: {
				text: '烟台',
				subtext: '养殖场分析',
				sublink: '//',
				x:'center',
				textStyle: {
					color: '#fff'
				}
			},
			tooltip: {
				trigger: 'item',
				formatter: function (params) {
					return params.name + ' : ' + params.value[2]; //+ ' : ' + params.value[1];
				}
			},
			legend: {
				orient: 'vertical',
				y: 'bottom',
				x:'right',
				data:['养殖场'],
				textStyle: {
					color: '#fff'
				}
			},
			visualMap: {
				min: 0,
				//max: 20000,
				calculable: false,
				inRange: {
					color: ['#50a3ba', 'green', 'red']
				},
				textStyle: {
					color: '#fff'
				}
			},
			/* toolbox: {
				show: true,
				orient: 'vertical',
				left: 'right',
				top: 'center',
				feature: {
					dataView: {readOnly: false},
					saveAsImage: {}
				}
			},
			animation: false,
			animationDurationUpdate: 1000,
			animationEasingUpdate: 'cubicInOut', */
			geo: {
				map: 'china',
				label: {
					emphasis: {
						show: true
					}
				},
				itemStyle: {
					normal: {
						areaColor: '#001737',
						borderColor: '#0f5099'
					},
					emphasis: {
						areaColor: '#0087c7'
					}
				},
				textStyle: {
					color: '#fff'
				},
				roam:true
			},
			series: [
				{
					name: '养殖场',
					type: 'scatter',
					coordinateSystem: 'geo',
					data: convertData([
						<?php foreach($farm as $k => $v): if($v){foreach($v as $vs):?>
						{name: "<?php echo $k?>", value: "<?php echo $vs['name'];?><?php if($vs['stock']){foreach($vs['stock'] as $vb): ?><?php echo '<br>',$this->config->item('breed')[$vb['breed']],': ',$vb['stock'];?><?php endforeach;}?>"}
						<?php echo ',';endforeach;}endforeach;?>
					]),
					symbolSize: function (val) {
						//return val[2] * 100;
						return 10;
					},
					label: {
						normal: {
							formatter: '{b}',
							position: 'right',
							show: false
						},
						emphasis: {
							show: false
						}
					},
					itemStyle: {
						normal: {
							color: '#fff'
						}
					}
				}/* ,
				{
					name: 'Top 5',
					type: 'effectScatter',
					coordinateSystem: 'geo',
					data: convertData(data.sort(function (a, b) {
						return b.value - a.value;
					}).slice(0, 6)),
					symbolSize: function (val) {
						return val[2] / 10;
					},
					showEffectOn: 'render',
					rippleEffect: {
						brushType: 'stroke'
					},
					hoverAnimation: true,
					label: {
						normal: {
							formatter: '{b}',
							position: 'right',
							show: true
						}
					},
					itemStyle: {
						normal: {
							color: '#f4e925',
							shadowBlur: 10,
							shadowColor: '#333'
						}
					},
					zlevel: 1
				} */
			]
		};
		if (option && typeof option === "object") {
			myChart.setOption(option, true);
		}
    </script>
</body>
</html>