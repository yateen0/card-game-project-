<?php
session_start();

require_once __DIR__ . '/../models/UserModel.php';

class LoginController {
    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'];
            $password = $_POST['password'];

            $userModel = new UserModel();
            $user = $userModel->getUserByEmail($email);

            if ($user && password_verify($password, $user['password'])) {
                // Sla informatie van de gebruiker op in de sessie
                $_SESSION['user'] = [
                    'id' => $user['id'],
                    'email' => $user['email'],
                    'name' => $user['name']
                ];

                // Redirect naar de hoofdpagina
                header('Location: /public/index.php');
                exit();
            } else {
                $error = 'Onjuiste e-mail of wachtwoord.';
                include __DIR__ . '/../views/login.php';
            }
        } else {
            include __DIR__ . '/../views/login.php';
        }
    }
}