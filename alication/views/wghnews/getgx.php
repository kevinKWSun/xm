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
    <title>标记管辖区域</title>
    <link href="/Content/layui/css/layui.css" rel="stylesheet" />
    <link href="/Content/fhuaui/css/fhuaui.css" rel="stylesheet" />
    <link href="/Content/Font-Awesome/css/font-awesome.css" rel="stylesheet" />
</head>
<body>
    <div class="main-wrap">
        <blockquote class="layui-elem-quote fhui-admin-main_hd">
            <h2>标记管辖区域</h2>
        </blockquote>
        <div class="y-role">
            <div class="main-wrap">
				<div class="layui-form-item">
					<div class="layui-inline">
						<a class="layui-btn layui-btn-small" id='openPolylineTool'><i class="fa fa-plus"></i>添加直线</a>
					</div>
					<div class="layui-inline">
						<a class="layui-btn layui-btn-small" id='openPolygonTool'><i class="fa fa-plus"></i>添加多边形</a>
					</div>
					<div class="layui-inline">
						<a class="layui-btn layui-btn-small" id='clearOverLays'><i class="fa fa-trash"></i>清除</a>
					</div>
					<div class="layui-inline">
						<a class="layui-btn layui-btn-small" id="complete"><i class="fa fa-save"></i>完成</a>
					</div>
					<div id="myMap" style="width:100%; height: 650px"></div>
				</div>
			</div>
		</div>
    </div>
	<script type="text/javascript" src="/Content/js/jquery-1.7.2.min.js"></script>
	<script type="text/javascript" src="http://api.tianditu.com/api?v=4.0"></script>
    <script>

            var aryList = new Array();
			var map, zoom = 12, handler;
			$(function () {
				//初始化地图对象 
				map = new T.Map("myMap");
				//设置显示地图的中心点和级别 
				map.centerAndZoom(new T.LngLat(120, 37), zoom);
				map.enableScrollWheelZoom();
				var config = {
					showLabel: true,
					color: "blue", weight: 2, opacity: 0.5, fillColor: "#FFFFFF", fillOpacity: 0.5
				};
				polygonTool = new T.PolygonTool(map, config);
				var cp = new T.CoordinatePickup(map, {callback: getLngLat})
				cp.addEvent();
			});
			
			$('#openPolygonTool').on('click',function(){
				if (handler) handler.close();
				handler = new T.PolygonTool(map);
				handler.open();
			});
			$('#openPolylineTool').on('click',function(){
				if (handler) handler.close();
				handler = new T.PolylineTool(map);
				handler.open();
			});
			$('#clearOverLays').on('click',function(){
				map.clearOverLays()
			});
			function getLngLat(lnglat) {
				aryList.push(lnglat.lng.toFixed(6) + "," + lnglat.lat.toFixed(6));
			}
			$('#complete').on('click',function(){
				var frJurisdiction = "";
				if (aryList != null && aryList.length > 0) {
					for (var i = 0; i < aryList.length - 1; i++) {
						if (aryList[i] != null) {
							frJurisdiction += aryList[i] + "|";
						}
					}
					frJurisdiction += aryList[0];
				}
				$(window.parent.document).find('textarea[name=gxarea]').val(frJurisdiction);
				var index = parent.layer.getFrameIndex(window.name);
				parent.layer.close(index);
			});
	</script>
</body>
</html>