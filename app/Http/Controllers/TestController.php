<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TestController extends Controller
{
    public function __invoke(Request $request, Response $reponse) {

        return view('test', ['data' => $request->data]);
        // return view('test', ['data' => [['name'=>'山田太郎', 'mail' => 'lbridgeatnoon9617@icloud.com'], ['name'=>'山田太郎', 'mail' => 'lbridgeatnoon9617@icloud.com']]]);
    
        // return <<< EOF
        //     <div>{$request}</div>
        //     <div>{$reponse}</div>
        // EOF;
    }
}
