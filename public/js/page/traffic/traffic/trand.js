define(['tb', 'jquery_ui', 'echarts', 'daterangepicker'], function (tb, jquery_ui, echarts) {
    return {
        init: function () {
            //构建echarts start
            var $this = this;
            var obj_range = $('#date_range');
            var obj_line = document.getElementById('chart_line')
            var obj_table = $('#table');
            var obj_count = $('#summary');
            var obj_compare = $('#compare_input');
            var temp_name = null;
            var temp_type = null;
            var temp_form_type = ['PV', 'UV'];
            var value = {
                start_date: $this.GetDateStr(-7),
                end_date: $this.GetDateStr(-1),
                action: $(':input[name=action]').val(),
                indicator: $(':input[name=indicator]').val(),
                source: -1
            };
            temp_name = 'PV量';
            $this.dateRange(obj_range, value, obj_count, obj_line, obj_table, obj_compare, $this);
            $this.make_count(obj_count, value);
            $this.make_chart_line(obj_line, value);
            $this.make_form(obj_table, value);
            //构建echarts end
            //事件 start
            //指标->下拉
            $('.flash-indicator-wrapper').on('click', function () {
                $('#flash-option-container').toggle();
                $('.flash-indicator-wrapper').find('.glyphicon').toggleClass("glyphicon-chevron-down")

            })
            //选择指标 ->勾选
            $('.shortcutsButton').on('click', function () {
                var _this = $(this)
                $.each($('.shortcutsButton'), function (i, item) {
                    if ($(item) != $(this)) {
                        $(item).removeClass('selected');

                    }
                })
                $(this).addClass('selected');
                if (_this.attr('name') == 'Default') {
                    $.each($(':input[name=form_type]'), function (i, item) {
                        if ($(item).val() == 'PV' || $(item).val() == 'UV') {
                            $(item).prop("checked", true);
                        } else {
                            $(item).prop("checked", false);
                        }
                    })
                } else if (_this.attr('name') == 'Reservation') {
                    $.each($(':input[name=form_type]'), function (i, item) {
                        if ($(item).val() == 'Reservation_Num' || $(item).val() == 'Inc_ReservationNum') {
                            $(item).prop("checked", true);
                        } else {
                            $(item).prop("checked", false);
                        }
                    })

                } else if (_this.attr('name') == 'Consulting') {
                    $.each($(':input[name=form_type]'), function (i, item) {
                        if ($(item).val() == 'Consulting_Num' || $(item).val() == 'Inc_Consulting_Num') {
                            $(item).prop("checked", true);
                        } else {
                            $(item).prop("checked", false);
                        }
                    })

                }
            })
            //确认指标
            $('#confirm').on('click', function () {
                $('.table-indicator').css('display', 'none')
                $this.make_form(obj_table, value);
            })
            //最近几天
            $('.near').on('click', function () {
                $.each($('.near'), function (i, item) {
                    if ($(item) != $(this)) {
                        $(item).removeClass('cur');

                    }
                })
                $(this).addClass('cur');
                if ($(this).attr('id') == 'near7') {
                    value.start_date = $this.GetDateStr(-7);
                    value.end_date = $this.GetDateStr(-1);
                } else if ($(this).attr('id') == 'near30') {
                    value.start_date = $this.GetDateStr(-30);
                    value.end_date = $this.GetDateStr(-1);
                } else if ($(this).attr('id') == 'near_half') {
                    value.start_date = $this.GetMonthStr(-6);
                    value.end_date = $this.GetDateStr(-1);
                }
                var between = new Date(value.end_date).getTime() / 1000 - new Date(value.start_date).getTime() / 1000;
                var endDate = obj_compare.attr('data-endDate');
                if (endDate) {
                    var startDate = parseFloat(new Date(endDate).getTime() / 1000) - between;
                    startDate = $this.formatDate(new Date(startDate * 1000));
                    value.start_date_compare = startDate;
                    value.end_date_compare = endDate;
                    obj_compare.val(startDate + ' - ' + endDate);
                }
                $this.make_count(obj_count, value);
                $this.make_chart_line(obj_line, value);
                $this.make_form(obj_table, value);
                $this.dateRange(obj_range, value, obj_count, obj_line, obj_table, obj_compare, $this);
            });
            //改变指标 ->默认两个
            $(':input[name=type]').on('change', function () {
                var _this = $(this);
                //多选
                if ($(':input[name=type]:checked').length > 2) {
                    $(':input[name=type]:checked').each(function (i, item) {
                        if (temp_type) {
                            if ($(item).val() != temp_type && $(item).val() != _this.val()) {
                                $(item).prop("checked", false);
                            }
                        } else {
                            $(item).prop("checked", false);
                            return false;
                        }
                    })
                }
                if (value.start_date_compare && value.end_date_compare) {
                    $("#flash-indicator-text").text($(this).data('name'));
                } else {
                    $("#flash-indicator-text").text(temp_name + '、' + $(this).data('name'));
                }
                temp_name = $(this).data('name');
                temp_type = $(this).val();
                $this.make_chart_line(obj_line, value);
                //$this.make_chart_pie(obj_pie, value);
            });
            //改变表单指标 -> 默认三个
            $(':input[name=form_type]').on('change', function () {
                if ($(this).is(':checked')) {
                    temp_form_type.push($(this).val());
                    if ($this.objectSize(temp_form_type) > 3) {
                        temp_form_type.shift();
                    }
                } else {
                    var del_pos = temp_form_type.indexOf($(this).val())
                    temp_form_type.splice(del_pos, 1);
                }
                if ($(':input[name=form_type]:checked').length > 3) {
                    $(':input[name=form_type]:checked').each(function (i, item) {
                            var pos = temp_form_type.indexOf($(item).val());
                            if (pos < 0) {
                                $(item).prop("checked", false);
                            }
                        }
                    )
                }
                //$this.make_chart_line(obj_line, value);
                //$this.make_chart_pie(obj_pie, value);
            });
            //改变来源
            $(':input[name=source]').on('change', function () {
                value.source = $(this).val();
                $this.make_count(obj_count, value);
                $this.make_chart_line(obj_line, value);
            })
            //自定义指标 ->下拉
            $('.change_table').on('click', function () {
                $(".table-indicator").toggle();
            })

            //与其他时间段对比 start
            $('#compare_check').on('change', function () {
                if (!$(this).is(':checked')) {
                    value.start_date_compare = null;
                    value.end_date_compare = null;
                    obj_compare.removeAttr('data-endDate')
                    $this.make_chart_line(obj_line, value);
                    //$this.make_chart_pie(obj_pie, value);
                    $this.make_form(obj_table, value);
                    $(':input[name=type]').attr('type', 'checkbox')
                    $("#max-flash-indicator-num").text(2);
                    $.each($('.compare-value'), function (i, item) {
                        $(item).text('');
                        $(item).css('display', 'none');
                    })
                } else {
                    $(this).prop('checked', false);
                    $('#compare_div').show();
                    obj_compare.click();
                }
            })
            $this.dateRange2(obj_compare, value);
            //确定对比时间
            obj_compare.on('apply.daterangepicker', function (ev, picker) {
                $('#compare_check').prop('checked', true);
                var startDate = picker.startDate.format('YYYY/MM/DD');
                var endDate = picker.endDate.format('YYYY/MM/DD');
                var between = new Date(value.end_date).getTime() / 1000 - new Date(value.start_date).getTime() / 1000;
                endDate = parseFloat(new Date(startDate).getTime() / 1000) + between;
                endDate = $this.formatDate(new Date(endDate * 1000));
                value.start_date_compare = startDate;
                value.end_date_compare = endDate;
                obj_compare.val(startDate + ' - ' + endDate);
                //obj_compare.attr('data-startDate', startDate);
                obj_compare.attr('data-endDate', endDate);
                $(':input[name=type]').attr('type', 'radio');
                $("#max-flash-indicator-num").text(1)
                $("#flash-indicator-text").text($(':input[name=type]:checked').data('name'));
                $this.make_count(obj_count, value);
                $this.make_chart_line(obj_line, value);
                $this.make_form(obj_table, value);
                //$this.make_chart_pie(obj_pie, value);
            });
            //取消对比时间
            obj_compare.on('cancel.daterangepicker', function (ev, picker) {
                $(this).val('与其他时间段对比');
                //$(this).removeAttr('data-startDate')
                $(this).removeAttr('data-endDate')
                $('#compare_div').hide();
                $('#compare_check').prop('checked', false);
                $(':input[name=type]').attr('type', 'checkbox')
                $("#max-flash-indicator-num").text(2)
                $.each($('.compare-value'), function (i, item) {
                    $(item).text('');
                    $(item).css('display', 'none');
                })
                if (value.start_date_compare && value.end_date) {
                    value.start_date_compare = null;
                    value.end_date_compare = null;
                    $this.make_chart_line(obj_line, value);
                    $this.make_form(obj_table, value);
                    //$this.make_chart_pie(obj_pie, value);
                }
            });
            //点击空白处
            $(document).on('click', 'body', function (e) {
                if (!$('#compare_check').is(':checked')) {
                    var $tar = $(e.target);
                    if (!$tar.parents().is('#compare_div') && !$tar.parents().is('.daterangepicker')) {
                        obj_compare.val('与其他时间段对比');
                        $('#compare_div').hide();
                        $('#compare_check').prop('checked', false);
                        obj_compare.removeAttr('data-endDate');
                        $(':input[name=type]').attr('type', 'checkbox')
                        $("#max-flash-indicator-num").text(2)
                        $.each($('.compare-value'), function (i, item) {
                            $(item).text('');
                            $(item).css('display', 'none');
                        })
                    }
                }
                if ($('#flash-option-container').css('display') != 'none') {
                    var $tar = $(e.target);
                    if (!$tar.parents().is('#flash-option-container') && !$tar.parents().is('.flash-indicator-wrapper') && !$tar.is('#flash-option-container') && !$tar.is('.flash-indicator-wrapper')) {
                        $('#flash-option-container').css('display', 'none');
                        $('.flash-indicator-wrapper').find('.glyphicon').addClass("glyphicon-chevron-down")
                    }
                }
                if ($(".table-indicator").css('display') != 'none') {
                    var $tar = $(e.target);
                    if (!$tar.parents().is('.table-indicator') && !$tar.parents().is('.change_table') && !$tar.is('.table-indicator') && !$tar.is('.change_table')) {
                        $('.table-indicator').css('display', 'none')
                    }
                }
            });
            //事件 end
        },
        /*
         ** 生成统计
         */
        //parseFloat(num_s).toLocaleString()
        make_count: function (obj, data) {
            $.get('count', data, function (json) {
                $.each(obj.find('.value'), function (i, item) {
                    var name = $(item).data('name');
                    var text1 = json['value'][name] ? json['value'][name] : 0;
                    text1 = parseFloat(text1).toLocaleString();
                    $(item).text(text1);
                })
                if (json['compare-value']) {
                    $.each(obj.find('.compare-value'), function (i, item) {
                        var name = $(item).data('name');
                        var text2 = json['compare-value'][name] ? json['compare-value'][name] : 0;
                        text2 = parseFloat(text2).toLocaleString();
                        $(item).text(text2);
                        $(item).css('display', 'block');
                    })
                }
            }, 'json')
        },
        /*
         ** 生成折线图
         */
        make_chart_line: function (obj, data) {
            var myChart = echarts.init(obj);
            myChart.showLoading({
                text: '数据正在加载...',
            });
            var type = new Array();
            var series = new Array();
            var name = new Array();
            $('input[name=type]').each(function (i, item) {
                if ($(item).is(':checked')) {
                    type.push($(item).val());
                }
            })
            data.type = type;
            //修改title
            var title = data.start_date_compare ? '(' + data.start_date + '～' + data.end_date + ' 与 ' + data.start_date_compare + '～' + data.end_date_compare + ')' : '(' + data.start_date + '～' + data.end_date + ')';
            $('#title').text(title);
            var lineColor = ['rgb(79,168,249)', 'rgb(110,199,30)'];
            var areaColor = ['rgb(229,242,254)', 'rgb(211,236,220)'];

            $.get('chart-line', data, function (json) {
                if (typeof(json.key) !== 'undefined') {
                    var num = 0;
                    $.each(json.value, function (i, item) {
                        name.push(i);
                        series.push({
                            name: i,
                            type: 'line',
                            smooth: true,
                            label: {normal: {show: false}},
                            itemStyle: {normal: {color: lineColor[num]}},
                            lineStyle: {normal: {color: lineColor[num]}},
                            areaStyle: {normal: {color: areaColor[num]}},
                            data: item
                        })
                        num++;
                    })
                    var key = json.key;
                    var option = {
                        tooltip: {
                            trigger: 'axis'
                        },
                        toolbox: {
                            show: true,
                            feature: {
                                magicType: {type: ['line', 'bar']},
                                restore: {},
                                saveAsImage: {}
                            }
                        },
                        legend: {
                            data: name,
                        },
                        grid: {
                            left: '3%',
                            right: '6%',
                            bottom: '3%',
                            containLabel: true
                        },
                        xAxis: [{
                            type: 'category',
                            boundaryGap: false,
                            data: key
                        }],
                        yAxis: {
                            type: 'value',
                        },
                        series: series
                    };
                    myChart.setOption(option);
                    window.addEventListener("resize", function () {
                        myChart.resize();
                    });
                } else {
                    $(obj).html('<p style="text-align: center;">暂无数据</p>');

                }
                myChart.hideLoading();
            }, 'json')
        },

        /*
         ** 生成饼图
         */
        make_chart_pie: function (obj, data) {
            var type = new Array();
            var $this = this;
            $('input[name=type]').each(function (i, item) {
                if ($(item).is(':checked')) {
                    type.push($(item).val());
                }
            })
            data.type = type;
            $.get('chart-pie', data, function (json) {
                $(obj).parent().find(".pie[data-id !=1]").remove();
                var num = 0;
                var length = $this.objectSize(json);
                if (length > 1) {
                    $(obj).parent().find(".pie[data-id=1]").css("width", "600px");
                    $(obj).parent().find(".pie[data-id=1]").css("float", "left");
                    var radius = "60%";
                } else {
                    $(obj).parent().find(".pie[data-id=1]").css("width", 'auto');
                    $(obj).parent().find(".pie[data-id=1]").css("float", "none");
                    var radius = '75%';
                }
                $.each(json, function (i, item) {
                    num++;
                    var series = new Array();
                    var key = item.key;
                    series.push({
                        name: '',
                        type: 'pie',
                        radius: radius,
                        center: ['50%', '60%'],
                        data: item.value,
                        itemStyle: {
                            emphasis: {
                                shadowBlur: 10,
                                shadowOffsetX: 0,
                                shadowColor: 'rgba(0, 0, 0, 0.5)'
                            }
                        }
                    })
                    var subtext = length > 1 && i.indexOf("至") > 0 ? i : data.start_date + ' 至 ' + data.end_date
                    var option = {
                        title: {
                            text: item.name,
                            subtext: subtext,
                            x: 'center'
                        },
                        tooltip: {
                            trigger: 'item',
                            formatter: "{a} <br/>{b} : {c} ({d}%)"
                        },
                        legend: {
                            orient: 'vertical',
                            left: 'left',
                            data: key
                        },
                        series: series
                    };
                    var obj_now = $(obj).parent().find(".pie[data-id=" + num + "]")[0];
                    if (obj_now === undefined) {
                        var html = "";
                        html += "<div data-id='" + num + "' class='pie' style='height: 600px;width: 600px;float: left'></div>"
                        $('#pie_father').append(html);
                        obj_now = $(obj).parent().find(".pie[data-id=" + num + "]")[0];
                    }
                    if (item.value === undefined || item.value.length == 0) {
                        $(obj_now).css("text-align", "center");
                        $(obj_now).css("height", "50px");
                        $(obj_now).text(item.name + "-暂无数据");
                    } else {
                        $(obj_now).css("height", "600px");
                        var myChart = echarts.init(obj_now);
                        myChart.setOption(option);
                        window.addEventListener("resize", function () {
                            myChart.resize();
                        });
                    }

                })

            }, 'json')
        },

        /*
         ** 获取表单
         */
        make_form: function (obj, data) {
            if (!obj.hasClass('table-height')) obj.addClass('table-height');
            obj.children().remove();
            var loading = '<div class="loading"></div>'
            obj.append(loading);
            var type = new Array();
            $('input[name=form_type]').each(function (i, item) {
                if ($(item).is(':checked')) {
                    type.push($(item).val());
                }
            })
            data.form_type = type;
            var $this = this;
            var tr = '';
            $.get('form', data, function (json) {
                var thead = '<thead>';
                thead += '<td class="number-col number" data="" id="" colspan="1" rowspan="2"><div class="td-content">&nbsp;</div></td><td class="table-index sortable desc number" data="simple_date_title" id="simple_date_title" colspan="1" rowspan="2"><div class="td-content">日期</div></td>';
                $.each(json.thead.action, function (i, item) {
                    thead += '<td class="group" data="2" id="2" colspan="6" rowspan=""><div class="td-content">' + item + '</div></td>'
                })
                thead += '</tr>'
                thead += '<tr class="group-item" id="">';
                $.each(json.thead.action, function (i, item) {
                    var len = $this.objectSize(json.thead.source);
                    $.each(json.thead.source, function (_i, _item) {
                        var source_class = _item.id == 1 ? 'group' : 'number';
                        thead += '<td class=' + source_class + ' data="pv_ratio" id="pv_ratio" colspan="" rowspan=""><div class="td-content">' + _item.name + '</div></td>'

                    })
                })
                thead += '</tr>';
                thead += '</thead>';
                var html = ''
                var length = $this.objectSize(json.data);
                html += '<table class="table table-striped table-bordered table-hover text-center">';
                html += thead;
                html += "<tbody>";
                //构建tbody
                var num = 0;
                if (json.compare) {
                    $.each(json['data'], function (i, item) {
                        num++;
                        html += '<tr class="line-first" id="">'
                        html += '<td class="number-col number" data="" id="" colspan=""><div class="td-content" title="1">' + num + '</div></td>'
                        html += '<td class="table-index simple_date_title number" data="" id="" colspan=""><div class="td-content" title="">' + i + '</div></td>';
                        $.each(json.thead.action, function (action_i, action_item) {
                            var a = 0;
                            $.each(json.thead.source, function (source_i, source_item) {
                                a++;
                                var thead_class = a == 1 ? 'group' : 'number';
                                html += '<td class=' + thead_class + ' data="" id="" colspan=""><div class="td-content" title="">&nbsp;</div></td>';
                            })
                        })
                        html += '</tr>';
                        $.each(item, function (_i, _item) {
                            html += '<tr class="" id="">'
                            html += '<td class="number-col number" data="" id="" colspan=""><div class="td-content" title="&nbsp;">&nbsp;</div></td>';
                            html += '<td class="table-index simple_date_title number" data="" id="" colspan=""><div class="td-content" title="">' + _i + '</div></td>';
                            $.each(json.thead.action, function (action_i, action_item) {
                                var len = $this.objectSize(json.thead.source);
                                $.each(json.thead.source, function (source_i, source_item) {
                                    $.each(_item, function (n, m) {
                                        if (m.Source_Id == source_item.id) {
                                            var td_class = m.Source_Id == 1 ? "group" : 'number';
                                            var res = m[action_i] ? m[action_i] : 0;
                                            html += '<td class=' + td_class + ' data="" id="" colspan=""><div class="td-content" title="">' + res + '</div></td>';
                                        }
                                    })
                                })
                            })

                            html += '</tr>';
                        })

                    })
                } else {
                    $.each(json.data, function (_i, _item) {
                        num++;
                        html += '<tr class="line" style="background-color: #FFFFFF;" id="table-tr_0">';
                        html += '<td class="number-col number" data="" id="" colspan=""><div class="td-content" title="1">' + num + '</div></td>';
                        html += '<td class="table-index simple_date_title number" data="" id="" colspan=""><div class="td-content" title="1">' + _i + '</div></td>';
                        $.each(json.thead.action, function (action_i, action_item) {
                            var len = $this.objectSize(json.thead.source);
                            $.each(json.thead.source, function (source_i, source_item) {
                                $.each(_item, function (n, m) {
                                    if (m.Source_Id == source_item.id) {
                                        var td_class = m.Source_Id == 1 ? "group" : 'number';
                                        var res = m[action_i] ? m[action_i] : 0;
                                        html += '<td class=' + td_class + '><div class="td-content" title="">' + res + '</div></td>';
                                    }
                                })
                            })
                        })
                        html += '</tr>';
                    })
                }

                html += '</tbody></table>';
                //默认每一页15数据
                //html += '<div id="paging">'
                //html += '<div class="paging clearfix"><div class="page-number" id="page-number">'
                //html += '<a href="javascript:void(0);" class="previous"> < </a>' // 上一页
                //html += '<a class="number selected" href="javascript:void(0);" data="1">1</a><a class="number" href="javascript:void(0);" data="2">2</a>'
                //html += '<a href="javascript:void(0);" class="next"> > </a>' //下一页
                //html += '</div></div></div>';
                obj.removeClass('table-height');
                obj.children().remove();
                obj.append(html);
            }, 'json')
        },

        /*
         ** 获取几天内日期
         * @param  AddDayCount 多少天内的日期
         */
        GetDateStr: function (AddDayCount) {
            var dd = new Date();
            dd.setDate(dd.getDate() + AddDayCount);
            var y = dd.getFullYear();
            var m = (dd.getMonth() + 1) < 10 ? "0" + (dd.getMonth() + 1) : (dd.getMonth() + 1);
            var d = dd.getDate() < 10 ? "0" + dd.getDate() : dd.getDate();
            return y + "/" + m + "/" + d;
        },

        /*
         ** 获取几天内日期
         * @param  AddDayCount 多少天内的日期
         */
        GetMonthStr: function (AddMonthCount) {
            var dd = new Date();
            dd.setMonth(dd.getMonth() + AddMonthCount);
            var y = dd.getFullYear();
            var m = (dd.getMonth() + 1) < 10 ? "0" + (dd.getMonth() + 1) : (dd.getMonth() + 1);
            var d = dd.getDate() < 10 ? "0" + dd.getDate() : dd.getDate();
            return y + "/" + m + "/" + d;
        },

        /*
         **时间戳转日期
         */
        formatDate: function (now) {
            var year = now.getFullYear();
            var month = (now.getMonth() + 1) < 10 ? '0' + (now.getMonth() + 1) : (now.getMonth() + 1);
            var date = (now.getDate()) < 10 ? '0' + (now.getDate()) : (now.getDate());
            return year + "/" + month + "/" + date;
        },

        /*
         ** 修改dateRange参数
         */
        dateRange: function (obj_range, value, obj_count, obj_line, obj_table, obj_compare, $this) {
            //选项改变start
            obj_range.daterangepicker({
                showDropdowns: true,
                "opens": "center",
                "startDate": value.start_date,
                "endDate": value.end_date,
                maxDate: value.end_date,
                minDate: "2016/03/29",
                locale: {
                    format: "YYYY/MM/DD",
                    applyLabel: '确定',
                    cancelLabel: '清除',
                    fromLabel: '起始时间',
                    toLabel: '结束时间',
                    customRangeLabel: '自定义',
                    daysOfWeek: ['日', '一', '二', '三', '四', '五', '六'],
                    monthNames: ['一月', '二月', '三月', '四月', '五月', '六月',
                        '七月', '八月', '九月', '十月', '十一月', '十二月'],
                    firstDay: 1
                }
            }, function (start, end) {
                value.start_date = start.format(('YYYY/MM/DD'))
                value.end_date = end.format(('YYYY/MM/DD'));
                var between = new Date(value.end_date).getTime() / 1000 - new Date(value.start_date).getTime() / 1000;
                //var startDate = obj_compare.attr('data-startDate');
                var endDate = obj_compare.attr('data-endDate');
                if (endDate) {
                    var startDate = parseFloat(new Date(endDate).getTime() / 1000) - between;
                    startDate = $this.formatDate(new Date(startDate * 1000));
                    value.start_date_compare = startDate;
                    value.end_date_compare = endDate;
                    obj_compare.val(startDate + ' - ' + endDate);
                }
                $('.near').removeClass('cur');
                $this.make_count(obj_count, value);
                $this.make_chart_line(obj_line, value);
                $this.make_form(obj_table, value);
            });
        },
        dateRange2: function (obj_range, value) {
            //选项改变start
            obj_range.daterangepicker({
                showDropdowns: true,
                "opens": "center",
                autoUpdateInput: false,
                maxDate: value.end_date,
                minDate: "2016/03/29",
                locale: {
                    format: "YYYY/MM/DD",
                    applyLabel: '确定',
                    cancelLabel: '清除',
                    fromLabel: '起始时间',
                    toLabel: '结束时间',
                    customRangeLabel: '自定义',
                    defaultDate: '',//默认日期
                    daysOfWeek: ['日', '一', '二', '三', '四', '五', '六'],
                    monthNames: ['一月', '二月', '三月', '四月', '五月', '六月',
                        '七月', '八月', '九月', '十月', '十一月', '十二月'],
                    firstDay: 1
                }
            }, function (start, end) {
            });
        },

        /*
         ** 计算对象长度
         */
        objectSize: function (obj) {
            var object_size = 0;
            for (var key in obj) {
                if (obj.hasOwnProperty(key)) {
                    object_size++;
                }
            }
            return object_size;
        }

    }
});
