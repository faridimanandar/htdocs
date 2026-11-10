<?php
/*
|--------------------------------------------------------------------------
| LAB 7 WEB - PEMROGRAMAN SERVER-SIDE DENGAN PHP
| Seluruh Latihan 1-7 dan Mini Project digabung dalam satu file index.php.
|--------------------------------------------------------------------------
*/

date_default_timezone_set('Asia/Jakarta');

function e($nilai) {
    return htmlspecialchars((string)$nilai, ENT_QUOTES, 'UTF-8');
}

function rupiah($angka) {
    return 'Rp' . number_format((float)$angka, 0, ',', '.');
}

function hitungDiskon($harga, $persen) {
    $potongan = $harga * ($persen / 100);
    return $harga - $potongan;
}

function hitungLuasPersegiPanjang($panjang, $lebar) {
    return $panjang * $lebar;
}

function tentukanKelulusan($nilai) {
    return $nilai >= 60 ? 'Lulus' : 'Belum Lulus';
}

/* Data awal untuk Latihan 3 dan Latihan 5 */
$mahasiswa = ['Alya', 'Bima', 'Citra', 'Doni', 'Farah', 'Gilang', 'Hana'];

/* Variabel hasil dan pesan */
$hasilPost = null;
$errorPost = '';
$hasilTransaksi = null;
$errorTransaksi = '';
$dataMiniProject = null;
$errorMiniProject = [];

/* Latihan 6: Memproses form dengan POST */
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['aksi'] ?? '') === 'latihan6') {
    $namaPost = trim($_POST['nama'] ?? '');
    $prodiPost = trim($_POST['prodi'] ?? '');

    if ($namaPost === '' || $prodiPost === '') {
        $errorPost = 'Semua kolom wajib diisi.';
    } else {
        $hasilPost = [
            'nama' => $namaPost,
            'prodi' => $prodiPost
        ];
    }
}

/* Latihan 7: Pengolahan data transaksi sederhana */
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['aksi'] ?? '') === 'latihan7') {
    $barang = trim($_POST['barang'] ?? '');
    $hargaInput = trim($_POST['harga'] ?? '');
    $jumlahInput = trim($_POST['jumlah'] ?? '');

    if (
        $barang === '' ||
        $hargaInput === '' ||
        !is_numeric($hargaInput) ||
        !preg_match('/^\d+$/', $jumlahInput) ||
        (float)$hargaInput < 0 ||
        (int)$jumlahInput < 1
    ) {
        $errorTransaksi = 'Periksa kembali nama barang, harga, dan jumlah. Harga tidak boleh negatif dan jumlah minimal 1.';
    } else {
        $harga = (float)$hargaInput;
        $jumlah = (int)$jumlahInput;
        $subtotal = $harga * $jumlah;

        $hasilTransaksi = [
            'barang' => $barang,
            'harga' => $harga,
            'jumlah' => $jumlah,
            'subtotal' => $subtotal
        ];
    }
}

/* Mini Project: Formulir Data Mahasiswa */
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['aksi'] ?? '') === 'mini_project') {
    $namaMini = trim($_POST['nama_mini'] ?? '');
    $nimMini = trim($_POST['nim_mini'] ?? '');
    $prodiMini = trim($_POST['prodi_mini'] ?? '');
    $semesterInput = trim($_POST['semester_mini'] ?? '');
    $emailMini = trim($_POST['email_mini'] ?? '');

    if ($namaMini === '') {
        $errorMiniProject[] = 'Nama wajib diisi.';
    }
    if ($nimMini === '') {
        $errorMiniProject[] = 'NIM wajib diisi.';
    } elseif (!ctype_digit($nimMini)) {
        $errorMiniProject[] = 'NIM hanya boleh berisi angka.';
    } elseif (strlen($nimMini) !== 9) {
        $errorMiniProject[] = 'NIM harus terdiri dari 9 angka.';
    }
    if ($prodiMini === '') {
        $errorMiniProject[] = 'Program studi wajib diisi.';
    }
    if (!filter_var($emailMini, FILTER_VALIDATE_EMAIL)) {
        $errorMiniProject[] = 'Format email tidak valid.';
    }
    if (!ctype_digit($semesterInput) || (int)$semesterInput < 1 || (int)$semesterInput > 14) {
        $errorMiniProject[] = 'Semester harus berupa bilangan bulat dari 1 sampai 14.';
    }

    if (count($errorMiniProject) === 0) {
        $dataMiniProject = [
            'nama' => $namaMini,
            'nim' => $nimMini,
            'prodi' => $prodiMini,
            'semester' => (int)$semesterInput,
            'email' => $emailMini
        ];
    }
}

