<?php

define("DB_HOST", $_ENV['DB_HOST'] ?? 'localhost');
define("DB_PORT", $_ENV['DB_PORT'] ?? '3306');
define("DB_USER", $_ENV['DB_USER'] ?? 'root');
define("DB_PASS", $_ENV['DB_PASS'] ?? 'root');
define("DB_NAME", $_ENV['DB_NAME'] ?? 'checkride');

if (isset($_SESSION['user'])) {
    $userNav = $_SESSION['user']['id'];
}

try {
    $linkConnectDB = connect();
} catch (Exception $e) {
    die($e->getMessage());
}

/**
 * @return mysqli
 */
function getLinkConnectDB(): mysqli {
    global $linkConnectDB;
    return $linkConnectDB;
}

/**
 * Etablis une connection a la base de données.
 *
 * @return mysqli
 * @throws Exception
 */
function connect(): mysqli {
    $linkConnectDB = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME, DB_PORT);

    if ($linkConnectDB->connect_error) {
        throw new Exception('Connection error: ' . $linkConnectDB->connect_error);
    }

    $linkConnectDB->set_charset("utf8mb4");

    return $linkConnectDB;
}

/**
 * Sanitize et execute une requête SQL.
 *
 * @param string $sql La requête SQL a exécuter.
 * @param array $params Les paramètres a accrocher a la requête sql.
 *
 * @return mysqli_stmt La requête SQL préparé.
 * @throws Exception
 */
function executeQuery(string $sql, array $params = []): mysqli_stmt {
    global $linkConnectDB;
    $stmt = $linkConnectDB->prepare($sql);

    if (!$stmt) {
        throw new Exception('Prepare failed: ' . $stmt->error);
    }

    if (!$params) {
        $stmt->bind_param(str_repeat('s', count($params)), ...$params);
    }

    if (!$stmt->execute()) {
        throw new Exception('Execute failed: ' . $stmt->error);
    }

    return $stmt;
}