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
        $appDatas = Apps::getDatas([],'*',true);

//        $appLogs = IpNode::getDatas();
//        foreach ($appLogs['data'] as $appLog)
//        {
//            $appDatas['data'][] = $appLog;
//        }
        $this->data = $appDatas;
        $this->returnJsonData();
    }

    public function log(){
        print_r($this->params['id']);

    }
    public function rollback(){
        print_r($this->params['id']);

    }
    public function release(){
        $text = 'temp.sh';
        $str = "#!/bin/sh\n";
        $location = "cd /data/deploy/admin_git/\n";
        $shell = "git pull 2>&1\n";
//        $shell.="echo 1";
        $shells = $str.$location.$shell;
        file_put_contents($text,$shells);
        exec("sh ".$text, $result, $status);
        print_r($result);
        print_r($status);

    }
    public function quick(){
        print_r($this->params['id']);

    }
}
