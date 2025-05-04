<?php

class Blacklist
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    // Получить всех заблокированных пользователей
    public function getBlacklistedUsers()
    {
        $stmt = $this->pdo->query("SELECT * FROM blacklist");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Добавить пользователя в черный список
    public function addToBlacklist($user_id, $reason)
    {
        $stmt = $this->pdo->prepare("INSERT INTO blacklist (user_id, reason) VALUES (:user_id, :reason)");
        return $stmt->execute([
            'user_id' => $user_id,
            'reason' => $reason
        ]);
    }

    // Удалить пользователя из черного списка
    public function removeFromBlacklist($user_id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM blacklist WHERE user_id = :user_id");
        return $stmt->execute(['user_id' => $user_id]);
    }
}