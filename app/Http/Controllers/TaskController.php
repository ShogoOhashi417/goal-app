<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use DateTime;
use Carbon\Carbon;
use App\Application\UseCase\Task\Read\ReadTaskUseCase;
use App\Infrastructure\Task\TaskRepository;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        $readTaskUseCase = new ReadTaskUseCase(
            new TaskRepository()
        );

        $task_list = $readTaskUseCase->handle();

        return view('task',
            [
                'task_list' => $task_list
            ]);
    }

    public function get()
    {
        $readTaskUseCase = new ReadTaskUseCase(
            new TaskRepository()
        );

        $taskList = $readTaskUseCase->handle();

        return [
            'task_list' => $taskList
        ];
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

    public function update(Request $request)
    {
        $task = Task::find($request->id);
        $task->update([
            'name' => $request->name,
            'dead_line' => $request->dead_line,
            'updated_at' => new DateTime()
        ]);

        return redirect('/task');
    }

    public function remove(Request $request)
    {
        Task::find($request->id)->delete();
    }
}
