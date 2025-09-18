<?php
namespace App\Controller;

use App\Auth;
use App\News;

class NewsController {
    private $news;
    private $user;

    public function __construct(\PDO $db)
    {
        $this->news = new News($db);
        $this->user = Auth::user();
    }

    // fő entry point
    public function handle()
    {
        if (!Auth::check()) {
            header('Location: /');
            exit;
        }

        include __DIR__ . '/../../public/news.php';
    }

    // AJAX: új hír létrehozása
    public function create($title, $body)
    {
        return $this->news->create($title, $body, $this->user);
    }

    // AJAX: hír frissítése
    public function update($id, $title, $body)
    {
        return $this->news->update((int)$id, $title, $body);
    }

    // AJAX: hír törlése
    public function delete($id)
    {
        return $this->news->delete((int)$id);
    }

    // hírek lekérése JSON-ban (AJAX)
    public function allJson()
    {
        header('Content-Type: application/json');
        echo json_encode($this->news->all());
    }
}
