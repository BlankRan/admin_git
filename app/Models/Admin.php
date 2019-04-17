<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    public $timestamps = false;
    protected $table = 'admin';

    //获取所有数据
    public static function getData($option = '')
    {
        $items = self::where('delete',1)->get();
        $data = array('code'=>0,'msg'=>'','count'=>0);
        $data['data'] = array();
        foreach($items as $item)
        {
            $data['data'][  ] =array(
                'id' => $item->id,
                'username' => $item->username,
                'phone' => $item->phone,
                'email' => $item->email,
                'created_at' => $item->created_at,
                'status' => $item->status
            );
        }
        return $data;
    }

    //保存数据(新建数据)
    public static function Saved($data = [])
    {
        if (!$data) return false;
        $item = new Admin;
        foreach ($data['data'] as $k => $v)
        {
            $item->$k = $v;
        }
        if ($item->save()) return true;
    }
}
