<?php
/**
 * Cgi 地址
 */
return [
    'host' => env('APP_ENV', 'local') === 'live' ? 'http://cgi.gstzy.cn' : 'http://120.25.154.225',
    'user' => [
        'follow'         => '/cgi-bin/fans/buildfans2doctorrelation',
        'query2wechat'   => '/cgi-bin/user/query2wechat',
        'queryshop'      => '/cgi-bin/mix/queryshop', //查询门店
        'querycity'      => '/cgi-bin/mix/querycity', //查询城市
        'queryshop2dept' => '/cgi-bin/user/queryshop2dept', //4.1查询门店的科室
    ],
];
