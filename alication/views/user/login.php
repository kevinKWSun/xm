<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>登录</title>
    <meta http-equiv="Content-Language" content="zh-cn" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta http-equiv="Cache-Control" content="no-siteapp" />
    <meta name="viewport" content="width=device-width, maximum-scale=1.0, initial-scale=1.0,initial-scale=1.0,user-scalable=no" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <link href="Content/layui/css/layui.css" rel="stylesheet" />
    <link href="Content/css/global.css" rel="stylesheet" />
    <link href="Content/fhuaui/css/loginb.css" rel="stylesheet" />
    <link href="Content/Font-Awesome/css/font-awesome.css" rel="stylesheet" />
    <script src="Content/layui/layui.js"></script>
</head>
<body style='background:url(Content/img/logbg.jpg) right'>
    <div class="lay_wrap lay-login " id="lay">
        <!--div class="layui-header header login-header hide">
            <div class="layui-main login-top-bg">
                <div class="sitename">
                    <a class="logo" href="/">
                        <img src="Content/img/fhua/logo.png" alt="上海谊梯科技">
                    </a>
                    <h2>安监信息管理系统1.0</h2>
                </div>
                <ul class="layui-nav login-top-menu">
                    <li class="layui-nav-item site-nav-layim"><a href="http://www.aisuny.com/" target="_blank">技术支持官方网站</a></li>
                </ul>
            </div>
        </div-->
        <div class="lay_main clearfix" id="login_div" style="top: 120px;">
            <div class="lay_inner">
                <div class="lay-wrap">
                    <div class="lay-area">
                        <a id="adImgHref" href="<?php echo base_url('/'); ?>" target="_blank">
                            <img id="adImg" src="Content/fhuaui/img/mhdcity.jpg" />
                        </a>
                        <span class="lay-txt">系统</span>
                    </div>
                    <div class="login_wrap">
                        <?php echo form_open('login','class="layui-form layui-form-pane" id="sign-in" onSubmit="return false;"'); ?>
                            <div class="layui-form-item">
                                <label class="layui-form-label">账号</label>
                                <div class="layui-input-block">
                                    <input name="user_name" lay-verify="required" autocomplete="off" placeholder="请输入账号" class="layui-input" type="text" />
                                </div>
                            </div>
                            <div class="layui-form-item">
                                <label class="layui-form-label">密码</label>
                                <div class="layui-input-block">
                                    <input name="password" lay-verify="required"  autocomplete="off" placeholder="请输入密码" class="layui-input" type="password" />
                                </div>
                            </div>
                            <div class="layui-form-item">
                                <div class="loginform_btn">
                                    <a class="layui-btn pop_login_btn" lay-submit="" data-loading-text="登录中..." lay-filter="btnsubmit">登&nbsp;&nbsp;录</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="login_mask"></div>
            </div>
        </div>
        <!--页脚部分-->
        <div class="lay_foot">
            <div class="lay_inner">
                <div class="login_device">
                    <ul>
                        <li><a href="javascript:;"><i class="fa fa-apple"></i><span>iPhone</span></a></li>
                        <li><a href="javascript:;"><i class="fa fa-tablet"></i><span>iPad</span></a></li>
                        <li><a href="javascript:;"><i class="fa fa-android"></i><span>Android</span></a></li>
                        <li><a href="javascript:;"><i class="fa fa-windows"></i><span>Windows Phone</span></a></li>
                        <li><a href="javascript:;"><i class="fa fa-mobile"></i><span>其他手机</span></a></li>
                    </ul>
                </div>
                <div class="copyright">
                    <div class="layui-footer footer admin-footer" style="left: 200px;">
                        <div class="layui-main" style="width: auto">
                            <p>COPYRIGHT &#169; <?php echo date('Y',time()); ?>. ALL RIGHTS RESERVED.  技术支持：谊梯科技</p>
                            <p>
                                <a id="pay" href="javascript:;">捐赠作者</a>
                                <a id="git" href="javascript:;">Git仓库</a>
                                <a id="weibo" href="javascript:;">微博</a>
                                <a id="weixin" href="javascript:;">微信公众号</a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="author-info">
                <p id="j-author-message"><span class="author-title"></span><a target="_blank" href="http://www.yt8.top">谊梯科技</a></p>
            </div>
        </div>
    </div>
    <div class="lay_background" id="lay_bg" style="width: auto; height: auto;"></div>
    <div class="shang_box" style="display: none;">
        <div class="shang_tit">
            <p>感谢您的支持，我会继续努力的!</p>
        </div>
        <div class="shang_payimg">
            <img src="Content/img/fhua/alipayimg.png" alt="扫码支持" title="扫一扫" />
        </div>
        <div class="pay_explain">扫码打赏，你说多少就多少</div>
        <div class="shang_info">
            <p>打开<span id="shang_pay_txt">微信</span>扫一扫，即可进行扫码打赏哦</p>
        </div>
    </div>

    <script src="Content/myjs/global.js"></script>
    <script type="text/javascript">
        layui.use(['layer', 'form', 'common'], function () {
            var $ = layui.jquery
            , layer = layui.layer
            , form = layui.form()
            , common = layui.common;
            $(document).keydown(function(event){
                if(event.keyCode == 13){
                    $("a.pop_login_btn").click();
                }
            });
            form.on('submit(btnsubmit)', function (formdata) {
            	var url = $(this).attr('action');
                $.post(url,formdata.field,function(s){
                	if(s.state == 1){
                		top.location.href = s.url;
                	}else{
                        common.layerAlertE('错误提示：' + s.message, '登录失败');
                	}
                });
                return false;
            });

        });
    </script>
</body>
</html>