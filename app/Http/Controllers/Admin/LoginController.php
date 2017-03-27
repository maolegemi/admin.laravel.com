<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Models\Common\Curl;
use Session;

class LoginController extends Controller
{
    //
    public function __construct(Request $request)
    {
        $this->request = $request;
    }
    //
    public function getLogin()
    {
        extract($this->request->all());
        if (isset($ticket) && $ticket) {
            //1-登录成功,把ticket存到session
            Session::set('ticket', $ticket);
            Session::save();
            //2-更新用户+权限+ticket是否失效
            $curl   = new Curl();
            $host   = env('CAS_HOST', 'http://cas.gstzy.cn');
            $method = config('cas.api.validate');
            $url    = $host . $method;
            $param  = [
                'host'   => env('HOST', 'data.gstzy.cn'),
                'secret' => env('CAS_SECRET', 123456),
                'ticket' => $ticket,
            ];
            $cgi_data = $curl->post($url, $param);
            $data     = json_decode($cgi_data, 1);
            //ticket无效,重新登录
            if ($data['status']) {
                //清空ticket
                Session::set('ticket',null);
                Session::save();
                return redirect()->route('admin.login.login');
            }
            //3-把用户信息+权限信息写进session
            $admin = [
                'admin_ticket'     => $ticket,
                'admin_id'         => $data['data']['id'],
                'admin_name'       => $data['data']['username'],
                'admin_email'      => $data['data']['email'],
                'admin_mobile'     => $data['data']['mobile'],
                'admin_realname'   => $data['data']['realname'],
                'admin_position'   => $data['data']['position'],
                'admin_header'     => $data['data']['avatar'],
                'admin_roles'      => $data['data']['roles'],
                'admin_permission' => $data['data']['permissions'],
            ];
            Session::set('admin',$admin);
            Session::save();
            return redirect()->route('admin.admin.home');
        }
        //跳转到CAS登录认证
        $url    = '';
        $host   = env('CAS_HOST', 'http://cas.gstzy.cn');
        $method = config('cas.user.login');
        $param  = [
            'host'         => env('HOST', 'data.gstzy.cn'),
            'redirect_uri' => route('admin.login.login'),
        ];
        $url = $host . $method . '?' . http_build_query($param);
        return redirect($url);

    }
    //
    public function getLogout()
    {
        $ticket = Session::get('ticket');
        //1-检查ticket是否存在
        if (empty($ticket)) {
            return redirect()->route('admin.login.login');
        }
        //2-检查ticket是否有效
        $curl   = new Curl();
        $host   = env('CAS_HOST', 'http://cas.gstzy.cn');
        $method = config('cas.api.validate');
        $url    = $host . $method;
        $param  = [
            'host'   => env('HOST', 'data.gstzy.cn'),
            'secret' => env('CAS_SECRET', 123456),
            'ticket' => $ticket,
        ];
        $cgi_data = $curl->post($url, $param);
        $data     = json_decode($cgi_data, 1);
        if ($data['status']) {
            //清空ticket
            Session::set('ticket',null);
            Session::save();
            return redirect()->route('admin.login.login');
        }
        //3-注销登录
        $url    = '';
        $host   = env('CAS_HOST', 'http://cas.gstzy.cn');
        $method = config('cas.user.logout');
        $param  = [
            'host'         => env('HOST', 'data.gstzy.cn'),
            'redirect_uri' => route('admin.login.login'),
            'ticket'       => $ticket,
            'secret'       => env('CAS_SECRET', 123456),
        ];
        $url = $host . $method . '?' . http_build_query($param);
        Session::set('ticket', null);
        Session::save();
        return redirect($url);
    }
}
