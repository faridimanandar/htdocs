<?php
wajibLogin();
$nama = '';
$email = '';
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    validasiCsrf();
    $nama = trim((string) ($_POST['nama'] ?? ''));
    $email = trim((string) ($_POST['email'] ?? ''));

    if ($nama === '') $errors[] = 'Nama wajib diisi.';
    if (!validasiEmail($email)) $errors[] = 'Format email tidak valid.';

    if (!$errors) {
        try {
            $stmt = $pdo->prepare('INSERT INTO users (nama, email) VALUES (:nama, :email)');
            $stmt->execute(['nama' => $nama, 'email' => $email]);
            setFlash('success', 'Data pengguna berhasil ditambahkan.');
            header('Location: index.php?page=user/list');
            exit;
        } catch (PDOException $e) {
            $errors[] = 'Email mungkin sudah digunakan atau terjadi kesalahan database.';
            error_log($e->getMessage());
        }
    }
}
?>
<section class="card">
    <h2>Tambah Pengguna</h2>
    <?php foreach ($errors as $error): ?><div class="alert error"><?= e($error) ?></div><?php endforeach; ?>
    <form method="post" action="index.php?page=user/add" class="form">
        <input type="hidden" name="csrf_token" value="<?= e(csrfToken()) ?>">
        <label>Nama lengkap</label>
        <input type="text" name="nama" value="<?= e($nama) ?>" required maxlength="100">
        <label>Email</label>
        <input type="email" name="email" value="<?= e($email) ?>" required maxlength="150">
        <button type="submit">Simpan</button>
        <a href="index.php?page=user/list">Batal</a>
    </form>
</section>
