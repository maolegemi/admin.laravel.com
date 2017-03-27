define([], function() {
    return {
        init: function() {
            //键盘确定事件
            $(document).keydown(function(e) {
                if (e.keyCode == 13) {
                    reportObj.search();
                    return true;
                }
            });
            reportObj = {
                boxObj: '',
                initSearch: function() {

                },
                search: function() {
                    this.tableInit();
                },
                reset: function() {
                    $("#reoprt-form")[0].reset();
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
                tableInit: function() {
                    this.boxObj = $('#operateBox');
                    var where = {};
                    $.each($("#reoprt-form").serializeArray(), function(k, v) {
                        where[v['name']] = v['value'];
                    });
                    toMakeATable(this.boxObj, '', where);
                },
                export: function(obj) {
                    var url = $(obj).val();
                    var param = '?export=1';
                    $.each($("#reoprt-form").serializeArray(), function(k, v) {
                        param += "&" + v['name'] +"=" +v['value'];
                    });
                    window.location = url + param;
                }
            };
            reportObj.tableInit();
        }
    } //end return

    //通过ajax方法获取经过编译后的模板表格数据
    function toMakeATable(Obj, url, data) {
        var htmlobj = $.ajax({
            url: url,
            async: false,
            method: 'get',
            data: data,
            'dataType': 'json'
        });
        Obj.html(htmlobj.responseText);
    }
});
