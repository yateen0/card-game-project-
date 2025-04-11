<?php
class UserController
{
    private $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function register()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'];
            $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

            try {
                if ($this->userModel->createUser($username, $password)) {
                    header('Location: /card-game-project-/index.php?action=login');
                    exit;
                } else {
                    throw new Exception("Error registering user");
                }
            } catch (Exception $e) {
                echo "Error: " . $e->getMessage();
            }
        } else {
            require __DIR__ . '/../views/register.php';
        }
    }

    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'];
            $password = $_POST['password'];

            try {
                $user = $this->userModel->getUserByUsername($username);
                if ($user && password_verify($password, $user['password'])) {
                    session_start();
                    $_SESSION['user_id'] = $user['id'];
                    header('Location: /card-game-project-/index.php');
                    exit;
                } else {
                    throw new Exception("Invalid username or password");
                }
            } catch (Exception $e) {
                echo "Error: " . $e->getMessage();
            }
        } else {
            require __DIR__ . '/../views/login.php';
        }
    }
}