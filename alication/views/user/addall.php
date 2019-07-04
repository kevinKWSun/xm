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
    <title>增加规则</title>
    <link href="/Content/layui/css/layui.css" rel="stylesheet" />
    <link href="/Content/fhuaui/css/fhuaui.css" rel="stylesheet" />
    <link href="/Content/Font-Awesome/css/font-awesome.css" rel="stylesheet" />
    <script src="/Content/layui/layui.js"></script>
</head>
<body>
    <div class="main-wrap">
        <blockquote class="layui-elem-quote fhui-admin-main_hd">
            <h2>增加规则 　
                <a href='javascript:;' class='a_add' data='0'><font color='red'>加</font></a> 
                <a href='javascript:;' class='a_del'><font color='red'>减</font></a>
            </h2>
        </blockquote>
        <form action="/rule/addall" class="layui-form layui-form-pane" id="formrec" method="post" role="form">
            <div class="layui-form-item">
                <label class="layui-form-label">所属组</label>
                <div class="layui-input-block">
                    <select data-val="true" data-val-number="字段 Int32 必须是一个数字" data-val-required="Int32 字段是必需的" id="gids">
                        <option selected="selected" value="0">选择所属组</option>
                        <?php foreach ($rule as $v): ?>
                        <option value="<?php echo $v['id']; ?>" <?php if($v['id'] == $id){?>selected<?php }?>><?php echo $v['level'],$v['title']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class='aid'>
                <div class="layui-form-item">
                    <label class="layui-form-label">规则名称</label>
                    <div class="layui-input-block">
                        <input name="title" autocomplete="off" lay-verify="required" value="" placeholder="必填,规则名称" class="layui-input" type="text">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">URL</label>
                    <div class="layui-input-block">
                        <input name="name" autocomplete="off" lay-verify="" value="" placeholder="无子类必填,URL(由字母和'/'组成)" class="layui-input" type="text">
                    </div>
                </div>
            </div>
            <div class="layui-form-item zt" pane="">
                <label class="layui-form-label">显示状态</label>
                <div class="layui-input-block">
                  <input name="type" value="1" title="显示" type="radio" checked="" />
                  <input name="type" value="2" title="隐藏" type="radio" />
                </div>
            </div>
            <!--底部工具栏-->
            <div class="page-footer">
                <div class="btn-list">
                    <div class="btnlist">
                        <a class="layui-btn layui-btn-small" lay-submit="" lay-filter="doPostAll" data-href="/rule/addall"><i class="fa fa-save"></i>提交</a>
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
    <script type="text/javascript">
        layui.use(['layer', 'common'], function () {
            var $ = layui.jquery
            , layer = layui.layer
            , common = layui.common;
            $('.a_add').click(function(){
                var num = $(this).attr('data');
                if(num > 9){
                    layer.msg('最多添加10条！');
                } else {
                    var obj = $('.aid').clone();
                    $(this).attr('data', (num*1+1));
                    obj.removeClass('aid');
                    obj.addClass('aid'+(num*1+1));
                    $('.zt').before(obj);
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