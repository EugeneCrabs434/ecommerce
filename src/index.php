<?php

// Подключаем конфигурацию базы данных
$pdo = require_once __DIR__.'/config/database.php';

// Включаем отображение всех ошибок
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "Подключение к базе данных установлено успешно!<br>";

// Подключаем модели
require_once __DIR__ . '/models/OrderItems.php';
require_once __DIR__ . '/models/Blacklist.php';
require_once __DIR__ . '/models/Order.php';
require_once __DIR__ . '/models/Product.php';
require_once __DIR__ . '/models/User.php';

// Работа с пользователями
$userModel = new User($pdo);

// Добавляем тестового пользователя
if ($userModel->addUser('Евгений', 'evgeniy_stalbovskiy@mail.ru', '123456')) {
    echo "Пользователь добавлен успешно!<br>";
} else {
    echo "Ошибка добавления пользователя!<br>";
}

// Получаем всех пользователей
$users = $userModel->getAllUsers();
echo "<h3>Список пользователей:</h3>";
echo "<pre>";
print_r($users);
echo "</pre>";

// Остальной код (работа с товарами, заказами и т.д.)
// ...

$productModel = new Product($pdo);
$products = $productModel->getAllProducts();
print_r($products);

$orderModel = new Order($pdo);
$orders = $orderModel->getAllOrders();
print_r($orders);

// Пример использования модели Blacklist
$blacklistModel = new Blacklist($pdo);
$blacklistedUsers = $blacklistModel->getBlacklistedUsers();
print_r($blacklistedUsers);

$orderItemsModel= new OrderItem($pdo);
$ordersItems = $orderItemsModel->getAllOrderItems();
print_r($ordersItems);

