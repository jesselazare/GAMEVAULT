<?php
define('SECURE_ACCESS', true);
require_once 'includes/db.php';
require_once 'includes/auth.php';

// Sécurité : Seul l'admin peut supprimer
if (!is_admin()) {
    die("Action non autorisée.");
}

$id = intval($_GET['id'] ?? 0);

if ($id > 0) {
    $stmt = $pdo->prepare("DELETE FROM games WHERE id = ?");
    $stmt->execute([$id]);
}

// Redirection vers le dashboard après suppression
header("Location: dashboard.php?msg=deleted");
exit();
?>