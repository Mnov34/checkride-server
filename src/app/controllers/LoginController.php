<?php

namespace src\app\controllers;

use PDOException;
use src\app\models\User;

class LoginController {
    private User $userModel;

    public function __construct() {
        $this->userModel = new User();
    }

    public function login($username, $password) {
        try {
            $user = $this->userModel->getUserByUsernameAndPassword($username, $password);
            if ($user) {
                $_SESSION['username'] = $username;
                return ["success" => true, "message" => "Login Successful"];
            }
            return ["success" => false, "message" => "Le nom d'utilisateur ou le mot de passe est incorrect."];
        } catch (PDOException $e) {
            return ["success" => false, "message" => "Erreur lors de l'authentification : " . $e->getMessage()];
        }
    }
}