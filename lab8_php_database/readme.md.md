# PRAKTIKUM 8 --- PHP DAN DATABASE MYSQL

## Identitas Mahasiswa

  Keterangan       Informasi
  ---------------- ------------------------------
  Nama             Farid Iman Nandar
  NIM              312510102
  Program Studi    Teknik Informatika
  Mata Praktikum   Pemrograman Web
  Praktikum        8 --- PHP dan Database MySQL

------------------------------------------------------------------------

## 1. Tujuan Praktikum

Berdasarkan Modul Praktikum 8, tujuan kegiatan ini adalah:

1.  Mahasiswa mampu memahami konsep dasar database.
2.  Mahasiswa mampu memahami konsep dasar CRUD menggunakan PHP.
3.  Mahasiswa mampu membuat program CRUD sederhana menggunakan PHP.

## 2. Deskripsi Praktikum

Praktikum ini membuat aplikasi sederhana untuk mengelola data barang
menggunakan PHP dan MySQL. Aplikasi menerapkan empat operasi CRUD:

  Operasi   Kepanjangan   Fungsi
  --------- ------------- -------------------------
  Create    Membuat       Menambahkan data barang
  Read      Membaca       Menampilkan data barang
  Update    Memperbarui   Mengubah data barang
  Delete    Menghapus     Menghapus data barang

Data barang yang dikelola meliputi ID barang, kategori, nama barang,
gambar, harga beli, harga jual, dan stok.

## 3. Perangkat yang Dibutuhkan

Pastikan perangkat berikut sudah tersedia:

-   **XAMPP** --- menjalankan Apache dan MySQL/MariaDB di komputer
    lokal.
-   **Visual Studio Code** --- membuat dan mengedit file PHP, HTML,
    serta CSS.
-   **Browser** --- membuka aplikasi melalui `localhost`.
-   **phpMyAdmin** --- mengelola database melalui browser.
-   **Git** --- mengelola versi project.
-   **Akun GitHub** --- menyimpan repository praktikum.

## 4. Persiapan Lingkungan Praktikum

### 4.1 Menjalankan XAMPP

1.  Buka XAMPP Control Panel.
2.  Klik **Start** pada modul Apache.
3.  Klik **Start** pada modul MySQL.
4.  Pastikan keduanya berjalan tanpa pesan kesalahan.

### 4.2 Membuka phpMyAdmin

Buka browser dan akses:

``` text
http://localhost/phpmyadmin/
```

Pastikan halaman phpMyAdmin dapat dibuka.

### 4.3 Membuat Folder Project

Buat folder project di dalam direktori `htdocs` XAMPP. Pada instalasi
Windows standar, lokasinya:

``` text
C:\xampp\htdocs\lab8_php_database
```

Jika XAMPP dipasang di drive atau direktori lain, sesuaikan lokasi
`htdocs` dengan instalasi tersebut.

## 5. Membuat Database dan Tabel

### 5.1 Membuat Database

Di phpMyAdmin, pilih tab **SQL**, lalu jalankan:

``` sql
CREATE DATABASE latihan1;
```

Setelah berhasil, pilih database `latihan1`.

### 5.2 Membuat Tabel `data_barang`

Jalankan perintah berikut pada tab SQL setelah memilih database
`latihan1`:

``` sql
CREATE TABLE data_barang (
    id_barang INT(10) AUTO_INCREMENT PRIMARY KEY,
    kategori VARCHAR(30),
    nama VARCHAR(30),
    gambar VARCHAR(100),
    harga_beli DECIMAL(10,0),
    harga_jual DECIMAL(10,0),
    stok INT(4)
);
```

Keterangan kolom:

  Kolom          Tipe Data         Kegunaan
  -------------- ----------------- ------------------------------------
  `id_barang`    `INT(10)`         ID unik barang, bertambah otomatis
  `kategori`     `VARCHAR(30)`     Kategori barang
  `nama`         `VARCHAR(30)`     Nama barang
  `gambar`       `VARCHAR(100)`    Lokasi/nama file gambar
  `harga_beli`   `DECIMAL(10,0)`   Harga beli barang
  `harga_jual`   `DECIMAL(10,0)`   Harga jual barang
  `stok`         `INT(4)`          Jumlah stok barang

