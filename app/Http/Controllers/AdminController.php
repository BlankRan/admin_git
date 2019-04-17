<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function json()
    {
        $items = Admin::getData();
        $this->data = $items;
        $this->returnJsonData();

    }

    public function add()
    {
        if ($this->params['loginpwd'] != $this->params['againpwd']){
            $this->showCodeMassage($this->FAILED,'两次登陆密码不一致！');
        }
        $pwd = $this->params['loginpwd']??'000000';
        $time = date('Y-m-d H:i:s', time());
        $data['data'] = [
            'username'=>$this->params['loginname']??'',
            'password'=>Hash::make($pwd),
//            'againpwd'=>$this->params['againpwd']??'000000',
            'email'=>$this->params['email']??'',
            'phone'=>$this->params['phone']??'',
            'git_account'=>$this->params['git_account']??'',
            'git_password'=>$this->params['git_password']??'',
            'created_at'=>$time,
            'updated_at'=>$time,
            'status'=>$this->params['status'],
        ];
        $saved = Admin::Saved($data);
        if ($saved) $this->showCodeMassage($this->SUCCESS,'添加成功！');
        $this->showCodeMassage($this->FAILED,'添加失败！');
    }
    //删除
    public function del(){
        $id = $this->params['id'];
        if ($id)
        {
            $admin = Admin::find($id);
            $admin->delete = -1;
            if ($admin->save()){
                $this->showCodeMassage($this->SUCCESS,'已删除');
            }
        }
    }

    public function edit(){
        print_r($this->params['id']);
    }

}
