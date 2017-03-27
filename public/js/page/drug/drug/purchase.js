define(['echarts', 'datatables'], function(_echarts, datatables) {
    return {
        init: function() {
                //键盘确定事件
                $(document).keydown(function(e) {
                    if (e.keyCode == 13) {
                        purchaseObj.search();
                        return true;
                    }
                });
                purchaseObj = {
                    purchaseTable: '',
                    search: function() {
                        this.purchaseTable.draw();
                    },
                    reset: function() {
                        $("#purchase-form")[0].reset();
                        var shopObj = $('#shop');
                        shopObj.find('option.shop').show();
                    },
                    cityChange: function(obj) {
                        var city_no = $(obj).find('option:selected').val();
                        var shopObj = $('#shop');
                        $('#shop').val('');
                        if (city_no) {
                            shopObj.find('option.shop').hide();
                            shopObj.find('option[data="city_no_' + city_no + '"]').show();

                        } else {
                            shopObj.find('option.shop').show();
                        }
                    },
                    barInit: function() {
                        var pointObj = $("input[name='orderBar']:checked");
                        purchaseObj.pointChange(pointObj);
                    },
                    pointChange: function(obj) {
                        var pointVal = $(obj).val();
                        var data = [];
                        var titleBar = {
                            'QTY': "数量[g](总)(取整)",
                            'Ret_AllMoney': "成本[￥](总)(取整)",
                            'Buy_SumMoney': "零售[￥](总)(取整)"
                        };
                        data.push({
                            name: 'action',
                            value: 'bar'
                        });
                        data.push({
                            name: 'barOrder',
                            value: pointVal
                        });
                        // data.push({
                        //     name:'Vou_Date',
                        //     value: $("#purchase-form input[name='Vou_Date']").val()
                        // });
                        // data.push({
                        //     name:'City_Id',
                        //     value: $("#purchase-form select[name='City_Id']").find('option:selected').val()
                        // });
                        // data.push({
                        //     name:'Shop_Id',
                        //     value: $("#purchase-form select[name='City_Id']").find('option:selected').val()
                        // });
                        ////////////////
                        //初始化柱形图//
                        ///////////////
                        var barData = toGetData("", data);
                        var barObj = document.getElementById('barBox');
                        var clean = {};
                        clean['title'] = titleBar[pointVal];
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
                        var xAxis = [];
                        var series = [];
                        $.each(barData['data'], function(k, v) {
                            xAxis.push(v['Item_Name']);
                            series.push(v['sumAll']);
                        });
                        clean['xAxis'] = [{
                            type: 'category',
                            data: xAxis,
                            scale: true,
                            show: true,
                            splitLine: {　　　　
                                show: true
                            },
                            axisLabel: {
                                interval: 0,
                                rotate: 15, //倾斜度 -90 至 90 默认为0  
                                margin: 10,
                            },
                        }];
                        clean['series'] = [{
                            name: titleBar[pointVal],
                            type: 'line',
                            data: series,
                            itemStyle: {
                                normal: {
                                    label: {
                                        show: true,
                                        formatter: "{c}"
                                    },
                                    labelLine: {
                                        show: false
                                    },
                                    color: '#005ab5'
                                }
                            },
                        }];
                        toMakeBar(barObj, clean);
                    },
                    tableInit: function() {
                        this.purchaseTable = $('#purchaseTable').DataTable({
                            responsive: true,
                            serverSide: true,
                            processing: false,
                            bSort: true,
                            searchable: false,
                            searching: false,
                            ordering: true,
                            paging: true,
                            pageLength: 20,
                            bLengthChange: false,
                            ajax: {
                                url: "",
                                data: function(d) {
                                    $.each($("#purchase-form").serializeArray(), function(k, v) {
                                        d[v['name']] = v['value'];
                                    });
                                }
                            },
                            columns: [{
                                "data": "Vou_Date",
                                "sClass": "text-center",
                            }, {
                                "data": "City_Id",
                                "sClass": "text-center",
                                "orderable": false,
                            }, {
                                "data": "Shop_Id",
                                "sClass": "text-center",
                                "orderable": false,
                            }, {
                                "data": "Dept_Name",
                                "sClass": "text-center",
                                "orderable": false,
                            }, {
                                "data": "Item_Code",
                                "sClass": "text-center",
                                "orderable": false,
                            }, {
                                "data": "Item_Name",
                                "sClass": "text-center",
                                "orderable": false,
                            }, {
                                "data": "Cls_Name",
                                "sClass": "text-center",
                                "orderable": false,
                            }, {
                                "data": "QTY",
                                "sClass": "text-center"
                            }, {
                                "data": "Ret_Price",
                                "sClass": "text-center"
                            }, {
                                "data": "Tra_Price",
                                "sClass": "text-center"
                            }, {
                                "data": "Buy_SumMoney",
                                "sClass": "text-center"
                            }, {
                                "data": "Ret_AllMoney",
                                "sClass": "text-center"
                            }, {
                                "data": "Big_Unit",
                                "sClass": "text-center",
                                "orderable": false,
                            }, {
                                "data": "Standard",
                                "sClass": "text-center",
                                "orderable": false,
                            }, {
                                "data": "Small_Unit",
                                "sClass": "text-center",
                                "orderable": false,
                            }, {
                                "data": "Vou_Name",
                                "sClass": "text-center",
                                "orderable": false,
                            }],
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
                    }
                };
                purchaseObj.barInit();
                purchaseObj.tableInit();
            } //end init
    };
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
    //构造柱形图表方法
    function toMakeBar(obj, clean) {
        var option = {
            title: {
                text: '药品采购领取--' + clean['title'] + '--排行',
                x: 'center'
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
