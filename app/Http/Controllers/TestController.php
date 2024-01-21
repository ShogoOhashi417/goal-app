<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Requests\TestRequest;
use Validator;
use App\Facades\TestService;
use App\Jobs\Testjob;

class TestController extends Controller
{
    function __construct()
    {
        // $test = app('App\TestClasses\Test');
    }
    
    public function index(Request $request, Response $reponse, $message="hello", $name="shogo") {

        // Testjob::dispatch()->delay(now()->addSeconds(10));
        // $test = app()->makeWith('App\TestClasses\Test', ['id'=>'指定された']);
        // TestService::test();
        // return view('test', ['data' => $request->data]);
        $parameterList = [
            'message' => $message,
            'name' => $name
        ];
        return view('welcome', $parameterList);
    
        // return <<< EOF
        //     <div>{$request}</div>
        //     <div>{$reponse}</div>
        // EOF;
    }

    public function post(TestRequest $request, Response $reponse) {
        $validator = Validator::make($request->all(), [
            "name" => "required",
            "mail" => "email",
            "age" => "numeric"
        ]);

        if ($validator->fails()) {
            return redirect('/test')
            ->withErrors($validator)
            ->withInput();
        }

        return view('test', ['message'=>'成功！']);

        // $this->validate($request, $validate_rule);
        return view('test', ['message' => "成功！" ,'data' => [['name'=>'山田太郎', 'mail' => 'lbridgeatnoon9617@icloud.com'], ['name'=>'山田太郎', 'mail' => 'lbridgeatnoon9617@icloud.com']]]);
    }

    public function json() {
        return json_encode(['message' => 'わっしょい']);
    }
}