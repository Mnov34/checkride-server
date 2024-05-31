<?php

header('Content-Type: application/json');
require_once './vendor/autoload.php';

use src\app\controllers\login\LoginController;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $data = json_decode(file_get_contents("php://input"), true, 512, JSON_THROW_ON_ERROR);

    if (isset($data['username'], $data['password'])) {
        $username = htmlspecialchars($data['username']);
        $password = htmlspecialchars($data['password']);

        session_start();
        $loginController = new LoginController();
        $result = $loginController->login($username, $password);

        if ($result['success']) {
            http_response_code(200);
            echo json_encode(["message" => "Login successful"], JSON_THROW_ON_ERROR);
        } else {
            http_response_code(401);
            echo json_encode(["message" => $result['wtf, problem in login API']], JSON_THROW_ON_ERROR);
        }
    } else {
        http_response_code(400);
        echo json_encode(["message" => "Invalid username or password."], JSON_THROW_ON_ERROR);
    }
} else {
    http_response_code(405); // Method Not Allowed
    echo json_encode(["message" => "Method not allowed"], JSON_THROW_ON_ERROR);
}
