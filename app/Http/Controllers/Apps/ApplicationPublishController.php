<?php

namespace App\Http\Controllers\Apps;

use App\Models\AppLog;
use App\Models\Apps;
use App\Models\IpNode;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\App;

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
        $app = Apps::getData($this->params['id']);
        $location = "cd /data/test/admin_git/\n";
        $gitConfig = "git config --global user.email 'a@a.com'\ngit config --global user.name 'aaaa'";
        $shell = "git pull\n";
//        $shell.="echo 1";
        $shells = $str.$location.$shell.$gitConfig;
        file_put_contents($text,$shells);
        exec("sh ".$text, $result, $status);
        if ($status == 0 )
        {

        }
        print_r($result);
        print_r($status);
        //123456

    }
    public function quick(){
        print_r($this->params['id']);

    }
}
