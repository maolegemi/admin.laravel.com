define(['domReady', 'app/common/common', 'app/common/base', 'underscore', 'bootstrap','AdminLTE'], function(domReady, common, base) {
    var env, appMap, app;
    env = (window.location.host.indexOf('dev') !== -1 || window.location.search.indexOf('dev') !== -1) ? new base('dev') : new base('live');

    domReady(function() {
        // 加载公共JS
        common(env);

        // 根据Url 动态加载需要的SAP
        appMap = {
            //运营>预约
            'operation_booking': 'app/operation/booking/index',
            'operation_booking_detail': 'app/operation/booking/detail',
            //运营>医生
            'operation_doctor_kpi': 'app/operation/doctor/kpi',
            'operation_doctor_rank': 'app/operation/doctor/rank',
            //运营>门店
            'operation_shop': 'app/operation/shop/index',
            'operation_shop_kpi': 'app/operation/shop/kpi',
            // 药品分析
            'drug_drug_consume': 'app/drug/drug/consume',
            'drug_drug_purchase': 'app/drug/drug/purchase',
            // 扫码统计
            'qrcode_d-shop': 'app/qrcode_shop',
            'qrcode_d-doctor': 'app/qrcode_doctor',
            'qrcode_d-city': 'app/qrcode_city',
            //轻问诊统计 add by lzb
            'qingchat_doctor_kpi':'app/qingchat/doctor/kpi',
            'qingchat_qrcode_scan':'app/qingchat/qrcode/scan',
            'fac_qing-chat-stat': 'app/qingchat_stat',
            //医馆统计 add by lzb
            'rep_income': 'app/rep_chart',
            'rep_service': 'app/rep_chart',
            'rep_operation': 'app/rep_chart',
            'rep_patient': 'app/rep_chart',
            //医生数据
            'doctor_charges': 'app/doctor_chart',
            'doctor_visit': 'app/doctor_visit',
            //流量分析'
            'traffic_traffic_trend': 'app/traffic/traffic/trend',
            'traffic_source': 'app/traffic_source',
        };
        // 检查Url
        var url = document.location.pathname;
        // 首页
        url = url === '/' ? 'default' : url.substr(1).replace(/\//g, '_');

        console.log('Your mapping Index is:%c ' + url, 'color:red;');

        if (_.has(appMap, url)) {
            app = _.property(url)(appMap);
            requirejs([app], function(pageApp) {
                if (_.indexOf(_.functions(pageApp), 'init') !== -1) {
                    pageApp.init.call(_.extend(env, pageApp));
                    // pageApp.init.apply(env);
                    // pageApp.init.bind(env)();
                } else if (typeof(pageApp) === 'function') {
                    var f = new pageApp();
                    f.init.call(env);
                }
            });
        }
    });
});