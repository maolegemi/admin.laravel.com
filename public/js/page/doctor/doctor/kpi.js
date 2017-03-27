define(['echarts', 'datatables'], function(_echarts, datatables) {
    return {
        init: function() {
                var tb_id = 'daily';
                //tab菜单点击事件
                $("#doctor-kpi-nav li a").click(function() {
                    var href = $(this).attr('href');
                    tb_id = href.substring(1, href.length);
                    if (!kpiObj[tb_id + "Table"]) {
                        var method = tb_id + "Init";
                        kpiObj[method]();
                    }
                });
                //键盘确定事件
                $(document).keydown(function(e) {
                    if (e.keyCode == 13) {
                        kpiObj.search(tb_id);
                        return true;
                    }
                });
                //KPI操作对象
                kpiObj = {
                    dailyTable: '',
                    weeklyTable: '',
                    monthlyTable: '',
                    dailyData: '',
                    weeklyData: '',
                    monthlyData: '',
                    search: function(type) {
                        kpiObj[type + "Init"]();
                    },
                    reset: function(type) {
                        $("#" + type + "-form")[0].reset();
                        var shopObj = $('#shop-' + type);
                        shopObj.find('option.shop').show();
                    },
                    cityChange: function(obj, type) {
                        var city_no = $(obj).find('option:selected').val();
                        var shopObj = $('#shop-' + type);
                        $('#shop-' + type).val('');
                        if (city_no) {
                            shopObj.find('option.shop').hide();
                            shopObj.find('option[data="city_no_' + city_no + '"]').show();
                        } else {
                            shopObj.find('option.shop').show();
                        }
                    },
                    dailyInit: function() {
                        if (this.dailyTable) {
                            this.dailyTable.draw();
                            return true;
                        }
                        this.dailyTable = init_kpi_table('daily');
                    },
                    weeklyInit: function() {
                        if (this.weeklyTable) {
                            this.weeklyTable.draw();
                            return true;
                        }
                        this.weeklyTable = init_kpi_table('weekly');
                    },
                    monthlyInit: function() {
                        if (this.monthlyTable) {
                            this.monthlyTable.draw();
                            return true;
                        }
                        this.monthlyTable = init_kpi_table('monthly');
                    },
                    pointChange: function(type) {
                        ///////////////////////////////
                        ////////初始化折线图数据///////
                        ///////////////////////////////
                        var data = kpiObj[type + "Data"];
                        var lineObj = document.getElementById(type + 'LineBox');
                        var pointKey = $("#" + type + "Point").find("option:selected").val();
                        var pointValue = $("#" + type + "Point").find("option:selected").text();
                        var clean = [];
                        clean['xAxis'] = data['Insert_Date'];
                        clean['legend'] = [];
                        clean['legend'].push(pointValue);
                        clean['yAxis'] = [{
                            type: 'value',
                            axisLabel: {
                                formatter: '{value}'
                            }
                        }];
                        clean['series'] = [{
                            name: pointValue,
                            type: 'line',
                            data: data[pointKey]
                        }];
                        makeLineChart(lineObj, clean);
                    }
                };
                kpiObj.dailyInit();
            } //return init
    } //end return
    //初始化表格数据
    function init_kpi_table(type) {
        var table = '';
        table = $("#" + type + "Table").DataTable({
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
                    $.each($("#" + type + "-form").serializeArray(), function(k, v) {
                        d[v['name']] = v['value'];
                    });
                },
            },
            columns: [{
                "data": "Insert_Date",
                "sClass": "text-center",
                "orderable": false,
            }, {
                "data": "OutpatientNum",
                "sClass": "text-center",
                "orderable": false,
            }, {
                "data": "RegCharges",
                "sClass": "text-center",
                "orderable": true,
            }, {
                "data": "DrugCharges",
                "sClass": "text-center",
                "orderable": false,
            }, {
                "data": "AgreeRecipeCharges",
                "sClass": "text-center",
                "orderable": false,
            }, {
                "data": "ExamCharges",
                "sClass": "text-center",
                "orderable": false,
            }, {
                "data": "TreatCharges",
                "sClass": "text-center",
                "orderable": false,
            }, {
                "data": "GuixiCharges",
                "sClass": "text-center",
                "orderable": false,
            }],
            "fnDrawCallback": function(obj) {
                var data = obj.json.data;
                //初始化线性图数据
                kpiObj[type + "Data"] = [];
                $.each(data.reverse(), function(k, v) {
                    $.each(v, function(kk, vv) {
                        if (kpiObj[type + "Data"][kk] == undefined) {
                            kpiObj[type + "Data"][kk] = [];
                            kpiObj[type + "Data"][kk].push(vv);
                        } else {
                            kpiObj[type + "Data"][kk].push(vv);
                        }
                    });
                });
                //初始化总和数据
                var sum = {};
                $.each(data, function(k, v) {
                    $.each(v, function(kk, vv) {
                        if (kk != 'Insert_Date') {
                            var value = parseInt(vv);
                            if (sum[kk] == undefined) {
                                sum[kk] = [];
                                sum[kk] = value;
                            } else {
                                sum[kk] += value;
                            }
                        }
                    });
                });
                $.each(sum, function(k, v) {
                    $("#" + type + k).text(myFunction.format(v,3));
                });
                ////////////////////
                ////初始化饼状图////
                ////////////////////
                var point = [];
                $.each($('#dailyPoint').find('option'), function(k, v) {
                    var key = $(v).val();
                    var value = $(v).text();
                    point[key] = value;
                });
                var pieObj = document.getElementById(type + 'PieBox');
                var clean = [];
                clean['legend'] = [];
                var series = [];
                $.each(sum, function(k, v) {
                    clean['legend'].push(k); //渠道名称
                    series.push({ value: v, name: point[k] });
                });
                clean['series'] = [{
                    name: '医生业绩数据',
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
                    data: series
                }];
                makePieChart(pieObj, clean);
                ///////////////////////////
                /////////初始化线性图//////
                //////////////////////////
                kpiObj.pointChange(type);
            }
        });
        return table;
    }
    //构造饼状图
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
    //构造折线图
    function makeLineChart(obj, clean) {
        option = {
            // title: {
            //     text: '温度计式图表',
            //     x:'center'
            // },
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
                    //interval: 0,
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
    function setDateRange(obj) {
        obj.daterangepicker({
            opens: 'right',
            separator: " ~ ",
            format: "YYYY-MM-DD",
        }, function() {
            kpiObj.search();
        });
    }
});
