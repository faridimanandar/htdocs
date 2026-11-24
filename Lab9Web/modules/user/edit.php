<?php
wajibLogin();
$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if (!$id || $id < 1) {
    http_response_code(400);
    echo '<section class="card"><h2>ID tidak valid</h2></section>';
    return;
}
$stmt = $pdo->prepare('SELECT id, nama, email FROM users WHERE id = :id');
$stmt->execute(['id' => $id]);
$userData = $stmt->fetch();
if (!$userData) {
    http_response_code(404);
    echo '<section class="card"><h2>Data tidak ditemukan</h2></section>';
    return;
}
$nama = $userData['nama'];
$email = $userData['email'];
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    validasiCsrf();
    $nama = trim((string) ($_POST['nama'] ?? ''));
    $email = trim((string) ($_POST['email'] ?? ''));
    if ($nama === '') $errors[] = 'Nama wajib diisi.';
    if (!validasiEmail($email)) $errors[] = 'Format email tidak valid.';

    if (!$errors) {
        try {
            $update = $pdo->prepare('UPDATE users SET nama = :nama, email = :email WHERE id = :id');
            $update->execute(['nama' => $nama, 'email' => $email, 'id' => $id]);
            setFlash('success', 'Data pengguna berhasil diperbarui.');
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
    <h2>Edit Pengguna</h2>
    <?php foreach ($errors as $error): ?><div class="alert error"><?= e($error) ?></div><?php endforeach; ?>
    <form method="post" action="index.php?page=user/edit&id=<?= (int) $id ?>" class="form">
        <input type="hidden" name="csrf_token" value="<?= e(csrfToken()) ?>">
        <label>Nama lengkap</label>
        <input type="text" name="nama" value="<?= e($nama) ?>" required maxlength="100">
        <label>Email</label>
        <input type="email" name="email" value="<?= e($email) ?>" required maxlength="150">
        <button type="submit">Simpan Perubahan</button>
        <a href="index.php?page=user/list">Batal</a>
    </form>
</section>
