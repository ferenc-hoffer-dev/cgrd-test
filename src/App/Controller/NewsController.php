<?php

namespace App\Controller;

use App\Service\AuthService;
use App\Service\NewsService;
use App\Traits\JsonResponseTrait;

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

    public function handle(): void
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
        $ok = $this->service->createNews($title, $body, $this->authService->user());
        $ok ? $this->jsonSuccess(null, 'News created') : $this->jsonError('Create failed');
    }

    public function update(int $id, string $title, string $body): void
    {
        $ok = $this->service->updateNews($id, $title, $body);
        $ok ? $this->jsonSuccess(null, 'News updated') : $this->jsonError('Update failed');
    }

    public function delete(int $id): void
    {
        $ok = $this->service->deleteNews($id);
        $ok ? $this->jsonSuccess(null, 'News deleted') : $this->jsonError('Delete failed');
    }
}
