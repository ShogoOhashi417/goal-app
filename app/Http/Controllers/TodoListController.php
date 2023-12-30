<?php

namespace App\Http\Controllers;

use App\Models\TodoList;
use Illuminate\Http\Request;

class TodoListController extends Controller
{
    public function index(Request $request)
    {
        $todo_list = TodoList::all();

        return view('todo_list',
            [
                'todo_list' => $todo_list
            ]);
    }
}
