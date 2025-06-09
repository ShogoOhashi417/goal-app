<?php

declare(strict_types=1);

namespace App\Application\UseCase\Task\Read;

use App\Infrastructure\Task\TaskRepositoryInterface;
use App\Application\Service\AuthService;

final class ReadTaskUseCase
{
    public function __construct(
        private readonly TaskRepositoryInterface $taskRepository,
        private readonly AuthService $authService
    ) {}

    public function handle(): array
    {
        $userId = $this->authService->getCurrentUserId();
        return $this->taskRepository->fetchTaskInfo($userId);
    }
}