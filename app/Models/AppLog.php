<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AppLog extends Model
{
    public $timestamps = false;
    protected $table = 'app_log';
    public static function getDatas($option = [],$select='*')
    {
        $items = self::where($option)->select($select)->get();
        $data['data'] = array();
        foreach($items as $item)
        {
            $data['data'][  ] =array(
                'id' => $item->id,
                'apps_id' => $item->apps_id,
//                'admin_id' => $item->admin_id,
                'commit_id' => $item->commit_id,
                'last_commit_id' => $item->last_commit_id,
                'remark' => $item->remark,
                'created_at' => $item->created_at,
                'updated_at' => $item->updated_at,
            );
        }
        return $data;
    }
}
