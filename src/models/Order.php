<?php

class Order
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    // Получить все заказы
    public function getAllOrders()
    {
        $stmt = $this->pdo->query("SELECT * FROM orders");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Получить заказ по ID
    public function getOrderById($id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM orders WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Добавить новый заказ
    public function addOrder($user_id, $product_ids, $total_price)
    {
        $stmt = $this->pdo->prepare("INSERT INTO orders (user_id, product_ids, total_price) VALUES (:user_id, :product_ids, :total_price)");
        return $stmt->execute([
            'user_id' => $user_id,
            'product_ids' => json_encode($product_ids),
            'total_price' => $total_price
        ]);
    }

    // Обновить заказ
    public function updateOrder($id, $status)
    {
        $stmt = $this->pdo->prepare("UPDATE orders SET status = :status WHERE id = :id");
        return $stmt->execute([
            'id' => $id,
            'status' => $status
        ]);
    }

    // Удалить заказ
    public function deleteOrder($id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM orders WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }
}