<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use DateTime;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        $task_list = Task::all();

        return view('task',
            [
                'task_list' => $task_list
            ]);
    }

    public function create(Request $request)
    {
        Task::insert([
            'name' => $request->name,
            'dead_line' => $request->dead_line,
            'created_at' => new DateTime(),
            'updated_at' => new DateTime()
        ]);

        $task_list = Task::all();

        return view('task',
            [
                'task_list' => $task_list
            ]
        );
    }
}
