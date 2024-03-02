<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TestService\TestService;

class TestController extends Controller
{
    public function index()
    {
        $testService = app('App\TestService\TestService');
        // もしくは
        $testService = app()->make('App\TestService\TestService');
        // もしくは
        $testService = resolve('App\TestService\TestService');

        // newすればいいのだが、シングルトンパターンだとそうもいかない
        dd($testService->say());
        return view('welcome');
    }
}
