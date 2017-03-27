<?php
/**
 * Cgi 地址
 */
return [
    //'host' => env('APP_ENV', 'local') === 'live' ? 'http://cas.gstzy.cn' : 'http://cas-dev.gstzy.cn',
    'user' => [
        'login'  => '/login',
        'logout' => '/logout',
    ],
    'api' => [
        'auth'     => '/api/auth', //权限验证
        'validate' => '/api/validate', //获取用户信息
    ],
];
