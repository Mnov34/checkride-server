<?php

header('Content-Type: application/json');
require_once './vendor/autoload.php';

use src\app\controllers\login\RegisterController;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $data = json_decode(file_get_contents("php://input"), true, 512, JSON_THROW_ON_ERROR);

    if (isset($data['username'], $data['password'], $data['confirm_password'], $data['email'])) {
        $username = htmlspecialchars($data['username']);
        $password = htmlspecialchars($data['password']);
        $confirmPassword = htmlspecialchars($data['confirm_password']);
        $email = htmlspecialchars($data['email']);

        $registerController = new RegisterController();
        $result = $registerController->register($username, $password, $confirmPassword, $email);

        if ($result['success']) {
            http_response_code(201);
            echo json_encode(["message" => $result['message']], JSON_THROW_ON_ERROR);
        } else {
            http_response_code(400);
            echo json_encode(["message" => $result['WTF ERROR IN REGISTER API']], JSON_THROW_ON_ERROR);
        }
    } else {
        http_response_code(400);
        echo json_encode(["message" => "Invalid username or password"], JSON_THROW_ON_ERROR);
    }
} else {
    http_response_code(405); // Method Not Allowed
    echo json_encode(["message" => "Method not allowed"], JSON_THROW_ON_ERROR);
}