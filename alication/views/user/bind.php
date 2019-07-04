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
    <title>账号绑定</title>
    <link href="/Content/layui/css/layui.css" rel="stylesheet" />
    <link href="/Content/fhuaui/css/fhuaui.css" rel="stylesheet" />
    <link href="/Content/Font-Awesome/css/font-awesome.css" rel="stylesheet" />
    <script src="/Content/layui/layui.js"></script>
</head>
<body>
    <div class="main-wrap">
        <blockquote class="layui-elem-quote fhui-admin-main_hd">
            <h2>账号绑定</h2>
        </blockquote>
        <div class="y-role">
            <!--工具栏-->
            <div id="floatHead" class="toolbar-wrap">
                <div class="toolbar">
                    <div class="box-wrap">
                        <div class="l-list clearfix">
                            <form id="tt" class="layui-form layui-form-pane">
                                <div class="layui-form-item">
                                    <div class="layui-inline">
                                        <div class="layui-input-block" style="margin-left: 0px">
                                            <input name="skey" lay-verify="required" value="" autocomplete="off" placeholder="请输入关键字" class="layui-input" type="text" />
                                        </div>
                                    </div>
                                    <div class="layui-inline">
                                        <a class="layui-btn layui-btn-small" lay-submit="" lay-filter="cx">
                                            <i class="fa fa-search"></i>查询
                                        </a>
                                        <a class="layui-btn layui-btn-small do-action" data-type="doRefresh" data-href="/ausers/bind.html">
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
                <form class="form-horizontal" id="formrec" method="post" role="form">
                    <table class="layui-table" lay-skin="line">
                        <thead>
                            <tr>
                                <th>选择</th>
                                <th>账号</th>
                                <th>权限</th>
                                <th style='text-align:center;'>状态</th>
                                <th>日期</th>
                            </tr>
                        </thead>
                        <tbody>
                        	<?php if(! $ausers){ ?>
                            <tr>
                                <td class="nodata" colspan="5">暂无数据！</td>
                            </tr>
                            <?php }else{foreach ($ausers as $v): if($v['id']==1){continue;} ?>
                            <tr class='ck'>
                                <td>
									<input name="ck" value="<?php echo $v['id']; ?>" title="" type="radio">
                                </td>
                                <td><?php echo $v['name']; ?></td>
                                <td><?php echo $v['gid']?$v['gid']:'无'; ?></td>
                                <td align="center">
                                	<?php if($v['type'] == 1){ ?>
                                	<i class="fa fa-unlock unlock"></i>
                                	<?php }else{ ?>
                                	<i class="fa fa-lock lock"></i>
                                	<?php } ?>
                                </td>
                                <td><?php echo date('Y-m-d',$v['addtime']); ?></td>
                            </tr>
                            <?php endforeach;} ?>
                        </tbody>
                    </table>
                </form>
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
    <script>
        layui.use(['layer', 'laypage', 'common', 'form', 'paging'], function () {
            var $ = layui.jquery, layer = layui.layer, laypage = layui.laypage, common = layui.common, form = layui.form(), paging = layui.paging();
            //监听查询
            form.on('submit(cx)', function (data) {
                var keywords = data.field.skey;
                $.post('/ausers/bind', { keywords: keywords },
                function (result, status) {
                    if (result.state == 1) {
                        window.location.href = '/ausers/bind/?query=' + result.message;//result.data;
                    }else{
                        common.layerAlertE('错误提示：' + s.message, '提示');
                    }
                });
            });
			var index = parent.layer.getFrameIndex(window.name);
			$('tr.ck').on('click', function(){
				var sid = $(this).find('input').val();
				$(window.parent.document).find('input[name=aid]').val(sid);
                parent.layer.close(index);
			});
        });
    </script>
</body>
</html>