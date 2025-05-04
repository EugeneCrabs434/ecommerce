<?php

require_once __DIR__ . '/Controller.php';
require_once __DIR__ . '/../models/User.php';

class AuthController extends Controller {
    private $userModel;

    public function __construct($pdo) {
        parent::__construct($pdo);
        $this->userModel = new User($pdo);
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function handleRequest() {
        $action = $this->getQueryParams()['action'] ?? 'login';
        switch ($action) {
            case 'register':
                return $this->register();
            case 'logout':
                return $this->logout();
            case 'login':
            default:
                return $this->login();
        }
    }

    private function login() {
        $error = '';
        if ($this->isPost()) {
            $data = $this->getPostData();
            $user = $this->findUserByEmail($data['email']);
            if ($user && $data['password'] === $user['password']) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['role'] = $user['role'];
                $_SESSION['user_name'] = $user['name'];
                // Редирект в зависимости от роли
                if ($user['role'] === 'admin') {
                    $this->redirect('/products');
                } else {
                    $this->redirect('/');
                }
            } else {
                $error = 'Неверный email или пароль';
            }
        }
        $this->render('auth/login', ['error' => $error]);
    }

    private function register() {
        $error = '';
        if ($this->isPost()) {
            $data = $this->getPostData();
            if ($this->findUserByEmail($data['email'])) {
                $error = 'Пользователь с таким email уже существует';
            } else {
                $passwordHash = $data['password'];
                if ($this->userModel->addUser($data['name'], $data['email'], $passwordHash)) {
                    $this->redirect('/auth?action=login');
                } else {
                    $error = 'Ошибка регистрации';
                }
            }
        }
        $this->render('auth/register', ['error' => $error]);
    }

    private function logout() {
        session_destroy();
        $this->redirect('/');
    }

    private function findUserByEmail($email) {
        $users = $this->userModel->getAllUsers();
        foreach ($users as $user) {
            if ($user['email'] === $email) {
                return $user;
            }
        }
        return null;
    }
}