### 5.3 Memasukkan Data Awal

Jalankan SQL berikut untuk memasukkan tiga data awal sesuai modul:

``` sql
INSERT INTO data_barang
    (kategori, nama, gambar, harga_beli, harga_jual, stok)
VALUES
    ('Elektronik', 'HP Samsung Android', 'gambar/hp_samsung.jpg', 2000000, 2400000, 5),
    ('Elektronik', 'HP Xiaomi Android', 'gambar/hp_xiaomi.jpg', 1000000, 1400000, 5),
    ('Elektronik', 'HP OPPO Android', 'gambar/hp_oppo.jpg', 1800000, 2300000, 5);
```

> Catatan: Lokasi gambar diisi dengan `gambar/...` agar sesuai dengan
> pemanggilan gambar pada aplikasi. Pastikan file gambar dengan nama
> yang sama diletakkan di folder `gambar`.

## 6. Struktur Folder Project

Buat struktur project seperti berikut:

``` text
lab8_php_database/
├── README.md
├── koneksi.php
├── index.php
├── tambah.php
├── ubah.php
├── hapus.php
├── style.css

```

Keterangan file:

  File/Folder     Fungsi
  --------------- --------------------------------------------
  `koneksi.php`   Menghubungkan PHP ke database MySQL
  `index.php`     Menampilkan daftar data barang (Read)
  `tambah.php`    Form dan proses penambahan barang (Create)
  `ubah.php`      Form dan proses perubahan barang (Update)
  `hapus.php`     Proses penghapusan barang (Delete)
  `style.css`     Mengatur tampilan halaman
  `gambar/`       Menyimpan gambar barang
  `README.md`     Dokumentasi project dan langkah praktikum

## 7. Pembuatan Program

### 7.1 Membuat `koneksi.php`

File ini digunakan agar halaman PHP dapat terhubung ke database
`latihan1`.

``` php
<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "latihan1";

$conn = mysqli_connect($host, $user, $pass, $db);

if ($conn == false) {
    echo "Koneksi ke server gagal.";
    die();
}

// Aktifkan baris berikut sementara untuk menguji koneksi:
// echo "Koneksi berhasil";
?>
```

**Penjelasan:**

-   `$host` berisi alamat server database.
-   `$user` berisi username MySQL.
-   `$pass` berisi password MySQL. Pada konfigurasi XAMPP standar,
    password root sering kali kosong; sesuaikan jika konfigurasi
    komputer berbeda.
-   `$db` menentukan database yang digunakan.
-   `mysqli_connect()` membuat koneksi PHP dengan MySQL.
-   Pemeriksaan `if` menghentikan proses apabila koneksi gagal.

**Pengujian koneksi:** buka
`http://localhost/lab8_php_database/koneksi.php`. Untuk melihat pesan
sukses, hilangkan komentar pada `echo "Koneksi berhasil";` sementara.

### 7.2 Membuat `index.php` --- READ

File ini mengambil seluruh data dari tabel dan menampilkannya dalam
tabel HTML.

