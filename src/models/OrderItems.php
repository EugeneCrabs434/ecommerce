<?php

class OrderItem
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    // Получить все элементы заказа
    public function getAllOrderItems()
    {
        $stmt = $this->pdo->query("SELECT * FROM order_items");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Получить элементы заказа по ID заказа
    public function getOrderItemsByOrderId($order_id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM order_items WHERE order_id = :order_id");
        $stmt->execute(['order_id' => $order_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Добавить новый элемент заказа
    public function addOrderItem($order_id, $product_id, $quantity)
    {
        $stmt = $this->pdo->prepare("INSERT INTO order_items (order_id, product_id, quantity) VALUES (:order_id, :product_id, :quantity)");
        return $stmt->execute([
            'order_id' => $order_id,
            'product_id' => $product_id,
            'quantity' => $quantity
        ]);
    }

    // Обновить количество товара в заказе
    public function updateOrderItem($id, $quantity)
    {
        $stmt = $this->pdo->prepare("UPDATE order_items SET quantity = :quantity WHERE id = :id");
        return $stmt->execute([
            'id' => $id,
            'quantity' => $quantity
        ]);
    }

    // Удалить элемент заказа
    public function deleteOrderItem($id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM order_items WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }
}