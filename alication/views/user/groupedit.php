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
    <title>编辑权限</title>
    <link href="/Content/layui/css/layui.css" rel="stylesheet" />
    <link href="/Content/fhuaui/css/fhuaui.css" rel="stylesheet" />
    <link href="/Content/Font-Awesome/css/font-awesome.css" rel="stylesheet" />
    <script src="/Content/layui/layui.js"></script>
</head>
<body>
    <div class="main-wrap">
        <blockquote class="layui-elem-quote fhui-admin-main_hd">
            <h2>编辑权限</h2>
        </blockquote>
        <form action="/group/edit" class="layui-form layui-form-pane" id="formrec" method="post" role="form">
            <div class="layui-form-item">
                <label class="layui-form-label">权限名称</label>
                <div class="layui-input-block">
                    <input id="name" autocomplete="off" lay-verify="required" value="<?php echo $d['title']; ?>" placeholder="必填,权限名称" class="layui-input" type="text">
                </div>
                <input id="id" type='hidden' value="<?php echo $d['id']; ?>" />
            </div>
            <?php if($rules){foreach ($rules as $k => $v): ?>
            <dl class="checkmod">
                <dt>
                    <input title="<?php echo $v['title']?>" lay-skin="primary" name="rules" ids="<?php echo $v['id']?>" type="checkbox" />
                </dt>
                <?php foreach ($v['child'] as $ks => $vs): if($vs['child']){?>
                <dd>
                    <div class='towC'>
                        <input title="<?php echo $vs['title']?>" lay-skin="primary" name="rules" ids="<?php echo $vs['id']?>" type="checkbox" />
                    </div>
                    <ul style='padding-left:28px;'>
                    <?php foreach ($vs['child'] as $kb=>$vb): if($vb['child']){?>
                    <li>
                        <div class='towD'>
                            <input title="<?php echo $vb['title']?>" lay-skin="primary" name="rules" ids="<?php echo $vb['id']?>" type="checkbox" />
                        </div>
                        <ul style='padding-left:28px;'>
                        <?php foreach ($vb['child'] as $kc=>$vc): if($vc['child']){?>
                        <li>
                            <div class='towE'>
                                <input title="<?php echo $vc['title']?>" lay-skin="primary" name="rules" ids="<?php echo $vc['id']?>" type="checkbox" />
                            </div>
                            <?php foreach ($vc['child'] as $kd=>$vd): ?>
                            <span class="divsion">&nbsp;</span>
                            <span>
                                <input title="<?php echo $vd['title']?>" lay-skin="primary" name="rules" ids="<?php echo $vd['id']?>" type="checkbox" />
                            </span>
                            <?php endforeach; ?>
                        </li>
                        <?php }else{?>
                        <span>
                            <input title="<?php echo $vc['title']?>" lay-skin="primary" name="rules" ids="<?php echo $vc['id']?>" type="checkbox" />
                        </span>
                        <?php }endforeach;?>
                        </ul>
                    </li>
                    <?php }else{?>
                    <span>
                        <input title="<?php echo $vb['title']?>" lay-skin="primary" name="rules" ids="<?php echo $vb['id']?>" type="checkbox" />
                    </span>
                    <?php }endforeach; ?>
                    </ul>
                </dd>
                <?php }else{?>
                <span>
                    <input title="<?php echo $vs['title']?>" lay-skin="primary" name="rules" ids="<?php echo $vs['id']?>" type="checkbox" />
                </span>
                <?php }endforeach; ?>
            </dl>
            <?php endforeach;} ?>
            <!--底部工具栏-->
            <div class="page-footer">
                <div class="btn-list">
                    <div class="btnlist">
                        <a class="layui-btn layui-btn-small" lay-submit="" lay-filter="doPostg" data-href="/group/edit"><i class="fa fa-save"></i>提交</a>
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
            var $ = layui.jquery
            , layer = layui.layer;
            //监听查询
            var rules = [<?php echo $d['rules']; ?>];
            $('dl.checkmod input').each(function(){
                var ids = $(this).attr('ids');
                if( $.inArray( parseInt(ids,10),rules )>-1 ){
                    $(this).attr('checked',true);
                }
            });
        });
    </script>
</body>
</html>