``` php
<?php
include("koneksi.php");

$sql = "SELECT * FROM data_barang";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="style.css" rel="stylesheet" type="text/css">
    <title>Data Barang</title>
</head>
<body>
<div class="container">
    <h1>Data Barang</h1>

    <div class="main">
        <p><a href="tambah.php">+ Tambah Barang</a></p>

        <table>
            <tr>
                <th>Gambar</th>
                <th>Nama Barang</th>
                <th>Kategori</th>
                <th>Harga Beli</th>
                <th>Harga Jual</th>
                <th>Stok</th>
                <th>Aksi</th>
            </tr>

            <?php if ($result && mysqli_num_rows($result) > 0): ?>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td>
                            <?php if (!empty($row['gambar'])): ?>
                                <img src="<?= htmlspecialchars($row['gambar']); ?>"
                                     alt="<?= htmlspecialchars($row['nama']); ?>"
                                     width="100">
                            <?php else: ?>
                                Tidak ada gambar
                            <?php endif; ?>
                        </td>
                        <td><?= htmlspecialchars($row['nama']); ?></td>
                        <td><?= htmlspecialchars($row['kategori']); ?></td>
                        <td><?= htmlspecialchars($row['harga_beli']); ?></td>
                        <td><?= htmlspecialchars($row['harga_jual']); ?></td>
                        <td><?= htmlspecialchars($row['stok']); ?></td>
                        <td>
                            <a href="ubah.php?id=<?= (int) $row['id_barang']; ?>">Ubah</a> |
                            <a href="hapus.php?id=<?= (int) $row['id_barang']; ?>"
                               onclick="return confirm('Yakin ingin menghapus data ini?')">
                                Hapus
                            </a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="7">Belum ada data</td>
                </tr>
            <?php endif; ?>
        </table>
    </div>
</div>
</body>
</html>
```

**Penjelasan:**

-   `include("koneksi.php")` memanggil file koneksi.
-   `SELECT * FROM data_barang` mengambil semua kolom dan baris.
-   `mysqli_query()` menjalankan query.
-   `mysqli_fetch_assoc()` mengambil hasil per baris dalam bentuk array
    asosiatif.
-   `while` mengulang tampilan untuk setiap barang.
-   `htmlspecialchars()` membantu menampilkan teks sebagai teks biasa,
    bukan markup HTML.
-   Tautan **Ubah** mengirim ID barang ke `ubah.php`.
-   Tautan **Hapus** mengirim ID barang ke `hapus.php`.

### 7.3 Membuat Folder `gambar`

Buat folder `gambar` di dalam folder project. Masukkan file gambar
barang ke dalamnya. Nama file harus sesuai dengan nilai kolom `gambar`
di database, misalnya:

``` text
gambar/
├── hp_samsung.jpg
├── hp_xiaomi.jpg
└── hp_oppo.jpg
```

Jika nama atau lokasi file berbeda, sesuaikan nilai kolom `gambar` pada
database.

### 7.4 Membuat `tambah.php` --- CREATE

File ini menyediakan formulir untuk menambahkan barang dan menyimpan
datanya ke database.

