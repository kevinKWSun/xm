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
    <title>肉品品质检验合格报告单详情</title>
    <link href="/Content/layui/css/layui.css" rel="stylesheet" />
    <link href="/Content/fhuaui/css/fhuaui.css" rel="stylesheet" />
    <link href="/Content/Font-Awesome/css/font-awesome.css" rel="stylesheet" />
    <script src="/Content/layui/layui.js"></script>
</head>
<body>
    <div class="main-wrap">
        <blockquote class="layui-elem-quote fhui-admin-main_hd">
            <h2>肉品品质检验合格报告单详情 　
                <a class="layui-btn layui-btn-small" onclick="$('#myPrintArea').printArea();"><i class="fa fa-print"></i>打印</a>
            </h2>
        </blockquote>
        <div class="y-role">
            <!--文字列表-->
            <div class="fhui-admin-table-container" id='myPrintArea'>
                <div class="layui-form-item"><center>肉品品质检验合格报告单详情</center></div>
				<span style="float:right;">NO：<?php echo $ms['NO']; ?></span>
                <table class="layui-table layui-tables" lay-skin="line" boder='1'>
                    <tbody>
                        <tr>
                            <td><b>屠宰企业</b></td>
                            <td><?php echo $ms['bname']; ?></td>
                            <td><b>数量/重量</b></td>
                            <td><?php echo $ms['num']; ?> (公斤)</td>
                        </tr>
						<tr>
                            <td colspan='4'>
								1、本批产品未检出“瘦肉精”等违禁物质，未注水及他物质;　　　 　 　 <br>
2、屠宰的种猪及晚阉猪，已在胴体及品质检验合格证上注明;　 　　　 <br>
3、其他项目已按照《生猪屠宰产品品质检验规程》规定检验, 产品合格.<br><br><br>
                                                                                                    <span style="float:right;">肉品品质检验负责人签字：<?php echo $ms['charge']; ?><br> 
                                                                                                             <?php echo date('Y年m月d日', $ms['qtime']); ?> <br>
                                                                                                         （屠宰企业肉品品质检验专用章）</span>
							</td>
                        </tr>
						<tr>
                            <td colspan='4'>
							注：本报告单一猪一单，生猪产品一个包装或一个批次一单，由官方兽医连同动物检疫合格证明存根一并留存备查
							</td>
                        </tr>
                    </tbody>
                </table>
                <div style='float:right;'><?php echo ' 填表时间：',date('Y-m-d', $ms['add_time']),' ';?></div>
            </div>
            <!--/文字列表-->
        </div>
    </div>
    <script type="text/javascript" src="/Content/js/jquery-1.7.2.min.js"></script>
    <script type="text/javascript" src="/Content/jquery.PrintArea.js"></script>
</body>
</html>