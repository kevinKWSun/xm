
layui.use(['layer', 'common', 'element', 'form', 'upload', 'laydate'], function () {
    var $ = layui.jquery
        , layer = layui.layer
        , laypage = layui.laypage
        , common = layui.common
        , form = layui.form()
        , laydate = layui.laydate
        , element = layui.element;
    //新增全选!--
    $('dl.checkmod dt').on('click', function (event) {
        var d = $(this).find('div').hasClass('layui-form-checked');
        if(d){
            $(this).find('input').attr('checked',true);
            $(this).parent().find('div.layui-form-checkbox').addClass('layui-form-checked');
            $(this).parent().find('input').attr('checked',true);
        }else{
            $(this).find('input').attr('checked',false);
            $(this).parent().find('div.layui-form-checkbox').removeClass('layui-form-checked');
            $(this).parent().find('input').attr('checked',false);
        }
    });
    $('dl.checkmod dd div.towC').on('click', function (event) {
        var d = $(this).find('div').hasClass('layui-form-checked');
        if(d){
            $(this).parent().find('input').attr('checked',true);
            $(this).parent().find('div.layui-form-checkbox').addClass('layui-form-checked');
        }else{
            $(this).parent().find('input').attr('checked',false);
            $(this).parent().find('div.layui-form-checkbox').removeClass('layui-form-checked');
        }
    });
    $('dl.checkmod li div.towD').on('click', function (event) {
        var d = $(this).find('div').hasClass('layui-form-checked');
        if(d){
            $(this).parent().find('input').attr('checked',true);
            $(this).parent().find('div.layui-form-checkbox').addClass('layui-form-checked');
        }else{
            $(this).parent().find('input').attr('checked',false);
            $(this).parent().find('div.layui-form-checkbox').removeClass('layui-form-checked');
        }
    });
    $('dl.checkmod div.towE').on('click', function (event) {
        var d = $(this).find('div').hasClass('layui-form-checked');
        if(d){
            $(this).parent().find('input').attr('checked',true);
            $(this).parent().find('div.layui-form-checkbox').addClass('layui-form-checked');
        }else{
            $(this).parent().find('input').attr('checked',false);
            $(this).parent().find('div.layui-form-checkbox').removeClass('layui-form-checked');
        }
    });
    //新增全选结束--!
    //多项选项PROP
    var active = {
        ruleMultiPorp: function () {
            var parentObj = $(".rule-multi-porp");
            $(parentObj).each(function () {
                var $parentObj = $(this);
                $parentObj.addClass("multi-porp"); //添加样式
                $parentObj.children().hide(); //隐藏内容
                var divObj = $('<ul></ul>').prependTo($parentObj); //前插入一个DIV
                $parentObj.find(":checkbox").each(function () {
                    var indexNum = $parentObj.find(":checkbox").index(this); //当前索引
                    var liObj = $('<li></li>').appendTo(divObj)
                    var newObj = $('<a href="javascript:;">' + $parentObj.find('label').eq(indexNum).text() + '</a><i></i>').appendTo(liObj); //查找对应Label创建选项
                    if ($(this).prop("checked") == true) {
                        liObj.addClass("selected"); //默认选中
                    }
                    //检查控件是否启用
                    if ($(this).prop("disabled") == true) {
                        newObj.css("cursor", "default");
                        return;
                    }
                    //绑定事件
                    $(newObj).click(function () {
                        if ($(this).parent().hasClass("selected")) {
                            $(this).parent().removeClass("selected");
                        } else {
                            $(this).parent().addClass("selected");
                        }
                        $parentObj.find(':checkbox').eq(indexNum).trigger("click"); //触发对应的checkbox的click事件
                        //alert(parentObj.find(':checkbox').eq(indexNum).prop("checked"));
                    });
                });
            });
        },
		doShow: function () {
            var url = $(this).data('href');
            if (url) {
                layer.open({
                    type: 2,
                    title: '详情',
                    //shadeClose: true,
                    shade: 0.1,
                    maxmin: true,
                    area: ['90%', '90%'],
                    fixed: true,
                    content: url
                });
            }
            else {
                common.layerAlertE('链接错误！', '提示');
            }
        },
        submit: function (dat) {
            var url = $(this).data('href');
            if (url) {
                $.ajax({
                    url: url,
                    type: type,
                    dataType: dataType,
                    data: data,
                    success: function (data, startic) {
                        if (data.state == 1) {
                            obj.layerAlertS(data.message, '提示');
                            location.href = location.href;
                        }
                        else {
                            obj.layerAlertE(data.message, '提示');
                        }
                    },
                    error: function () {

                    }
                });
            } else {
                common.layerAlertE('链接错误！', '提示');
            }
        },
    };
    //初始化PROP
    active['ruleMultiPorp'] ? active['ruleMultiPorp'].call(this) : '';	form.on('submit(doPosttz)', function (data) {        var url = $(this).data('href');        var t = true;        if (url) {			var type = ''			$("input:checkbox[name='type']:checked").each(function() {				type += $(this).val()+',';			});			data.field.type = type;            if (t) {                $.ajax({                    url: url,                    type: 'post',                    dataType: 'json',                    data: data.field,                    success: function (data, startic) {                        if (data.state == 1) {                            layer.msg(data.message);                            location.href = data.url;                        }                        else {                            layer.msg(data.message);                        }                    },                    beforeSend: function () {                       // 一般是禁用按钮等防止用户重复提交                       $(data.elem).attr("disabled", "true").text("保存中...");                    },                    complete: function () {                       $(data.elem).removeAttr("disabled").html('<i class="fa fa-save"></i>提交');                    },                    error: function (XMLHttpRequest, textStatus, errorThrown) {                        common.layerAlertE(textStatus, '提示');                    }                });            }        } else {            common.layerAlertE('链接错误！', '提示');        }        return false;    });
    form.on('submit(doPost)', function (data) {
        var url = $(this).data('href');
        var t = true;
        if (url) {
            if (data.field.pd != data.field.pd2) {
                t = false;
                layer.msg('两次密码不一致', '提示');
                return;
            }/* 			if (data.field.type) {				var type = ''				$("input:checkbox[name='type']:checked").each(function() {					type += $(this).val()+',';				});				data.field.type = type;            } */
            if (t) {
                $.ajax({
                    url: url,
                    type: 'post',
                    dataType: 'json',
                    data: data.field,
                    success: function (data, startic) {
                        if (data.state == 1) {
                            layer.msg(data.message);
                            location.href = data.url;
                        }
                        else {
                            layer.msg(data.message);
                        }
                    },
                    beforeSend: function () {
                       // 一般是禁用按钮等防止用户重复提交
                       $(data.elem).attr("disabled", "true").text("保存中...");
                    },
                    complete: function () {
                       $(data.elem).removeAttr("disabled").html('<i class="fa fa-save"></i>提交');
                    },
                    error: function (XMLHttpRequest, textStatus, errorThrown) {
                        common.layerAlertE(textStatus, '提示');
                    }
                });
            }
        } else {
            common.layerAlertE('链接错误！', '提示');
        }
        return false;
    });
    form.on('submit(doPostAll)', function (data) {
        var url = $(this).data('href');
        if (url) {
            var title = "", name = "";
            $('input[name=title]').each(function(){
                if($(this).val()){
                    title += $(this).val() + ',';
                }else {
                    layer.msg('请完善必填项', '提示');
                }
            });
            $('input[name=name]').each(function(){
                name += $(this).val() + ',';
            });
            var gids = $('#gids').val();
            var type = data.field.type;
            var data = {gids: gids,name: name,title: title, type: type};
            $.ajax({
                url: url,
                type: 'post',
                dataType: 'json',
                data: data,
                success: function (data, startic) {
                    if (data.state == 1) {
                        layer.msg(data.message);
                        location.href = data.url;
                    }
                    else {
                        layer.msg(data.message);
                    }
                },
                beforeSend: function () {
                   // 一般是禁用按钮等防止用户重复提交
                   $(data.elem).attr("disabled", "true").text("保存中...");
                },
                complete: function () {
                   $(data.elem).removeAttr("disabled").html('<i class="fa fa-save"></i>提交');
                },
                error: function (XMLHttpRequest, textStatus, errorThrown) {
                    common.layerAlertE(textStatus, '提示');
                }
            });
        } else {
            common.layerAlertE('链接错误！', '提示');
        }
        return false;
    });
    form.on('submit(doPostg)', function (data) {
        var url = $(this).data('href');
        if (url) {
            var ids = "";
            var checkObj = $("dl input:checked");
            if(checkObj.length >= 1){
                for (var i = 0; i < checkObj.length; i++) {
                    if (checkObj[i].checked && $(checkObj[i]).attr("disabled") != "disabled"){
                        ids += $(checkObj[i]).attr("ids") + ',';
                    }
                }
            }
            var name = $('#name').val();
            if($('#id').val()){
                var data = {ids: ids,name: name, id: $('#id').val()};
            }else{
                var data = {ids: ids,name: name};
            }
            $.ajax({
                url: url,
                type: 'post',
                dataType: 'json',
                data: data,
                success: function (data, startic) {
                    if (data.state == 1) {
                        layer.msg(data.message);
                        location.href = data.url;
                    }
                    else {
                        layer.msg(data.message);
                    }
                },
                beforeSend: function () {
                   // 一般是禁用按钮等防止用户重复提交
                   $(data.elem).attr("disabled", "true").text("保存中...");
                },
                complete: function () {
                   $(data.elem).removeAttr("disabled").html('<i class="fa fa-save"></i>提交');
                },
                error: function (XMLHttpRequest, textStatus, errorThrown) {
                    common.layerAlertE(textStatus, '提示');
                }
            });
        } else {
            common.layerAlertE('链接错误！', '提示');
        }
        return false;
    });
    form.on('submit(doPosty)', function (data) {
        var url = $(this).data('href');
        if (url) {
            $('.address select').each(function(){
                var op = $(this).find('option:selected').val();
                if(op == 0 || ! op){
                    layer.msg('请完善地址项');
                    return;
                }else{
                    data.field.cityid += op + ',';
                }
            });
            $('fieldset select').each(function(){
                data.field.position += $(this).find('option:selected').val() + ',';
            });
            $('fieldset input[name=names]').each(function(){
                data.field.name += $(this).val() + ',';
            });
            $('fieldset input[name=departments]').each(function(){
                data.field.department += $(this).val() + ',';
            });
            $('fieldset input[name=tels]').each(function(){
                data.field.tel += $(this).val() + ',';
            });
            $('fieldset input[name=phones]').each(function(){
                data.field.phone += $(this).val() + ',';
            });
            $.ajax({
                url: url,
                type: 'post',
                dataType: 'json',
                data: data.field,
                success: function (data, startic) {
                    if (data.state == 1) {
                        layer.msg(data.message);
                        location.href = data.url;
                    }
                    else {
                        layer.msg(data.message);
                    }
                },
                beforeSend: function () {
                   // 一般是禁用按钮等防止用户重复提交
                   $(data.elem).attr("disabled", "true").text("保存中...");
                },
                complete: function () {
                   $(data.elem).removeAttr("disabled").html('<i class="fa fa-save"></i>提交');
                },
                error: function (XMLHttpRequest, textStatus, errorThrown) {
                    common.layerAlertE(textStatus, '提示');
                }
            });
        } else {
            common.layerAlertE('链接错误！', '提示');
        }
        return false;
    });
    form.on('submit(doPostw)', function (data) {
        var url = $(this).data('href');
        if (url) {
            $('.address select').each(function(){
                var op = $(this).find('option:selected').val();
                if(op == 0 || ! op){
                    layer.msg('请完善地址项');
                    return;
                }else{
                    data.field.cityid += op + ',';
                }
            });
            $.ajax({
                url: url,
                type: 'post',
                dataType: 'json',
                data: data.field,
                success: function (data, startic) {
                    if (data.state == 1) {
                        layer.msg(data.message);
                        location.href = data.url;
                    }
                    else {
                        layer.msg(data.message);
                    }
                },
                beforeSend: function () {
                   // 一般是禁用按钮等防止用户重复提交
                   $(data.elem).attr("disabled", "true").text("保存中...");
                },
                complete: function () {
                   $(data.elem).removeAttr("disabled").html('<i class="fa fa-save"></i>提交');
                },
                error: function (XMLHttpRequest, textStatus, errorThrown) {
                    common.layerAlertE(textStatus, '提示');
                }
            });
        } else {
            common.layerAlertE('链接错误！', '提示');
        }
        return false;
    });
	form.on('submit(doPostArea)', function (data) {
		var index = parent.layer.getFrameIndex(window.name);
        var url = $(this).data('href');
		var rel = $(this).attr('rel');
		if(rel == 2){
			var title = "";
			$('input[name=title]').each(function(){
				if($(this).val()){
					title += $(this).val() + ',';
				}else {
					layer.msg('请完善必填项', '提示');
				}
			});
			data.field.title = title;
		}
        if (url) {
            $.ajax({
                url: url,
                type: 'post',
                dataType: 'json',
                data: data.field,
                success: function (data, startic) {
                    if (data.state == 1) {
                        layer.msg(data.message);
                        parent.layer.close(index);
						window.parent.location.reload();
                    }
                    else {
                        layer.msg(data.message);
                    }
                },
                beforeSend: function () {
                   // 一般是禁用按钮等防止用户重复提交
                   $(data.elem).attr("disabled", "true").text("保存中...");
                },
                complete: function () {
                   $(data.elem).removeAttr("disabled").html('<i class="fa fa-save"></i>提交');
                },
                error: function (XMLHttpRequest, textStatus, errorThrown) {
                    common.layerAlertE(textStatus, '提示');
                }
            });
        } else {
            common.layerAlertE('链接错误！', '提示');
        }
        return false;
    });
	$('.do-action').on('click', function (e) {
        var type = $(this).data('type');
        active[type] ? active[type].call(this) : '';
        layui.stope(e);
    });
	form.on('submit(doPostAllS)', function (data) {
        var url = $(this).data('href');
        if (url) {
            var breed = "", types = "", stock = '', unit = '';
            $('select[name=breed]').each(function(){
                if($(this).val() > 0){
                    breed += $(this).val() + ',';
                }
            });
            $('select[name=types]').each(function(){
                if($(this).val() > 0){
                    types += $(this).val() + ',';
                }
            });
			$('input[name=stock]').each(function(){
                if($(this).val() > 0){
                    stock += $(this).val() + ',';
                }
            });
			$('select[name=unit]').each(function(){
                if($(this).val() > 0){
                    unit += $(this).val() + ',';
                }
            });
            var id = $('input[name=id]').val();
            var data = {breed: breed,types: types,stock: stock, unit: unit, id: id};
            $.ajax({
                url: url,
                type: 'post',
                dataType: 'json',
                data: data,
                success: function (data, startic) {
                    if (data.state == 1) {
                        layer.msg(data.message);
                        location.href = data.url;
                    }
                    else {
                        layer.msg(data.message);
                    }
                },
                beforeSend: function () {
                   // 一般是禁用按钮等防止用户重复提交
                   $(data.elem).attr("disabled", "true").text("保存中...");
                },
                complete: function () {
                   $(data.elem).removeAttr("disabled").html('<i class="fa fa-save"></i>提交');
                },
                error: function (XMLHttpRequest, textStatus, errorThrown) {
                    common.layerAlertE(textStatus, '提示');
                }
            });
        } else {
            common.layerAlertE('链接错误！', '提示');
        }
        return false;
    });	form.on('submit(doPostAllSy)', function (data) {

        var url = $(this).data('href');

        if (url) {

            var breed = "", types = "", stock = '';

            $('select[name=breed]').each(function(){

                if($(this).val() > 0){

                    breed += $(this).val() + ',';

                }

            });

            $('select[name=types]').each(function(){

                if($(this).val() > 0){

                    types += $(this).val() + ',';

                }

            });

			$('input[name=stock]').each(function(){

                stock += $(this).val() + ',';

            });

            var id = $('input[name=id]').val();

            var data = {breed: breed,types: types,stock: stock, id: id};

            $.ajax({

                url: url,

                type: 'post',

                dataType: 'json',

                data: data,

                success: function (data, startic) {

                    if (data.state == 1) {

                        layer.msg(data.message);

                        location.href = data.url;

                    }

                    else {

                        layer.msg(data.message);

                    }

                },

                beforeSend: function () {

                   // 一般是禁用按钮等防止用户重复提交

                   $(data.elem).attr("disabled", "true").text("保存中...");

                },

                complete: function () {

                   $(data.elem).removeAttr("disabled").html('<i class="fa fa-save"></i>提交');

                },

                error: function (XMLHttpRequest, textStatus, errorThrown) {

                    common.layerAlertE(textStatus, '提示');

                }

            });

        } else {

            common.layerAlertE('链接错误！', '提示');

        }

        return false;

    });
});