``` php
<?php
error_reporting(E_ALL);
include_once 'koneksi.php';

$error = '';

if (isset($_POST['submit'])) {
    $nama = trim($_POST['nama'] ?? '');
    $kategori = $_POST['kategori'] ?? '';
    $harga_jual = $_POST['harga_jual'] ?? '';
    $harga_beli = $_POST['harga_beli'] ?? '';
    $stok = $_POST['stok'] ?? '';

    $gambar = null;

    if ($nama === '' || !is_numeric($harga_jual) ||
        !is_numeric($harga_beli) || !filter_var($stok, FILTER_VALIDATE_INT)) {
        $error = 'Periksa kembali nama, harga, dan stok barang.';
    } else {
        if (isset($_FILES['file_gambar']) &&
            $_FILES['file_gambar']['error'] !== UPLOAD_ERR_NO_FILE) {

            if ($_FILES['file_gambar']['error'] !== UPLOAD_ERR_OK) {
                $error = 'Upload gambar gagal.';
            } else {
                $allowed = ['jpg', 'jpeg', 'png', 'gif'];
                $extension = strtolower(pathinfo($_FILES['file_gambar']['name'], PATHINFO_EXTENSION));

                if (!in_array($extension, $allowed, true)) {
                    $error = 'Format gambar harus JPG, JPEG, PNG, atau GIF.';
                } else {
                    $filename = uniqid('barang_', true) . '.' . $extension;
                    $destination = __DIR__ . '/gambar/' . $filename;

                    if (move_uploaded_file($_FILES['file_gambar']['tmp_name'], $destination)) {
                        $gambar = 'gambar/' . $filename;
                    } else {
                        $error = 'Gambar tidak dapat disimpan.';
                    }
                }
            }
        }

        if ($error === '') {
            $stmt = mysqli_prepare(
                $conn,
                "INSERT INTO data_barang
                (nama, kategori, harga_jual, harga_beli, stok, gambar)
                VALUES (?, ?, ?, ?, ?, ?)"
            );

            mysqli_stmt_bind_param(
                $stmt,
                "ssddis",
                $nama,
                $kategori,
                $harga_jual,
                $harga_beli,
                $stok,
                $gambar
            );

            if (mysqli_stmt_execute($stmt)) {
                header('Location: index.php');
                exit;
            } else {
                $error = 'Data gagal disimpan: ' . mysqli_error($conn);
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="style.css" rel="stylesheet" type="text/css">
    <title>Tambah Barang</title>
</head>
<body>
<div class="container">
    <h1>Tambah Barang</h1>

    <?php if ($error !== ''): ?>
        <p class="error"><?= htmlspecialchars($error); ?></p>
    <?php endif; ?>

    <form method="post" action="tambah.php" enctype="multipart/form-data">
        <div class="input">
            <label>Nama Barang</label>
            <input type="text" name="nama" required>
        </div>

        <div class="input">
            <label>Kategori</label>
            <select name="kategori" required>
                <option value="Komputer">Komputer</option>
                <option value="Elektronik">Elektronik</option>
                <option value="Hand Phone">Hand Phone</option>
            </select>
        </div>

        <div class="input">
            <label>Harga Jual</label>
            <input type="number" name="harga_jual" min="0" required>
        </div>

        <div class="input">
            <label>Harga Beli</label>
            <input type="number" name="harga_beli" min="0" required>
        </div>

        <div class="input">
            <label>Stok</label>
            <input type="number" name="stok" min="0" required>
        </div>

        <div class="input">
            <label>File Gambar</label>
            <input type="file" name="file_gambar" accept=".jpg,.jpeg,.png,.gif">
        </div>

        <div class="submit">
            <input type="submit" name="submit" value="Simpan">
        </div>
    </form>

    <p><a href="index.php">Kembali ke daftar barang</a></p>
</div>
</body>
</html>
```

**Penjelasan:**

-   `$_POST` mengambil nilai dari formulir.
-   `$_FILES` mengambil informasi file yang diunggah.
-   `enctype="multipart/form-data"` diperlukan untuk upload file.
-   `move_uploaded_file()` memindahkan file ke folder `gambar`.
-   `INSERT INTO` menyimpan data baru.
-   `mysqli_prepare()` dan `mysqli_stmt_bind_param()` digunakan untuk
    menyiapkan query dengan parameter.
-   Setelah berhasil, pengguna diarahkan kembali ke `index.php`.

### 7.5 Membuat `ubah.php` --- UPDATE

File ini mengambil data berdasarkan ID, menampilkannya di formulir, lalu
menyimpan perubahan.

