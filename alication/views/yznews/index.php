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
    <title>规模化养殖场</title>
    <link href="/Content/layui/css/layui.css" rel="stylesheet" />
    <link href="/Content/fhuaui/css/fhuaui.css" rel="stylesheet" />
    <link href="/Content/Font-Awesome/css/font-awesome.css" rel="stylesheet" />
    <script src="/Content/layui/layui.js"></script>
</head>
<body>
    <div class="main-wrap">
        <blockquote class="layui-elem-quote fhui-admin-main_hd">
            <h2>规模化养殖场</h2>
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
                                        <a class="layui-btn layui-btn-small do-action" data-type="doAdd" data-href="/yznews/yznewsadd.html">
                                            <i class="fa fa-plus"></i>新增
                                        </a><!-- 
                                        <a class="layui-btn layui-btn-small do-action" data-type="doAction" data-href="/ausers">
                                            <i class="fa fa-edit"></i>初始化密码
                                        </a> -->
                                        <a class="layui-btn layui-btn-small do-action" data-type="doAction" data-href="/yznews/lock.html">
                                            <i class="fa fa-lock"></i>关闭
                                        </a>
                                        <a class="layui-btn layui-btn-small do-action" data-type="doAction" data-href="/yznews/unlock.html">
                                            <i class="fa fa-unlock"></i>开启
                                        </a>
                                        <!-- <a class="layui-btn layui-btn-small do-action" data-type="doDelete" data-href="/ausers/del.html">
                                            <i class="fa fa-trash-o"></i>删除
                                        </a> -->
										<a class="layui-btn layui-btn-small do-action" data-type="doAction" data-href="/yznews/sh.html">
                                            <i class="fa fa-refresh"></i>审核通过
                                        </a>
										<a class="layui-btn layui-btn-small do-action" data-type="doAction" data-href="/yznews/desh.html">
                                            <i class="fa fa-refresh"></i>审核不通过
                                        </a>
                                        <a class="layui-btn layui-btn-small do-action" data-type="doRefresh" data-href="/yznews/index.html">
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
                                <th><input type="checkbox" id="selected-all" /></th>
                                <th>养殖场名称</th>
                                <th>编号</th>
                                <th>监管兽医</th>
                                <th>地址</th>
								<th>法定代表/负责人</th>
								<th>法人联系电话</th>
								<th>防疫合格证编号</th>
								<th>防疫合格证发证时间</th>
								<td>视频信号接入点</td>
								<th>经营状态</th>
								<th>审核状态</th>
								<th>编辑</th>
								<th>详情</th>
                            </tr>
                        </thead>
                        <tbody>
							<?php foreach ($yznews as $v) { ?>
							<tr>
								<td>
                                    <input id="ck" ids="<?php echo $v['id']; ?>" name="ck" type="checkbox" value="true" />
                                </td>
								<td><?php echo $v['name']; ?></td>
                                <td><?php echo 'YTYZC' . str_pad($v['id'],6,'0',STR_PAD_LEFT); ?></td>
                                <td><?php echo $v['vname']; ?></td>
                                <td><?php echo $v['addr']; ?></td>
								<td><?php echo $v['legal_name'].'/'.$v['real_name']; ?></td>
								<td><?php echo $v['legal_phone']; ?></td>
								<td><?php echo $v['prevent_num']; ?></td>
								<td><?php echo date('Y-m-d', $v['issuing_time']); ?></td>
								<td><?php echo $v['point']; ?></td>
								<td><?php echo ($v['status']!=3) ? '正常' : '关闭'; ?></td>
								<td><?php if($v['status']==0){echo '待审';}elseif($v['status']==1){echo '通过';}elseif($v['status']==2){echo '未通过';}else{echo '无';} ?></td>
								<td>
									 <a class="layui-btn layui-btn-small do-action" data-type="doEdit" data-href="/yznews/yznewsedit/<?php echo $v['id']; ?>.html"><i class="icon-edit  fa fa-pencil-square-o"></i>编辑</a>　
									<a class="layui-btn layui-btn-small do-action" data-type="doEdit" data-href="/yznews/stock/<?php echo $v['id']; ?>.html"><i class="icon-edit  fa fa-pencil-square-o"></i>详细</a>
								</td>
								<td>
									<a class="layui-btn layui-btn-small do-action" data-type="doEdit" data-href="/yznews/yznewsdetail/<?php echo $v['id']; ?>.html"><i class="fa fa-search"></i>查看</a>
								</td>
							</tr>
							<?php } ?>
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
                $.post('/yznews/solor', { keywords: keywords },
                function (result, status) {
                    if (result.state == 1) {
                        window.location.href = '/yznews/solor/1?query=' + result.message;//result.data;
                    }else{
                        common.layerAlertE('错误提示：' + s.message, '提示');
                    }
                });
            });
        });
    </script>
</body>
</html>