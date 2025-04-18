<?php

namespace App\Http\Controllers;

use function Illuminate\Tests\Integration\Routing\fail;

abstract class Controller
{

    function resourcefetch($data, $message = '', $status = 201) {
        return response()->json([
            'status'=>true,
            'data' => $data,
            'message' => $message,
        ],$status);
    }


    function resourcecreated($data, $message = '', $status = 202) {
        return response()->json([
            'status'=>true,
            'data' => $data,
            'message' => $message,
        ],$status);
    }



    function validation($data,$message = '', $status = 404) {
         return response()->json([
            'status'=>false,
            'data' => $data,
            'message' => $message,
        ],$status);


    }
    function error($message = '', $status = 500) {
        return response()->json([
            'status'=>false,
            'message' => $message,
        ],$status);
    }
}
