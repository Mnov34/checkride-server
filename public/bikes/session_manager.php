<?php
session_start();

function is_logged_in() {
    return isset($_SESSION['username']);
}

function is_admin() {
    return isset($_SESSION['status']) && $_SESSION['status'] === 'admin';
}

function require_login() {
    if (!is_logged_in()) {
        header("Location: ../login.php");
        exit();
    }
}

function require_admin() {
    if (!is_logged_in() || !is_admin()) {
        header("Location: ../login.php");
        exit();
    }
}
?>
