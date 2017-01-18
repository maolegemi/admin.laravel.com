define(['datatables'], function(datatables) {
    return {
        init: function() {
            orderObj = {
                table: '',
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
                export: function() {
                    //alert('export');
                }
            };
            orderObj.tableInit();
        }
    }

});
