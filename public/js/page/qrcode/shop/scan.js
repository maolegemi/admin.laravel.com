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
                    weeklyTable: '',
                    monthlyTable: '',
                    search: function(tb_id) {
                        scanObj[tb_id + "Table"].draw();
                    },
                    reset: function(tb_id) {
                        $("#" + tb_id + "-form")[0].reset();
                        var shopObj = $('#shop-' + tb_id);
                        $('#shop-' + tb_id).val('');
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
                "data": "Shop_Id",
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
                //var data = obj.json.data;
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
});
