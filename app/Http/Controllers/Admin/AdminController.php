<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Common\BasicController;

class AdminController extends BasicController
{
    //
    public function getHome()
    {
        $data         = [];
        $data['init'] = [
            'db_host'         => env('DB_HOST_DBCENTER'),
            'db_name'         => env('DB_DATABASE_DBCENTER'),
            'db_user'         => env('DB_USERNAME_DBCENTER'),
            'cgi_path'        => env('CGI_PATH'),
            'cas_path'        => env('CAS_HOST'),
            'os'              => $_SERVER['OS'],
            'software'        => $_SERVER['SERVER_SOFTWARE'],
            'http_host'       => $_SERVER['HTTP_HOST'],
            'server_addr'     => $_SERVER['SERVER_ADDR'],
        ];
        return View('admin.home', compact('data'));
    }
    //
    public function getAuth(){
       $data = [];
       return View('admin.auth', compact('data'));
    }
}
