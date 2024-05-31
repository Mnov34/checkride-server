<?php

namespace src\app\controllers\login;

use src\app\models\User;
use PDOException;

class RegisterController {
    private User $userModel;

    public function __construct() {
        $this->userModel = new User();
    }

    public function register($username, $password, $confirmPassword, $email) {
        if ($password !== $confirmPassword) {
            return ["success" => false, "message" => "Les mots de passe ne correspondent pas."];
        }

        try {
            $this->userModel->registerUser($username, $password, $email);
            return ["success" => true, "message" => "Vous avez été enregistré avec succès."];
        } catch (PDOException $e) {
            return ["success" => false, "message" => "Erreur lors de l'enregistrement : " . $e->getMessage()];
        }
    }
}
