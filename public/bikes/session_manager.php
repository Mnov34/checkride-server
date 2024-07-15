<?php
// Démarrer une nouvelle session ou reprendre une session existante
session_start();

/**
 * Vérifie si l'utilisateur est connecté
 *
 * @return bool Retourne true si l'utilisateur est connecté, false sinon
 */
function is_logged_in() {
    // Vérifie si la variable de session 'username' est définie
    return isset($_SESSION['username']);
}

/**
 * Vérifie si l'utilisateur a le rôle d'administrateur
 *
 * @return bool Retourne true si l'utilisateur est un administrateur, false sinon
 */
function is_admin() {
    // Vérifie si la variable de session 'role' est définie et si elle est égale à 'admin'
    return isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
}

/**
 * Redirige vers la page de connexion si l'utilisateur n'est pas connecté
 *
 * Si l'utilisateur n'est pas connecté, il est redirigé vers 'login.php' et le script est arrêté
 */
function require_login() {
    // Si l'utilisateur n'est pas connecté
    if (!is_logged_in()) {
        // Redirige vers la page de connexion
        header("Location: ../login.php");
        // Arrête l'exécution du script
        exit();
    }
}

/**
 * Redirige vers la page de connexion si l'utilisateur n'est pas administrateur
 *
 * Si l'utilisateur n'est pas connecté ou n'est pas administrateur, il est redirigé vers 'login.php' et le script est arrêté
 */
function require_admin() {
    // Si l'utilisateur n'est pas connecté ou n'est pas administrateur
    if (!is_logged_in() || !is_admin()) {
        // Redirige vers la page de connexion
        header("Location: ../login.php");
        // Arrête l'exécution du script
        exit();
    }
}
?>
