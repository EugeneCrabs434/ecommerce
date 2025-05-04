<?php

require_once __DIR__ . '/Controller.php';
require_once __DIR__ . '/../models/Product.php';

class ProductController extends Controller {
    private $productModel;
    
    public function __construct($pdo) {
        parent::__construct($pdo);
        $this->productModel = new Product($pdo);
    }
    
    public function handleRequest() {
        $action = $this->getQueryParams()['action'] ?? 'list';
        
        switch ($action) {
            case 'create':
                return $this->create();
            case 'edit':
                return $this->edit();
            case 'delete':
                return $this->delete();
            case 'list':
            default:
                return $this->list();
        }
    }
    
    private function list() {
        $products = $this->productModel->getAllProducts();
        $this->render('products/list', ['products' => $products]);
    }
    
    private function create() {
        $this->requireAdmin();
        if ($this->isPost()) {
            $data = $this->getPostData();
            if ($this->productModel->addProduct(
                $data['name'],
                $data['description'],
                $data['price'],
                $data['category']
            )) {
                $this->redirect('/products');
            }
        }
        $this->render('products/create');
    }
    
    private function edit() {
        $this->requireAdmin();
        $id = $this->getQueryParams()['id'] ?? null;
        if (!$id) {
            $this->redirect('/products');
        }
        
        if ($this->isPost()) {
            $data = $this->getPostData();
            if ($this->productModel->updateProduct(
                $id,
                $data['name'],
                $data['description'],
                $data['price'],
                $data['category']
            )) {
                $this->redirect('/products');
            }
        }
        
        $product = $this->productModel->getProductById($id);
        $this->render('products/edit', ['product' => $product]);
    }
    
    private function delete() {
        $this->requireAdmin();
        $id = $this->getQueryParams()['id'] ?? null;
        if ($id && $this->productModel->deleteProduct($id)) {
            $this->redirect('/products');
        }
    }
} 