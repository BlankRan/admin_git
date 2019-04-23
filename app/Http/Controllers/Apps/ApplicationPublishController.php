<?php

namespace App\Http\Controllers\Apps;

use App\Models\AppLog;
use App\Models\Apps;
use App\Models\IpNode;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ApplicationPublishController extends Controller
{
    public function list(){
        return view('publish.list');
    }

    public function json(){
        $appDatas = Apps::getDatas();

//        $appLogs = IpNode::getDatas();
//        foreach ($appLogs['data'] as $appLog)
//        {
//            $appDatas['data'][] = $appLog;
//        }
        $this->data = $appDatas;
        $this->returnJsonData();
    }
}
