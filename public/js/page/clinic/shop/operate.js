define(['echarts', 'datatables'], function(_echarts, datatables) {
    return {
        init: function() {
                //KPI操作对象
                operateObj = {
                    operateTable: '',
                    city_no: '',
                    shop_no: '',
                    pointKey: '',
                    pointValue: '',
                    lineData: '',
                    cityPieData: '',
                    shopPieData: '',
                    searchInit: function() {
                        setDateRange($('#RegDate'));
                        //初始化表格+线性图数据
                        this.tableInit();
                        //初始化饼状图数据
                        this.pieDataInit();
                    },
                    search: function() {
                        this.operateTable.draw();
                    },
                    pointInit: function() {
                        this.date    = $("#RegDate").val();
                        this.city_no = $("#city").find('option:selected').val();
                        this.shop_no = $("#shop").find('option:selected').val();
                        this.pointKey = $("#point").find("option:selected").val();
                        this.pointValue = $("#point").find("option:selected").text();
                    },
                    pointChange: function() {
                        //改变变量
                        this.pointInit();
                        ///初始化折线图数据//
                        this.lineInit();
                        //初始化区域饼状图//
                        this.cityPieInit();
                        //初始化门店饼状图//
                        this.shopPieInit();
                    },
                    cityChange: function(obj) {
                        this.city_no = $(obj).find('option:selected').val();
                        var shopObj = $('#shop');
                        $('#shop').val('');
                        if (this.city_no) {
                            shopObj.find('option.shop').hide();
                            shopObj.find('option[data="city_no_' + this.city_no + '"]').show();

                        } else {
                            shopObj.find('option.shop').show();
                        }
                        //刷新门店饼状图
                        this.shopPieInit();
                        //刷新折线图//
                        this.search();
                    },
                    shopChange: function() {
                        //刷新//
                        this.search();
                    },
                    lineInit: function() {
                        //初始化变量
                        this.pointInit();
                        var lineData = operateObj["lineData"];
                        var lineObj = document.getElementById('lineBox');
                        var clean = [];
                        clean['xAxis'] = lineData['RegDate'];
                        clean['legend'] = [];
                        clean['legend'].push(this.pointValue);
                        clean['yAxis'] = [{
                            type: 'value',
                            axisLabel: {
                                formatter: '{value}'
                            }
                        }];
                        clean['series'] = [{
                            name: this.pointValue,
                            type: 'line',
                            data: lineData[this.pointKey]
                        }];
                        makeLineChart(lineObj, clean);
                    },
                    cityPieInit: function() {
                        this.pointInit();
                        var cityPieObj = document.getElementById('cityPieBox');
                        var citySum = operateObj['cityPieData'][this.pointKey];
                        var clean = [];
                        clean['legend'] = [];
                        var series = [];
                        $.each(citySum, function(k, v) {
                            if (v != undefined) {
                                clean['legend'].push(v['CityName']); //城市名称
                                series.push({ value: v['CityData'], name: v['CityName'] });
                            }
                        });
                        clean['series'] = [{
                            name: '区域-' + this.pointValue,
                            type: 'pie',
                            radius: ['0%', '70%'],
                            avoidLabelOverlap: false,
                            itemStyle: {
                                normal: {
                                    label: {
                                        show: true,
                                        formatter: "{b}:({d}%)"
                                    },
                                    labelLine: {
                                        show: true
                                    }
                                }
                            },
                            data: series
                        }];
                        clean['title'] = '区域-' + this.pointValue;
                        makePieChart(cityPieObj, clean);
                    },
                    shopPieInit: function() {
                        this.pointInit();
                        var shopPieObj = document.getElementById('shopPieBox');
                        var shopSum = [];
                        if (this.city_no) {
                            if (operateObj['cityPieData'][this.pointKey][this.city_no] == undefined) {
                                return false;
                            }
                            shopSum = operateObj['cityPieData'][this.pointKey][this.city_no]['ShopData'];
                        } else {
                            shopSum = operateObj['shopPieData'][this.pointKey];
                        }
                        var clean = [];
                        clean['legend'] = [];
                        var series = [];
                        $.each(shopSum, function(k, v) {
                            if (v != undefined) {
                                clean['legend'].push(v['ShopName']); //门店名称
                                series.push({ value: v['ShopData'], name: v['ShopName'] });
                            }
                        });
                        clean['series'] = [{
                            name: '门店-' + this.pointValue,
                            type: 'pie',
                            radius: ['0%', '70%'],
                            avoidLabelOverlap: false,
                            itemStyle: {
                                normal: {
                                    label: {
                                        show: true,
                                        formatter: "{b}:({d}%)"
                                    },
                                    labelLine: {
                                        show: true
                                    }
                                }
                            },
                            data: series
                        }];
                        clean['title'] = '门店-' + this.pointValue;
                        makePieChart(shopPieObj, clean);
                    },
                    pieDataInit: function() {
                        //构造饼状图数据//
                        var RegDate = $("#RegDate").val();
                        var where = { type: 'pie',RegDate:RegDate};
                        var retData = toGetData('', where);
                        var pieData = retData.data;
                        operateObj['cityPieData'] = {};
                        operateObj['shopPieData'] = {};
                        keys = ['RegDate', 'CityId', 'CityName', 'ShopId', 'ShopName'];
                        $.each(pieData, function(k, v) {
                            $.each(v, function(kk, vv) {
                                if ($.inArray(kk, keys) == -1) {
                                    var _vv = parseFloat(vv);
                                    if (operateObj['cityPieData'][kk] == undefined) {
                                        //区域数据
                                        operateObj["cityPieData"][kk] = [];
                                        operateObj["cityPieData"][kk][v['CityId']] = [];
                                        operateObj["cityPieData"][kk][v['CityId']]['CityId'] = v['CityId'];
                                        operateObj["cityPieData"][kk][v['CityId']]['CityName'] = v['CityName'];
                                        operateObj["cityPieData"][kk][v['CityId']]['CityData'] = _vv;
                                        //区域门店数据
                                        operateObj["cityPieData"][kk][v['CityId']]['ShopData'] = [];
                                        operateObj["cityPieData"][kk][v['CityId']]['ShopData'][v['ShopId']] = [];
                                        operateObj["cityPieData"][kk][v['CityId']]['ShopData'][v['ShopId']]['ShopId'] = v['ShopId'];
                                        operateObj["cityPieData"][kk][v['CityId']]['ShopData'][v['ShopId']]['ShopName'] = v['ShopName'];
                                        operateObj["cityPieData"][kk][v['CityId']]['ShopData'][v['ShopId']]['ShopData'] = _vv;
                                        //门店总和数据//
                                        operateObj["shopPieData"][kk] = [];
                                        operateObj["shopPieData"][kk][v['ShopId']] = [];
                                        operateObj["shopPieData"][kk][v['ShopId']]['ShopId'] = v['ShopId'];
                                        operateObj["shopPieData"][kk][v['ShopId']]['ShopName'] = v['ShopName'];
                                        operateObj["shopPieData"][kk][v['ShopId']]['ShopData'] = _vv;


                                    } else {
                                        //区域数据
                                        if (operateObj["cityPieData"][kk][v['CityId']] == undefined) {
                                            operateObj["cityPieData"][kk][v['CityId']] = [];
                                            operateObj["cityPieData"][kk][v['CityId']]['CityId'] = v['CityId'];
                                            operateObj["cityPieData"][kk][v['CityId']]['CityName'] = v['CityName'];
                                            operateObj["cityPieData"][kk][v['CityId']]['CityData'] = _vv;
                                            //区域门店数据//
                                            operateObj["cityPieData"][kk][v['CityId']]['ShopData'] = [];
                                            operateObj["cityPieData"][kk][v['CityId']]['ShopData'][v['ShopId']] = [];
                                            operateObj["cityPieData"][kk][v['CityId']]['ShopData'][v['ShopId']]['ShopId'] = v['ShopId'];
                                            operateObj["cityPieData"][kk][v['CityId']]['ShopData'][v['ShopId']]['ShopName'] = v['ShopName'];
                                            operateObj["cityPieData"][kk][v['CityId']]['ShopData'][v['ShopId']]['ShopData'] = _vv;
                                        } else {
                                            //计算区域数据//
                                            operateObj["cityPieData"][kk][v['CityId']]['CityData'] += _vv;
                                            //区域门店数据//
                                            operateObj["cityPieData"][kk][v['CityId']]['ShopData'][v['ShopId']] = [];
                                            operateObj["cityPieData"][kk][v['CityId']]['ShopData'][v['ShopId']]['ShopId'] = v['ShopId'];
                                            operateObj["cityPieData"][kk][v['CityId']]['ShopData'][v['ShopId']]['ShopName'] = v['ShopName'];
                                            operateObj["cityPieData"][kk][v['CityId']]['ShopData'][v['ShopId']]['ShopData'] = _vv;

                                        }
                                        //门店总和数据
                                        if (operateObj["shopPieData"][kk][v['ShopId']] == undefined) {
                                            operateObj["shopPieData"][kk][v['ShopId']] = [];
                                            operateObj["shopPieData"][kk][v['ShopId']]['ShopId'] = v['ShopId'];
                                            operateObj["shopPieData"][kk][v['ShopId']]['ShopName'] = v['ShopName'];
                                            operateObj["shopPieData"][kk][v['ShopId']]['ShopData'] = _vv;
                                        } else {
                                            operateObj["shopPieData"][kk][v['ShopId']]['ShopData'] += _vv;
                                        }

                                    }
                                }
                            });
                        });
                        //初始化区域饼状图//
                        this.cityPieInit();
                        //初始化门店饼状图//
                        this.shopPieInit();
                    },
                    tableInit: function() {
                        this.operateTable = $("#operateTable").DataTable({
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
                                    d.RegDate = $("#RegDate").val();
                                    d.CityId = $("#city").val();
                                    d.ShopId = $("#shop").val();
                                },
                            },
                            columns: [{
                                "data": "RegDate",
                                "sClass": "text-center",
                                "orderable": false,
                            }, {
                                "data": "OutpatientSum",
                                "sClass": "text-center",
                                "orderable": false,
                            }, {
                                "data": "TotalChargesSum",
                                "sClass": "text-center",
                                "orderable": true,
                            }, {
                                "data": "TreatChargesSum",
                                "sClass": "text-center",
                                "orderable": false,
                            }, {
                                "data": "ExamChargesSum",
                                "sClass": "text-center",
                                "orderable": false,
                            }, {
                                "data": "AgreeRecipeChargesSum",
                                "sClass": "text-center",
                                "orderable": false,
                            }, {
                                "data": "GuixiChargesSum",
                                "sClass": "text-center",
                                "orderable": false,
                            }, {
                                "data": "FirstVisitSum",
                                "sClass": "text-center",
                                "orderable": false,
                            }, {
                                "data": "FirstVisitRate",
                                "sClass": "text-center",
                                "orderable": false,
                            }, {
                                "data": "FurtherVisitRate",
                                "sClass": "text-center",
                                "orderable": false,
                            }, {
                                "data": "EscapeChargeRate",
                                "sClass": "text-center",
                                "orderable": false,
                            }, {
                                "data": "PeakGetMedAverage",
                                "sClass": "text-center",
                                "orderable": false,
                            }, {
                                "data": "PeakVisitTimesAverage",
                                "sClass": "text-center",
                                "orderable": false,
                            }],
                            "fnDrawCallback": function(obj) {
                                var data = obj.json.data;
                                //构造线性图数据//
                                operateObj["lineData"] = {};
                                $.each(data.reverse(), function(k, v) {
                                    $.each(v, function(kk, vv) {
                                        if (operateObj["lineData"][kk] == undefined) {
                                            operateObj["lineData"][kk] = [];
                                            operateObj["lineData"][kk].push(vv);
                                        } else {
                                            operateObj["lineData"][kk].push(vv);
                                        }
                                    });
                                });
                                //初始化折线图
                                operateObj.lineInit();
                            }
                        });
                    }
                };
                operateObj.searchInit();
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
        window.addEventListener("resize", function() {
            myChart.resize();
        });
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
            operateObj.search();
            operateObj.pieDataInit();
        });
    }
});
