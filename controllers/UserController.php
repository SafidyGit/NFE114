<?php
require_once '../../models/User.php';

class UserController {
    public function index() {
        
    }
    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = htmlspecialchars($_POST['username']);
            $email = htmlspecialchars($_POST['email']);
            $password = $_POST['password'];
            $role_id = $_POST['role_id'];

            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            $userModel = new User();
            $userModel->add($username, $email, $hashedPassword, $role_id);

            header('Location: views/admin/user/create.php?success=1');
            exit;
        } else {
            require 'views/admin/user/create.php';
        }
    }
    public function update(){

    }
    public function delete(){

    }

    
}
