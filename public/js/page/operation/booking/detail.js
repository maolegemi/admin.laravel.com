define(['datatables'], function(datatables) {
    return {
        init: function() {
            orderObj = {
                table: '',
                searchInit: function() {
                    multiSelect($("#source"));
                    multiSelect($("#paymode"));
                },
                tableInit: function() {
                    this.table = $('#booking-daily-list').DataTable({
                        info: true,
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

                            },
                        },
                        columns: [{
                                "data": "OrderId",
                                "sClass": "text-center",
                            }, {
                                "data": "PatientName",
                                "sClass": "text-center",
                                "orderable": false,
                            }, {
                                "data": "MobilePhone",
                                "sClass": "text-center",
                                "orderable": false,
                            }, {
                                "data": "OrderVisitDate",
                                "sClass": "text-center",
                                "orderable": true,
                            }, {
                                "data": "OrderStatus",
                                "sClass": "text-center",
                                "orderable": false,
                            }, {
                                "data": "CityId",
                                "sClass": "text-center",
                                "orderable": false,
                            }, {
                                "data": "ShopId",
                                "sClass": "text-center",
                                "orderable": false,
                            }, {
                                "data": "DoctorName",
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
                            }, {
                                "data": "OrderConfirmDate",
                                "sClass": "text-center"
                            }] //,
                    });
                },
                reset:function(obj){
                  $(obj)[0].reset();
                },
                export: function() {
                    //alert('export');
                }
            };
            orderObj.searchInit();
            orderObj.tableInit();
        }
    }

    //多选下拉框js
    function multiSelect(obj) {
        var input = obj.find("input[type='text']").eq(0);
        var box   = obj.find('div.contentBox');
        var state = true;
        //点击事件
        input.unbind('click');
        input.click(function(event) {
            var status = box.css('display');
            if (status == 'block') {
                state = state == true ? true : false;
                box.hide();
            } else {
                state = state == false ? false : true;
                box.show();
            }
        });
        //input鼠标焦点事件
        input.hover(function() {
            state = true;
        }, function() {
            state = false;
        });
        //box鼠标焦点事件
        box.hover(function() {
            state = true;
        }, function() {
            state = false;
        });
        //鼠标点击事件
        $(document).bind("click", function() {
            if (state == false) {
                box.hide();
            }
        });
        //多选选中事件


    }

});
