<?php
define('SECURE_ACCESS', true);
require_once 'includes/db.php';
require_once 'includes/auth.php'; // Gère déjà le session_start()

if (isset($_SESSION['user'])) {
    header('Location: dashboard.php');
    exit;
}

include 'includes/header.php';

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    
    if (empty($username) || empty($email) || empty($password)) {
        $errors[] = "Tous les champs sont requis.";
    } else {
        $hashed = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, 'user')");
        try {
            $stmt->execute([$username, $email, $hashed]);
            $_SESSION['user'] = ['id' => $pdo->lastInsertId(), 'username' => $username, 'role' => 'user'];
            header('Location: dashboard.php');
            exit;
        } catch (PDOException $e) {
            $errors[] = "Erreur : Nom d'utilisateur ou email déjà pris.";
        }
    }
}
?>
<main>
    <h2>Inscription</h2>
    <?php if ($errors): ?>
        <div style="color:red;"><?= implode('<br>', $errors) ?></div>
    <?php endif; ?>
    <form method="POST">
        <label>Nom d'utilisateur</label><input type="text" name="username" required>
        <label>Email</label><input type="email" name="email" required>
        <label>Mot de passe</label><input type="password" name="password" required>
        <button type="submit">S'inscrire</button>
    </form>
</main>
<?php include 'includes/footer.php'; ?>