CREATE DATABASE IF NOT EXISTS news_app CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE news_app;

CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO users (username, password_hash)
VALUES ('admin', '$2y$10$k9UdC2ErI8YIZv..g7mAseNmrSnGZ/HwzFxInA4L8ZkXxOdyHZYYa');

CREATE TABLE IF NOT EXISTS news (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    body TEXT NOT NULL,
    author VARCHAR(100) DEFAULT 'admin',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

INSERT INTO news (title, body, author)
VALUES ('First news', 'First news in a system.', 'admin');
