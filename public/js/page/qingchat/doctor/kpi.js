define(['echarts', 'datatables'], function(_echarts, datatables) {
    return {
        init: function() {
                kpiObj = {
                    table: '',
                    quickSelect:function(obj){
                      var value = $(obj).val();
                        var timeRang = '';
                        if (value == 'week') {
                            timeRang = GetDateStr(-7) + " ~ " + GetDateStr(0);
                            $('#qingchat-doctor-kpi-form input[name="Stat_Time"]').val(timeRang);
                        }
                        if (value == 'month') {
                            timeRang = GetMonthStr(-1) + " ~ " + GetMonthStr(0);
                            $('#qingchat-doctor-kpi-form input[name="Stat_Time"]').val(timeRang);
                        }
                        if (value == 'halfYear') {
                            timeRang = GetMonthStr(-6) + " ~ " + GetMonthStr(0);
                            $('#qingchat-doctor-kpi-form input[name="Stat_Time"]').val(timeRang);
                        }
                        if (this.table) {
                            this.table.draw();
                        }
                    },
                    searchInit: function() {
                        setDateRange($("input[name='Stat_Time']"));
                    },
                    search: function() {
                        if (this.table) {
                            this.table.draw();
                        }
                    },
                    tableInit: function() {
                        {
                            this.table = $('#qingchat-doctor-kpi-table').DataTable({
                                info: false,
                                responsive: true,
                                serverSide: true,
                                processing: true,
                                bSort: true,
                                searchable: false,
                                searching: false,
                                ordering: false,
                                order: [],
                                paging: false,
                                pageLength: 20,
                                bLengthChange: false,
                                ajax: {
                                    url: "",
                                    data: function(d) {
                                        d.Stat_Time = $('#qingchat-doctor-kpi-form input[name="Stat_Time"]').val();
                                    }
                                },
                                columns: [{
                                    "data": "Stat_Time",
                                    "sClass": "text-center"
                                }, {
                                    "data": "Doctor_Num",
                                    "sClass": "text-center"
                                }, {
                                    "data": "LeiJi_NewDoctorNum",
                                    "sClass": "text-center"
                                }, {
                                    "data": "LeiJi_DoctorNum",
                                    "sClass": "text-center"
                                }, {
                                    "data": "Online_ChatNum",
                                    "sClass": "text-center"
                                }, {
                                    "data": "LeiJi_ChatNum",
                                    "sClass": "text-center"
                                }, {
                                    "data": "Online_AnswerNum",
                                    "sClass": "text-center"
                                }, {
                                    "data": "TowHourAnswerNum",
                                    "sClass": "text-center"
                                }, {
                                    "data": "First_AnswerDoctorNum",
                                    "sClass": "text-center"
                                }, {
                                    "data": "TwoWeek_AnswerDoctorNum",
                                    "sClass": "text-center"
                                }, {
                                    "data": "ChangeToFans_Num",
                                    "sClass": "text-center"
                                }, {
                                    "data": "ChatToApp_Num",
                                    "sClass": "text-center"
                                }, {
                                    "data": "LeiJi_AppNum",
                                    "sClass": "text-center"
                                }, {
                                    "data": "LeiJi_ToFansNum",
                                    "sClass": "text-center"
                                }],
                                "fnDrawCallback": function(obj) {
                                    //kpiObj.data = obj.json.data;
                                    data = obj.json.data;
                                    toMakeSummerData(data);
                                    //指标变换
                                    pointSelect($("div.pointBox"), data.reverse());
                                },
                            });
                        } //
                    }
                }; //end kpiObj
                kpiObj.searchInit();
                kpiObj.tableInit();
            } //end init
    } //end return
    //
    function setDateRange(obj) {
        obj.daterangepicker({
            opens: 'right',
            separator: " ~ ",
            format: "YYYY-MM-DD",
        },function(){
            kpiObj.search();
        });
    }
    //
    function pointSelect(obj, data) {
        //console.log(data);
        var btn = $(obj).find('button');
        var box = btn.parent().find('div.contentBox');
        var input = box.find('input[type="checkbox"]');
        var state = false;
        btn.unbind('click');
        btn.click(function(event) {
            var _box = $(this).parent().find('div.contentBox');
            var status = _box.css('display');
            if (status == 'block') {
                state = state == false ? false : true;
                _box.hide();
            } else {
                state = state == true ? true : false;
                _box.show();
            }
        });
        //btn鼠标事件
        btn.hover(function() {
            state = true;
        }, function() {
            state = false;
        });
        //box鼠标事件
        box.hover(function() {
            state = true;
        }, function() {
            state = false;
        });
        //鼠标事件
        $(document).bind("click", function() {
            if (state == false) {
                box.hide();
            }
        });
        //构造折线图数据
        var _obj = document.getElementById('lineBox');
        var clean = [];
        clean['Stat_Time'] = { data: [] };
        //初始化数据
        $.each(input, function(k, v) {
            var key = $(v).val();
            var label = $(v).parent().parent().parent().find('label').text();
            clean[key] = {
                label: label,
                data: [],
            };
        });
        $.each(data, function(k, v) {
            $.each(v, function(kk, vv) {
                clean[kk].data.push(vv);
            });
        });
        //默认显示数据,初始化数据
        var _data = [];
        _data['xAxis'] = clean['Stat_Time'].data;
        _data['legend'] = [];
        _data['series'] = [];
        $.each(input, function(k, v) {
            if ($(v).is(':checked')) {
                var key = $(v).val();
                var label = $(v).parent().parent().parent().find('label').text();
                _data['legend'].push(label);
                var series = {
                    key: key,
                    name: label,
                    type: 'line',
                    data: clean[key].data,
                };
                _data['series'].push(series);
            }
        });
        toMakeLine(_obj, _data);
        //选中事件
        input.on('ifChecked', function(event) {
            //判断选中项数是否大于2
            var length = _data['legend'].length;
            if (length > 1) {
                _data['legend'].pop();
                var last = _data['series'].pop();
                $('input[value="' + last.key + '"]').iCheck('uncheck');
            }
            var key = $(this).val();
            var label = $(this).parent().parent().parent().find('label').text();
            _data['legend'].push(label);
            var series = {
                key: key,
                name: label,
                type: 'line',
                data: clean[key].data,
            };
            _data['series'].push(series);
            toMakeLine(_obj, _data);

        });
        //撤销选中事件
        input.on('ifUnchecked', function(event) {
            var key = $(this).val();
            var label = $(this).parent().parent().parent().find('label').text();
            //
            $.each(_data['legend'], function(k, v) {
                if (v == label) {
                    _data['legend'].splice(k, 1);
                }
            });
            //
            $.each(_data['series'], function(k, v) {
                if (v != undefined && v.name == label) {
                    _data['series'].splice(k, 1);
                }
            });
            toMakeLine(_obj, _data);
        });
    }
    //构造折线图表方法
    function toMakeLine(obj, data) {
        var myChart = echarts.init(obj);
        myChart.showLoading({
            text: '数据正在加载...',
        });
        var option = {
            legend: {
                show: true,
                data: data['legend'],
                selectedMode: false,
            },
            tooltip: {
                trigger: 'axis'
            },
            toolbox: {
                show: false,
                feature: {
                    magicType: { type: ['line', 'bar'] },
                    restore: {},
                    saveAsImage: {}
                }
            },
            xAxis: [{
                type: 'category',
                boundaryGap: false,
                data: data['xAxis'],
                // axisLabel: {
                //     interval: 0,
                //     rotate: 45, //倾斜度 -90 至 90 默认为0  
                //     margin: 10,
                // },
            }],
            yAxis: [{
                type: 'value'
            }],
            series: data['series']
        };
        myChart.setOption(option);
        window.addEventListener("resize", function() {
            myChart.resize();
        });
        myChart.hideLoading();
    }
    //
    //构造累计总量数据图表
    function toMakeSummerData(data) {
        var keyArr = [
            { 'id': 'Doctor_Num', 'total': 0, 'name': '当日问诊医生量(总)' },
            { 'id': 'LeiJi_NewDoctorNum', 'total': 0, 'name': '当日新增问诊医生量(总)' },
            { 'id': 'Online_ChatNum', 'total': 0, 'name': '当日总问诊量(总)' },
            { 'id': 'Online_AnswerNum', 'total': 0, 'name': '24H回复咨询量(总)' },
            { 'id': 'TowHourAnswerNum', 'total': 0, 'name': '2小时回复咨询量(总)' },
            { 'id': 'First_AnswerDoctorNum', 'total': 0, 'name': '首次回复医生量(总)' },
            { 'id': 'TwoWeek_AnswerDoctorNum', 'total': 0, 'name': '两周内有回复医生量(总)' },
            { 'id': 'ChangeToFans_Num', 'total': 0, 'name': '当日挂号粉丝转换量(总)' },
            { 'id': 'ChatToApp_Num', 'total': 0, 'name': '当日问诊预约转化量(总)' },
        ];

        var html = '';
        $.each(keyArr, function(k, v) {
            $.each(data, function(key, value) {
                v['total'] += value[v['id']];
            });
            html += "<td><p>&nbsp;</p><p>" + v['name'] + "</p><p>" + v['total'] + "</p></td>";
        });
        $("#summaryBox table tbody").html(html);
    }
    //
    function GetDateStr(day) {
        var dd = new Date();
        dd.setDate(dd.getDate() + day);
        var y = dd.getFullYear();
        var m = (dd.getMonth() + 1) < 10 ? "0" + (dd.getMonth() + 1) : (dd.getMonth() + 1);
        var d = dd.getDate() < 10 ? "0" + dd.getDate() : dd.getDate();
        return y + "-" + m + "-" + d;
    }
    //
    function GetMonthStr(month) {
        var dd = new Date();
        dd.setMonth(dd.getMonth() + month);
        var y = dd.getFullYear();
        var m = (dd.getMonth() + 1) < 10 ? "0" + (dd.getMonth() + 1) : (dd.getMonth() + 1);
        var d = dd.getDate() < 10 ? "0" + dd.getDate() : dd.getDate();
        return y + "-" + m + "-" + d;
    }
});
