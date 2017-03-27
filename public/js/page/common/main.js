define(['domReady', 'app/common/common', 'app/common/base', 'underscore', 'bootstrap', 'AdminLTE','app/common/function'], function(domReady, common, base,score,boot,admin,fn) {
    var env, appMap, app;
    env = (window.location.host.indexOf('dev') !== -1 || window.location.search.indexOf('dev') !== -1) ? new base('dev') : new base('live');

    domReady(function() {
        // 加载公共JS
        common(env);

        // 根据Url 动态加载需要的SAP
        appMap = {
            //运营>预约
            'operation_booking_online': 'app/operation/booking/online',
            'operation_booking_detail': 'app/operation/booking/detail',
            //运营>医生
            'operation_doctor_kpi': 'app/operation/doctor/kpi',
            'operation_doctor_rank': 'app/operation/doctor/rank',
            //运营>门店
            'operation_shop_kpi': 'app/operation/shop/kpi',
            'operation_shop_menage': 'app/operation/shop/menage',
            // 药品分析
            'drug_drug_purchase': 'app/drug/drug/purchase',
            'drug_drug_consume': 'app/drug/drug/consume',
            // 扫码统计
            'qrcode_qrcode_doctor': 'app/qrcode/doctor/scan',
            'qrcode_qrcode_shop': 'app/qrcode/shop/scan',
            'qrcode_qrcode_city': 'app/qrcode/city/scan',
            //轻问诊
            'qingchat_doctor_kpi': 'app/qingchat/doctor/kpi',
            'qingchat_city_scan': 'app/qingchat/city/scan',
            //医馆统计
            'clinic_shop_operate': 'app/clinic/shop/operate',
            'clinic_shop_patient': 'app/clinic/shop/patient',
            'clinic_shop_report': 'app/clinic/shop/report',
            //医生数据
            'doctor_doctor_kpi': 'app/doctor/doctor/kpi',
            'doctor_visit': 'app/doctor_visit',
            //流量分析'
            'traffic_traffic_trend': 'app/traffic/traffic/trend',
            'traffic_traffic_source': 'app/traffic/traffic/source',
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
