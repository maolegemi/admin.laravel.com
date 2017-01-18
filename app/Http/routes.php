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
    return view('welcome');
});

Route::group(['prefix'=>'admin','namespace'=>'Admin'], function () {
    Route::controller('admin', 'AdminController', [
        'getIndex'  => 'admin.admin.index',
        'getPassword' => 'admin.admin.password'
    ]);

});

//运营数据路由
Route::group(['prefix' => 'operation', 'namespace' => 'Operation'], function () {
    Route::controller('booking', 'BookingController', [
        //'getIndex'  => 'operation.booking.index',
        'getDetail' => 'operation.booking.detail',
    ]);
    // Route::controller('doctor', 'DoctorController', [
    //     'getKpi'   => 'operation.doctor.kpi',
    //     'getRank'  => 'operation.doctor.rank',
    //     'getLevel' => 'doctor.level',

    // ]);
    // Route::controller('shop', 'ShopController', [
    //     'getIndex' => 'operation.shop.index',
    //     'getKpi'   => 'operation.shop.kpi',
    // ]);
});
//轻问诊数据路由
Route::group(['prefix' => 'qingchat', 'namespace' => 'QingChat'], function () {
    Route::controller('doctor', 'DoctorController', [
        'getKpi' => 'qingchat.doctor.kpi',
    ]);
});



//流量分析数据路由
Route::group(['prefix' => 'traffic', 'namespace' => 'Traffic'], function () {
    Route::controller('traffic', 'TrafficController', [
        'getTrend' => 'traffic.traffic.trend',
    ]);
    
});
