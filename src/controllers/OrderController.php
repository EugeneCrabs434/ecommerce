<?php

require_once __DIR__ . '/Controller.php';
require_once __DIR__ . '/../models/Order.php';
require_once __DIR__ . '/../models/Product.php';
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../models/Blacklist.php';

class OrderController extends Controller {
    private $orderModel;
    private $productModel;
    private $userModel;
    private $blacklistModel;
    
    public function __construct($pdo) {
        parent::__construct($pdo);
        $this->orderModel = new Order($pdo);
        $this->productModel = new Product($pdo);
        $this->userModel = new User($pdo);
        $this->blacklistModel = new Blacklist($pdo);
    }
    
    public function handleRequest() {
        $this->requireAuth();
        $action = $this->getQueryParams()['action'] ?? 'list';
        
        switch ($action) {
            case 'create':
                return $this->create();
            case 'view':
                return $this->view();
            case 'pay':
                return $this->pay();
            case 'cancel':
                return $this->cancel();
            case 'list':
            default:
                return $this->list();
        }
    }
    
    private function list() {
        if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin') {
            $orders = $this->orderModel->getAllOrders();
        } else {
            // Для обычного пользователя — только его заказы
            $orders = $this->orderModel->getOrdersByUserId($_SESSION['user_id']);
        }
        $this->render('orders/list', ['orders' => $orders]);
    }
    
    private function create() {
        if ($this->isPost()) {
            $data = $this->getPostData();
            $userId = $data['user_id'];
            
            // Проверяем, не находится ли пользователь в черном списке
            if ($this->blacklistModel->isUserBlacklisted($userId)) {
                $this->render('orders/error', [
                    'message' => 'Пользователь находится в черном списке и не может создавать заказы'
                ]);
                return;
            }
            
            if ($this->orderModel->createOrder($userId, $data['products'])) {
                $this->redirect('/orders');
            }
        }
        
        $users = $this->userModel->getAllUsers();
        $products = $this->productModel->getAllProducts();
        $this->render('orders/create', [
            'users' => $users,
            'products' => $products
        ]);
    }
    
    private function view() {
        $id = $this->getQueryParams()['id'] ?? null;
        if (!$id) {
            $this->redirect('/orders');
        }
        
        $order = $this->orderModel->getOrderById($id);
        if (!$order) {
            $this->redirect('/orders');
        }
        
        $this->render('orders/view', ['order' => $order]);
    }
    
    private function pay() {
        $id = $this->getQueryParams()['id'] ?? null;
        if ($id && $this->orderModel->updateOrderStatus($id, 'paid')) {
            $this->redirect('/orders');
        }
    }
    
    private function cancel() {
        $id = $this->getQueryParams()['id'] ?? null;
        if ($id && $this->orderModel->updateOrderStatus($id, 'canceled')) {
            $this->redirect('/orders');
        }
    }
} 