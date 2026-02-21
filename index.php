<?php
define('SECURE_ACCESS', true);
require_once 'includes/db.php';
require_once 'includes/auth.php';
include 'includes/header.php';
?>

<main>
    <h2>Bienvenue !</h2>

    <?php if (is_logged_in()): ?>
        <p>Bonjour, <strong><?= htmlspecialchars($_SESSION['user']['username']); ?></strong> !</p>

        <?php if (is_admin()): ?>
            <h3>Mode Admin</h3>
            <ul>
                <li><a href="validate_game.php">Valider les jeux soumis</a></li>
                <li><a href="dashboard.php">Modifier / Supprimer les jeux</a></li>
            </ul>
        <?php else: ?>
            <h3>Mode Utilisateur</h3>
            <ul>
                <li><a href="create_game.php">Soumettre un nouveau jeu</a></li>
                <li><a href="dashboard.php">Mes jeux soumis</a></li>
            </ul>
        <?php endif; ?>
        <p><a href="logout.php">Se déconnecter</a></p>

    <?php else: ?>
        <p>Vous devez vous connecter pour accéder aux fonctionnalités :</p>
        <ul>
            <li><a href="login.php">Connexion</a></li>
            <li><a href="register.php">Inscription</a></li>
        </ul>
    <?php endif; ?>
</main>

<?php include 'includes/footer.php'; ?>