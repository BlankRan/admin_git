<?php

namespace App\Http\Controllers\Apps;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;
use Session;

class AdminController extends Controller
{
    public function json()
    {
        $items = Admin::getDatas();
        $this->data = $items;
        $this->returnJsonData();
    }

    public function add()
    {
        $id = $this->params['id'] ?? 0;
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
        $saved = Admin::Saved($data,$id);
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

    public function edit($id){
        $adminData = Admin::getData($id);
        return view('user.edit',compact(['adminData']));
    }

    public function status()
    {
        $id=$this->params['id'];
        if (!$id) $this->showCodeMassage(0,'');
        $item = Admin::find($id);
        $item->status = $this->params['status'] ?? -1;
        if ($item->save()){
            $this->showCodeMassage(200,'');
        }
    }
    public function index()
    {
        $id = Session::get('session_id');
        print_r($id);
        if ($id){
            $item = Admin::find($id);
            return view('index')->with('item',$item);
        }
    }
}
