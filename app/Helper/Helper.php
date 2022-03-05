<?php

namespace App\Helper;

use App\Models\User;

class Helper{

    public static function returnResponse($status="1",$message="",$data=[])
    {
        $code = 201;
        if($status == 1){
            $code = 200;
        }
        return response()->json(['success' => $status, 'message' => $message,"result"=>$data], $code);
    }
}