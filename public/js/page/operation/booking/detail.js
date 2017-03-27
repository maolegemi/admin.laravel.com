define(['datatables'], function(datatables) {
    return {
        init: function() {
            //键盘确定事件
            $(document).keydown(function(e) {
                if (e.keyCode == 13) {
                   orderObj.search();
                   return true;
                }
            });
            orderObj = {
                orderTable: '',
                searchInit: function() {

                },
                search: function() {
                    if (this.orderTable) {
                        this.orderTable.draw();
                    }
                },
                reset: function() {
                    $("#booking-detail-form")[0].reset();
                    var shopObj = $('#shop');
                    shopObj.find('option.shop').show();
                },
                export: function() {
                    //alert('export');
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
                tableInit: function() {
                    this.orderTable = $('#orderTable').DataTable({
                        info: true,
                        responsive: true,
                        serverSide: true,
                        processing: false,
                        bSort: false,
                        searchable: false,
                        searching: false,
                        ordering: false,
                        paging: true,
                        pageLength: 20,
                        bLengthChange: false,
                        ajax: {
                            url: "",
                            data: function(d) {
                                $.each($("#booking-detail-form").serializeArray(), function(k, v) {
                                    d[v['name']] = v['value'];
                                });
                            },
                        },
                        columns: [{
                            "data": "OrderId",
                            "sClass": "text-center",
                        }, {
                            "data": "OrderConfirmDate",
                            "sClass": "text-center"
                        }, {
                            "data": "OrderVisitDate",
                            "sClass": "text-center",
                            "orderable": true,
                        }, {
                            "data": "CityName",
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
                            "data": "PatientName",
                            "sClass": "text-center",
                            "orderable": false,
                        }, {
                            "data": "MobilePhone",
                            "sClass": "text-center",
                            "orderable": false,
                        }, {
                            "data": "OrderStatus",
                            "sClass": "text-center",
                            "orderable": false,
                        }, {
                            "data": "OrderType",
                            "sClass": "text-center",
                            "orderable": false,
                        }, {
                            "data": "SourceId",
                            "sClass": "text-center",
                            "orderable": false,
                        }, {
                            "data": "PayStatus",
                            "sClass": "text-center",
                            "orderable": false,
                        }, {
                            "data": "PayType",
                            "sClass": "text-center",
                            "orderable": false,
                        }, {
                            "data": "FirstVisitFlag",
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
            orderObj.searchInit();
            orderObj.tableInit();
        }
    }
});
