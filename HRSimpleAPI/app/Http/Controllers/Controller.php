<?php

namespace App\Http\Controllers;

use App\Models\UserLog;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Log;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function sendValidationError($message){
        return response()->json([
            'msg'=>$message
        ], 400);
    }

    public function createUserLog($userId, $text){
        UserLog::create([
            'text'=>$text,
            'userId'=>$userId
        ]);
        Log::channel('users')->info($text);
    }
}
