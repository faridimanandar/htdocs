
<?php
error_reporting(E_ALL);
include_once 'koneksi.php';

if (isset($_POST['submit'])) {

    $id = $_POST['id'];
    $nama = $_POST['nama'];
    $kategori = $_POST['kategori'];
    $harga_jual = $_POST['harga_jual'];
    $harga_beli = $_POST['harga_beli'];
    $stok = $_POST['stok'];

    $file_gambar = $_FILES['file_gambar'];
    $gambar = null;

    if ($file_gambar['error'] == 0) {

        $filename = str_replace(' ', '_', $file_gambar['name']);

        $destination = dirname(__FILE__) . '/gambar/' . $filename;

        if (move_uploaded_file($file_gambar['tmp_name'], $destination)) {
            $gambar = 'gambar/' . $filename;
        }
    }

    if (!empty($gambar)) {

        $stmt = mysqli_prepare(
            $conn,
            "UPDATE data_barang
             SET nama=?, kategori=?, harga_jual=?,
                 harga_beli=?, stok=?, gambar=?
             WHERE id_barang=?"
        );

        mysqli_stmt_bind_param(
            $stmt,
            "ssddisi",
            $nama,
            $kategori,
            $harga_jual,
            $harga_beli,
            $stok,
            $gambar,
            $id
        );

    } else {

        $stmt = mysqli_prepare(
            $conn,
            "UPDATE data_barang
             SET nama=?, kategori=?, harga_jual=?,
                 harga_beli=?, stok=?
             WHERE id_barang=?"
        );

        mysqli_stmt_bind_param(
            $stmt,
            "ssddii",
            $nama,
            $kategori,
            $harga_jual,
            $harga_beli,
            $stok,
            $id
        );
    }

    mysqli_stmt_execute($stmt);

    header('Location: index.php');
    exit;
}

$id = $_GET['id'] ?? null;

if (!$id) {
    die('ID barang tidak ditemukan.');
}

$stmt = mysqli_prepare(
    $conn,
    "SELECT * FROM data_barang WHERE id_barang=?"
);

mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);
$data = mysqli_fetch_array($result);

if (!$data) {
    die('Error: Data tidak tersedia');
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <link href="style.css" rel="stylesheet" type="text/css">
    <title>Ubah Barang</title>
</head>
<body>

<div class="container">
    <h1>Ubah Barang</h1>

    <div class="main">
        <form method="post" action="ubah.php"
              enctype="multipart/form-data">

            <div class="input">
                <label>Nama Barang</label>
                <input type="text" name="nama"
                       value="<?= htmlspecialchars($data['nama']); ?>"
                       required>
            </div>

            <div class="input">
                <label>Kategori</label>
                <select name="kategori">
                    <option value="Komputer"
                        <?= $data['kategori'] == 'Komputer' ? 'selected' : ''; ?>>
                        Komputer
                    </option>

                    <option value="Elektronik"
                        <?= $data['kategori'] == 'Elektronik' ? 'selected' : ''; ?>>
                        Elektronik
                    </option>

                    <option value="Hand Phone"
                        <?= $data['kategori'] == 'Hand Phone' ? 'selected' : ''; ?>>
                        Hand Phone
                    </option>
                </select>
            </div>

            <div class="input">
                <label>Harga Jual</label>
                <input type="number" name="harga_jual"
                       value="<?= $data['harga_jual']; ?>" required>
            </div>

            <div class="input">
                <label>Harga Beli</label>
                <input type="number" name="harga_beli"
                       value="<?= $data['harga_beli']; ?>" required>
            </div>

            <div class="input">
                <label>Stok</label>
                <input type="number" name="stok"
                       value="<?= $data['stok']; ?>" required>
            </div>

            <div class="input">
                <label>File Gambar Baru (opsional)</label>
                <input type="file" name="file_gambar"
                       accept="image/*">
            </div>

            <input type="hidden" name="id"
                   value="<?= $data['id_barang']; ?>">

            <div class="submit">
                <input type="submit" name="submit" value="Simpan">
            </div>

        </form>
    </div>
</div>

</body>
</html>
