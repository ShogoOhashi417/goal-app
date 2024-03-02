<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TestService\TestService;

class TestController extends Controller
{
    public function __construct()
    {
        app('App\TestService\TestService');
    }

    public function index()
    {
        $testService = app('App\TestService\TestService');

        dd($testService->getId());

        return view('welcome');
    }
}
