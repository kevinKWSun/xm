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
    <title>网格化监管</title>
    <link href="/Content/layui/css/layui.css" rel="stylesheet" />
    <link href="/Content/fhuaui/css/fhuaui.css" rel="stylesheet" />
    <link href="/Content/Font-Awesome/css/font-awesome.css" rel="stylesheet" />
    <script src="/Content/layui/layui.js"></script>
</head>
<body>
    <div class="main-wrap">
        <blockquote class="layui-elem-quote fhui-admin-main_hd">
            <h2>网格化监管</h2>
        </blockquote>
        <div class="y-role">
            <!--工具栏-->
            <div id="floatHead" class="toolbar-wrap">
                <div class="toolbar">
                    <div class="box-wrap">
                        <div class="l-list clearfix">
                            <form id="tt" class="layui-form layui-form-pane">
                                <div class="layui-form-item">
									<div class="layui-input-inline" style="margin-left: 0px">
										<input name="skey" lay-verify="required" value="" autocomplete="off" placeholder="编号/名称/填报单位" class="layui-input" type="text" />
									</div>
                                    <div class="layui-inline">
                                        <a class="layui-btn layui-btn-small" lay-submit="" lay-filter="cx">
                                            <i class="fa fa-search"></i>查询
                                        </a>
                                        <a class="layui-btn layui-btn-small do-action" data-type="doRefresh" data-href="/wghnews/manager.html">
                                            <i class="fa fa-refresh"></i>重新载入
                                        </a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!--/工具栏-->
            <!--文字列表-->
            <div class="fhui-admin-table-container">
                <div id="mapDiv" style="width:100%; height: 650px"></div>
            </div>
            <!--/文字列表-->
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
    </div>
    <script src="/Content/myjs/global.js"></script>
    <script src="/Content/myjs/list.js"></script>
	<script type="text/javascript" src="http://api.tianditu.com/api?v=4.0"></script>
    <script>
        layui.use(['layer', 'laypage', 'common', 'form', 'paging'], function () {
            var $ = layui.jquery, layer = layui.layer, laypage = layui.laypage, common = layui.common, form = layui.form(), paging = layui.paging();
            //监听查询
            form.on('submit(cx)', function (data) {
                var keywords = data.field.skey;
                $.post('/wghnews/manager.html', { keywords: keywords },
                function (result, status) {
                    if (result.state == 1) {
                        window.location.href = '/wghnews/manager/1?query=' + result.message;//result.data;
                    }else{
                        common.layerAlertE('错误提示：' + s.message, '提示');
                    }
                });
            });
			var map;
			var zoom = 12;
			map = new T.Map("mapDiv");
			map.centerAndZoom(new T.LngLat(<?php echo explode('|', $manager[0]['gxarea'])[0]?>), zoom);
			var points = [];
			
			var imageURL = "http://t0.tianditu.cn/img_w/wmts?" +
                    "SERVICE=WMTS&REQUEST=GetTile&VERSION=1.0.0&LAYER=img&STYLE=default&TILEMATRIXSET=w&FORMAT=tiles" +
                    "&TILEMATRIX={z}&TILEROW={y}&TILECOL={x}";
			var lay = new T.TileLayer(imageURL,{minZoom:1,maxZoom:16});
			<?php foreach($manager as $k=>$vb): foreach(explode('|', $vb['gxarea']) as $v):?>
			points.push(new T.LngLat(<?php echo $v ?>));
			<?php endforeach;endforeach;?>			
			//创建面对象
			var polygon = new T.Polygon(points,{
				color: "red", weight: 2, opacity: 0.5, fillColor: "#FFFFFF", fillOpacity: 0.5
			});
			//向地图上添加面
			map.addOverLay(polygon);
			
			<?php foreach($manager as $k=>$vb):?>
			polygon.addEventListener("click", MarkerClick<?php echo $k?>);
			var icon = new T.Icon({ 
				iconUrl: "/Content/t/dian.png", 
				iconSize: new T.Point(20, 20), 
				iconAnchor: new T.Point(21, 21) 
			}); 
			var marker = new T.Marker(new T.LngLat(<?php echo $vb['lng'],', ',$vb['lat']?>), {icon: icon}); 
			map.addOverLay(marker);
			marker.addEventListener("click", MarkerClick<?php echo $k?>);
			//创建信息窗口对象
			function MarkerClick<?php echo $k?>(e) {
				var sContent = 
					"<div style='margin:0px;line-height:25px;'>" + 
					"<div style='margin:10px 10px;'>" + 
					"<?php echo '编号：',$vb['num'],'<br>','网格名称：',$vb['name'],'<br>','监管对象：',$vb['jgdx'],'<br>','监管单位：',$vb['unit'],'<br>','监管责任人：',$vb['admin'],'<br>','责任人职务：',$vb['jname'],'<br>','联系方式：',$vb['tel'],'<br>','更新时间：',date('Y-m-d', $vb['add_time'])?>" + 
					"</div>" + 
					"</div>";
				var infoWin = new T.InfoWindow(sContent);
				infoWin.setContent(sContent);
				this.openInfoWindow(sContent);
				map.panTo(new T.LngLat(e.lnglat.lng,e.lnglat.lat), map.getZoom());
			}
			<?php endforeach;?>
			map.setViewport(polygon);
			map.setViewport(marker);
        });
    </script>
</body>
</html>