define(['echarts', 'datatables'], function(_echarts, datatables) {
    return {
        init: function() {
                //键盘确定事件
                $(document).keydown(function(e) {
                    if (e.keyCode == 13) {
                        operateObj.search();
                        return true;
                    }
                });
                operateObj = {
                    monthlyTable: '',
                    search: function() {
                        this.monthlyTable.draw();
                    },
                    reset: function(type) {
                        $("#"+type+"-form")[0].reset();
                        var shopObj = $('#shop-'+type);
                        shopObj.find('option.shop').show();
                    },
                    cityChange: function(obj,type) {
                        var city_no = $(obj).find('option:selected').val();
                        var shopObj = $('#shop-'+type);
                        $('#shop-'+type).val('');
                        if (city_no) {
                            shopObj.find('option.shop').hide();
                            shopObj.find('option[data="city_no_' + city_no + '"]').show();

                        } else {
                            shopObj.find('option.shop').show();
                        }
                    },
                    tableInit: function() {
                        this.monthlyTable = $('#monthlyTable').DataTable({
                            info: false,
                            responsive: true,
                            serverSide: true,
                            processing: false,
                            bSort: false,
                            searchable: false,
                            searching: false,
                            ordering: false,
                            paging: false,
                            pageLength: 20,
                            bLengthChange: false,
                            ajax: {
                                url: "",
                                data: function(d) {
                                    $.each($("#monthly-form").serializeArray(), function(k, v) {
                                        d[v['name']] = v['value'];
                                    });
                                }
                            },
                            columns: [{
                                "data": "City_Name",
                                "sClass": "text-center",
                            }, {
                                "data": "Shop_Name",
                                "sClass": "text-center",
                                "orderable": false,
                            }, {
                                "data": "Reg_Num",
                                "sClass": "text-center",
                                "orderable": false,
                            }, {
                                "data": "Patient_Num",
                                "sClass": "text-center",
                                "orderable": false,
                            }, {
                                "data": "PaoDan_Num",
                                "sClass": "text-center",
                                "orderable": false,
                            }, {
                                "data": "Qrcode_Num",
                                "sClass": "text-center",
                                "orderable": false,
                            }, {
                                "data": "Qrcode_Per",
                                "sClass": "text-center",
                                "orderable": false,
                            }, {
                                "data": "Return_Num",
                                "sClass": "text-center",
                                "orderable": false,
                            }, {
                                "data": "Return_Per",
                                "sClass": "text-center"
                            }, {
                                "data": "XieDingFang_Num",
                                "sClass": "text-center"
                            }, {
                                "data": "YinPian_Num",
                                "sClass": "text-center"
                            }, {
                                "data": "WeiXin_Num",
                                "sClass": "text-center"
                            }, {
                                "data": "WeiXin_Per",
                                "sClass": "text-center"
                            }, {
                                "data": "Wait_DrugsTime",
                                "sClass": "text-center"
                            }, {
                                "data": "Wait_FeeTime",
                                "sClass": "text-center"
                            }, {
                                "data": "Wait_PayTime",
                                "sClass": "text-center"
                            }, {
                                "data": "ShuangYue_Num",
                                "sClass": "text-center"
                            }, {
                                "data": "ShuangYue_Per",
                                "sClass": "text-center"
                            }, {
                                "data": "DaiJian_Num",
                                "sClass": "text-center"
                            }, {
                                "data": "DaiJian_Per",
                                "sClass": "text-center"
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
                operateObj.tableInit();
            } //end init
    };
});
