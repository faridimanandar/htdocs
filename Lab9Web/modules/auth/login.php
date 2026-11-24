<?php
if (!empty($_SESSION['user'])) {
    header('Location: index.php?page=user/list');
    exit;
}
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    validasiCsrf();
    $email = trim((string) ($_POST['email'] ?? ''));
    $password = (string) ($_POST['password'] ?? '');
    $stmt = $pdo->prepare('SELECT id, nama, email, password FROM admins WHERE email = :email LIMIT 1');
    $stmt->execute(['email' => $email]);
    $admin = $stmt->fetch();

    if ($admin && password_verify($password, $admin['password'])) {
        session_regenerate_id(true);
        $_SESSION['user'] = ['id' => (int) $admin['id'], 'nama' => $admin['nama'], 'email' => $admin['email']];
        setFlash('success', 'Login berhasil. Menu CRUD sekarang dapat digunakan.');
        header('Location: index.php?page=user/list');
        exit;
    }
    $error = 'Email atau password salah.';
}
?>
<section class="card narrow">
    <h2>Login Administrator</h2>
    <p>Gunakan akun administrator yang dibuat melalui setup.php.</p>
    <?php if ($error): ?><div class="alert error"><?= e($error) ?></div><?php endif; ?>
    <form method="post" class="form">
        <input type="hidden" name="csrf_token" value="<?= e(csrfToken()) ?>">
        <label>Email</label>
        <input type="email" name="email" required>
        <label>Password</label>
        <input type="password" name="password" required>
        <button type="submit">Login</button>
    </form>
</section>
