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
    <title>疫情信息</title>
    <link href="/Content/layui/css/layui.css" rel="stylesheet" />
    <link href="/Content/fhuaui/css/fhuaui.css" rel="stylesheet" />
    <link href="/Content/Font-Awesome/css/font-awesome.css" rel="stylesheet" />
    <script src="/Content/layui/layui.js"></script>
</head>
<body>
    <div class="main-wrap">
        <blockquote class="layui-elem-quote fhui-admin-main_hd">
            <h2>疫情信息</h2>
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
										<input name="skey" lay-verify="required" value="" autocomplete="off" placeholder="地点/疫病/症状/联系方式" class="layui-input" type="text" />
									</div>
                                    <div class="layui-inline">
                                        <a class="layui-btn layui-btn-small" lay-submit="" lay-filter="cx">
                                            <i class="fa fa-search"></i>查询
                                        </a>
                                        <a class="layui-btn layui-btn-small do-action" data-type="doRefresh" data-href="/yjgisnews/report.html">
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
								<th>选项</th>
                                <th>疫情编号</th>
                                <th>发病地点</th>
								<th>联系方式</th>
								<th>疑似的疫病</th>
								<th>临床症状</th>
                                <th>报告时间</th>
                                <th>存栏数量</th>
                                <th>发病数量</th>
								<th>死亡数量</th>
								<th>审核状态</th>
								<th>操作</th>
                            </tr>
                        </thead>
                        <tbody>
                        	<?php if(! $synews){ ?>
                            <tr>
                                <td class="nodata" colspan="12">暂无数据！</td>
                            </tr>
                            <?php }else{foreach ($synews as $v): ?>
                            <tr class='ck'>
								<td>
                                    <input name="ck" value="<?php echo $v['id']; ?>" title="<?php echo $v['suspected']; ?>" type="radio" lng="<?php echo $v['lng']; ?>" lat="<?php echo $v['lat'] ?>">
                                </td>
                                <td class='name'><?php echo 'YTYQ' . str_pad($v['id'],6,'0',STR_PAD_LEFT); ?></td>
                                <td><?php echo $v['area'] ?></td>
								<td><?php echo $v['tel'] ?></td>
                                <td><?php echo $v['suspected']; ?></td>
                                <td><?php echo $v['symptom'] ?></td>
								<td><?php echo date('Y-m-d', $v['times']); ?></td>
								<td><?php echo $v['cnumber'] ?></td>
								<td><?php echo $v['fnumber'] ?></td>
								<td><?php echo $v['number'] ?></td>
								<td><?php if($v['status']==0){echo '待审';}elseif($v['status']==1){echo '通过';}elseif($v['status']==2){echo '未通过';}else{echo '无';} ?></td>
                                <td>
                                    <a class="layui-btn layui-btn-small" href='javascript:;'><i class="fa fa-save"></i>确定</a>
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
                $.post('/yjgisnews/report', { keywords: keywords },
                function (result, status) {
                    if (result.state == 1) {
                        window.location.href = '/yjgisnews/report/1?query=' + result.message;//result.data;
                    }else{
                        common.layerAlertE('错误提示：' + s.message, '提示');
                    }
                });
            });
			var index = parent.layer.getFrameIndex(window.name);
			$('tr.ck').on('click', function(){
				var sid = $(this).find('input').val();
				var sa = $(this).find('input').attr('title');
				var lng = $(this).find('input').attr('lng');
				var lat = $(this).find('input').attr('lat');
				$(window.parent.document).find('input[name=sname]').val(sa);
				$(window.parent.document).find('input[name=sid]').val(sid);
				$(window.parent.document).find('input[name=lngb]').val(lng);
				$(window.parent.document).find('input[name=latb]').val(lat);
				$(window.parent.document).find('#iframeMap').attr('src', '/map/getmap/'+lng+'/'+lat+'.html');
                parent.layer.close(index);
			});
        });
    </script>
</body>
</html>