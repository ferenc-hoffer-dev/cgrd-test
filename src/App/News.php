<?php
namespace App;

use PDO;

class News {
    private $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function all(): array {
        return $this->pdo->query("SELECT * FROM news ORDER BY created_at DESC")->fetchAll();
    }

    public function create(string $title, string $body, string $author): bool {
        $stmt = $this->pdo->prepare("INSERT INTO news (title, body, author) VALUES (:t, :b, :a)");
        return $stmt->execute(['t' => $title, 'b' => $body, 'a' => $author]);
    }

    public function update(int $id, string $title, string $body): bool {
        $stmt = $this->pdo->prepare("UPDATE news SET title = :t, body = :b WHERE id = :id");
        return $stmt->execute(['t' => $title, 'b' => $body, 'id' => $id]);
    }

    public function delete(int $id): bool {
        $stmt = $this->pdo->prepare("DELETE FROM news WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }
}
