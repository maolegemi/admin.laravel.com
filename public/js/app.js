requirejs.config({
    // enforceDefine: false, // 如果为True, 不是用define的script都会报错
    waitSeconds: 15, // 默认 7 秒
    urlArgs: "v=20161125" + "bust=" + (new Date()).getTime(),
    //urlArgs: "bust="+(new Date()).getTime(), // 阻止cache "bust="+(new Date()).getTime(),
    baseUrl: '/js', // 本文件的相对路径
    paths: {
        // 备错模式，当第一个不能成功加载的时候，从本地加载
        domReady: 'lib/domReady',
        jquery: ['lib/jquery-1.11.1.min', 'http://libs.baidu.com/jquery/1.11.1/jquery.min'],
        underscore: ['lib/underscore-min', 'http://apps.bdimg.com/libs/underscore.js/1.7.0/underscore-min'],
        bootstrap: 'plugin/bootstrap/js/bootstrap.min',
        select2: 'plugin/select2/select2.min',
        AdminLTE: 'plugin/AdminLTE/js/app.min',
        slimScroll:'plugin/slimScroll/jquery.slimscroll.min',
        daterangepicker:'plugin/daterangepicker/daterangepicker',
        datatables:'plugin/datatables/jquery.dataTables.min',
        moment: 'plugin/daterangepicker/moment',
        icheck: 'plugin/iCheck/icheck.min',
        chartjs: 'plugin/chartjs/Chart.min',
        echarts: 'plugin/echarts/echarts-all',
        app: 'page',
    },
    map: {
        '*': {
            'css': 'lib/css.min' // or whatever the path to require-css is
        }
    },
    shim: {
        underscore: { exports: "_" },
        AdminLTE:  { deps: ['bootstrap','css!plugin/AdminLTE/css/AdminLTE.min.css','css!plugin/AdminLTE/css/skins/_all-skins.min.css'] },
        slimScroll:{ deps: ['jquery'] },
        chartjs:{ deps: ['jquery'] },
        echarts:{ deps: ['jquery'] },
        select2:  { deps: ['jquery','css!plugin/select2/select2.min.css'] },
        bootstrap: { deps: ['jquery','css!plugin/bootstrap/css/bootstrap.min.css'] },
        daterangepicker: { deps: ['moment','jquery','css!plugin/daterangepicker/daterangepicker.css'] },
        datatables: { deps: ['jquery','css!plugin/datatables/jquery.dataTables.min.css'] },
        icheck: { deps: ['AdminLTE','css!plugin/iCheck/all.css'] },
    }
});

// SAP 加载页面内容
requirejs(['app/common/main']);
