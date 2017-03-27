define(['echarts', 'datatables'], function(_echarts, datatables) {
    return {
        init: function() {
                //KPI操作对象
                patientObj = {
                    patientTable: '',
                    lineData: '',
                    pieData: '',
                    serachInit: function() {
                        setDateRange($("#ResDate"));
                    },
                    search: function() {
                        patientObj['patientTable'].draw();
                    },
                    pieInit: function() {
                        ////////////////////////
                        ////初始化预约/首诊饼状图////
                        ///////////////////////
                        var resPieObj = document.getElementById('resPieBox');
                        var firstPieObj = document.getElementById('firstPieBox');
                        var pieData = patientObj['pieData'];
                        var cleanRes = [];
                        var cleanFirst = [];
                        cleanRes['legend'] = [];
                        cleanFirst['legend'] = [];
                        var seriesRes = [];
                        var seriesFirst = [];
                        $.each(pieData, function(k, v) {
                            //预约
                            cleanRes['legend'].push(v['Name']); //渠道名称
                            seriesRes.push({ value: v['ResSum'], name: v['Name'] });
                            //首诊
                            cleanRes['legend'].push(v['Name']); //渠道名称
                            seriesFirst.push({ value: v['FirstVisitSum'], name: v['Name'] });
                        });
                        cleanRes['series'] = [{
                            name: '渠道预约占比',
                            type: 'pie',
                            radius: ['0%', '70%'],
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
                            data: seriesRes
                        }];
                        cleanFirst['series'] = [{
                            name: '渠道首诊占比',
                            type: 'pie',
                            radius: ['0%', '70%'],
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
                            data: seriesFirst
                        }];
                        cleanRes['title'] = '渠道预约占比';
                        cleanFirst['title'] = '渠道首诊占比';
                        makePieChart(resPieObj, cleanRes);
                        makePieChart(firstPieObj, cleanFirst);
                    },
                    cityChange: function(obj) {
                        var city_no = $(obj).find('option:selected').val();
                        var shopObj = $('#shop');
                        $('#shop').val('');
                        if (city_no) {
                            shopObj.find('option.shop').hide();
                            shopObj.find('option[data="city_no_' + city_no + '"]').show();
                            //初始化
                        } else {
                            shopObj.find('option.shop').show();
                        }
                        this.search();
                    },
                    sourceChange: function(obj) {
                        //初始化线性数据
                        var source = $("#source").find("option:selected");
                        var lineData = patientObj['lineData'];
                        var source_id = source.val();
                        var source_name = source.text();
                        var data = lineData[source_id];
                        if (data == undefined) {
                            return false;
                        }
                        //初始化线性图形
                        var lineObj = document.getElementById('lineBox');
                        var clean = [];
                        clean['legend'] = [source_name + '预约', source_name + '首诊'];
                        clean['xAxis'] = data['ResDate']['data'];
                        clean['yAxis'] = [{
                            type: 'value',
                            name: '预约',
                            axisLabel: {
                                formatter: '{value} 人次'
                            }
                        }, {
                            type: 'value',
                            name: '首诊',
                            axisLabel: {
                                formatter: '{value} 人'
                            }
                        }];
                        clean['series'] = [{
                            name: source_name + '预约',
                            type: 'bar',
                            data: data['Res_Sum']['data'],
                            itemStyle: {
                                normal: {
                                    color: '#cd5c5c'
                                }
                            }
                        }, {
                            name: source_name + '首诊',
                            type: 'line',
                            data: data['FirstVisit_Sum']['data'],
                            itemStyle: {
                                normal: {
                                    color: '#26C0C0'
                                }
                            }
                        }];
                        makeBarChart(lineObj, clean);
                    },
                    tableInit: function() {
                        this.patientTable = $("#patientTable").DataTable({
                            info: false,
                            responsive: true,
                            serverSide: true,
                            processing: false,
                            bSort: true,
                            searchable: false,
                            searching: false,
                            ordering: false,
                            paging: false,
                            pageLength: 30,
                            bLengthChange: false,
                            ajax: {
                                url: "",
                                data: function(d) {
                                    d.ResDate = $("#ResDate").val();
                                    d.CityId = $("#city").val();
                                    d.ShopId = $("#shop").val();
                                },
                            },
                            columns: [{
                                "data": "ResDate",
                                "sClass": "text-center",
                                "orderable": false,
                            }, {
                                "data": "SourceId",
                                "sClass": "text-center",
                                "orderable": false,
                            }, {
                                "data": "SourceName",
                                "sClass": "text-center",
                                "orderable": true,
                            }, {
                                "data": "CityId",
                                "sClass": "text-center",
                                "orderable": false,
                            }, {
                                "data": "CityName",
                                "sClass": "text-center",
                                "orderable": false,
                            }, {
                                "data": "ShopId",
                                "sClass": "text-center",
                                "orderable": false,
                            }, {
                                "data": "ShopName",
                                "sClass": "text-center",
                                "orderable": false,
                            }, {
                                "data": "Res_Sum",
                                "sClass": "text-center",
                                "orderable": false,
                            }, {
                                "data": "FirstVisit_Sum",
                                "sClass": "text-center",
                                "orderable": false,
                            }],
                            "fnDrawCallback": function(obj) {
                                var data = obj.json.data;
                                //构造线性图数据//
                                var lineData = {};
                                $.each(data.reverse(), function(k, v) {
                                    if (lineData[v['SourceId']] == undefined) {
                                        lineData[v['SourceId']] = [];
                                    }
                                    $.each(v, function(kk, vv) {
                                        if (lineData[v['SourceId']][kk] == undefined) {
                                            lineData[v['SourceId']][kk] = {
                                                'label': kk,
                                                'data': []
                                            };
                                            lineData[v['SourceId']][kk]['data'].push(vv);
                                        } else {
                                            lineData[v['SourceId']][kk]['data'].push(vv);
                                        }
                                    });
                                });
                                patientObj['lineData'] = lineData;
                                patientObj.sourceChange("#source");
                                //构造饼状图数据//
                                var where = {
                                    type: 'pie',
                                    ResDate: $("#ResDate").val(),
                                    CityId: $("#city").val(),
                                    ShopId: $("#shop").val()
                                };
                                var retData = toGetData('', where);
                                var data = retData['data'];
                                var keys = ['Res_Sum', 'FirstVisit_Sum'];
                                var pieData = {};
                                $.each(data, function(k, v) {
                                    var Res_Sum = parseInt(v['Res_Sum']);
                                    var FirstVisit_Sum = parseInt(v['FirstVisit_Sum']);
                                    if (pieData[v['SourceId']] == undefined) {
                                        //初始化渠道数据//
                                        pieData[v['SourceId']] = [];
                                        pieData[v['SourceId']]['Id'] = v['SourceId'];
                                        pieData[v['SourceId']]['Name'] = v['SourceName'];
                                        pieData[v['SourceId']]['ResSum'] = Res_Sum;
                                        pieData[v['SourceId']]['FirstVisitSum'] = FirstVisit_Sum;
                                    } else {
                                        //计算渠道总和//
                                        pieData[v['SourceId']]['ResSum'] += Res_Sum;
                                        pieData[v['SourceId']]['FirstVisitSum'] += FirstVisit_Sum;
                                    }
                                });
                                //清除多余数据
                                patientObj['pieData'] = {};
                                $.each(pieData, function(k, v) {
                                    if (v != undefined) {
                                        patientObj['pieData'][k] = v;
                                    }
                                });
                                patientObj.pieInit();
                            }
                        });
                    }
                };
                patientObj.serachInit();
                patientObj.tableInit();
            } //return init
    } //end return
    //构造饼状图
    function makePieChart(obj, clean) {
        var option = {
            title: {
                text: clean.title,
                x: 'center',
                y: 'bottom'
            },
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
        window.addEventListener("resize", function() {
            myChart.resize();
        });
    }
    //构造折线图
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
        myChart.showLoading({
            text: '数据正在加载...',
        });
        myChart.setOption(option);
        window.addEventListener("resize", function() {
            myChart.resize();
        });
        myChart.hideLoading();
    }
    //通过ajax方法获取数据方法
    function toGetData(url, data) {
        var dataArr = [];
        var htmlobj = $.ajax({
            url: url,
            async: false,
            method: 'get',
            data: data,
            'dataType': 'json'
        });
        var jsonObj = htmlobj.responseText;
        var dataArr = $.parseJSON(jsonObj);
        return dataArr;
    }
    //
    function setDateRange(obj) {
        obj.daterangepicker({
            opens: 'right',
            separator: " ~ ",
            format: "YYYY-MM-DD",
        }, function() {
            patientObj.search();
        });
    }
});
