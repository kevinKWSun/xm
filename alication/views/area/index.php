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
    <title>地区管理</title>
    <link href="/Content/layui/css/layui.css" rel="stylesheet" />
    <link href="/Content/fhuaui/css/fhuaui.css" rel="stylesheet" />
    <link href="/Content/Font-Awesome/css/font-awesome.css" rel="stylesheet" />
    <script src="/Content/layui/layui.js"></script>
</head>
<body>
    <div class="main-wrap">
        <blockquote class="layui-elem-quote fhui-admin-main_hd">
            <h2>地区管理</h2>
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
										<input name="skey" lay-verify="" value="" autocomplete="off" placeholder="请输入关键字" class="layui-input" type="hidden" />
                                    </div>
									<div class="layui-inline">
										<select data-val="true" data-val-number="字段 Int32 必须是一个数字" data-val-required="Int32 字段是必需的" name="pid">
											<option value='0'>所有地区</option>
											<?php foreach ($area as $vc): ?>
											<option value="<?php echo $vc['id']; ?>"><?php echo $vc['name']; ?></option>
											<?php endforeach; ?>
										</select>
									</div>
                                    <div class="layui-inline">
                                        <a class="layui-btn layui-btn-small" lay-submit="" lay-filter="cx">
                                            <i class="fa fa-search"></i>查询
                                        </a>
                                        <a class="layui-btn layui-btn-small do-action" data-type="doRefresh" data-href="/areanews.html">
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
                                <th>烟台市地区名称</th>
                                <th>操作</th>
                            </tr>
                        </thead>
                        <tbody>
                        	<?php if(! $areas){ ?>
                            <tr>
                                <td class="nodata" colspan="2">暂无数据！</td>
                            </tr>
                            <?php }else{foreach ($areas as $v): ?>
                            <tr>
                                <td class='name'>
                                    <?php echo $v['name']; ?>
                                </td>
                                <td>
                                    <a class="layui-btn layui-btn-small" data-type="" data-type="doEdit" data-href="/areanews/add/<?php echo $v['id']; ?>.html"><i class="icon-edit fa fa-plus"></i>增加</a>
                                </td>
                            </tr>
							<?php if ($v['childs']){ foreach ($v['childs'] as $vs):  ?>
                            <tr>
                                <td class='name'>
                                    　├<?php echo $vs['name']; ?>
                                </td>
                                <td>
                                    <a class="layui-btn layui-btn-small" data-href="/areanews/edit/<?php echo $vs['id']; ?>.html"><i class="icon-edit fa fa-pencil-square-o"></i>编辑</a>
                                </td>
                            </tr>
                            <?php endforeach;}endforeach;} ?>
                        </tbody>
                    </table>
                </form>
            </div>
            <!--/文字列表-->
            
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
				keywords = keywords ? keywords : 0;
				var pid = data.field.pid;
                $.post('/areanews/solor', { keywords: keywords, pid: pid},
                function (result, status) {
                    if (result.state == 1) {
                        window.location.href = '/areanews/solor/' + keywords + '/' + pid + '.html';//result.data;
                    }else{
                        common.layerAlertE('错误提示：' + result.message, '提示');
                    }
                });
            });
			$('td a').on('click',function(){
				var href = $(this).attr('data-href');
				var name = $(this).parent().parent().find('.name').html();
                layer.open({
                    type: 2,
                    title: name,
                    //shadeClose: true,
                    shade: 0.5,
                    maxmin: true,
                    area: ['700px', '520px'],
                    fixed: false,
                    content: [href,'no']
                });
            });
        });
    </script>
</body>
</html>