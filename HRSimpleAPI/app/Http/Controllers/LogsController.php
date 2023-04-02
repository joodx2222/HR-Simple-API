<?php

namespace App\Http\Controllers;

use App\Models\UserLog;
use Illuminate\Http\Request;

class LogsController extends Controller
{
    public function index(Request $request)
    {
        $dbUserLogs = UserLog::whereDate('created_at', '=', $request->date)->orderBy('id', 'desc')->get();
        $dbUser = $request->dbUser;
        $this->createUserLog($dbUser->id, "User $dbUser->name that has Id $dbUser->id accessed the users logs on $request->date");
        return response()->json($dbUserLogs);
    }
}
