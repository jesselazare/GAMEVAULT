<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title><?= defined('SITE_NAME') ? SITE_NAME : 'GameVault' ?></title>
    <link rel="stylesheet" href="assets/css/style.css"> </head>
<body>
<header>
    <h1>GAMEVAULT</h1>
    <nav>
        <a href="index.php">Accueil</a>
        <a href="games.php">Catalogue</a> <?php if (isset($_SESSION['user'])): ?>
            <a href="dashboard.php">Dashboard</a>
            <a href="logout.php" style="color: #ff3333;">Déconnexion</a>
        <?php else: ?>
            <a href="login.php">Connexion</a>
            <a href="register.php">Inscription</a>
        <?php endif; ?>
    </nav>
</header>