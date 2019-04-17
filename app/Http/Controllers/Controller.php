<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Session;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public $params;
    public $pageSize;
    public $filed;
    public $order;
    public $data;
    public $SUCCESS = 200;
    public $FAILED = 0;


    const PAGE_SIZE = 30;
    const SUCCESS = 200;
    const FAILED = 0;

    public function __construct(Request $request)
    {
        $id = Session::get('session_id');
        $this->params = $request->all();
        $this->field = $request->get('field') ? $request->get('field') : 'id';
        $this->order = $request->get('order') ? $request->get('order') : 'desc';
        $this->pageSize = $request->get('limit') ? $request->get('limit') : self::PAGE_SIZE;
    }

    public function showCodeMassage($code,$msg,$data='')
    {
        header('Content-type: application/json;charset=utf-8');
        $message = array('code' => $code, 'msg' => $msg, 'data' => $data);
        echo json_encode($message);
        exit(0);
    }

    public function returnJsonData($message = array())
    {
        header('Content-type: application/json;charset=utf-8');
        echo json_encode($this->data ? $this->data : $message);
        exit(0);
    }
}
