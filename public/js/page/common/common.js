define(['select2', 'slimScroll', 'daterangepicker', 'datepicker', 'icheck', 'moment', 'datetimepicker_cn'],
    function(select2, slim, daterangepicker, icheck, moment, datetimepicker) {
        function init(env) {
            //给左边菜单加上.active状态
            var url = window.location.origin+window.location.pathname;
            var obj = $("ul.sidebar-menu li ul li a");
            $.each(obj, function(k, v) {
                var href = $(v).attr('href');
                if (href == url) {
                    $(v).parent().addClass('active').siblings("ul.sidebar-menu li ul li").removeClass('active');
                    $(v).parent().parent().parent().addClass('active').siblings("ul.sidebar-menu li").removeClass('active');
                }
            });
            //时间范围
            $("input[data='daterangepicker']").daterangepicker({
                opens: 'right', //日期选择框的弹出位置
                separator: ' ~ ',
                format: "YYYY-MM-DD",
            }, function(start, end, label) {
            });
            //日期选择插件
            $('input[data="datepicker"]').datetimepicker({
                language: 'zh-CN',
                format: 'yyyy-mm-dd',
                weekStart: 1,
                todayBtn: 0,
                autoclose: 1,
                todayHighlight: 0,
                startView: 2,
                minView: 2,
                forceParse: 0,
                showMeridian: 0
            });
            //周期选择
            $("input[data='weekpicker']").datetimepicker({
                language: 'zh-CN',
                format: 'yyyy-mm-dd',
                weekStart: 1,
                todayBtn: 0,
                autoclose: 1,
                todayHighlight: 0,
                startView: 2,
                minView: 2,
                forceParse: 0,
                showMeridian: 0
            });
            //月份选择插件
            $('input[data="monthpicker"]').datetimepicker({
                language: 'zh-CN',
                weekStart: 1,
                todayBtn: 0,
                autoclose: 1,
                todayHighlight: 0,
                startView: 4,
                minView: 3,
                forceParse: 0,
                format: 'yyyy-mm'
            });
            $('input[data="yearpicker"]').datetimepicker({
                language: 'zh-CN',
                weekStart: 1,
                todayBtn: 0,
                autoclose: 1,
                todayHighlight: 0,
                startView: 4,
                minView: 4,
                forceParse: 0,
                format: 'yyyy'
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
