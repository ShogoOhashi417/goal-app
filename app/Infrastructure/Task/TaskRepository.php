<?php

namespace App\Infrastructure\Task;

use App\Models\Task;
use App\Infrastructure\Task\TaskRepositoryInterface;

class TaskRepository implements TaskRepositoryInterface {
    const PAGE_LENGTH = 10;

    public function fetchTaskInfo(int $userId)
    {
        return Task::where('user_id', $userId)->paginate(self::PAGE_LENGTH);
    }
}