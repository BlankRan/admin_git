<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class IpNode extends Model
{
    public $timestamps = false;
    protected $table = 'ip_node';

    //保存数据(新建数据)
    public static function Saved($data = '',$appsId=0)
    {
        if (!$data || !$appsId) return false;
        DB::beginTransaction();
        try{
            foreach ($data['data'] as $k)
            {
                $item = new self;
                $item->apps_id = $appsId;
                $item->ip = $k;
                $item->save();
            }
        }catch (\Exception $e){
            DB::rollBack();
        }
        DB::commit();
        return true;
    }



}
