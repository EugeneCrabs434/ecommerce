<?php

require_once __DIR__ . '/Controller.php';
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../models/Blacklist.php';

class UserController extends Controller {
    private $userModel;
    private $blacklistModel;
    
    public function __construct($pdo) {
        parent::__construct($pdo);
        $this->userModel = new User($pdo);
        $this->blacklistModel = new Blacklist($pdo);
    }
    
    public function handleRequest() {
        $this->requireAdmin();
        $action = $this->getQueryParams()['action'] ?? 'list';
        
        switch ($action) {
            case 'create':
                return $this->create();
            case 'edit':
                return $this->edit();
            case 'delete':
                return $this->delete();
            case 'blacklist':
                return $this->blacklist();
            case 'removeFromBlacklist':
                return $this->removeFromBlacklist();
            case 'list':
            default:
                return $this->list();
        }
    }
    
    private function list() {
        $users = $this->userModel->getAllUsers();
        $blacklistedUsers = $this->blacklistModel->getBlacklistedUsers();
        $this->render('users/list', [
            'users' => $users,
            'blacklistedUsers' => $blacklistedUsers
        ]);
    }
    
    private function create() {
        if ($this->isPost()) {
            $data = $this->getPostData();
            if ($this->userModel->addUser($data['name'], $data['email'], $data['password'])) {
                $this->redirect('/users');
            }
        }
        $this->render('users/create');
    }
    
    private function edit() {
        $id = $this->getQueryParams()['id'] ?? null;
        if (!$id) {
            $this->redirect('/users');
        }
        
        if ($this->isPost()) {
            $data = $this->getPostData();
            if ($this->userModel->updateUser($id, $data)) {
                $this->redirect('/users');
            }
        }
        
        $user = $this->userModel->getUserById($id);
        $this->render('users/edit', ['user' => $user]);
    }
    
    private function delete() {
        $id = $this->getQueryParams()['id'] ?? null;
        if ($id && $this->userModel->deleteUser($id)) {
            $this->redirect('/users');
        }
    }
    
    private function blacklist() {
        if ($this->isPost()) {
            $data = $this->getPostData();
            if ($this->blacklistModel->addToBlacklist($data['user_id'], $data['reason'])) {
                $this->redirect('/users');
            }
        }
        
        $id = $this->getQueryParams()['id'] ?? null;
        if (!$id) {
            $this->redirect('/users');
        }
        
        $user = $this->userModel->getUserById($id);
        $this->render('users/blacklist', ['user' => $user]);
    }
    
    private function removeFromBlacklist() {
        $id = $this->getQueryParams()['id'] ?? null;
        if ($id && $this->blacklistModel->removeFromBlacklist($id)) {
            $this->redirect('/users');
        }
    }
} 