/* Latihan 2: Nilai akhir dan predikat */
$namaNilai = 'Siti';
$tugas = 85;
$uts = 78;
$uas = 90;
$nilaiAkhir = ($tugas * 0.30) + ($uts * 0.30) + ($uas * 0.40);

if ($nilaiAkhir >= 85) {
    $predikat = 'A';
} elseif ($nilaiAkhir >= 75) {
    $predikat = 'B';
} elseif ($nilaiAkhir >= 60) {
    $predikat = 'C';
} else {
    $predikat = 'D';
}

/* Latihan 4: Perhitungan function tambahan */
$hargaAwal = 150000;
$diskonPersen = 10;
$hargaSetelahDiskon = hitungDiskon($hargaAwal, $diskonPersen);
$luas = hitungLuasPersegiPanjang(8, 4);
$hasilKelulusan = tentukanKelulusan(78);

/* Latihan 5: Pencarian nama menggunakan GET */
$kataKunci = trim($_GET['kata'] ?? '');
$hasilPencarian = [];
if (isset($_GET['kata']) && $kataKunci !== '') {
    foreach ($mahasiswa as $namaMahasiswa) {
        if (stripos($namaMahasiswa, $kataKunci) !== false) {
            $hasilPencarian[] = $namaMahasiswa;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lab 7 - Pemrograman Server-Side PHP</title>
    <style>
        * { box-sizing: border-box; }
        body {
            margin: 0;
            font-family: Arial, Helvetica, sans-serif;
            background: #f3f6fb;
            color: #1f2937;
            line-height: 1.6;
        }
        header {
            background: linear-gradient(135deg, #173b70, #2563a6);
            color: white;
            padding: 38px 20px;
            text-align: center;
        }
        header h1 { margin: 0 0 8px; font-size: 30px; }
        header p { margin: 0; opacity: .92; }
        nav {
            background: #102b50;
            padding: 12px 18px;
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 8px;
            position: sticky;
            top: 0;
            z-index: 5;
        }
        nav a {
            color: white;
            text-decoration: none;
            padding: 7px 11px;
            border-radius: 6px;
            font-size: 13px;
        }
        nav a:hover { background: #2d5d91; }
        main { width: min(1050px, 94%); margin: 28px auto; }
        .card {
            background: white;
            margin-bottom: 22px;
            padding: 24px;
            border-radius: 12px;
            box-shadow: 0 4px 16px rgba(15, 35, 65, .07);
            scroll-margin-top: 85px;
        }
        h2 { color: #173b70; margin-top: 0; }
        h3 { color: #244d7c; margin-bottom: 8px; }
        .tag {
            display: inline-block;
            background: #e7f0fb;
            color: #17477d;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
            margin-bottom: 8px;
        }
        .result {
            background: #eef8f0;
            border-left: 4px solid #26934b;
            padding: 13px 16px;
            margin-top: 15px;
            border-radius: 5px;
        }
        .error {
            background: #fff0f0;
            border-left: 4px solid #d33;
            padding: 12px 16px;
            margin-top: 14px;
            border-radius: 5px;
            color: #8b1e1e;
        }
        form { margin-top: 12px; }
        label { display: block; font-weight: bold; margin: 12px 0 5px; }
        input {
            width: 100%;
            max-width: 520px;
            padding: 10px 12px;
            border: 1px solid #cbd5e1;
            border-radius: 6px;
            font-size: 15px;
        }
        button {
            margin-top: 15px;
            background: #1f5c99;
            color: white;
            border: 0;
            border-radius: 6px;
            padding: 10px 18px;
            cursor: pointer;
            font-size: 14px;
        }
        button:hover { background: #174575; }
        button.reset { background: #64748b; }
        table { border-collapse: collapse; width: 100%; max-width: 650px; margin-top: 10px; }
        th, td { border: 1px solid #dbe2ea; padding: 9px 12px; text-align: left; }
        th { background: #edf3f9; }
        code { background: #eef2f7; padding: 2px 5px; border-radius: 4px; }
        footer { text-align: center; padding: 25px; color: #64748b; font-size: 13px; }
        .note { color: #64748b; font-size: 14px; }
        @media (max-width: 600px) {
            header h1 { font-size: 23px; }
            .card { padding: 17px; }
            nav { position: static; }
        }
    </style>
</head>
<body>
<header>
    <h1>Praktikum 7: Pemrograman Server-Side dengan PHP</h1>
    <p>Latihan 1–7 dan Mini Project dalam satu aplikasi</p>
</header>

<nav>
    <a href="#latihan1">Latihan 1</a>
    <a href="#latihan2">Latihan 2</a>
    <a href="#latihan3">Latihan 3</a>
    <a href="#latihan4">Latihan 4</a>
    <a href="#latihan5">Latihan 5</a>
    <a href="#latihan6">Latihan 6</a>
    <a href="#latihan7">Latihan 7</a>
    <a href="#mini-project">Mini Project</a>
</nav>

<main>
    <!-- LATIHAN 1 -->
    <section class="card" id="latihan1">
        <span class="tag">Latihan 1</span>
        <h2>Menjalankan PHP</h2>
        <p>Bagian ini menampilkan output PHP dan waktu server. Jika teks di bawah muncul, berarti PHP berhasil diproses oleh web server.</p>
        <?php
            echo '<div class="result">';
            echo '<strong>PHP berhasil dijalankan.</strong><br>';
            echo 'Waktu server: ' . e(date('d-m-Y H:i:s'));
            echo '</div>';
        ?>
    </section>

    <!-- LATIHAN 2 -->
    <section class="card" id="latihan2">
        <span class="tag">Latihan 2</span>
        <h2>Variabel, Operator, dan Percabangan</h2>
        <p>Nilai akhir dihitung dari Tugas 30%, UTS 30%, dan UAS 40%.</p>
        <table>
            <tr><th>Keterangan</th><th>Nilai</th></tr>
            <tr><td>Nama</td><td><?= e($namaNilai) ?></td></tr>
            <tr><td>Nilai Tugas</td><td><?= e($tugas) ?></td></tr>
            <tr><td>Nilai UTS</td><td><?= e($uts) ?></td></tr>
            <tr><td>Nilai UAS</td><td><?= e($uas) ?></td></tr>
            <tr><th>Nilai Akhir</th><th><?= number_format($nilaiAkhir, 2, ',', '.') ?></th></tr>
            <tr><th>Predikat</th><th><?= e($predikat) ?></th></tr>
        </table>
        <p class="note">Ubah variabel <code>$tugas</code>, <code>$uts</code>, dan <code>$uas</code> di bagian PHP untuk mencoba kombinasi nilai lainnya.</p>
    </section>

    <!-- LATIHAN 3 -->
    <section class="card" id="latihan3">
        <span class="tag">Latihan 3</span>
        <h2>Perulangan dan Array</h2>
        <p>Daftar berikut berisi tujuh nama mahasiswa dan ditampilkan menggunakan perulangan <code>foreach</code>.</p>
        <ol>
            <?php foreach ($mahasiswa as $namaMahasiswa): ?>
                <li><?= e($namaMahasiswa) ?></li>
            <?php endforeach; ?>
        </ol>
    </section>

    <!-- LATIHAN 4 -->
    <section class="card" id="latihan4">
        <span class="tag">Latihan 4</span>
        <h2>Membuat Function</h2>
        <p>Function digunakan agar proses yang sama dapat dipanggil kembali tanpa menulis ulang seluruh perintah.</p>
        <div class="result">
            Harga awal: <?= rupiah($hargaAwal) ?><br>
            Diskon: <?= e($diskonPersen) ?>%<br>
            Harga setelah diskon: <strong><?= rupiah($hargaSetelahDiskon) ?></strong><br><br>
            Luas persegi panjang (8 × 4): <strong><?= e($luas) ?> satuan luas</strong><br>
            Hasil kelulusan nilai 78: <strong><?= e($hasilKelulusan) ?></strong>
        </div>
    </section>

    <!-- LATIHAN 5 -->
    <section class="card" id="latihan5">
        <span class="tag">Latihan 5</span>
        <h2>Memproses Form dengan GET</h2>
        <p>Masukkan nama atau sebagian nama mahasiswa. Kata kunci akan terlihat pada URL karena form menggunakan metode GET.</p>
        <form method="GET" action="">
            <label for="kata">Kata kunci:</label>
            <input id="kata" name="kata" type="text" value="<?= e($kataKunci) ?>" placeholder="Contoh: Alya">
            <button type="submit">Cari</button>
            <button class="reset" type="button" onclick="window.location.href=window.location.pathname">Reset Pencarian</button>
        </form>
        <?php if (isset($_GET['kata'])): ?>
            <div class="result">
                <?php if ($kataKunci === ''): ?>
                    Masukkan kata kunci untuk melakukan pencarian.
                <?php elseif (count($hasilPencarian) > 0): ?>
                    <strong>Hasil pencarian:</strong>
                    <ul>
                        <?php foreach ($hasilPencarian as $namaDitemukan): ?>
                            <li><?= e($namaDitemukan) ?></li>
                        <?php endforeach; ?>
                    </ul>
                <?php else: ?>
                    Nama dengan kata kunci <strong><?= e($kataKunci) ?></strong> tidak ditemukan.
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </section>

    <!-- LATIHAN 6 -->
    <section class="card" id="latihan6">
        <span class="tag">Latihan 6</span>
        <h2>Memproses Form dengan POST</h2>
        <p>Form menerima nama dan program studi. Data diperiksa di sisi server sebelum ditampilkan.</p>
        <form method="POST" action="#latihan6">
            <input type="hidden" name="aksi" value="latihan6">
            <label for="nama">Nama:</label>
            <input id="nama" name="nama" type="text" required>
            <label for="prodi">Program Studi:</label>
            <input id="prodi" name="prodi" type="text" required>
            <button type="submit">Kirim Data</button>
        </form>
        <?php if ($errorPost !== ''): ?>
            <div class="error"><?= e($errorPost) ?></div>
        <?php elseif ($hasilPost !== null): ?>
            <div class="result">
                <strong>Data diterima</strong><br>
                Nama: <?= e($hasilPost['nama']) ?><br>
                Program Studi: <?= e($hasilPost['prodi']) ?>
            </div>
        <?php endif; ?>
    </section>

    <!-- LATIHAN 7 -->
    <section class="card" id="latihan7">
        <span class="tag">Latihan 7</span>
        <h2>Pengolahan Data Sederhana</h2>
        <p>Masukkan nama barang, harga, dan jumlah. Program akan memvalidasi input lalu menghitung subtotal.</p>
        <form method="POST" action="#latihan7">
            <input type="hidden" name="aksi" value="latihan7">
            <label for="barang">Nama barang:</label>
            <input id="barang" name="barang" type="text" required>
            <label for="harga">Harga:</label>
            <input id="harga" name="harga" type="number" min="0" step="0.01" required>
            <label for="jumlah">Jumlah:</label>
            <input id="jumlah" name="jumlah" type="number" min="1" step="1" required>
            <button type="submit">Hitung Subtotal</button>
        </form>
        <?php if ($errorTransaksi !== ''): ?>
            <div class="error"><?= e($errorTransaksi) ?></div>
        <?php elseif ($hasilTransaksi !== null): ?>
            <div class="result">
                <strong>Ringkasan Transaksi</strong><br>
                Nama barang: <?= e($hasilTransaksi['barang']) ?><br>
                Harga satuan: <?= rupiah($hasilTransaksi['harga']) ?><br>
                Jumlah: <?= e($hasilTransaksi['jumlah']) ?><br>
                Subtotal: <strong><?= rupiah($hasilTransaksi['subtotal']) ?></strong>
            </div>
        <?php endif; ?>
    </section>

    <!-- MINI PROJECT -->
    <section class="card" id="mini-project">
        <span class="tag">Mini Project</span>
        <h2>Aplikasi Formulir Data Mahasiswa</h2>
        <p>Form ini menerima nama, NIM, program studi, semester, dan email. Seluruh data dikirim menggunakan POST dan divalidasi di sisi server.</p>
        <form method="POST" action="#mini-project">
            <input type="hidden" name="aksi" value="mini_project">
            <label for="nama_mini">Nama lengkap:</label>
            <input id="nama_mini" name="nama_mini" type="text" required>
            <label for="nim_mini">NIM (9 angka):</label>
            <input id="nim_mini" name="nim_mini" type="text" inputmode="numeric" required>
            <label for="prodi_mini">Program Studi:</label>
            <input id="prodi_mini" name="prodi_mini" type="text" required>
            <label for="semester_mini">Semester (1–14):</label>
            <input id="semester_mini" name="semester_mini" type="number" min="1" max="14" step="1" required>
            <label for="email_mini">Email:</label>
            <input id="email_mini" name="email_mini" type="email" required>
            <button type="submit">Kirim Formulir Mahasiswa</button>
        </form>

        <?php if (count($errorMiniProject) > 0): ?>
            <div class="error">
                <strong>Data belum dapat diproses. Periksa kesalahan berikut:</strong>
                <ul>
                    <?php foreach ($errorMiniProject as $pesanError): ?>
                        <li><?= e($pesanError) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php elseif ($dataMiniProject !== null): ?>
            <div class="result">
                <strong>Data Mahasiswa Berhasil Diterima</strong>
                <table>
                    <tr><th>Nama</th><td><?= e($dataMiniProject['nama']) ?></td></tr>
                    <tr><th>NIM</th><td><?= e($dataMiniProject['nim']) ?></td></tr>
                    <tr><th>Program Studi</th><td><?= e($dataMiniProject['prodi']) ?></td></tr>
                    <tr><th>Semester</th><td><?= e($dataMiniProject['semester']) ?></td></tr>
                    <tr><th>Email</th><td><?= e($dataMiniProject['email']) ?></td></tr>
                </table>
            </div>
        <?php endif; ?>
        <p class="note">Ketentuan NIM pada aplikasi ini ditetapkan 9 angka. Ubah ketentuan panjang NIM pada validasi PHP jika dosen menetapkan aturan yang berbeda.</p>
    </section>
</main>

<footer>
    Praktikum 7 Pemrograman Web — Pemrograman Server-Side dengan PHP
</footer>
</body>
</html>
