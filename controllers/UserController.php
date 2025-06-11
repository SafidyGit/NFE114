<?php
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../models/Role.php';

class UserController 
{
    public function index() 
    {
        $userModel = new User();
        $users = $userModel->get_all_user();

        require __DIR__ . '/../views/admin/user/index.php';
    }

    public function get_user_by_id($id)
    {
        $userModel = new User();
        $user =$userModel->getById($id);

        return $user;
    }

    public function create()
    {
        $roleModel = new Role();
        $role_list = $roleModel->get_all_role();

        require __DIR__ . '/../views/admin/user/create.php';
    }

    public function store() 
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim(htmlspecialchars($_POST['username']));
            $email = trim(htmlspecialchars($_POST['user_email']));

            $password = $_POST['password'];
            $confirm_password = $_POST['confirm_password'];
            
            $role_id = $_POST['role_id'];

            if($password !== $confirm_password){
                header('Location: /index.php?action=user_create&error=password_mismatch');
                exit;
            }

            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            $userModel = new User();
            $userModel->add_user($username, $email, $hashedPassword, $role_id);

            header('Location: index.php?action=user_create&success=1');
            exit;
        } else {
            header('Location: index.php?action=user_create');
        }
    }
    public function edit()
    {
        $id = $_GET['id'];
        $user = $this->get_user_by_id($id);
        
        $roleModel = new Role();
        $role_list = $roleModel->get_all_role();
        
        require __DIR__ . '/../views/admin/user/update.php';
    }

    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user_id = $_GET['id'];
            $username = trim(htmlspecialchars($_POST['username']));
            $email = trim(htmlspecialchars($_POST['user_email']));

            $password = $_POST['password'];
            $confirm_password = $_POST['confirm_password'];
            
            $role_id = $_POST['role_id'];

            if($password !== $confirm_password){
                header('Location: /index.php?action=user_edit&error=password_mismatch&id='.$user_id);
                exit;
            }

            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            // var_dump($_POST);

            $userModel = new User();
            $userModel->update_user($user_id ,$username, $email, $hashedPassword, $role_id);

            header('Location: /index.php?action=user_list');

            exit;
            } else {
                require 'index.php?user_edit';
            }
        }

   public function delete()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user_id = $_GET['id'];

            $userModel = new User();
            $userModel->delete_user($user_id);

            header('Location: /index.php?action=user_list');
            exit;
        } else {
            require '/index.php?action=user_list';
        }
    }

    
}
