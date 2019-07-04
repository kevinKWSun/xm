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
    <title>编辑账号</title>
    <link href="/Content/layui/css/layui.css" rel="stylesheet" />
    <link href="/Content/fhuaui/css/fhuaui.css" rel="stylesheet" />
    <link href="/Content/Font-Awesome/css/font-awesome.css" rel="stylesheet" />
    <script src="/Content/layui/layui.js"></script>

</head>
<body>
    <div class="main-wrap">
        <blockquote class="layui-elem-quote fhui-admin-main_hd">
            <h2>编辑账号</h2>
        </blockquote>
        <form action="/ausers/edit" class="layui-form layui-form-pane" id="formrec" method="post" role="form">
            <input type='hidden' name='d' value="<?php echo $id; ?>" />
            <div class="layui-form-item">
                <label class="layui-form-label">所属权限</label>
                <div class="layui-input-block">
                    <select data-val="true" data-val-number="字段 Int32 必须是一个数字" data-val-required="Int32 字段是必需的" name="gids">
                        <option selected="selected" value="0">选择所属权限</option>
                        <?php foreach ($group as $v): ?>
                        <option value="<?php echo $v['id']; ?>" <?php if($v['id'] == $gid){?>selected<?php }?>><?php echo $v['level'],$v['title']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">登录名称</label>
                <div class="layui-input-block">
                    <input name="lname" autocomplete="off" lay-verify="required" value="<?php echo $name; ?>" placeholder="必填,真实姓名" class="layui-input" type="text">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">真实姓名</label>
                <div class="layui-input-block">
                    <input name="rname" autocomplete="off" lay-verify="required" value="<?php echo $realname; ?>" placeholder="必填,真实姓名" class="layui-input" type="text">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">修改密码</label>
                <div class="layui-input-block">
                    <input name="pd" autocomplete="off" lay-verify="" value="" placeholder="必填,登录密码(包含字母和数字,至少6位)" class="layui-input" type="text">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">重复密码</label>
                <div class="layui-input-block">
                    <input name="pd2" autocomplete="off" lay-verify="" value="" placeholder="必填,重复密码(与登录密码一致)" class="layui-input" type="text">
                </div>
            </div>
            <!--底部工具栏-->
            <div class="page-footer">
                <div class="btn-list">
                    <div class="btnlist">
                        <a class="layui-btn layui-btn-small" lay-submit="" lay-filter="doPost" data-href="/ausers/edit"><i class="fa fa-save"></i>提交</a>
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
</body>
</html>