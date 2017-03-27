define(['datatables'], function(datatables) {
    return {
        init: function() {
            //tab菜单点击事件
            var tb_id = 'daily';
            $("#shop-kpi-nav li a").click(function() {
                var href = $(this).attr('href');
                tb_id = href.substring(1, href.length);
                if (!shopObj[tb_id + "Table"]) {
                    var method = tb_id + "Init";
                    shopObj[method]();
                }
            });
            //键盘确定事件
            $(document).keydown(function(e) {
                if (e.keyCode == 13) {
                    shopObj.search(tb_id);
                    return true;
                }
            });
            //表格处理对象
            shopObj = {
                dailyTable: '',
                weeklyTable: '',
                monthlyTable: '',
                search: function(type) {
                    shopObj[type + "Init"]();
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
            };
            shopObj.dailyInit();
        }
    }
    //初始化医生预约表格数据
    function init_kpi_table(type) {
        var table = '';
        var columns = [{
            "data": "Sum_Date",
            "sClass": "text-center",
        }, {
            "data": "City_Name",
            "sClass": "text-center",
            "orderable": false,
        }, {
            "data": "Shop_Name",
            "sClass": "text-center",
            "orderable": false,
        }, {
            "data": "Total_Counts",
            "sClass": "text-center",
            "orderable": false,
        }, {
            "data": "OutPatientNum",
            "sClass": "text-center",
            "orderable": false,
        }, {
            "data": "FirstVisitNum",
            "sClass": "text-center",
            "orderable": true,
        }, {
            "data": "OrderOnlineNum",
            "sClass": "text-center",
            "orderable": false,
        }, {
            "data": "FirstVisitOnline",
            "sClass": "text-center",
            "orderable": false,
        }, {
            "data": "OrderOnlineRate",
            "sClass": "text-center",
            "orderable": false,
        }, {
            "data": "FirstVisitOnlineRate",
            "sClass": "text-center"
        }];
        //周月增加多个字段
        var tb = $("#" + type + "-form").find('input[name="tb"]').val();
        if (tb == 'KPIWeekSum' || tb == 'KPIMonthSum') {
            var addClums = [{
                "data": "OrderOnlineRate_a",
                "sClass": "text-center fivepercent",
                "orderable": false,
            }, {
                "data": "OrderOnlineRate_b",
                "sClass": "text-center fivepercent",
                "orderable": true,
            }, {
                "data": "OrderOnlineRate_c",
                "sClass": "text-center fivepercent",
                "orderable": false,
            }, {
                "data": "FirstVisitOnlineRate_a",
                "sClass": "text-center fivepercent",
                "orderable": false,
            }, {
                "data": "FirstVisitOnlineRate_b",
                "sClass": "text-center fivepercent",
                "orderable": false,
            }, {
                "data": "FirstVisitOnlineRate_c",
                "sClass": "text-center fivepercent"
            }];
            columns = $.merge(columns, addClums);
        };
        table = $("#" + type + "Table").DataTable({
            info: true,
            responsive: true,
            serverSide: true,
            processing: false,
            bSort: true,
            searchable: false,
            searching: false,
            ordering: false,
            paging: true,
            pageLength: 25,
            bLengthChange: false,
            ajax: {
                url: "",
                data: function(d) {
                    $.each($("#" + type + "-form").serializeArray(), function(k, v) {
                        d[v['name']] = v['value'];
                    });
                },
            },
            columns: columns,
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
});
