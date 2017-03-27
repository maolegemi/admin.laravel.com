define(['echarts', 'datatables'], function(_echarts, datatables) {
    return {
        init: function() {
                //键盘确定事件
                $(document).keydown(function(e) {
                    if (e.keyCode == 13) {
                        scanObj.search();
                        return true;
                    }
                });
                scanObj = {
                    scanData: '',
                    cleanData: '',
                    scanTable: '',
                    searchInit: function() {

                    },
                    search: function() {
                        if (this.scanTable) {
                            this.scanTable.draw();
                        }
                    },
                    reset:function(){
                        $("#scan-form")[0].reset();
                    },
                    barInit: function() {
                        //初始化线性图数据
                        var clean = [];
                        $.each(this.scanData, function(k, v) {
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
                        this.cleanData = clean;
                        scanObj.pointChange($("#point"));
                    },
                    pointChange: function(obj) {
                        var pointVal = $(obj).find('option:checked').val();
                        var pointName = $(obj).find('option:checked').text();
                        ////////////////
                        //初始化柱形图//
                        ///////////////
                        var barObj = document.getElementById('barBox');
                        var data = this.cleanData;
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
                                    color: '#6bbaad'
                                }
                            },
                        }];
                        toMakeBar(barObj, clean);
                        //
                    },
                    tableInit: function() {
                        {
                            this.scanTable = $('#scanTable').DataTable({
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
                                pageLength: 200,
                                bLengthChange: false,
                                ajax: {
                                    url: "",
                                    data: function(d) {
                                        $.each($("#scan-form").serializeArray(), function(k, v) {
                                            d[v['name']] = v['value'];
                                        });
                                    }
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
                                    "data": "Today_Qrcode_Num",
                                    "sClass": "text-center"
                                }, {
                                    "data": "NewFans_Num",
                                    "sClass": "text-center"
                                }, {
                                    "data": "LeiJi_FansNum",
                                    "sClass": "text-center"
                                }, {
                                    "data": "LeiJi_Qrcode_Num",
                                    "sClass": "text-center"
                                }, {
                                    "data": "Today_NewScan_Num",
                                    "sClass": "text-center"
                                }, {
                                    "data": "LeiJi_Scan_Num",
                                    "sClass": "text-center"
                                }, {
                                    "data": "Month_New_Scan",
                                    "sClass": "text-center"
                                }, {
                                    "data": "KT_QingChart_Num",
                                    "sClass": "text-center"
                                }, {
                                    "data": "Today_EffectAsk_Num",
                                    "sClass": "text-center"
                                }, {
                                    "data": "LeiJi_EffectAsk_Num",
                                    "sClass": "text-center"
                                }],
                                "fnDrawCallback": function(obj) {
                                    //scanObj.data = obj.json.data;
                                    data = obj.json.data;
                                    //计算总量+初始化线性图数据
                                    var sum = {};
                                    $.each(data, function(k, v) {
                                        $.each(v, function(kk, vv) {
                                            if ((kk != 'Insert_Date') && (kk != 'City_Id') && (kk != 'City_Name')) {
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
                                    scanObj.scanData = data;
                                    //初始化线性图
                                    scanObj.barInit();
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
                        } //
                    }
                }; //end scanObj
                scanObj.searchInit();
                scanObj.tableInit();
            } //end init
    } //end return
    //
    function GetDateStr(day) {
        var dd = new Date();
        dd.setDate(dd.getDate() + day);
        var y = dd.getFullYear();
        var m = (dd.getMonth() + 1) < 10 ? "0" + (dd.getMonth() + 1) : (dd.getMonth() + 1);
        var d = dd.getDate() < 10 ? "0" + dd.getDate() : dd.getDate();
        return y + "-" + m + "-" + d;
    }
    //构造柱形图表方法
    function toMakeBar(obj, clean) {
        var option = {
            title: {
                text: '区域二维码[' + clean['title'] + ']统计',
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
