<?php

class User {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // Получить всех пользователей
    public function getAllUsers() {
        $stmt = $this->pdo->query("SELECT * FROM users");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Добавить пользователя
    public function addUser($name, $email, $password) { 
        try {
            $stmt = $this->pdo->prepare("
                INSERT INTO users (name, email, password) 
                VALUES (:name, :email, :password)
            ");
            return $stmt->execute([
                'name' => $name,
                'email' => $email,
                'password' => $password
            ]);
        } catch (PDOException $e) {
            error_log("Ошибка добавления пользователя: " . $e->getMessage());
            return false;
        }
    }

    // Удалить пользователя
    public function deleteUser($id) {
        $stmt = $this->pdo->prepare("DELETE FROM users WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }
}