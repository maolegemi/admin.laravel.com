define(['datatables'], function(datatables) {
    return {
        init: function() {
            //tab菜单点击事件
            var tb_id = 'daily';
            $("#doctor-kpi-nav li a").click(function() {
                var href = $(this).attr('href');
                tb_id = href.substring(1, href.length);
                //tab切换
                if (!doctorObj[tb_id + "Table"]) {
                    var method = tb_id + "Init";
                    doctorObj[method]();
                }
            });
            //键盘确定事件
            $(document).keydown(function(e) {
                if (e.keyCode == 13) {
                    doctorObj.search(tb_id);
                    return true;
                }
            });
            //表格处理对象
            doctorObj = {
                dailyTable: '',
                weeklyTable: '',
                monthlyTable: '',
                weeklyRankTable: '',
                monthlyRankTable: '',
                search: function(type) {
                    doctorObj[type + "Init"]();
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
                weeklyRankInit: function() {
                    if (this.weeklyRankTable) {
                        this.weeklyRankTable.draw();
                        return true;
                    }
                    this.weeklyRankTable = init_rank_table('weeklyRank');
                },
                monthlyRankInit: function() {
                    if (this.monthlyRankTable) {
                        this.monthlyRankTable.draw();
                        return true;
                    }
                    this.monthlyRankTable = init_rank_table('monthlyRank');
                }
            };
            doctorObj.dailyInit();
        }
    }
    //初始化医生预约表格数据
    function init_kpi_table(type) {
        var table = '';
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
                "data": "Sum_Date",
                "sClass": "text-center",
                "orderable": false,
            }, {
                "data": "City_Name",
                "sClass": "text-center",
                "orderable": false,
            }, {
                "data": "Shop_Name",
                "sClass": "text-center",
                "orderable": false,
            }, {
                "data": "Doctor_MisId",
                "sClass": "text-center",
                "orderable": false,
            }, {
                "data": "Doctor_Name",
                "sClass": "text-center",
                "orderable": false,
            }, {
                "data": "Total_Counts",
                "sClass": "text-center",
                "orderable": true,
            }, {
                "data": "OutPatientNum",
                "sClass": "text-center",
                "orderable": false,
            }, {
                "data": "FirstVisitNum",
                "sClass": "text-center",
                "orderable": false,
            }, {
                "data": "OrderOnlineNum",
                "sClass": "text-center",
                "orderable": false,
            }, {
                "data": "mzyy_rate",
                "sClass": "text-center",
                "orderable": false,
            }, {
                "data": "mzsz_rate",
                "sClass": "text-center",
                "orderable": false,
            }, {
                "data": "Saturation",
                "sClass": "text-center",
                "orderable": false,
            }, {
                "data": "Doctor_Level",
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
        return table;
    }
    //初始化医生排行榜表格
    //初始化表格数据
    function init_rank_table(type) {
        var table = '';
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
                "data": "Sum_Date",
                "sClass": "text-center",
            }, {
                "data": "City_Name",
                "sClass": "text-center",
            }, {
                "data": "Shop_Name",
                "sClass": "text-center",
            }, {
                "data": "Doctor_Name",
                "sClass": "text-center",
            }, {
                "data": "rank",
                "sClass": "text-center",
            }, {
                "data": "Doctor_Level",
                "sClass": "text-center",
            }, {
                "data": "OutPatientNum",
                "sClass": "text-center sixpercent",
            }, {
                "data": "OutPatientNum_Rate",
                "sClass": "text-center",
            }, {
                "data": "FirstVisitNum",
                "sClass": "text-center sixpercent",
            }, {
                "data": "FirstVisitNum_Rate",
                "sClass": "text-center sixpercent",
            }, {
                "data": "OrderOnlineNum",
                "sClass": "text-center sixpercent"
            }, {
                "data": "ShopOrderOnlineNum_Rate",
                "sClass": "text-center",
            }, {
                "data": "ShopFirstVisitOnline_Rate",
                "sClass": "text-center sixpercent",
            }, {
                "data": "FirstVisitOnline",
                "sClass": "text-center",
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
        return table;
    }
});
