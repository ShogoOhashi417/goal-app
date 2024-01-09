<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Requests\TestRequest;
use Validator;
use App\Facades\TestService;

class TestController extends Controller
{
    function __construct(Test $test)
    {
        $test = app('App\Http\Controllers\Test');
    }
    
    public function index(Request $request, Response $reponse) {

        // $test = app()->makeWith('App\Http\Controllers\Test', ['id'=>'指定された']);
        TestService::test();
        // return view('test', ['data' => $request->data]);
        return view('test', ['message' => "失敗", 'data' => [['name'=>'山田太郎', 'mail' => 'lbridgeatnoon9617@icloud.com'], ['name'=>'山田太郎', 'mail' => 'lbridgeatnoon9617@icloud.com']]]);
    
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
}

class Test implements TestInterface {

    // public function __construct($id)
    // {
    //     $this->num = rand();
    //     echo $this->num;
    //     $this->id = $id;
    // }

    public function test($id = "指定されていない") {
        echo $id;
    }
}

interface TestInterface {
    public function test();
}