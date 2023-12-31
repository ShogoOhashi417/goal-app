<?php

namespace App\Http\Controllers;

use App\Models\TodoList;
use Illuminate\Http\Request;
use DateTime;

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

    public function create(Request $request)
    {
        TodoList::insert([
            'name' => $request->name,
            'dead_line' => $request->dead_line,
            'created_at' => new DateTime(),
            'updated_at' => new DateTime()
        ]);

        $todo_list = TodoList::all();

        return view('todo_list',
            [
                'todo_list' => $todo_list
            ]
        );
    }
}
