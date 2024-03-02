<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TestService\TestService;

class TestController extends Controller
{
    public function index(TestService $testService)
    {
        dd($testService->say());
        return view('welcome');
    }
}
