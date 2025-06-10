<?php
require_once __DIR__ . '/../models/User.php';

class UserController 
{
    public function index() 
    {
        $userModel = new User();
        $users = $userModel->get_all_user();

        require __DIR__ . '/../views/admin/user/index.php';
    }

    public function create()
    {
        require __DIR__ . '/../views/admin/user/create.php';
    }

    public function store() 
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = htmlspecialchars($_POST['username']);
            $email = htmlspecialchars($_POST['email']);
            $password = $_POST['password'];
            $role_id = $_POST['role_id'];

            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            $userModel = new User();
            $userModel->add($username, $email, $hashedPassword, $role_id);

            header('Location: create.php?success=1');
            exit;
        } else {
            require 'views/admin/user/create.php';
        }
    }
    public function update()
    {

    }
    public function delete()
    {

    }

    
}