``` php
<?php
error_reporting(E_ALL);
include_once 'koneksi.php';

$error = '';

if (isset($_POST['submit'])) {
    $id = filter_var($_POST['id'] ?? '', FILTER_VALIDATE_INT);
    $nama = trim($_POST['nama'] ?? '');
    $kategori = $_POST['kategori'] ?? '';
    $harga_jual = $_POST['harga_jual'] ?? '';
    $harga_beli = $_POST['harga_beli'] ?? '';
    $stok = $_POST['stok'] ?? '';

    if (!$id || $nama === '' || !is_numeric($harga_jual) ||
        !is_numeric($harga_beli) || !filter_var($stok, FILTER_VALIDATE_INT)) {
        $error = 'Data yang dimasukkan tidak valid.';
    } else {
        $gambar = null;

        if (isset($_FILES['file_gambar']) &&
            $_FILES['file_gambar']['error'] !== UPLOAD_ERR_NO_FILE) {

            if ($_FILES['file_gambar']['error'] !== UPLOAD_ERR_OK) {
                $error = 'Upload gambar gagal.';
            } else {
                $allowed = ['jpg', 'jpeg', 'png', 'gif'];
                $extension = strtolower(pathinfo($_FILES['file_gambar']['name'], PATHINFO_EXTENSION));

                if (!in_array($extension, $allowed, true)) {
                    $error = 'Format gambar harus JPG, JPEG, PNG, atau GIF.';
                } else {
                    $filename = uniqid('barang_', true) . '.' . $extension;
                    $destination = __DIR__ . '/gambar/' . $filename;

                    if (move_uploaded_file($_FILES['file_gambar']['tmp_name'], $destination)) {
                        $gambar = 'gambar/' . $filename;
                    } else {
                        $error = 'Gambar tidak dapat disimpan.';
                    }
                }
            }
        }

        if ($error === '') {
            if ($gambar !== null) {
                $stmt = mysqli_prepare(
                    $conn,
                    "UPDATE data_barang
                     SET nama=?, kategori=?, harga_jual=?, harga_beli=?,
                         stok=?, gambar=?
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
                     SET nama=?, kategori=?, harga_jual=?, harga_beli=?, stok=?
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

            if (mysqli_stmt_execute($stmt)) {
                header('Location: index.php');
                exit;
            } else {
                $error = 'Data gagal diperbarui: ' . mysqli_error($conn);
            }
        }
    }
}

$id = filter_var($_GET['id'] ?? $_POST['id'] ?? '', FILTER_VALIDATE_INT);

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
$data = mysqli_fetch_assoc($result);

if (!$data) {
    die('Data barang tidak tersedia.');
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="style.css" rel="stylesheet" type="text/css">
    <title>Ubah Barang</title>
</head>
<body>
<div class="container">
    <h1>Ubah Barang</h1>

    <?php if ($error !== ''): ?>
        <p class="error"><?= htmlspecialchars($error); ?></p>
    <?php endif; ?>

    <form method="post" action="ubah.php" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?= (int) $data['id_barang']; ?>">

        <div class="input">
            <label>Nama Barang</label>
            <input type="text" name="nama"
                   value="<?= htmlspecialchars($data['nama']); ?>" required>
        </div>

        <div class="input">
            <label>Kategori</label>
            <select name="kategori" required>
                <?php
                $kategori_list = ['Komputer', 'Elektronik', 'Hand Phone'];
                foreach ($kategori_list as $kategori_item):
                ?>
                    <option value="<?= htmlspecialchars($kategori_item); ?>"
                        <?= $data['kategori'] === $kategori_item ? 'selected' : ''; ?>>
                        <?= htmlspecialchars($kategori_item); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="input">
            <label>Harga Jual</label>
            <input type="number" name="harga_jual"
                   value="<?= htmlspecialchars($data['harga_jual']); ?>" min="0" required>
        </div>

        <div class="input">
            <label>Harga Beli</label>
            <input type="number" name="harga_beli"
                   value="<?= htmlspecialchars($data['harga_beli']); ?>" min="0" required>
        </div>

        <div class="input">
            <label>Stok</label>
            <input type="number" name="stok"
                   value="<?= htmlspecialchars($data['stok']); ?>" min="0" required>
        </div>

        <div class="input">
            <label>File Gambar Baru (opsional)</label>
            <input type="file" name="file_gambar" accept=".jpg,.jpeg,.png,.gif">
        </div>

        <div class="submit">
            <input type="submit" name="submit" value="Simpan Perubahan">
        </div>
    </form>

    <p><a href="index.php">Kembali ke daftar barang</a></p>
</div>
</body>
</html>
```

**Penjelasan:**

-   `$_GET['id']` mengambil ID barang dari URL ketika halaman edit
    dibuka.
