define(['echarts', 'datatables'], function(_echarts, datatables) {
    return {
        init: function() {
            //键盘确定事件
                $(document).keydown(function(e) {
                    if (e.keyCode == 13) {
                        sourceObj.search();
                        return true;
                    }
                });
                sourceObj = {
                    sourceTb: '',
                    sumData: {},
                    detailData: {},
                    pointKey: '',
                    pointName: '',
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
                    pointChange: function(obj) {
                        sourceObj.pointKey = $(obj).find('option:selected').val();
                        sourceObj.pointName = $(obj).find('option:selected').text();
                        //######总和#####//
                        $.each(this.sumData[sourceObj.pointKey], function(k, v) {
                            $("#" + k).text(myFunction.format(v,3));
                        });
                        //#######图表#######//
                        sourceObj.chartInit();
                    },
                    search: function() {
                        if (this.sourceTb) {
                            this.sourceTb.draw();
                        }
                    },
                    reset:function(){
                        $("#source-form")[0].reset();
                        this.quickTime("#source-form button[data='15']");
                    },
                    tableInit: function() {
                        this.sourceTb = $('#sourceTable').DataTable({
                            info: false,
                            responsive: true,
                            serverSide: true,
                            processing: false,
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
                                    $.each($("#source-form").serializeArray(), function(k, v) {
                                        d[v['name']] = v['value'];
                                    });
                                }
                            },
                            columns: [{
                                "data": "Insert_Date",
                                "sClass": "text-center"
                            }, {
                                "data": "Source_Id",
                                "sClass": "text-center"
                            }, {
                                "data": "Source_Name",
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
                                var data = obj.json.data;
                                var sum = {};
                                $.each(data, function(k, v) {
                                    var key = "Source_" + v['Source_Id'];
                                    $.each(v, function(kk, vv) {
                                        ////各指标的各渠道总和////
                                        if ((kk != "Source_Id") && (kk != "Source_Name") && (kk != "Insert_Date")) {
                                            var value = parseInt(vv);
                                            if (sum[kk] == undefined) {
                                                sum[kk] = {};
                                                sum[kk][key] = value;
                                                sum[kk]['Source_All'] = 0; //总和
                                            } else {
                                                if (sum[kk][key] == undefined) {
                                                    sum[kk][key] = value;
                                                } else {
                                                    sum[kk][key] += value;
                                                }
                                                sum[kk]['Source_All'] += value;
                                            }
                                        }
                                    });
                                });
                                //初始化对象数据+更新总和数据
                                sourceObj.sumData = sum;
                                sourceObj.detailData = data;
                                sourceObj.pointChange($('#Source_Id'));
                            },
                        });
                    },
                    chartInit: function() {
                        ////////////////////////////////
                        ////////初始化饼状图数据///////
                        ///////////////////////////////
                        var data = sourceObj.sumData;
                        var pieObj = document.getElementById('pieBox');
                        var source = { 0: 'PC', 1: '微信', 2: '安卓', 3: 'IOS', 4: 'H5', 5: '平安', 7: 'PC官网', 255: '其它' };
                        var pieData = [];
                        pieData['legend'] = [];
                        var series = [];
                        $.each(source, function(k, v) {
                            var key = "Source_" + k;
                            if (data[sourceObj['pointKey']][key] != undefined) {
                                pieData['legend'].push(v); //渠道名称
                                series.push({ value: data[sourceObj['pointKey']][key], name: v });
                            }
                        });
                        pieData['series'] = [{
                            name: sourceObj.pointName,
                            type: 'pie',
                            radius: ['50%', '70%'],
                            avoidLabelOverlap: false,
                            itemStyle: {
                                normal: {
                                    label: {
                                        show: true,
                                        formatter: "{b}:{d}%"
                                    },
                                    labelLine: {
                                        show: true
                                    }
                                }
                            },
                            data: series
                        }];
                        makePieChart(pieObj, pieData);
                        ////////////////////////////////
                        ////////初始化折线图数据///////
                        ///////////////////////////////
                        var clean = {};
                        $.each(sourceObj.detailData, function(k, v) {
                            var key = "Source_" + v['Source_Id'];
                            $.each(v, function(kk, vv) {
                                if (clean[kk] == undefined) {
                                    clean[kk] = {};
                                    clean[kk]['data'] = {};
                                    clean[kk]['data'][key] = {
                                        label: source[v['Source_Id']],
                                        data: [],
                                    };
                                    clean[kk]['data'][key]['data'].push(vv);
                                } else {
                                    if (clean[kk]['data'][key] == undefined) {
                                        clean[kk]['data'][key] = {
                                            label: source[v['Source_Id']],
                                            data: [],
                                        }
                                    }
                                    clean[kk]['data'][key]['data'].push(vv);
                                }
                            });
                        });
                        ///////////////////////////////
                        ////////初始化折线图数据///////
                        ///////////////////////////////
                        var lineObj = document.getElementById('lineBox');
                        var lineData = [];
                        lineData['xAxis'] = clean['Insert_Date']['data']['Source_1']['data'];
                        lineData['legend'] = [];
                        lineData['yAxis'] = [{
                            type: 'value',
                            axisLabel: {
                                formatter: '{value} 次'
                            }
                        }];
                        lineData['series'] = [];
                        $.each(clean[sourceObj['pointKey']], function(k, v) {
                            $.each(v, function(kk, vv) {
                                lineData['legend'].push(vv['label']); //渠道名称
                                var series = {
                                    name: vv['label'],
                                    type: 'line',
                                    data: vv['data']
                                };
                                lineData['series'].push(series);

                            });
                        });
                        makeLineChart(lineObj, lineData);
                    }
                };
                sourceObj.searchInit();
                sourceObj.tableInit();
            } //return init
    } //end return
    function makePieChart(obj, clean) {
        var option = {
            tooltip: {
                trigger: 'item',
                formatter: "{a} <br/>{b} : {c} ({d}%)"
            },
            legend: {
                show: false,
                orient: 'horizontal',
                x: 'center',
                data: clean['legend']
            },
            calculable: false,
            series: clean['series']
        };
        var myChart = echarts.init(obj);
        myChart.setOption(option);
    }
    //
    function makeLineChart(obj, clean) {
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
            sourceObj.search();
        });
    }
});
