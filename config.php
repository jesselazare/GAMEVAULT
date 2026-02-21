<?php
// Sécurité : empêcher l'accès direct
if (!defined('SECURE_ACCESS')) die('Accès direct interdit');

// === CONFIGURATION DE LA BASE DE DONNÉES ===
define('DB_HOST', 'localhost');        // hôte MySQL
define('DB_NAME', 'projet_secu');     // nom de la base de données
define('DB_USER', 'root');             // utilisateur MySQL
define('DB_PASS', '');                 // mot de passe MySQL
define('DB_CHARSET', 'utf8mb4');       // encodage

// === CONSTANTES GÉNÉRALES ===
define('SITE_NAME', 'GameVault');
define('BASE_URL', '/Securiser_site_web_projet/gamevault/'); // à adapter si besoin

// === PARAMÈTRES DE SÉCURITÉ ===
// Durée de session (en secondes)
define('SESSION_TIMEOUT', 3600);

// Statuts de validation (pour référence rapide)
define('STATUS_PENDING', 1);
define('STATUS_APPROVED', 2);

// Roles utilisateurs
define('ROLE_ADMIN', 'admin');
define('ROLE_USER', 'user');
?>
