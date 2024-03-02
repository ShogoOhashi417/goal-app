<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TestService\TestService;

class TestController extends Controller
{
    public function index()
    {
        $testService = app()->makeWith('App\TestService\TestService', [
            'message' => 'Hello!!',
            'data' => ['Hello', 'GoodBye']
        ]);

        dd($testService->getId());

        return view('welcome');
    }
}
