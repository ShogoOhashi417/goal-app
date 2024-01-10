<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Facades\TestService;
use App\TestClasses\Test;

class HelloMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        TestService::test();
        $response = $next($request);
        $content = $response->content();

        $pattern = '置き換える';
        $replace = '置き換わった';

        $content = str_replace($pattern, $replace, $content);
        $response->setContent($content);
        return $response;

        $request->merge(['data' => $data]);
        return $next($request);
    }
}
