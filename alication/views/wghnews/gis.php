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
    <title>电子地图</title>
    <link href="/Content/layui/css/layui.css" rel="stylesheet" />
    <link href="/Content/fhuaui/css/fhuaui.css" rel="stylesheet" />
    <link href="/Content/Font-Awesome/css/font-awesome.css" rel="stylesheet" />
    <script src="/Content/layui/layui.js"></script>
</head>
<body>
    <div class="main-wrap">
        <blockquote class="layui-elem-quote fhui-admin-main_hd">
            <h2>电子地图</h2>
        </blockquote>
		<div id="floatHead" class="toolbar-wrap">
			<div class="toolbar">
				<div class="box-wrap">
					<div class="l-list clearfix">
						<form id="tt" class="layui-form layui-form-pane">
							<div class="layui-form-item">
								<div class="layui-input-inline" style="margin-left: 0px">
									<input name="skey" lay-verify="required" value="" autocomplete="off" placeholder="养殖场名称" class="layui-input" type="text" />
								</div>
								<div class="layui-inline">
									<a class="layui-btn layui-btn-small" lay-submit="" lay-filter="cx">
										<i class="fa fa-search"></i>查询
									</a>
									<a class="layui-btn layui-btn-small do-action" data-type="doRefresh" data-href="/yjgisnews/gis.html">
										<i class="fa fa-refresh"></i>重新载入
									</a>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
        <div>
            <div class="layui-form-item">
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
					<input type='hidden' id='mark' value='s' />
					<div id="mapDiv" style="width:100%; height: 650px"></div>
				</div>
            </div>
        </div>
		<div class="fhui-admin-pagelist">
			<div id="page">
				<div class="pagelist">
					<div class="l-btns">
						<span>共 <?php echo $totals; ?> 条</span>
					</div>
					<div id="PageContent" class="default"><?php echo $page; ?></div>
				</div>
			</div>
		</div>
    </div>
    <script src="/Content/myjs/global.js"></script>
    <script src="/Content/myjs/modify.js"></script>
	<script type="text/javascript" src="http://api.tianditu.com/api?v=4.0"></script>
    <script>
    layui.use(['layer', 'form'], function () {
        var $ = layui.jquery, layer = layui.layer, form = layui.form();
		form.on('submit(cx)', function (data) {
			var keywords = data.field.skey;
			$.post('/wghnews/gis.html', { keywords: keywords },
			function (result, status) {
				if (result.state == 1) {
					window.location.href = '/wghnews/gis/1?query=' + result.message;//result.data;
				}else{
					common.layerAlertE('错误提示：' + s.message, '提示');
				}
			});
		});
        var map; 
        var zoom = 12;
        var l = "121";
        var w = "37";
        //初始化地图对象 
        map = new T.Map("mapDiv"); 
        //设置显示地图的中心点和级别 
        map.centerAndZoom(new T.LngLat(<?php echo $ms[0]['lng'],', ',$ms[0]['lat'];?>), zoom);
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
		<?php foreach($ms as $k => $v):?>
		//添加自定义标注
		var icon = new T.Icon({ 
			iconUrl: "<?php echo $this->config->item('img')[explode(',',$v['farms']['cate'])[0]]?>", 
			iconSize: new T.Point(50, 50), 
			iconAnchor: new T.Point(44, 44) 
		}); 
		var marker = new T.Marker(new T.LngLat(<?php echo $v['lngb'],', ',$v['latb']?>), {icon: icon}); 
		map.addOverLay(marker);
		marker.addEventListener("click", MarkerClick<?php echo $k?>);
		//创建信息窗口对象
		function MarkerClick<?php echo $k?>(e) {
            var sContent = 
                "<div style='margin:0px;line-height:25px;'>" + 
                "<div style='margin:10px 10px;'>" + 
                "<?php echo '场名称：',$v['farms']['name'],'<br>','地　址：',$v['farms']['addr']?>" + 
                "</div>" + 
                "</div>";
			var infoWin = new T.InfoWindow(sContent);
            infoWin.setContent(sContent);
			this.openInfoWindow(sContent);
			map.panTo(new T.LngLat(e.lnglat.lng,e.lnglat.lat), map.getZoom());
		}
		<?php endforeach;?>
		map.setViewport(marker);//所有点都在可视中
		
    });
    </script> 
</body>
</html>