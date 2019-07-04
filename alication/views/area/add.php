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
    <title>增加地区</title>
    <link href="/Content/layui/css/layui.css" rel="stylesheet" />
    <link href="/Content/fhuaui/css/fhuaui.css" rel="stylesheet" />
    <link href="/Content/Font-Awesome/css/font-awesome.css" rel="stylesheet" />
    <script src="/Content/layui/layui.js"></script>
</head>
<body>
    <div class="main-wrap">
        <blockquote class="layui-elem-quote fhui-admin-main_hd">
            <h2>增加监管站
                <a href='javascript:;' class='a_add' data='0'><font color='red'>加</font></a> 
                <a href='javascript:;' class='a_del'><font color='red'>减</font></a>
            </h2>
        </blockquote>
        <form action="/areanews/add" class="layui-form layui-form-pane" id="formrec" method="post" role="form">
            <div class='aid'>
                <div class="layui-form-item">
                    <label class="layui-form-label">监管站名称</label>
                    <div class="layui-input-block">
                        <input name="title" autocomplete="off" lay-verify="required" value="" placeholder="必填,监管站名称" class="layui-input" type="text">
                    </div>
                </div>
            </div>
            <!--底部工具栏-->
            <div class="page-footer">
                <div class="btn-list">
                    <div class="btnlist">
                        <a rel='1' class="layui-btn layui-btn-small" lay-submit="" lay-filter="doPostArea" data-href="/areanews/add/<?php echo $id?>"><i class="fa fa-save"></i>提交</a>
                        <a class="layui-btn layui-btn-small do-action" data-type="doRefresh" data-href=""><i class="fa fa-refresh fa-spin"></i>刷新</a>
                    </div>
                </div>
            </div>
            <!--/底部工具栏-->
        </form>
    </div>
    <script src="/Content/myjs/global.js"></script>
    <script src="/Content/myjs/modify.js"></script>
    <script type="text/javascript">
        layui.use(['layer', 'common'], function () {
            var $ = layui.jquery
            , layer = layui.layer
            , common = layui.common;
            $('.a_add').click(function(){
                var num = $(this).attr('data');
                if(num > 9){
                    alert('最多添加10条！');
                } else {
                    var obj = $('.aid').clone();
                    $(this).attr('data', (num*1+1));
                    obj.removeClass('aid');
                    obj.addClass('aid'+(num*1+1));
                    $('.page-footer').before(obj);
                }
                
            });
            $('.a_del').click(function(){
                var num = $(this).siblings('.a_add').attr('data');
                if(num > 0){
                    $('.aid'+num).remove();
                    $(this).siblings('.a_add').attr('data', (num*1-1));
                } 
            });
        });
    </script>
</body>
</html>