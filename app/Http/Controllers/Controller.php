<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function success($msg, $data = [])
    {
        return ['status' => true, 'msg' => $msg, 'data' => $data];
    }

    public function error($msg, $data = [])
    {
        return ['status' => false, 'msg' => $msg, 'data' => $data];
    }
}
