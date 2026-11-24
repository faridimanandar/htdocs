<?php
// Jalankan sekali melalui browser untuk membuat akun admin demo.
// Setelah berhasil, hapus file setup.php dari server.
require_once __DIR__ . '/config/database.php';
$nama = 'Administrator';
$email = 'admin@lab9.test';
$password = password_hash('admin123', PASSWORD_DEFAULT);

$stmt = $pdo->prepare('SELECT id FROM admins WHERE email = :email');
$stmt->execute(['email' => $email]);
if ($stmt->fetch()) {
    echo 'Akun admin sudah tersedia. Email: admin@lab9.test';
} else {
    $insert = $pdo->prepare('INSERT INTO admins (nama, email, password) VALUES (:nama, :email, :password)');
    $insert->execute(['nama' => $nama, 'email' => $email, 'password' => $password]);
    echo 'Admin berhasil dibuat. Email: admin@lab9.test | Password: admin123';
}
echo '<br>Hapus file setup.php setelah selesai.';
