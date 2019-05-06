<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Apps extends Model
{
    public $timestamps = false;
    protected $table = 'apps';

    //保存数据(新建数据)
    public static function Saved($data = [],$id=0)
    {
        $item = self::find($id);
        if (!$data) return false;
        if (!$id) $item = new self;
        if($id){
            IpNode::where('apps_id',$id)->delete();
        }
        foreach ($data['data'] as $k => $v)
        {
            if ($id && $k=='update_at') continue;
            $item->$k = $v;
        }
        if ($item->save()) return $item->id;
        return false;
    }

    public static function getDatas($option = [],$select='*',$node=false)
    {
        $items = self::where($option)->select($select)->get();
        $data = array('code'=>0,'msg'=>'','count'=>$items->count());
        $data['data'] = array();
        foreach($items as $item)
        {
            $number = IpNode::select('id')->where('apps_id',$item->id)->count();
            $data['data'][  ] =array(
                'id' => $item->id,
                'name' => $item->name,
                'domain_name' => $item->domain_name,
                'git_url' => $item->git_url,
                'directory' => $item->directory,
                'init' => $item->init,
                'composer' => $item->composer,
                'created_at' => $item->created_at,
                'updated_at' => $item->updated_at,
                'pid' => 0,
                'number' => $number,
            );
            if ($item->ipNode && $node)
            {
                foreach($item->ipNode as $v)
                {
                    $data['data'][] = array(
                        'name' => $item->name,
                        'domain_name' => $item->domain_name,
                        'id' => $item->id.'-'.$v->id,
                        'ip' => $v->ip,
                        'pid' => intval($v->apps_id),
                        'remark' => $v->remark,
                    );
                }
            }
        }
        return $data;
    }

    public static function getData($id = 0,$select = '*'){
            if (!$id) return '';
            $item = self::where('id',$id)->select($select)->first();
            return $item;
    }
    public  function  ipNode()
    {
        return $this->hasMany(IpNode::class,'apps_id','id');
    }
}
