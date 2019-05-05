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
        $this->data = $appDatas;
        $this->returnJsonData();
    }

    public function log(){
        print_r($this->params['id']);
    }
    public function rollback(){
        $text = 'temp.sh';
        $str = "#!/bin/sh\n";
        $id = $this->params['id'];
        $app = Apps::getData($this->params['id']);
        $shell = '';
        if (strpos($id,'-'))
        {
            $nodeId = explode('-',$id);
            $shell .= "ssh ".$app->server_account."@".$nodeId[1]."\n";
            $shell .= "cd ".$app->directory.$app->domain_name."\n";
            $shell .= "git config --global user.email 'a@a.com'\ngit config --global user.name 'aaaa'\n";
            $shell .= "git reset --hard HEAD^\n";
            $shells = $str.$shell;
        }else
        {
            if ($app->ipNode)
            {
                foreach($app->ipNode as $node)
                {
                    $shell .= "ssh ".$app->server_account."@".$node->ip."\n";
                    $shell .= "cd ".$app->directory."\n";
                    $shell .= "git config --global user.email 'a@a.com'\ngit config --global user.name 'aaaa'\n";
                    $shell .= "git reset --hard HEAD^\n";
                    $shells = $str.$shell;
                }
            }
        }
        file_put_contents($text,$shells);
        exec("sh ".$text, $result, $status);

    }
    public function release(){
        $text = 'temp.sh';
        $str = "#!/bin/sh\n";
        $id = $this->params['id'];
        $app = Apps::getData($this->params['id']);
        $init = $app->init;
        $composer = $app->composer;
        $shell = '';
        if (strpos($id,'-'))
        {
            $nodeId = explode('-',$id);
            $shell .= "ssh ".$app->server_account."@".$nodeId[1]."\n";
            $shell .= "cd ".$app->directory."\n";
            $shell .= "git config --global user.email 'a@a.com'\ngit config --global user.name 'aaaa'\n";
            if ($init == 1) $shell .= "git clone ".$app->git_url."\n";
            if ($composer == 1) $shell .="composer install\n";
            $shell .= "git checkout -b origin master\n";
            $shell .= "git pull\n";
            $shells = $str.$shell;
        }else
        {
            if ($app->ipNode)
            {
                foreach($app->ipNode as $node)
                {
                    $shell .= "ssh ".$app->server_account."@".$node->ip."\n";
                    $shell .= "cd ".$app->directory."\n";
                    $shell .= "git config --global user.email 'a@a.com'\ngit config --global user.name 'aaaa'\n";
                    if ($init == 1) $shell .= "git clone ".$app->git_url."\n";
                    if ($composer == 1) $shell .="composer install\n";
                    $shell .= "git checkout -b origin master\n";
                    $shell .= "git pull\n";
                    $shells = $str.$shell;
                }
            }
        }
        file_put_contents($text,$shells);
        exec("sh ".$text, $result, $status);
        $app->composer = -1;
        $app->init = -1;
        $app->save();
        print_r($result);
        print_r($status);
        //123456

    }
    public function quick(){
        $text = 'temp.sh';
        $str = "#!/bin/sh\n";
        $id = $this->params['id'];
        $app = Apps::getData($this->params['id']);
        $version = $this->params['commit_id'];
        if (empty($version)) $this->showCodeMassage(999,'回退失败');
        $shell = '';
        if (strpos($id,'-'))
        {
            $nodeId = explode('-',$id);
            $shell .= "ssh ".$app->server_account."@".$nodeId[1]."\n";
            $shell .= "cd ".$app->directory.$app->domain_name."\n";
            $shell .= "git config --global user.email 'a@a.com'\ngit config --global user.name 'aaaa'\n";
            $shell .= "git reset --hard ".$version."\n";
            $shells = $str.$shell;
        }else
        {
            if ($app->ipNode)
            {
                foreach($app->ipNode as $node)
                {
                    $shell .= "ssh ".$app->server_account."@".$node->ip."\n";
                    $shell .= "cd ".$app->directory."\n";
                    $shell .= "git config --global user.email 'a@a.com'\ngit config --global user.name 'aaaa'\n";
                    $shell .= "git reset --hard ".$version."\n";
                    $shells = $str.$shell;
                }
            }
        }
        file_put_contents($text,$shells);
        exec("sh ".$text, $result, $status);


    }
}