-   Query `SELECT` mengambil data lama berdasarkan ID.
-   Nilai `value` menampilkan data lama pada formulir.
-   `UPDATE` memperbarui kolom barang.
-   Jika gambar baru tidak diunggah, gambar lama tetap digunakan.
-   `WHERE id_barang=?` membatasi perubahan hanya pada barang yang
    dipilih.

### 7.6 Membuat `hapus.php` --- DELETE

File ini menghapus data barang berdasarkan ID. Contoh berikut memakai
metode POST agar penghapusan tidak dilakukan hanya dengan membuka tautan
GET.

``` php
<?php
include_once 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit;
}

$id = filter_var($_POST['id'] ?? '', FILTER_VALIDATE_INT);

if (!$id) {
    die('ID barang tidak valid.');
}

$stmt = mysqli_prepare(
    $conn,
    "DELETE FROM data_barang WHERE id_barang=?"
);

mysqli_stmt_bind_param($stmt, "i", $id);

if (mysqli_stmt_execute($stmt)) {
    header('Location: index.php');
    exit;
}

die('Data gagal dihapus: ' . mysqli_error($conn));
?>
```

**Penting:** Karena file ini menggunakan POST, ubah bagian aksi hapus di
`index.php` menjadi formulir berikut di dalam kolom Aksi:

``` php
<form method="post" action="hapus.php"
      onsubmit="return confirm('Yakin ingin menghapus data ini?')">
    <input type="hidden" name="id"
           value="<?= (int) $row['id_barang']; ?>">
    <button type="submit">Hapus</button>
</form>
```

-   `DELETE FROM` menghapus data.
-   `WHERE id_barang=?` menentukan data yang akan dihapus.
-   Formulir POST mengirim ID barang ke `hapus.php`.
-   Konfirmasi membantu menghindari penghapusan yang tidak disengaja.

### 7.7 Membuat `style.css`

File CSS mengatur tampilan halaman agar formulir dan tabel lebih rapi.

``` css
* {
    box-sizing: border-box;
}

body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f4;
    margin: 0;
    padding: 20px;
}

.container {
    width: 90%;
    max-width: 1100px;
    margin: 30px auto;
    background-color: white;
    padding: 25px;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
}

h1 {
    text-align: center;
    color: #333;
}

table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

table th,
table td {
    border: 1px solid #ddd;
    padding: 12px;
    text-align: center;
}

table th {
    background-color: #333;
    color: white;
}

table img {
    width: 80px;
    height: 70px;
    object-fit: contain;
}

.input {
    margin-bottom: 15px;
}

.input label {
    display: block;
    margin-bottom: 7px;
    font-weight: bold;
}

.input input,
.input select {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
}

.submit input,
button {
    padding: 10px 20px;
    background-color: #2878d0;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

.submit input:hover,
button:hover {
    background-color: #155ba5;
}

a {
    color: #2878d0;
    text-decoration: none;
}

a:hover {
    text-decoration: underline;
}

.error {
    color: #b00020;
    background: #ffe8e8;
    padding: 10px;
    border-radius: 5px;
}
```

## 8. Cara Menjalankan Aplikasi

1.  Pastikan seluruh file project berada di dalam folder `htdocs`.
2.  Buka XAMPP Control Panel.
3.  Jalankan Apache dan MySQL.
4.  Buka phpMyAdmin dan pastikan database `latihan1` serta tabel
    `data_barang` tersedia.
5.  Pastikan file gambar berada di folder `gambar`.
6.  Buka browser dan akses:

``` text
http://localhost/lab8_php_database/
```

7.  Halaman utama akan menampilkan daftar barang.
8.  Gunakan tombol **Tambah Barang** untuk menguji Create.
9.  Gunakan tombol **Ubah** untuk menguji Update.
10. Gunakan tombol **Hapus** untuk menguji Delete.

## 9. Pengujian CRUD

