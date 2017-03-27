define(['datatables'], function(datatables) {
    return {
        init: function() {
                //tab菜单点击事件
                var tb_id = 'kpi';
                $("#online-nav li a").click(function() {
                    var href = $(this).attr('href');
                    tb_id = href.substring(1, href.length);
                    if (!tableObj[tb_id + "Table"]) {
                        var method = tb_id + "Init";
                        tableObj[method]();
                    }
                    //键盘确定事件
                    $(document).keydown(function(e) {
                        if (e.keyCode == 13) {
                            tableObj.search(tb_id);
                            return true;
                        }
                    });
                });
                //表格对象
                tableObj = {
                    kpiTable: '',
                    rateTable: '',
                    doctorTable: '',
                    shopTable: '',
                    sourceTable: '',
                    search: function(tb_id) {
                        tableObj[tb_id + "Init"]();
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
                    export: function(type) {
                        var url   = '';
                        var param = '?action=excel&type='+type;
                        $.each($("#" + type + "-form").serializeArray(), function(k, v) {
                            param += "&" + v['name'] + "=" + v['value'];
                        });
                        window.location = url + param;
                    },
                    kpiInit: function() {
                        this.kpiTable = true;
                        var where = {};
                        where['type'] = 'kpi';
                        $.each($("#kpi-form").serializeArray(), function(k, v) {
                            where[v['name']] = v['value'];
                        });
                        toMakeTable('#kpi', '', where);
                    },
                    rateInit: function() {
                        this.rateTable = true;
                        var where = {};
                        where['type'] = 'rate';
                        $.each($("#rate-form").serializeArray(), function(k, v) {
                            where[v['name']] = v['value'];
                        });
                        toMakeTable('#rate', '', where);

                    },
                    doctorInit: function() {
                        if (this.doctorTable) {
                            this.doctorTable.draw();
                            return true;
                        }
                        this.doctorTable = $('#doctorTable').DataTable({
                            info: true,
                            responsive: true,
                            serverSide: true,
                            processing: false,
                            bSort: false,
                            searchable: false,
                            searching: false,
                            ordering: false,
                            paging: true,
                            pageLength: 15,
                            bLengthChange: false,
                            ajax: {
                                url: "",
                                data: function(d) {
                                    d.type = 'doctor';
                                    $.each($("#doctor-form").serializeArray(), function(k, v) {
                                        d[v['name']] = v['value'];
                                    });
                                },
                            },
                            columns: [{
                                "data": "index",
                                "sClass": "text-center",
                                "orderable": false,
                            }, {
                                "data": "ShopName",
                                "sClass": "text-center",
                                "orderable": false,
                            }, {
                                "data": "DoctorName",
                                "sClass": "text-center",
                                "orderable": false,
                            }, {
                                "data": "DoctorMisId",
                                "sClass": "text-center",
                                "orderable": false,
                            }, {
                                "data": "Wx_Order",
                                "sClass": "text-center",
                                "orderable": false,
                            }, {
                                "data": "Web_Order",
                                "sClass": "text-center",
                                "orderable": false,
                            }, {
                                "data": "Jy160_Order",
                                "sClass": "text-center",
                                "orderable": false,
                            }, {
                                "data": "Gh_Order",
                                "sClass": "text-center"
                            }, {
                                "data": "Yjk_Order",
                                "sClass": "text-center",
                                "orderable": false,
                            }, {
                                "data": "Other_Order",
                                "sClass": "text-center"
                            }, {
                                "data": "Total_Order",
                                "sClass": "text-center"
                            }],
                            "columnDefs": [{
                                "render": function(data, type, full) {
                                    var str = "线上预约<hr />线上首诊";
                                    return str;
                                },
                                "targets": [3]
                            }, {
                                "render": function(data, type, full) {
                                    var str = data['first_rate'] + "<hr />" + data['further_rate'];
                                    return str;
                                },
                                "targets": [4, 5, 6, 7, 8, 9]
                            }, {
                                "render": function(data, type, full) {
                                    var str = data['first_sum'] + "<hr />" + data['further_sum'];
                                    return str;
                                },
                                "targets": [10]
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
                    },
                    shopInit: function() {
                        if (this.shopTable) {
                            this.shopTable.draw();
                            return true;
                        }
                        this.shopTable = $('#shopTable').DataTable({
                            info: true,
                            responsive: true,
                            serverSide: true,
                            processing: false,
                            bSort: false,
                            searchable: false,
                            searching: false,
                            ordering: false,
                            paging: true,
                            pageLength: 15,
                            bLengthChange: false,
                            ajax: {
                                url: "",
                                data: function(d) {
                                    d.type = 'shop';
                                    $.each($("#shop-form").serializeArray(), function(k, v) {
                                        d[v['name']] = v['value'];
                                    });
                                },
                            },
                            columns: [{
                                "data": "index",
                                "sClass": "text-center",
                                "orderable": false,
                            }, {
                                "data": "CityName",
                                "sClass": "text-center",
                                "orderable": false,
                            }, {
                                "data": "ShopName",
                                "sClass": "text-center",
                                "orderable": false,
                            }, {
                                "data": "ShopId",
                                "sClass": "text-center",
                                "orderable": false,
                            }, {
                                "data": "Wx_Order",
                                "sClass": "text-center",
                                "orderable": false,
                            }, {
                                "data": "Web_Order",
                                "sClass": "text-center",
                                "orderable": false,
                            }, {
                                "data": "Jy160_Order",
                                "sClass": "text-center",
                                "orderable": false,
                            }, {
                                "data": "Gh_Order",
                                "sClass": "text-center"
                            }, {
                                "data": "Yjk_Order",
                                "sClass": "text-center",
                                "orderable": false,
                            }, {
                                "data": "Other_Order",
                                "sClass": "text-center"
                            }, {
                                "data": "Total_Order",
                                "sClass": "text-center"
                            }],
                            "columnDefs": [{
                                "render": function(data, type, full) {
                                    var str = "线上预约<hr />线上首诊";
                                    return str;
                                },
                                "targets": [3]
                            }, {
                                "render": function(data, type, full) {
                                    var str = data['first_rate'] + "<hr />" + data['further_rate'];
                                    return str;
                                },
                                "targets": [4, 5, 6, 7, 8, 9]
                            }, {
                                "render": function(data, type, full) {
                                    var str = data['first_sum'] + "<hr />" + data['further_sum'];
                                    return str;
                                },
                                "targets": [10]
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
                    },
                    sourceInit: function() {
                        this.sourceTable = true;
                        var where = {};
                        where['type'] = 'source';
                        $.each($("#source-form").serializeArray(), function(k, v) {
                            where[v['name']] = v['value'];
                        });
                        toMakeTable('#source', '', where);
                    }
                }; //end tableObj
                tableObj.kpiInit('kpi');
            } //end init
    }
    //通过ajax方法获取数据方法
    function toMakeTable(tab_id, url, where) {
        var dataArr = [];
        var htmlobj = $.ajax({
            url: url,
            async: false,
            method: 'get',
            data: where,
            'dataType': 'json'
        });
        var view = htmlobj.responseText;
        var rst = $(tab_id + "Box").html(view);
    }
});
