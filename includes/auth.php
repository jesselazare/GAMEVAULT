<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
/**
 * Vérifie si l'utilisateur est connecté et redirige si non
 */
function requireLogin() {
    $current_page = basename($_SERVER['PHP_SELF']); // récupère le nom du fichier actuel
    if (!isset($_SESSION['user']) && !in_array($current_page, ['login.php', 'register.php'])) {
        header("Location: login.php");
        exit();
    }
}


/**
 * Vérifie si l'utilisateur est admin et redirige si non
 */
function requireAdmin() {
    if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
        header("Location: login.php");
        exit();
    }
}

/**
 * Vérifie si l'utilisateur est connecté
 */
function is_logged_in() {
    return isset($_SESSION['user']);
}

/**
 * Vérifie si l'utilisateur est admin
 */
function is_admin() {
    return isset($_SESSION['user']) && $_SESSION['user']['role'] === 'admin';
}

/**
 * Génère un token CSRF
 */
function generateCSRFToken() {
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

/**
 * Vérifie le token CSRF
 */
function verifyCSRFToken($token) {
    if (!isset($_SESSION['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $token)) {
        die("Erreur CSRF : requête invalide.");
    }
}
?>