Lakukan pengujian berikut dan catat hasilnya:

  No.   Pengujian   Langkah                       Hasil yang Diharapkan
  ----- ----------- ----------------------------- ----------------------------
  1     READ        Buka halaman utama            Data barang tampil
  2     CREATE      Tambahkan barang baru         Barang baru masuk ke tabel
  3     UPDATE      Ubah nama, harga, atau stok   Data berubah sesuai input
  4     DELETE      Hapus salah satu barang       Barang tidak lagi tampil

### Checklist Pengujian

-   [ ] Apache berjalan.
-   [ ] MySQL berjalan.
-   [ ] Database `latihan1` berhasil dibuat.
-   [ ] Tabel `data_barang` berhasil dibuat.
-   [ ] Tiga data awal berhasil dimasukkan.
-   [ ] Koneksi PHP ke database berhasil.
-   [ ] Halaman daftar barang dapat dibuka.
-   [ ] Fitur tambah barang berhasil.
-   [ ] Fitur ubah barang berhasil.
-   [ ] Fitur hapus barang berhasil.
-   [ ] Gambar barang dapat ditampilkan.

## 10. Dokumentasi Screenshot

Instruksi laporan pada modul meminta screenshot setiap perubahan. Simpan
screenshot di folder `screenshots` agar dokumentasi mudah diperiksa.

Buat struktur berikut:

``` text
screenshots/
├── 01-xampp-aktif.png
├── 02-database-latihan1.png
├── 03-tabel-data-barang.png
├── 04-data-awal.png
├── 05-uji-koneksi.png
├── 06-halaman-index.png
├── 07-form-tambah.png
├── 08-hasil-tambah.png
├── 09-form-ubah.png
├── 10-hasil-ubah.png
├── 11-hasil-hapus.png
├── 12-struktur-folder.png
└── 13-repository-github.png
```

Tambahkan screenshot asli milik sendiri. Contoh menampilkan gambar di
Markdown:

``` markdown
![XAMPP aktif](screenshots/01-xampp-aktif.png)
```

Dokumentasikan setiap screenshot dengan keterangan singkat, misalnya:

-   **Gambar 1.** Apache dan MySQL berhasil dijalankan melalui XAMPP.
-   **Gambar 2.** Database `latihan1` berhasil dibuat di phpMyAdmin.
-   **Gambar 3.** Tabel `data_barang` berhasil dibuat.
-   **Gambar 4.** Tiga data barang awal berhasil dimasukkan.
-   **Gambar 5.** Koneksi PHP dengan MySQL berhasil.
-   **Gambar 6.** Halaman utama menampilkan data barang.
-   **Gambar 7.** Formulir penambahan barang.
-   **Gambar 8.** Data barang baru berhasil ditambahkan.
-   **Gambar 9.** Formulir perubahan data barang.
-   **Gambar 10.** Data berhasil diperbarui.
-   **Gambar 11.** Data berhasil dihapus.
-   **Gambar 12.** Struktur folder project di Visual Studio Code.
-   **Gambar 13.** Repository praktikum di GitHub.

## 11. Mengunggah Project ke GitHub

Sesuai instruksi laporan modul, buat repository baru dengan nama
`Lab8Web`.

### 11.1 Membuat Repository

