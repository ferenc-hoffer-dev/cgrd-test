<?php
namespace App\Controller;

use App\News;
use App\Traits\JsonResponseTrait;

class NewsController extends BaseController {
    use JsonResponseTrait;
    private News $news;

    public function __construct(\PDO $pdo) {
        parent::__construct($pdo);
        $this->news = new News($pdo);
    }

    public function handle(): void {
        if (!$this->isAuthenticated()) {
            $this->redirect('/');
        }

        include __DIR__ . '/../../public/news.php';
    }

    public function indexJson(): void {
        $news = $this->news->all();
        $this->jsonSuccess($news);
    }

    public function create(string $title, string $body): void {
        $ok = $this->news->create($title, $body, $this->getCurrentUser());
        $ok ? $this->jsonSuccess(null, 'News created') : $this->jsonError('Create failed');
    }

    public function update(int $id, string $title, string $body): void {
        $ok = $this->news->update($id, $title, $body);
        $ok ? $this->jsonSuccess(null, 'News updated') : $this->jsonError('Update failed');
    }

    public function delete(int $id): void {
        $ok = $this->news->delete($id);
        $ok ? $this->jsonSuccess(null, 'News deleted') : $this->jsonError('Delete failed');
    }
}
