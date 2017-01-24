define(['select2', 'slimScroll', 'daterangepicker', 'icheck'], function(select2, slim, daterangepicker, icheck) {
    function init(env) {
        //给左边菜单加上.active状态
        var url = window.location;
        var obj = $("ul.sidebar-menu li ul li a");
        $.each(obj, function(k, v) {
            var href = $(v).attr('href');
            if (href == url) {
                $(v).parent().addClass('active').siblings("ul.sidebar-menu li ul li").removeClass('active');
                $(v).parent().parent().parent().addClass('active').siblings("ul.sidebar-menu li").removeClass('active');
            }
        });

        //时间
        $("input[data='daterangepicker']").daterangepicker({
            opens: 'center', //日期选择框的弹出位置
            buttonClasses: ['btn btn-info'],
            applyClass: 'btn-small btn-primary blue',
            cancelClass: 'btn-small',
            locale: {
                format: "YYYY-MM-DD",
                separator: " ~ ",
                applyLabel: "确定",
                cancelLabel: "取消",
                fromLabel: "开始",
                toLabel: "结束",
                customRangeLabel: "自定义",
                weekLabel: "W",
                daysOfWeek: ["日", "一", "二", "三", "四", "五", "六"],
                monthNames: ["一月", "二月", "三月", "四月", "五月", "六月", "七月", "八月", "九月", "十月", "十一月", "十二月 "],
                firstDay: 1
            }
        }, function(start, end, label) {

        });

        //多选
        $(".select2").select2();


        //iCheck for checkbox and radio inputs
        $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
            checkboxClass: 'icheckbox_minimal-blue',
            radioClass: 'iradio_minimal-blue'
        });
        //Red color scheme for iCheck
        $('input[type="checkbox"].minimal-red, input[type="radio"].minimal-red').iCheck({
            checkboxClass: 'icheckbox_minimal-red',
            radioClass: 'iradio_minimal-red'
        });
        //Flat red color scheme for iCheck
        $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
            checkboxClass: 'icheckbox_flat-green',
            radioClass: 'iradio_flat-green'
        });
    }

    return init;
});
