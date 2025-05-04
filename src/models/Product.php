<?php

class Product
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function getAllProducts()
    {
        $stmt = $this->pdo->query("SELECT * FROM products");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getProductById($id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM products WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function addProduct($name, $description, $price, $category)
    {
        $stmt = $this->pdo->prepare("INSERT INTO products (name, description, price, category) VALUES (:name, :description, :price, :category)");
        return $stmt->execute([
            'name' => $name,
            'description' => $description,
            'price' => $price,
            'category' => $category
        ]);
    }

    public function updateProduct($id, $name, $description, $price, $category)
    {
        $stmt = $this->pdo->prepare("UPDATE products SET name = :name, description = :description, price = :price, category = :category WHERE id = :id");
        return $stmt->execute([
            'id' => $id,
            'name' => $name,
            'description' => $description,
            'price' => $price,
            'category' => $category
        ]);
    }

    public function deleteProduct($id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM products WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }
}