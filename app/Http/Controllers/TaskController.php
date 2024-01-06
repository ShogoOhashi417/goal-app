<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use DateTime;

class TaskController extends Controller
{
    const PAGE_LENGTH = 10;
    
    public function index(Request $request)
    {
        $task_list = Task::paginate(self::PAGE_LENGTH);

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

        return redirect('/task');
    }

    public function remove(Request $request)
    {
        Task::find($request->task_id)->delete();

        return redirect('/task');
    }
}
