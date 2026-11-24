<?php
wajibLogin();
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    exit('Metode tidak diizinkan. Penghapusan harus menggunakan POST.');
}
validasiCsrf();
$id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
if (!$id || $id < 1) {
    setFlash('error', 'ID pengguna tidak valid.');
} else {
    $stmt = $pdo->prepare('DELETE FROM users WHERE id = :id');
    $stmt->execute(['id' => $id]);
    setFlash('success', $stmt->rowCount() ? 'Data pengguna berhasil dihapus.' : 'Data tidak ditemukan.');
}
header('Location: index.php?page=user/list');
exit;
