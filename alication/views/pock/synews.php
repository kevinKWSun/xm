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
    <title>肉品品质检验合格报告单信息</title>
    <link href="/Content/layui/css/layui.css" rel="stylesheet" />
    <link href="/Content/fhuaui/css/fhuaui.css" rel="stylesheet" />
    <link href="/Content/Font-Awesome/css/font-awesome.css" rel="stylesheet" />
    <script src="/Content/layui/layui.js"></script>
</head>
<body>
    <div class="main-wrap">
        <blockquote class="layui-elem-quote fhui-admin-main_hd">
            <h2>肉品品质检验合格报告单信息</h2>
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
										<input name="skey" lay-verify="required" value="" autocomplete="off" placeholder="屠宰企业名称" class="layui-input" type="text" />
									</div>
                                    <div class="layui-inline">
                                        <a class="layui-btn layui-btn-small" lay-submit="" lay-filter="cx">
                                            <i class="fa fa-search"></i>查询
                                        </a>
                                        <a class="layui-btn layui-btn-small do-action" data-type="doAdd" data-href="/pock/add.html">
                                            <i class="fa fa-plus"></i>新增
                                        </a>
                                        <!--a class="layui-btn layui-btn-small do-action" data-type="doAction" data-href="/pock/lock.html">
                                            <i class="fa fa-lock"></i>关闭
                                        </a>
                                        <a class="layui-btn layui-btn-small do-action" data-type="doAction" data-href="/pock/unlock.html">
                                            <i class="fa fa-unlock"></i>开启
                                        </a>
										<a class="layui-btn layui-btn-small do-action" data-type="doAction" data-href="/pock/sh.html">
                                            <i class="fa fa-refresh"></i>审核通过
                                        </a>
										<a class="layui-btn layui-btn-small do-action" data-type="doAction" data-href="/pock/desh.html">
                                            <i class="fa fa-refresh"></i>审核不通过
                                        </a-->
                                        <a class="layui-btn layui-btn-small do-action" data-type="doRefresh" data-href="/pock.html">
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
                    <table class="layui-table layui-tables" lay-skin="line">
                        <thead>
                            <tr>
								<!--th><input type="checkbox" id="selected-all" /></th-->
                                <th>名称</th>
                                <th>编号</th>
                                <th>数量/重量</th>
                                <th>质检负责人</th>
                                <th>签字时间</th>
								<th>入厂动物检疫证明号码</th>
								<th>操作</th>
                            </tr>
                        </thead>
                        <tbody>
                        	<?php if(! $pock){ ?>
                            <tr>
                                <td class="nodata" colspan="7">暂无数据！</td>
                            </tr>
                            <?php }else{foreach ($pock as $v): ?>
                            <tr>
								<!--td>
                                    <input id="ck" ids="<?php echo $v['id']; ?>" name="ck" type="checkbox" value="true" />
                                </td-->
                                <td class='name'><?php echo $v['bname']; ?></td>
                                <td><?php echo $v['NO'] ?></td>
                                <td><?php echo $v['num']; ?></td>
                                <td><?php echo $v['charge'] ?></td>
								<td><?php echo date('Y-m-d', $v['qtime']); ?></td>
								<td><?php echo $v['code'] ?></td>
                                <td>
								<a class="layui-btn layui-btn-small do" data-type="doEdit" data-href="/pock/show/<?php echo $v['id']; ?>.html"><i class="fa fa-search"></i>查看</a>
								</td>
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
                $.post('/pock/solor.html', { keywords: keywords },
                function (result, status) {
                    if (result.state == 1) {
                        window.location.href = '/pock/solor/1?query=' + result.message;//result.data;
                    }else{
                        common.layerAlertE('错误提示：' + s.message, '提示');
                    }
                });
            });
			$('td a.do').on('click',function(){
				var href = $(this).attr('data-href');
				var name = $(this).parent().parent().find('.name').html();
                layer.open({
                    type: 2,
                    title: name,
                    //shadeClose: true,
                    shade: 0.5,
                    maxmin: true,
                    area: ['800px', '520px'],
                    fixed: true,
                    content: [href,'yes']
                });
            });

        });
    </script>
</body>
</html>