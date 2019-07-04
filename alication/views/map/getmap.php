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
    <title>地图区域</title>
    <link href="/Content/layui/css/layui.css" rel="stylesheet" />
    <link href="/Content/fhuaui/css/fhuaui.css" rel="stylesheet" />
    <link href="/Content/Font-Awesome/css/font-awesome.css" rel="stylesheet" />
    <script src="/Content/layui/layui.js"></script>
</head>
<body>
    <div class="main-wrap">
        <div class="layui-form-item">
			<div class="layui-inline">
				<a class="layui-btn layui-btn-small" id="vector">
					<i class="fa fa-search"></i>矢量
				</a>
			</div>
			<div class="layui-inline">
				<a class="layui-btn layui-btn-small" id="satellite">
					<i class="fa fa-search"></i>影像
				</a>
			</div>
			<input type='hidden' id='dmapType' value='0' />
            <div id="mapDiv" style="width:100%; height: 650px"></div>
        </div>
    </div>
    <script type="text/javascript" src="http://api.tianditu.com/api?v=4.0"></script>
    <script>
    layui.use(['layer'], function () {
        var $ = layui.jquery, layer = layui.layer;
        var map; 
        var zoom = 12;
        var l = "<?php echo $l?>";
        var w = "<?php echo $w?>";
        //初始化地图对象 
        map = new T.Map("mapDiv"); 
        //设置显示地图的中心点和级别 
		if(l > 0 && w > 0){
			map.centerAndZoom(new T.LngLat(l, w), zoom);
		}else{
			map.centerAndZoom(new T.LngLat(121, 37), zoom);
		}
		map.enableScrollWheelZoom();
		var imageURL = "http://t0.tianditu.cn/img_w/wmts?" +
                    "SERVICE=WMTS&REQUEST=GetTile&VERSION=1.0.0&LAYER=img&STYLE=default&TILEMATRIXSET=w&FORMAT=tiles" +
                    "&TILEMATRIX={z}&TILEROW={y}&TILECOL={x}";
		//创建自定义图层对象
		var lay = new T.TileLayer(imageURL,{minZoom:1,maxZoom:16});
		//将图层增加到地图上
		map.addLayer(lay);
		if ($("#dmapType").val() == "1") {
			map.addLayer(lay);
		}
		$('#satellite').on('click',function(){
			$("#dmapType").val("1");
			map.addLayer(lay);
		});
		$('#vector').on('click',function(){
			$("#dmapType").val("0");
			map.removeLayer(lay);
		});
		if(l > 0 && w > 0){
			// 定义该矩形的显示区域
			var circle = new T.Circle(new T.LngLat(l, w), 1000,{color:"#009688",weight:2,opacity:0.5,fillColor:"red",fillOpacity:0.5,lineStyle:"solid"});
			//向地图上添加圆
			map.addOverLay(circle);
			var circle = new T.Circle(new T.LngLat(l, w), 3000,{color:"#009688",weight:2,opacity:0.5,fillColor:"green",fillOpacity:0.5,lineStyle:"solid"});
			//向地图上添加圆
			map.addOverLay(circle);
			var circle = new T.Circle(new T.LngLat(l, w), 5000,{color:"#009688",weight:2,opacity:0.5,fillColor:"yellow",fillOpacity:0.5,lineStyle:"solid"});
			//向地图上添加圆
			map.addOverLay(circle);
		}
    });
    </script> 
</body>
</html>