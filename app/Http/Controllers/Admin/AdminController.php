<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Common\BasicController;

class AdminController extends BasicController
{
    //
    public function getIndex(){
     
      return View('admin.index');
    }

    public function getPassword(){
     
      return View('admin.password');
    }
}
