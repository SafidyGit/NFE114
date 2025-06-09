<?php
require_once './models/User.php';

class AuthController {
    public function login(){
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = htmlspecialchars($_POST['email']);
            $password = $_POST['password'];

            $userModel = new User();
            $user = $userModel->findByEmail($email);

            if ($user && password_verify($password, $user['password'])) {
              
                session_start();
                $_SESSION['user_id'] = $user['user_id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['role_id'] = $user['role_id'];

                if ($_SESSION['role_id'] != 2) {
                    header('Location: views/admin/dashboard.php');
                }else {
                    header('Location: views/employe/dashboard.php');
                }
                exit;
            } else {
               
                $error = "Email ou mot de passe incorrect, Veuillez réessayer !";
                require 'views/auth/login.php';
            }
        } else {
           
            require 'views/auth/login.php';
        }
    }

    public function logout() {
        session_start();
        session_unset(); 
        session_destroy(); 
 
        header('Location: index.php?action=login');
        exit;
    
    }

}