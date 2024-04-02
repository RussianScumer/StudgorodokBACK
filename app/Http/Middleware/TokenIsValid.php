<?php

namespace App\Http\Middleware;

use App\Models\Tokens;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\Middleware;
use Symfony\Component\HttpFoundation\Response;


class TokenIsValid
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */


    public function handle(Request $request, Closure $next): Response
    {
        $token = new Tokens();
        if(Tokens::where('acctoken',$request->header('acctoken'))->exists()) {
            $token->acctoken = Tokens::where('acctoken',$request->header('acctoken'));
        }
        if(isset($token->acctoken)){
            return $next($request);
        }
        else{
            abort(401);
        }
    }
}
