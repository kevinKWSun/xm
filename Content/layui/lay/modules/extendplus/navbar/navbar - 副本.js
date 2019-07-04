layui.define(['element', 'layer', 'common'], function (exports) {var $ = layui.jquery,layer = layui.layer,
        element = layui.element(),
        common = layui.common,
        cacheName = 'tb_navbar';
    var Navbar = function () {
        this.config = {
            elem: undefined,
            data: undefined,
            url: undefined,
            type: 'GET',
            cached: false
        };
        this.v = '0.0.1';
    };
    Navbar.prototype.render = function () {
        var _that = this;
        var _config = _that.config;       
        if (typeof (_config.elem) !== 'string' && typeof (_config.elem) !== 'object') {
            common.layerAlertE('Navbar error: elem参数未定义或设置出错.', '出错');
        }
        var $container;
        if (typeof (_config.elem) === 'string') {
            $container = $('' + _config.elem + '');
        }
        if (typeof (_config.elem) === 'object') {
            $container = _config.elem;
        }
        if ($container.length === 0) {
            common.layerAlertE('Navbar error:找不到elem参数配置的容器，请检查.', '出错');
        }
        if (_config.data === undefined && _config.url === undefined) {
            common.layerAlertE('Navbar error:请为Navbar配置数据源.', '出错')
        }
        if (_config.data !== undefined && typeof (_config.data) === 'object') {
            var html = getHtml(_config.data);
            $container.html(html);
            element.init();
            _that.config.elem = $container;
        } else {
            if (_config.cached) {
                var cacheNavbar = layui.data(cacheName);
                if (cacheNavbar.navbar === undefined) {
                    $.ajax({
                        type: _config.type,
                        url: _config.url,
                        async: false, 
                        dataType: 'json',
                        success: function (result, status, xhr) {
                            layui.data(cacheName, {
                                key: 'navbar',
                                value: result
                            });
                            var html = getHtml(result);
                            $container.html(html);
                            element.init();
                        },
                        error: function (xhr, status, error) {
                            common.msgError('Navbar error:' + error);
                        },
                        complete: function (xhr, status) {
                            _that.config.elem = $container;
                        }
                    });
                } else {
                    var html = getHtml(cacheNavbar.navbar);
                    $container.html(html);
                    element.init();
                    _that.config.elem = $container;
                }
            } else {
                layui.data(cacheName, null);
                $.ajax({
                    type: _config.type,
                    url: _config.url,
                    async: false, 
                    dataType: 'json',
                    success: function (result, status, xhr) {
                        var html = getHtml(result);
                        $container.html(html);
                        element.init();
                    },
                    error: function (xhr, status, error) {
                        common.msgError('Navbar error:' + error);
                    },
                    complete: function (xhr, status) {
                        _that.config.elem = $container;
                    }
                });
            }
        }

        return _that;
    };

    Navbar.prototype.set = function (options) {
        var that = this; 
        $.extend(that.config, options);
        return that;
    };

    Navbar.prototype.on = function (events, callback) {
        var that = this;
        var _con = that.config.elem;
        if (typeof (events) !== 'string') {
            common.layerAlertE('Navbar error:事件名配置出错.', '出错');
        }
        var lIndex = events.indexOf('(');
        var eventName = events.substr(0, lIndex);
        var filter = events.substring(lIndex + 1, events.indexOf(')'));
        if (eventName === 'click') {
            if (_con.attr('lay-filter') !== undefined) {
                _con.children('ul').find('li').each(function () {
                    var $this = $(this);
                    if ($this.find('dl').length > 0) {
                        var $dd = $this.find('dd').each(function () {
                            $(this).on('click', function () {
                                var $a = $(this).children('a');
                                var href = $a.data('url');
                                var icon = $a.children('i').attr('class');
                                var title = $a.children('cite').text();
                                var data = {
                                    elem: $a,
                                    field: {
                                        href: href,
                                        icon: icon,
                                        title: title
                                    }
                                }
                                callback(data);
                            });
                        });
                    } else {
                        $this.on('click', function () {
                            var $a = $this.children('a');
                            var href = $a.data('url');
                            var icon = $a.children('i').attr('class');
                            var title = $a.children('cite').text();
                            var data = {
                                elem: $a,
                                field: {
                                    href: href,
                                    icon: icon,
                                    title: title
                                }
                            }
                            callback(data);
                        });
                    }
                });
            }
        }
    };

    function getHtml(data) {
        var ulHtml = '<div id="sidebar" class="sidebar-fold"><i class="fa fa-bars"></i></div><ul class="layui-nav layui-nav-tree admin-nav-tree">';
        for (var i = 0; i < data.length; i++) {
            if (i == 0) {
                ulHtml += '<li class="layui-nav-item layui-nav-itemed">';
            } else {
                ulHtml += '<li class="layui-nav-item">';
            }
            if (data[i].children !== undefined && data[i].children.length > 0) {
                ulHtml += '<a href="javascript:;">';
                if (data[i].icon !== undefined && data[i].icon !== '') {
                    if (data[i].icon.indexOf('fa-') !== -1) {
                        ulHtml += '<i class="' + data[i].icon + '" aria-hidden="true"></i>';
                    } else {
                        ulHtml += '<i class="layui-icon">' + data[i].icon + '</i>';
                    }
                }
                ulHtml += '<cite>' + data[i].title + '</cite>';
                ulHtml += '<span class="layui-nav-more"></span>';
                ulHtml += '</a>';
                ulHtml += '<dl class="layui-nav-child">';
                for (var j = 0; j < data[i].children.length; j++) {
                    if(data[i].children[j].children == null || ! data[i].children[j].children){
                        ulHtml += '<dd>';
                        ulHtml += '<a href="javascript:;" data-url="' + data[i].children[j].href + '">';
                        if (data[i].children[j].icon !== undefined && data[i].children[j].icon !== '') {
                            if (data[i].children[j].icon.indexOf('fa-') !== -1) {
                                ulHtml += '<i class="' + data[i].children[j].icon + '" aria-hidden="true"></i>';
                            } else {
                                ulHtml += '<i class="layui-icon">' + data[i].children[j].icon + '</i>';
                            }
                        }
                        ulHtml += '<cite>' + data[i].children[j].title + '</cite>';
                        ulHtml += '</a>';
                        ulHtml += '</dd>';
                    }else{
                        if(data[i].children[j].children !== undefined && data[i].children[j].children.length > 0){
                            if (i == 0 && j == 0) {
                                ulHtml += '<div class="layui-nav-item rel">';
                            } else {
                                ulHtml += '<div class="layui-nav-item layui-nav-itemed rel">';
                            }
                            ulHtml += '<a href="javascript:;" style="padding-left: 15px;">';
                            if (data[i].children[j].icon !== undefined && data[i].children[j].icon !== '') {
                                if (data[i].children[j].icon.indexOf('fa-') !== -1) {
                                    ulHtml += '<i class="' + data[i].children[j].icon + '" aria-hidden="true"></i>';
                                } else {
                                    ulHtml += '<i class="layui-icon">' + data[i].children[j].icon + '</i>';
                                }
                            }
                            ulHtml += '<cite>' + data[i].children[j].title + '</cite>';
                            ulHtml += '<span class="layui-nav-more"></span>';
                            ulHtml += '</a>';
                            if(i == 0 && j == 0){
                                ulHtml += '<dl class="layui-nav-child layui-nav-childs" style="display:block;">';
                            }else{
                                ulHtml += '<dl class="layui-nav-child layui-nav-childs" style="display:none;">';
                            }
                            for(var g = 0; g < data[i].children[j].children.length; g++){
                                if(data[i].children[j].children[g].children == null || ! data[i].children[j].children[g].children){
                                    ulHtml += '<dd>';
                                    ulHtml += '<a href="javascript:;" data-url="' + data[i].children[j].children[g].href + '">　';
                                    if (data[i].children[j].children[g].icon !== undefined && data[i].children[j].children[g].icon !== '') {
                                        if (data[i].children[j].children[g].icon.indexOf('fa-') !== -1) {
                                            ulHtml += '<i class="' + data[i].children[j].children[g].icon + '" aria-hidden="true"></i>';
                                        } else {
                                            ulHtml += '<i class="layui-icon">' + data[i].children[j].children[g].icon + '</i>';
                                        }
                                    }
                                    ulHtml += '<cite>' + data[i].children[j].children[g].title + '</cite>';
                                    ulHtml += '</a>';
                                    ulHtml += '</dd>';
                                }else{
                                    if(data[i].children[j].children[g].children !== undefined && data[i].children[j].children[g].children.length > 0){
                                        if (i == 0 && j == 0 && g == 0) {
                                            ulHtml += '<div class="layui-nav-item rels">';
                                        } else {
                                            ulHtml += '<div class="layui-nav-item layui-nav-itemed rels">';
                                        }
                                        ulHtml += '<a href="javascript:;" style="padding-left: 30px;">';
                                        if (data[i].children[j].children[g].icon !== undefined && data[i].children[j].children[g].icon !== '') {
                                            if (data[i].children[j].children[g].icon.indexOf('fa-') !== -1) {
                                                ulHtml += '<i class="' + data[i].children[j].children[g].icon + '" aria-hidden="true"></i>';
                                            } else {
                                                ulHtml += '<i class="layui-icon">' + data[i].children[j].children[g].icon + '</i>';
                                            }
                                        }
                                        ulHtml += '<cite>' + data[i].children[j].children[g].title + '</cite>';
                                        ulHtml += '<span class="layui-nav-more"></span>';
                                        ulHtml += '</a>';
                                        if (i == 0 && j == 0 && g == 0) {
                                            ulHtml += '<dl class="layui-nav-child layui-nav-childss" style="display:block;padding-left: 15px;">';
                                        }else{
                                            ulHtml += '<dl class="layui-nav-child layui-nav-childss" style="display:none;padding-left: 15px;">';
                                        }
                                        for(var v = 0; v < data[i].children[j].children[g].children.length; v++){
                                            ulHtml += '<dd>';
                                            ulHtml += '<a href="javascript:;" data-url="' + data[i].children[j].children[g].children[v].href + '">　';
                                            if (data[i].children[j].children[g].children[v].icon !== undefined && data[i].children[j].children[g].children[v].icon !== '') {
                                                if (data[i].children[j].children[g].children[v].icon.indexOf('fa-') !== -1) {
                                                    ulHtml += '<i class="' + data[i].children[j].children[g].children[v].icon + '" aria-hidden="true"></i>';
                                                } else {
                                                    ulHtml += '<i class="layui-icon">' + data[i].children[j].children[g].children[v].icon + '</i>';
                                                }
                                            }
                                            ulHtml += '<cite>' + data[i].children[j].children[g].children[v].title + '</cite>';
                                            ulHtml += '</a>';
                                            ulHtml += '</dd>';
                                        }
                                        ulHtml += '</dl></div>';
                                    }
                                }
                            }
                            ulHtml += '</dl></div>';
                        }
                    }
                }
                ulHtml += '</dl>';
            } else {
                var dataUrl = (data[i].href !== undefined && data[i].href !== '') ? 'data-url="' + data[i].href + '"' : '';
                ulHtml += '<a class="rs" href="javascript:;" ' + dataUrl + '>';
                if (data[i].icon !== undefined && data[i].icon !== '') {
                    if (data[i].icon.indexOf('fa-') !== -1) {
                        ulHtml += '<i class="' + data[i].icon + '" aria-hidden="true"></i>';
                    } else {
                        ulHtml += '<i class="layui-icon">' + data[i].icon + '</i>';
                    }
                }
                ulHtml += '<cite>' + data[i].title + '</cite>'
                ulHtml += '</a>';
            }
            ulHtml += '</li>';
        }
        ulHtml += '</ul>';

        return ulHtml;
    }
    var navbar = new Navbar();
    exports('navbar', function (options) {
        return navbar.set(options);
    });
});