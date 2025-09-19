<?php

namespace App\Controller;

use App\Service\AuthService;
use App\Service\NewsService;
use App\Traits\JsonResponseTrait;
use App\Enums\NewsResponseEnum;

class NewsController
{
    use JsonResponseTrait;

    private NewsService $service;
    private AuthService $authService;

    public function __construct(NewsService $service, AuthService $authService)
    {
        $this->service = $service;
        $this->authService = $authService;
    }

    public function index(): void
    {
        if (!$this->authService->check()) {
            $this->authService->redirect('/');
        }

        include __DIR__ . '/../../public/news.php';
    }

    public function indexJson(): void
    {
        $this->jsonSuccess($this->service->getAllNews());
    }

    public function create(string $title, string $body): void
    {
        $isCreated = $this->service->createNews($title, $body, $this->authService->user());
        $isCreated
            ? $this->jsonSuccess(null, NewsResponseEnum::CREATED_SUCCESS->value)
            : $this->jsonError(NewsResponseEnum::CREATED_ERROR->value);
    }

    public function update(int $id, string $title, string $body): void
    {
        $isUpdated = $this->service->updateNews($id, $title, $body);
        $isUpdated
            ? $this->jsonSuccess(null, NewsResponseEnum::UPDATED_SUCCESS->value)
            : $this->jsonError(NewsResponseEnum::UPDATED_ERROR->value);
    }

    public function delete(int $id): void
    {
        $isDeleted = $this->service->deleteNews($id);
        $isDeleted
            ? $this->jsonSuccess(null, NewsResponseEnum::DELETED_SUCCESS->value)
            : $this->jsonError(NewsResponseEnum::DELETED_ERROR->value);
    }
}
