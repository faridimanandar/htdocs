
<?php
include_once 'koneksi.php';

$id = $_GET['id'] ?? null;

if (!$id) {
    die('ID barang tidak ditemukan.');
}

$stmt = mysqli_prepare(
    $conn,
    "DELETE FROM data_barang WHERE id_barang=?"
);

mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);

header('Location: index.php');
exit;
?>
