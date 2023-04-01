<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use http\Client\Response;
use Illuminate\Http\Request;

class verifyToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $token = $request->header('authorization');
        if(!$token) return response()->json([
            'msg'=>'No Authorization token is found'
        ],401);
        $dbUser = User::where('api_token', $token)->first();
        if(!$dbUser) return response()->json([
            'msg'=>'Invalid token!'
        ],401);
        $request->dbUser = $dbUser;
        return $next($request);
    }
}
