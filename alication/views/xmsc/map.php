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
    <title>地图经纬度</title>
    <link href="/Content/layui/css/layui.css" rel="stylesheet" />
    <link href="/Content/fhuaui/css/fhuaui.css" rel="stylesheet" />
    <link href="/Content/Font-Awesome/css/font-awesome.css" rel="stylesheet" />
    <script src="/Content/layui/layui.js"></script>
</head>
<body>
    <div class="main-wrap">
        <div class="y-role">
            <!--工具栏-->
            <div id="floatHead" class="toolbar-wrap">
                <div class="toolbar">
                    <div class="box-wrap">
                        <div class="l-list clearfix">
                            <form id="tt" class="layui-form layui-form-pane">
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
                                    <div class="layui-inline">
                                        <div class="layui-input-block" style="margin-left: 0px">
                                            <input id="longitude" name="longitude" lay-verify="required" value="" autocomplete="off" placeholder="经度" class="layui-input" type="text" />
                                        </div>
                                    </div>
                                    <div class="layui-inline">
                                        <div class="layui-input-block" style="margin-left: 0px">
                                            <input id="latitude" name="latitude" lay-verify="required" value="" autocomplete="off" placeholder="纬度" class="layui-input" type="text" />
                                        </div>
                                    </div>
                                    <div class="layui-inline">
                                        <a class="layui-btn layui-btn-small" id='transmit'>
                                            <i class="fa fa-save"></i>确定
                                        </a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <input type='hidden' id='dmapType' value='0' />
            <div class="fhui-admin-table-container">
                <form class="form-horizontal" id="formrec" method="post" role="form">
                    <!--创建地图容器元素-->
                    <div id='scroll-1'>
                        <div id="mapdiv" class="content" style="width: 100%; height: 400px"></div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="/Content/myjs/global.js"></script>
    <script type="text/javascript" src="http://api.tianditu.com/api?v=4.0"></script>
    <script src="/Content/myjs/map.js"></script>
</body>
</html>