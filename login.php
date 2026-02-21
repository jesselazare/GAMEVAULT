<?php
define('SECURE_ACCESS', true);
require_once 'includes/db.php';
require_once 'includes/auth.php';
include 'includes/header.php';

$username = '';
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user'] = ['id' => $user['id'], 'username' => $user['username'], 'role' => $user['role']];
        header('Location: dashboard.php');
        exit;
    } else {
        $errors[] = 'Identifiants incorrects.';
    }
}
?>
<h2>Connexion</h2>
<?php if($errors): ?>
    <ul style="color:red;"><?php foreach($errors as $error): ?><li><?= htmlspecialchars($error); ?></li><?php endforeach; ?></ul>
<?php endif; ?>
<form method="POST" action="login.php" style="display:flex; flex-direction:column; max-width:400px; margin:auto;">
    <label>Nom d’utilisateur:</label>
    <input type="text" name="username" value="<?= htmlspecialchars($username); ?>" required>
    <label>Mot de passe:</label>
    <input type="password" name="password" required>
    <button type="submit" style="margin-top:10px; padding:10px; background:#33ff00; border:none; cursor:pointer;">Connexion</button>
</form>
<?php include 'includes/footer.php'; ?>