<?php
require_once './models/User.php';

class AuthController {

    // Attribut pour stocker l'instance du modèle User 
    private User $userModel;

    // Constructeur : injection du modèle User
    public function __construct(User $userModel)
    {
        $this->userModel = $userModel;
    }

    // Méthode pour gérer la connexion de l'utilisateur
    public function login(){
        // Vérifie si la requête est envoyée en POST (formulaire soumis)
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // les données entrées par l'utilisateur
            $email = htmlspecialchars($_POST['email']);
            $password = $_POST['password'];

            // Recherche de l'utilisateur par email
            $user = $this->userModel->findByEmail($email);

            // Vérifie si l'utilisateur existe et si le mot de passe est correct
            if ($user && password_verify($password, $user['password'])) {
                // Démarre la session et stocke les infos utilisateur
                session_start();
                $_SESSION['user_id'] = $user['user_id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['role_id'] = $user['role_id'];

                // Redirection selon le rôle de l'utilisateur
                if ($_SESSION['role_id'] != 2) {
                    header('Location: index.php?action=admin_dashboard');
                } else {
                    header('Location: index.php?action=dashboard');
                }
                exit;
            } else {
                // Si l'authentification échoue, affiche le formulaire avec un message d'erreur
                $error = "Email ou mot de passe incorrect";
                require 'views/auth/login.php';
            }
        } else {
            // Si requête GET, affiche simplement le formulaire de connexion
            require 'views/auth/login.php';
        }
    }

    // Méthode de déconnexion
    public function logout() {
        session_start(); // Démarre la session
        session_unset(); // Vide les variables de session
        session_destroy(); // Détruit la session

        // Redirige vers la page de connexion
        header('Location: index.php?action=login');
        exit;
    }
}
