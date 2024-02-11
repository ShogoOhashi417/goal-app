<?php

namespace App\Application\UseCase\Task\Read;

use App\Infrastructure\Task\TaskRepositoryInterface;

class ReadTaskUseCase {
    private readonly TaskRepositoryInterface $taskRepository;

    public function __construct(TaskRepositoryInterface $taskRepository)
    {
        $this->taskRepository = $taskRepository;
    }

    public function handle()
    {
        return $this->taskRepository->fetchTaskInfo();
    }
}