<?php

abstract class Controller {
    protected $pdo;
    protected $logger;
    
    public function __construct($pdo) {
        $this->pdo = $pdo;
        // TODO: Инициализировать логгер
    }
    
    protected function render($view, $data = []) {
        extract($data);
        require_once __DIR__ . "/../views/layouts/header.php";
        require_once __DIR__ . "/../views/{$view}.php";
        require_once __DIR__ . "/../views/layouts/footer.php";
    }
    
    protected function redirect($url) {
        header("Location: {$url}");
        exit;
    }
    
    protected function isPost() {
        return $_SERVER['REQUEST_METHOD'] === 'POST';
    }
    
    protected function getPostData() {
        return $_POST;
    }
    
    protected function getQueryParams() {
        return $_GET;
    }
    
    protected function requireAdmin() {
        if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
            header('HTTP/1.0 403 Forbidden');
            echo 'Доступ запрещён (только для администратора)';
            exit;
        }
    }

    protected function requireAuth() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /auth?action=login');
            exit;
        }
    }
    
    abstract public function handleRequest();
} 