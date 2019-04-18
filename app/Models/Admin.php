<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    public $timestamps = false;
    protected $table = 'admin';

    //获取所有数据
    public static function getDatas($option = '',$select='*')
    {
        $items = self::where('delete',1)->select($select)->get();
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
    public static function Saved($data = [],$id=0)
    {
        $item = self::find($id);
        if (!$data) return false;
        if (!$id) $item = new self;
        foreach ($data['data'] as $k => $v)
        {
            $item->$k = $v;
        }
        if ($item->save()) return true;
    }

    public static function getData($id,$select='*'){
        if (!$id) return '';
        $adminData = Admin::where('id',$id)->select($select)->first();
        return $adminData;
    }
}
