define(['echarts', 'datatables'], function(_echarts, datatables) {
    return {
        init: function() {
            //tab菜单点击事件
            var tb_id = 'daily';
            $("#shop-nav li a").click(function() {
                var href = $(this).attr('href');
                tb_id = href.substring(1, href.length);
                if (!scanObj[tb_id + "Table"]) {
                    var method = tb_id + "Init";
                    scanObj[method]();
                }
            });
            //键盘确定事件
            $(document).keydown(function(e) {
                if (e.keyCode == 13) {
                    scanObj.search(tb_id);
                    return true;
                }
            });
            //KPI操作对象
            scanObj = {
                dailyTable: '',
                dailyScanData: '',
                dailyCleanData: '',
                weeklyTable: '',
                monthlyTable: '',
                search: function(tb_id) {
                    scanObj[tb_id + "Table"].draw();
                },
                reset: function(tb_id) {
                    $("#" + tb_id + "-form")[0].reset();
                },
                barInit: function(type) {
                    //初始化线性图数据
                    var clean = [];
                    $.each(scanObj[type + 'ScanData'], function(k, v) {
                        $.each(v, function(kk, vv) {
                            if (clean[kk] == undefined) {
                                clean[kk] = {
                                    label: kk,
                                    data: [],
                                };
                                clean[kk]['data'].push(vv);
                            } else {
                                clean[kk]['data'].push(vv);
                            }
                        });
                    });
                    scanObj[type + 'CleanData'] = clean;
                    scanObj.pointChange($("#" + type + "Point"),type);
                },
                pointChange: function(obj,type) {
                    var pointVal = $(obj).find('option:checked').val();
                    var pointName = $(obj).find('option:checked').text();
                    ////////////////
                    //初始化柱形图//
                    ///////////////
                    var barObj = document.getElementById(type+'LineBox');
                    var data = scanObj[type + 'CleanData'];
                    var clean = [];
                    clean['title'] = pointName;
                    clean['yAxis'] = [{
                        type: 'value',
                        axisLabel: {
                            formatter: '{value}'
                        },
                        scale: true,
                        show: true,
                        splitLine: {　　　　
                            show: true
                        }
                    }];
                    clean['xAxis'] = [{
                        type: 'category',
                        data: data['City_Name']['data'],
                        scale: true,
                        show: true,
                        splitLine: {　　　　
                            show: true
                        },
                        axisLabel: {
                            // interval: 0,
                            // rotate: 15, //倾斜度 -90 至 90 默认为0  
                            // margin: 10,
                        },
                    }];
                    clean['series'] = [{
                        name: pointName,
                        type: 'line',
                        data: data[pointVal]['data'],
                        itemStyle: {
                            normal: {
                                label: {
                                    show: true,
                                    formatter: "{b}:{c}",
                                },
                                labelLine: {
                                    show: false
                                },
                                color: '#5cb85c'
                            }
                        },
                    }];
                    toMakeBar(barObj, clean);
                },
                dailyInit: function() {
                    if (this.dailyTable == '') {
                        this.dailyTable = initTable('daily');
                    }
                },
                weeklyInit: function() {
                    if (this.weeklyTable == '') {
                        this.weeklyTable = initTable('weekly');
                    }
                },
                monthlyInit: function() {
                    if (this.monthlyTable == '') {
                        this.monthlyTable = initTable('monthly');
                    }
                }
            };
            scanObj.dailyInit();
        } //return init
    } //end return
    //初始化表格数据
    function initTable(type) {
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
            pageLength: 20,
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
                "data": "City_Id",
                "sClass": "text-center",
                "orderable": false,
            }, {
                "data": "City_Name",
                "sClass": "text-center",
                "orderable": false,
            }, {
                "data": "New_Scan",
                "sClass": "text-center",
                "orderable": true,
            }, {
                "data": "New_Scan_v",
                "sClass": "text-center",
                "orderable": false,
            }, {
                "data": "Scan",
                "sClass": "text-center",
                "orderable": false,
            }, {
                "data": "Scan_v",
                "sClass": "text-center",
                "orderable": false,
            }, {
                "data": "Follow",
                "sClass": "text-center",
                "orderable": false,
            }, {
                "data": "Follow_v",
                "sClass": "text-center",
                "orderable": false,
            }],
            "fnDrawCallback": function(obj) {
                var data = obj.json.data;
                //计算总量
                var sum = {};
                $.each(data, function(k, v) {
                    $.each(v, function(kk, vv) {
                        if ((kk != 'Date') && (kk != 'City_Id') && (kk != 'City_Name')) {
                            var value = parseInt(vv);
                            if (sum[kk] == undefined) {
                                sum[kk] = value;
                            } else {
                                sum[kk] += value;
                            }
                        }
                    });
                });
                $.each(sum, function(k, v) {
                    $("#" + k).text(myFunction.format(v,3));
                });
                //初始化线性图数据+初始化折线图
                scanObj[type + 'ScanData'] = data;
                //初始化线性图
                scanObj.barInit(type);
            },
            "language": {
                "sLengthMenu": "每页显示 _MENU_ 条记录",
                "sInfo": "　一共 _TOTAL_ 条数据",
                "sInfoFiltered": "(从总记录 _MAX_ 条记录中过滤)",
                "sInfoEmpty": "没有数据",
                "sSearch": "查找 ",
                "sZeroRecords": "没有检索到数据",
                "oPaginate": {
                    "sFirst": "首页",
                    "sPrevious": "上一页",
                    "sNext": "下一页",
                    "sLast": "末页"
                }
            },
            "autoWidth": true,
            "retrieve": true,
        });
        return table;
    }
    //构造柱形图表方法
    function toMakeBar(obj, clean) {
        var option = {
            title: {
                text: '区域-' + clean['title'] + '-分布',
                x: 'center',
                color: '#ddd'
            },
            tooltip: {
                trigger: 'item',
                formatter: "{a} <br/>{b} : {c}"
            },
            calculable: false,
            xAxis: clean['xAxis'],
            yAxis: clean['yAxis'],
            series: clean['series']
        };
        var myChart = echarts.init(obj);
        myChart.setOption(option);
    }
});