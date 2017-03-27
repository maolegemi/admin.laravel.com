define(['echarts', 'datatables'], function(_echarts, datatables) {
    return {
        init: function() {
                //键盘确定事件
                $(document).keydown(function(e) {
                    if (e.keyCode == 13) {
                        trendObj.search();
                        return true;
                    }
                });
                trendObj = {
                    trendTb: '',
                    searchInit: function() {
                        setDateRange($("#Insert_Date"));
                    },
                    quickTime: function(obj) {
                        //去掉css//
                        $("button.date").removeClass('btn-primary');
                        $(obj).addClass('btn-primary');
                        var days = $(obj).attr('data');
                        var dayStr = GetDateStr(0 - days) + " ~ " + GetDateStr(0);
                        $("#Insert_Date").val(dayStr);
                        this.search();
                    },
                    search: function() {
                        if (this.trendTb) {
                            this.trendTb.draw();
                        }
                    },
                    reset:function(){
                        $("#trend-form")[0].reset();
                        this.quickTime("#trend-form button[data='15']");
                    },
                    tableInit: function() {
                        this.trendTb = $('#trendTable').DataTable({
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
                                    $.each($("#trend-form").serializeArray(), function(k, v) {
                                        d[v['name']] = v['value'];
                                    });
                                }
                            },
                            columns: [{
                                "data": "Insert_Date",
                                "sClass": "text-center"
                            }, {
                                "data": "PV_Sum",
                                "sClass": "text-center"
                            }, {
                                "data": "UV_Sum",
                                "sClass": "text-center"
                            }, {
                                "data": "Register_User_Sum",
                                "sClass": "text-center"
                            }, {
                                "data": "Reservation_Sum",
                                "sClass": "text-center"
                            }, {
                                "data": "Arrive_Sum",
                                "sClass": "text-center"
                            }, {
                                "data": "Inc_Reservation_Sum",
                                "sClass": "text-center"
                            }, {
                                "data": "Consulting_Sum",
                                "sClass": "text-center"
                            }, {
                                "data": "Inc_Consulting_Sum",
                                "sClass": "text-center"
                            }],
                            "fnDrawCallback": function(obj) {
                                data = obj.json.data;
                                if(data.length == 0){
                                    return true;
                                }
                                var sum = {};
                                $.each(data, function(k, v) {
                                    $.each(v, function(kk, vv) {
                                        if (kk != 'Insert_Date') {
                                            var value = parseInt(vv);
                                            if (sum[kk] == undefined) {
                                                sum[kk] = value;
                                            } else {
                                                sum[kk] += value;
                                            }
                                        }
                                    });
                                });
                                //
                                $.each(sum, function(k, v) {
                                    $("#" + k).text(myFunction.format(v,3));
                                });
                                trendObj.chartInit(data.reverse());
                            },
                        });
                    },
                    chartInit: function(data) {
                        //构造图表数据
                        var clean = {};
                        $.each(data, function(k, v) {
                            $.each(v, function(kk, vv) {
                                if (clean[kk] == undefined) {
                                    clean[kk] = {
                                        label: kk,
                                        data: [],
                                    };
                                    clean[kk].data.push(vv);
                                } else {
                                    clean[kk].data.push(vv);
                                }
                            });
                        });
                        /////////////////////////////
                        ////////初始化访问数据///////
                        ////////////////////////////
                        var objVisit = document.getElementById('lineBoxVisit');
                        var dataVisit = [];
                        dataVisit['legend'] = ['PV量', 'UV量', '注册用户数'];
                        dataVisit['xAxis'] = clean['Insert_Date']['data'];
                        dataVisit['yAxis'] = [{
                            type: 'value',
                            name: '访问量',
                            axisLabel: {
                                formatter: '{value} 次'
                            }
                        }, {
                            type: 'value',
                            name: '注册人数',
                            axisLabel: {
                                formatter: '{value} 人'
                            }
                        }];
                        dataVisit['series'] = [{
                            name: 'PV量',
                            type: 'bar',
                            data: clean['PV_Sum']['data'],
                            itemStyle: {
                                normal: {
                                    color: '#27727B'
                                }
                            }
                        }, {
                            name: 'UV量',
                            type: 'bar',
                            data: clean['UV_Sum']['data']
                        }, {
                            name: '注册用户数',
                            type: 'line',
                            yAxisIndex: 1,
                            data: clean['Register_User_Sum']['data'],
                            itemStyle: {
                                normal: {
                                    color: '#26C0C0'
                                }
                            }
                        }];
                        makeBarChart(objVisit, dataVisit);
                        /////////////////////////////
                        ////////初始化用户数据///////
                        ////////////////////////////
                        var objUser = document.getElementById('lineBoxUser');
                        var dataUser = [];
                        dataUser['legend'] = ['预约数', '新用户预约', '到店人数'];
                        dataUser['xAxis'] = clean['Insert_Date']['data'];
                        dataUser['yAxis'] = [{
                            type: 'value',
                            name: '预约数',
                            axisLabel: {
                                formatter: '{value} 人次'
                            }
                        }, {
                            type: 'value',
                            name: '到店数',
                            axisLabel: {
                                formatter: '{value} 人'
                            }
                        }];
                        dataUser['series'] = [{
                            name: '预约数',
                            type: 'line',
                            data: clean['Reservation_Sum']['data']
                        }, {
                            name: '新用户预约',
                            type: 'line',
                            //yAxisIndex: 1,
                            data: clean['Inc_Reservation_Sum']['data']
                        }, {
                            name: '到店人数',
                            type: 'line',
                            data: clean['Arrive_Sum']['data']
                        }];
                        makeBarChart(objUser, dataUser);
                        /////////////////////////////
                        ////////初始化咨询数据///////
                        ////////////////////////////
                        var objAsk = document.getElementById('lineBoxAsk');
                        var dataAsk = [];
                        dataAsk['legend'] = ['咨询数', '新增用户咨询数'];
                        dataAsk['xAxis'] = clean['Insert_Date']['data'];
                        dataAsk['yAxis'] = [{
                            type: 'value',
                            name: '人数',
                            axisLabel: {
                                formatter: '{value} 人数'
                            }
                        }, {
                            type: 'value',
                            name: '人数',
                            axisLabel: {
                                formatter: '{value} 人'
                            }
                        }];
                        dataAsk['series'] = [{
                            name: '咨询数',
                            type: 'line',
                            data: clean['Consulting_Sum']['data']
                        }, {
                            name: '新增用户咨询数',
                            type: 'line',
                            data: clean['Inc_Consulting_Sum']['data']
                        }];
                        makeBarChart(objAsk, dataAsk);
                    }
                };
                trendObj.searchInit();
                trendObj.tableInit();
            } //return init
    } //end return
    //
    function makeBarChart(obj, clean) {
        option = {
            tooltip: {
                trigger: 'axis'
            },
            legend: {
                selectedMode: false,
                data: clean.legend,
                x: 'center'
            },
            xAxis: [{
                type: 'category',
                data: clean.xAxis,
                axisLabel: {
                    // interval: 0,
                    // rotate: 15, //倾斜度 -90 至 90 默认为0  
                    // margin: 10,
                },
            }],
            yAxis: clean.yAxis,
            series: clean.series
        };
        ////////
        var myChart = echarts.init(obj);
        myChart.setOption(option);
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
    function setDateRange(obj) {
        obj.daterangepicker({
            opens: 'right',
            separator: " ~ ",
            format: "YYYY-MM-DD",
        }, function() {
            trendObj.search();
        });
    }
});