1.  Buka [GitHub](https://github.com/).
2.  Login ke akun GitHub.
3.  Pilih **New repository**.
4.  Isi nama repository dengan `Lab8Web`.
5.  Tentukan Public atau Private sesuai arahan dosen.
6.  Buat repository.

### 11.2 Mengirim Project Menggunakan Git

Buka terminal di Visual Studio Code pada folder project. Jalankan:

``` bash
git init
git add .
git commit -m "Praktikum 8 PHP dan MySQL"
git branch -M main
git remote add origin https://github.com/USERNAME/Lab8Web.git
git push -u origin main
```

Ganti `USERNAME` dengan username GitHub sendiri.

Jika repository sudah memiliki remote `origin`, jangan menjalankan
`git remote add origin` sekali lagi. Periksa dengan:

``` bash
git remote -v
```

Jika perlu memperbaiki alamat remote:

``` bash
git remote set-url origin https://github.com/USERNAME/Lab8Web.git
```

Untuk mengirim perubahan berikutnya:

``` bash
git add .
git commit -m "Melengkapi dokumentasi dan praktikum"
git push
```

## 12. Masalah yang Mungkin Terjadi

  --------------------------------------------------------------------------
  Masalah                 Kemungkinan Penyebab    Pemeriksaan/Penyelesaian
  ----------------------- ----------------------- --------------------------
  Apache tidak berjalan   Port sedang digunakan   Periksa konfigurasi port
                                                  Apache

  MySQL tidak berjalan    Service atau port MySQL Periksa log MySQL di XAMPP
                          bermasalah              

  Koneksi gagal           Host, username,         Periksa `koneksi.php`
                          password, atau nama     
                          database salah          

  Database tidak          Database belum dibuat   Buat database `latihan1`
  ditemukan                                       

  Tabel tidak ditemukan   Tabel belum dibuat atau Periksa tabel
                          salah nama              `data_barang`

  Halaman PHP tidak       File dibuka langsung    Buka melalui `localhost`
  diproses                dari File Explorer      

  Gambar tidak tampil     Path atau nama file     Periksa kolom `gambar` dan
                          tidak cocok             folder `gambar`

  Upload gambar gagal     Folder tidak tersedia   Periksa folder dan izin
                          atau tidak dapat        akses
                          ditulis                 

  Data tidak berubah      ID atau query tidak     Periksa parameter ID dan
                          sesuai                  pesan error

  Halaman kosong          Ada kesalahan PHP       Periksa konfigurasi error
                                                  dan log Apache
  --------------------------------------------------------------------------

## 13. Catatan Keamanan dan Penggunaan

Project ini merupakan latihan dasar untuk lingkungan lokal. Sebelum
digunakan pada server publik, perlu ditambahkan perlindungan lebih
lanjut, antara lain:

-   Validasi data di sisi server.
-   Validasi tipe dan ukuran file gambar, termasuk pemeriksaan isi file.
-   Perlindungan CSRF untuk formulir yang mengubah data.
-   Penghapusan gambar lama jika sudah tidak digunakan.
-   Penggunaan akun database khusus dengan hak akses minimum, bukan akun
    root.
-   Penanganan pesan kesalahan agar informasi internal database tidak
    ditampilkan kepada pengguna.
-   Penggunaan HTTPS dan konfigurasi server yang aman.

## 14. Kesimpulan

Praktikum 8 memberikan pemahaman mengenai penggunaan PHP dan MySQL dalam
membuat aplikasi pengelolaan data barang. Database digunakan untuk
menyimpan data, sedangkan PHP menghubungkan halaman aplikasi dengan
database dan menjalankan perintah SQL.

Melalui praktikum ini, empat operasi CRUD dipelajari, yaitu Create untuk
menambahkan data, Read untuk menampilkan data, Update untuk mengubah
data, dan Delete untuk menghapus data. Praktikum juga melatih penggunaan
XAMPP, phpMyAdmin, Visual Studio Code, serta GitHub untuk menyimpan
hasil pekerjaan.

## 15. Pengumpulan Praktikum

Sebelum mengumpulkan tugas, pastikan:

-   [ ] Seluruh file program sudah tersedia.
-   [ ] Database dan tabel sudah dibuat.
-   [ ] Semua fungsi CRUD sudah diuji.
-   [ ] Screenshot setiap tahap sudah dimasukkan ke folder
    `screenshots`.
-   [ ] File `README.md` sudah berada di repository.
-   [ ] Project sudah di-commit dan di-push ke GitHub.
-   [ ] URL repository `Lab8Web` sudah disiapkan untuk dikirim ke
    e-learning/eCampus.

**Repository GitHub:** `https://github.com/USERNAME/Lab8Web`

**Catatan:** Ganti `USERNAME` dengan username GitHub milik sendiri
sebelum mengumpulkan tugas.
