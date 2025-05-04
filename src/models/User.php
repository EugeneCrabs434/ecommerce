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
    public function addUser($name, $email, $password, $role = 'user') { 
        try {
            $stmt = $this->pdo->prepare("
                INSERT INTO users (name, email, password, role) 
                VALUES (:name, :email, :password, :role)
            ");
            return $stmt->execute([
                'name' => $name,
                'email' => $email,
                'password' => $password,
                'role' => $role
            ]);
        } catch (PDOException $e) {
            error_log("Ошибка добавления пользователя: " . $e->getMessage());
            return false;
        }
    }

    // Обновить пользователя
    public function updateUser($id, $data) {
        $stmt = $this->pdo->prepare("
            UPDATE users SET name = :name, email = :email, password = :password, role = :role WHERE id = :id
        ");
        return $stmt->execute([
            'id' => $id,
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $data['password'],
            'role' => $data['role']
        ]);
    }

    // Удалить пользователя
    public function deleteUser($id) {
        $stmt = $this->pdo->prepare("DELETE FROM users WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }
}