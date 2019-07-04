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
    <title>增加应急处置部署 </title>
    <link href="/Content/layui/css/layui.css" rel="stylesheet" />
    <link href="/Content/fhuaui/css/fhuaui.css" rel="stylesheet" />
    <link href="/Content/Font-Awesome/css/font-awesome.css" rel="stylesheet" />
    <script src="/Content/layui/layui.js"></script>
</head>
<body>
    <div class="main-wrap">
        <blockquote class="layui-elem-quote fhui-admin-main_hd">
            <h2>增加应急处置部署 </h2>
        </blockquote>
        <form action="/yjgisnews/add" class="layui-form layui-form-pane" id="formrec" method="post" role="form">
            <div class="layui-form-item">
                <div class="layui-inline">
                    <label class="layui-form-label">疫病名称</label>
                    <div class="layui-input-inline">
                        <input name="sname" id='sname' placeholder="必选,点击选择疫病名称" lay-verify="required" autocomplete="off" class="layui-input" type="text" readonly />
                    </div>
                    <input type="hidden" name='sid' />
                    <label class="layui-form-label">疫点半径</label>
                    <div class="layui-input-inline">
                        <input name="dradius" lay-verify="number" placeholder="必填,疫点半径(公里)" autocomplete="off" class="layui-input" type="text" />
                    </div>
                    <label class="layui-form-label">养殖场名称</label>
                    <div class="layui-input-inline">
                        <input name="yname" id='yname' placeholder="必选,点击选择养殖场" lay-verify="required" autocomplete="off" class="layui-input" type="text" readonly />
                    </div>
                    <input type="hidden" name='yid' />
					<input type="hidden" name='lng' />
					<input type="hidden" name='lat' />
					<input type="hidden" name='lngb' />
					<input type="hidden" name='latb' />
                </div>
            </div>
            <div class="layui-form-item">
                <iframe id="iframeMap" width="100%" src="/map/getmap.html" height="650" frameborder="0" marginheight="0"></iframe>
            </div>
            <!--底部工具栏-->
            <div class="page-footer">
                <div class="btn-list">
                    <div class="btnlist">
                        <a class="layui-btn layui-btn-small" lay-submit="" lay-filter="doPost" data-href="/yjgisnews/add"><i class="fa fa-save"></i>提交</a>
                        <a class="layui-btn layui-btn-small do-action" data-type="doRefresh" data-href=""><i class="fa fa-refresh fa-spin"></i>刷新</a>
                        <a class="layui-btn layui-btn-small do-action" data-type="doGoBack" data-href=""><i class="fa fa-mail-reply"></i>返回上一页</a>
                        <a class="layui-btn layui-btn-small do-action" data-type="doGoTop" data-href=""><i class="fa fa-arrow-up"></i>返回顶部</a>
                    </div>
                </div>
            </div>
            <!--/底部工具栏-->
        </form>
    </div>
    <script src="/Content/myjs/global.js"></script>
    <script src="/Content/myjs/modify.js"></script>
    <script>
    layui.use(['layer'], function () {
        var $ = layui.jquery, layer = layui.layer;
        $('#sname').on('click',function(){
            layer.open({
                type: 2,
                title: '获取疫病名称',
                //shadeClose: true,
                shade: 0.5,
                maxmin: true,
                area: ['800px', '520px'],
                fixed: false,
                content: '/yjgisnews/report.html'
            });
        });
        $('#yname').on('click',function(){
            layer.open({
                type: 2,
                title: '获取养殖场',
                //shadeClose: true,
                shade: 0.5,
                maxmin: true,
                area: ['800px', '520px'],
                fixed: false,
                content: '/yjgisnews/farm.html'
            });
        });
    });
    </script> 
</body>
</html>