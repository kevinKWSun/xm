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
    <title>后台管理系统</title>
    <link href="/Content/layui/css/layui.css" rel="stylesheet" />
    <link href="/Content/fhuaui/css/fhuaui.css" rel="stylesheet" />
    <link href="/Content/Font-Awesome/css/font-awesome.css" rel="stylesheet" />
    <script src="/Content/layui/layui.js"></script>
</head>
<body>
    <div class="layui-layout layui-layout-admin">
        <div class="layui-header header header-admin">
            <div class="layui-main">
                <div class="fhuaui-logo">
                    <a class="logo" href="javascript:;">
                        <img src="/Content/img/logo.png" alt="xmsystem" />
                    </a>
                </div>
                <ul class="layui-nav" id="menu">
                    <?php foreach ($rule as $v): ?>
                    <li class="layui-nav-item">
                        <a href="javascript:;" data-fid="<?php echo $v['id']; ?>">
                            <cite><?php echo $v['title']; ?></cite>
                        </a>
                    </li>
                    <?php endforeach; ?>
                </ul>
                <ul class="layui-nav" style="right:0;margin:0">
                    <li class="layui-nav-item">
                        <a href='javascript:;' id='exit'>进入全屏</a>
                    </li>
                    <li class="layui-nav-item">
                        <a href="javascript:;" class="admin-header-user" style='padding:0 20px;'>
                            <img src="/Content/img/0.jpg" style="width: 40px; height: 40px; border-radius: 100%;" />
                            <span><?php echo $name;?></span>
                        </a>
                        <dl class="layui-nav-child my_top_menu">
                            <dd>
                                <a href="javascript:;" style='padding:0 15px;'>
                                    <i class="fa fa-user" aria-hidden="true"></i> <?php echo $rname;?>
                                </a>
                            </dd>
                            <dd>
                                <a href="javascript:;" url="/adminr/modify.html" title="修改密码" class='frame_Add' style='padding:0 15px;'>
                                    <i class="fa fa-gear" aria-hidden="true"></i> 修改密码
                                </a>
                            </dd>
                            <dd>
                                <a href="javascript:void(0);" data-rturl="/adminr/logout.html" data-href="/adminr/logout.html" data-type="doLoginOut" class="do-admin" style='padding:0 15px;'>
                                    <i class="fa fa-sign-out"></i> 注销
                                </a>
                            </dd>
                        </dl>
                    </li>
                </ul>
            </div>
        </div>
        <div id="sidebar-side" class="layui-side layui-bg-black">
            <div id="admin-navbar-side" class="layui-side-scroll" lay-filter="side"></div>
        </div>
        <div id="admin-body" class="layui-body" style="bottom: 0;">
            <div class="layui-tab layui-tab-card admin-nav-card" lay-filter="admin-tab">
                <ul class="layui-tab-title" id="admin-tab">
                    <li class="layui-this">
                        <i class="layui-icon" style="top: 2px; font-size: 16px;">&#xe62e;</i>
                        <cite><?php echo $indextitle; ?></cite>
                    </li>
                </ul>
                <div class="layui-tab-content" id="admin-tab-container" style="min-height: 150px; padding: 0px;">
                    <div class="layui-tab-item layui-show">
                        <iframe name="mainframe" frameborder="0" src="/adminr/center.html"></iframe>
                    </div>
                </div>
            </div>
        </div>
        <?php include("footer.php")?>
    </div>
    <script src="Content/myjs/global.js"></script>
    <script src="Content/myjs/_admin.js"></script>
</body>
</html>
