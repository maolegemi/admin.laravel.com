<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
 */

Route::get('/', function () {
    return redirect()->route('admin.admin.home');
});
//登录控制路由
Route::group(['prefix' => 'admin', 'namespace' => 'Admin'], function () {
    Route::controller('login', 'LoginController', [
        'getLogin'  => 'admin.login.login',
        'getLogout' => 'admin.login.logout',
    ]);
});
//用户中心路由
Route::group(['middleware' => 'CAS', 'prefix' => 'admin', 'namespace' => 'Admin'], function () {
    Route::controller('admin', 'AdminController', [
        'getHome' => 'admin.admin.home',
        'getAuth' => 'admin.admin.auth',
    ]);
});
//运营数据路由
Route::group(['middleware' => 'CAS', 'prefix' => 'operation', 'namespace' => 'Operation'], function () {
    Route::controller('booking', 'BookingController', [
        'getOnline' => 'operation.booking.online',
        'getDetail' => 'operation.booking.detail',
    ]);
    Route::controller('doctor', 'DoctorController', [
        'getKpi' => 'operation.doctor.kpi',
        // 'getLevel' => 'doctor.level',
    ]);
    Route::controller('shop', 'ShopController', [
        'getKpi' => 'operation.shop.kpi',
    ]);
});
//药品数据路由
Route::group(['middleware' => 'CAS', 'prefix' => 'drug', 'namespace' => 'Drug'], function () {
    Route::controller('drug', 'DrugController', [
        'getPurchase' => 'drug.drug.purchase',
        'getConsume'  => 'drug.drug.consume',
    ]);
});
//二维码数据路由
Route::group(['middleware' => 'CAS', 'prefix' => 'qrcode', 'namespace' => 'Qrcode'], function () {
    Route::controller('qrcode', 'QrcodeController', [
        'getLive'   => 'qrcode.qrcode.live',
        'getDoctor' => 'qrcode.qrcode.doctor',
        'getShop'   => 'qrcode.qrcode.shop',
        'getCity'   => 'qrcode.qrcode.city',
    ]);
});
//轻问诊数据路由
Route::group(['middleware' => 'CAS', 'prefix' => 'qingchat', 'namespace' => 'QingChat'], function () {
    Route::controller('doctor', 'DoctorController', [
        'getKpi' => 'qingchat.doctor.kpi',
    ]);
    Route::controller('city', 'CityController', [
        'getScan' => 'qingchat.city.scan',
    ]);
});

//医馆统计路由
Route::group(['middleware' => 'CAS', 'prefix' => 'clinic', 'namespace' => 'Clinic'], function () {
    Route::controller('shop', 'ShopController', [
        'getOperate' => 'clinic.shop.operate',
        'getPatient' => 'clinic.shop.patient',
        'getReport'  => 'clinic.shop.report',
    ]);
});
//医生业绩路由
Route::group(['middleware' => 'CAS', 'prefix' => 'doctor', 'namespace' => 'Doctor'], function () {
    Route::controller('doctor', 'DoctorController', [
        'getKpi'   => 'doctor.doctor.kpi',
        'getMulti' => 'doctor.doctor.multi',
    ]);
});
//流量分析数据路由
Route::group(['middleware' => 'CAS', 'prefix' => 'traffic', 'namespace' => 'Traffic'], function () {
    Route::controller('traffic', 'TrafficController', [
        'getTrend'  => 'traffic.traffic.trend',
        'getSource' => 'traffic.traffic.source',
    ]);

});

//财务数据路由
Route::group(['middleware' => 'CAS', 'prefix' => 'financial', 'namespace' => 'Financial'], function () {
    Route::controller('shop', 'ShopController', [
        'getOperate' => 'financial.shop.operate',
    ]);

});
