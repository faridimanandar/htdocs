# Lab7Web_PHP — Praktikum 7 Pemrograman Server-Side dengan PHP

## Deskripsi
Proyek ini menggabungkan **Latihan 1 sampai Latihan 7 dan Mini Project** dari Modul Praktikum 7 ke dalam **satu aplikasi dan satu file kode PHP**, yaitu `index.php`. Setiap bagian ditampilkan pada halaman yang sama dan dapat dibuka melalui menu navigasi.

## Tujuan
- Menjalankan PHP melalui web server lokal.
- Menggunakan variabel, tipe data, operator, percabangan, array, perulangan, dan function.
- Memproses form menggunakan metode GET dan POST.
- Melakukan validasi input pada sisi server.
- Menampilkan kembali data pengguna dengan `htmlspecialchars()`.
- Mengolah data transaksi sederhana dan membuat formulir data mahasiswa.

## Perangkat
- Laptop/PC
- Visual Studio Code atau editor teks lain
- XAMPP atau Laragon
- PHP
- Web browser

## Struktur Folder
```text
Lab7Web_PHP/
├── index.php
└── README.md
```

Seluruh kode Latihan 1–7 dan Mini Project berada di `index.php`, tidak dipisahkan menjadi file PHP yang berbeda.

## Cara Menjalankan dengan XAMPP
1. Pastikan XAMPP sudah terpasang.
2. Buka XAMPP Control Panel.
3. Jalankan layanan **Apache**.
4. Salin folder `Lab7Web_PHP` ke dalam folder `C:\\xampp\\htdocs\\`.
5. Buka browser.
6. Ketik alamat berikut:
   `http://localhost/Lab7Web_PHP/`
7. Halaman praktikum akan tampil. Pilih bagian yang ingin diuji melalui menu navigasi.

> Jangan membuka `index.php` dengan klik dua kali. File PHP harus dijalankan melalui web server, misalnya menggunakan `localhost`.

## Cara Menjalankan dengan PHP Built-in Server
Jika PHP sudah terpasang dan perintah `php` tersedia:
1. Buka terminal pada folder `Lab7Web_PHP`.
2. Jalankan:
   ```bash
   php -S localhost:8000
   ```
3. Buka browser dan akses:
   `http://localhost:8000`

## Ringkasan Latihan

### Latihan 1 — Menjalankan PHP
Menampilkan judul, pesan bahwa PHP berhasil dijalankan, dan waktu server menggunakan `date()`.

### Latihan 2 — Variabel, Operator, dan Percabangan
Menghitung nilai akhir dengan bobot Tugas 30%, UTS 30%, dan UAS 40%. Program menentukan predikat A, B, C, atau D menggunakan `if`, `elseif`, dan `else`.

### Latihan 3 — Perulangan dan Array
Menyimpan tujuh nama mahasiswa dalam array dan menampilkan seluruh nama menggunakan `foreach`.

### Latihan 4 — Membuat Function
Menggunakan function untuk menghitung harga setelah diskon. Ditambahkan function menghitung luas persegi panjang dan menentukan kelulusan berdasarkan nilai.

### Latihan 5 — Memproses Form dengan GET
Menerima kata kunci melalui `$_GET`, lalu mencari nama yang cocok dari array mahasiswa. Kata kunci terlihat pada URL.

### Latihan 6 — Memproses Form dengan POST
Menerima nama dan program studi melalui `$_POST`. Server memeriksa agar kedua kolom tidak kosong sebelum menampilkan data.

### Latihan 7 — Pengolahan Data Sederhana
Menerima nama barang, harga, dan jumlah. PHP memvalidasi input dan menghitung subtotal dengan rumus harga dikali jumlah.

### Mini Project — Aplikasi Formulir Data Mahasiswa
Menerima nama, NIM, program studi, semester, dan email menggunakan POST. Validasi dilakukan di server:
- Semua kolom wajib diisi.
- NIM harus terdiri dari 9 angka.
- Semester harus berupa bilangan bulat 1 sampai 14.
- Email harus memiliki format yang valid.
- Data ditampilkan kembali menggunakan `htmlspecialchars()`.

## Contoh Pengujian

### Contoh input valid
1. Latihan 6: Nama `Farid Iman Nandar`, Program Studi `Teknik Informatika`. Hasil: data diterima dan ditampilkan.
2. Latihan 7: Barang `Buku`, Harga `15000`, Jumlah `2`. Hasil subtotal: `Rp30.000`.
3. Mini Project: Nama `Farid Iman Nandar`, NIM `312510102`, Program Studi `Teknik Informatika`, Semester `3`, Email `farid@example.com`. Hasil: ringkasan data mahasiswa ditampilkan.

### Contoh input tidak valid
1. Latihan 6: Nama diisi tetapi program studi dikosongkan. Hasil: pesan semua kolom wajib diisi.
2. Latihan 7: Harga negatif atau jumlah `0`. Hasil: pesan untuk memeriksa kembali input.
3. Mini Project: Email tanpa format email yang benar, semester `15`, atau NIM mengandung huruf. Hasil: seluruh pesan kesalahan yang sesuai ditampilkan.

## Catatan
- Ketentuan NIM 9 angka pada Mini Project merupakan ketentuan yang ditetapkan untuk contoh aplikasi ini. Sesuaikan jika ketentuan dari dosen berbeda.
- Form HTML menggunakan atribut seperti `required`, `min`, dan `max` untuk membantu pengguna. Pemeriksaan utama tetap dilakukan oleh PHP di server.
- `htmlspecialchars()` digunakan ketika menampilkan input pengguna agar karakter khusus tidak diperlakukan sebagai HTML.
- Metode POST tidak mengenkripsi data. Untuk pengiriman data melalui jaringan, gunakan HTTPS.

## Pengumpulan
Sesuai modul, ambil screenshot browser yang menunjukkan hasil setiap latihan serta pengujian validasi form. Setelah itu, commit folder proyek ke repository dan kumpulkan URL repository sesuai arahan dosen.
