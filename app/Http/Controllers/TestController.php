<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TestService\TestService;

class TestController extends Controller
{
    public function index()
    {
        $testService = app('App\TestService\TestService');

        $testService->setId(1);
        dd($testService->getId());

        return view('welcome');
    }
}
