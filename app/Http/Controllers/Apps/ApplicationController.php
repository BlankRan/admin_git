<?php

namespace App\Http\Controllers\Apps;

use App\Models\Apps;
use App\Models\IpNode;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ApplicationController extends Controller
{
    public function save()
    {
        $id = $this->params['id'] ?? 0;
        $time = date('Y-m-d H:i:s');
        $data['data'] = [
            'name' => $this->params['name'],
            'domain_name' => $this->params['domain_name'],
            'git_url' => $this->params['git_url'],
            'directory' => $this->params['directory'],
            'server_account' => $this->params['server_account'],
            'init' => $this->params['init'],
            'composer' => $this->params['composer'],
            'created_at'=>$time,
            'updated_at'=>$time,
        ];
        $node['data'] = $this->params['node'];
        $savedId = Apps::Saved($data,$id);
        $saveNode = IpNode::Saved($node,$savedId);
        if ($saveNode) $this->showCodeMassage($this->SUCCESS,'添加成功！');
        $this->showCodeMassage($this->FAILED,'添加失败！');
    }

    public function json()
    {
        $where = array();
        if (isset($this->params['app_id'])) $where['id'] = $this->params['app_id'];
        if (isset($this->params['app_name'])) $where['name'] = $this->params['app_name'];
        if (isset($this->params['domain_name'])) $where['domain_name'] = $this->params['domain_name'];
        $items = Apps::getDatas($where);
        $this->data = $items;
        $this->returnJsonData();
    }

    public function del()
    {
        $id = intval($this->params['id']);
        $item = Apps::find($id);
        if ($item->delete()) $this->showCodeMassage($this->SUCCESS,'已删除！');
        $this->showCodeMassage($this->FAILED,'删除失败！');

    }

    public function edit($id)
    {
        $id = intval($id);
        $item = Apps::getData($id);
        $ips=[];
        foreach ($item->ipNode as $v)
        {
            $ips[] = $v->ip;
        }
        if (empty($item)) echo '数据获取失败';
        return view('apps.edit',compact(['item','ips']));
    }
}
