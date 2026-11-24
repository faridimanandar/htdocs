# Lab9Web — Praktikum 9 PHP Modular

## 1. Deskripsi
Project ini mengerjakan materi Praktikum 9: PHP Modular, meliputi pengujian pemanggilan file PHP, template multi-halaman, library function, struktur direktori, routing whitelist, URL rewrite opsional, dan contoh integrasi CRUD database.

> Catatan integrasi: PDF meminta refactoring aplikasi CRUD dari praktikum sebelumnya. Karena source project CRUD sebelumnya tidak disertakan bersama modul ini, project ini menyediakan contoh CRUD pengguna mandiri menggunakan PDO. Jika tabel/project praktikum sebelumnya berbeda, sesuaikan nama tabel, kolom, dan query di `modules/user/` tanpa mencampur PDO dan MySQLi.

## 2. Kebutuhan perangkat
- Windows/Linux/macOS.
- XAMPP atau Laragon (Apache, PHP, MySQL/MariaDB).
- PHP 7.4+ (disarankan PHP 8+), ekstensi PDO MySQL, dan ekstensi mbstring.
- Visual Studio Code atau editor lain.
- Browser dan Git.

## 3. Struktur direktori
```text
Lab9Web/
├── index.php
├── setup.php
├── database.sql
├── .htaccess
├── config/
│   └── database.php
├── views/
│   ├── header.php
│   ├── footer.php
│   ├── dashboard.php
│   ├── home.php
│   ├── profil.php
│   ├── kontak.php
│   ├── functions-demo.php
│   └── 404.php
├── helpers/
│   └── functions.php
├── modules/
│   ├── user/
│   │   ├── list.php
│   │   ├── add.php
│   │   ├── edit.php
│   │   └── delete.php
│   └── auth/
│       ├── login.php
│       └── logout.php
├── include-test/
│   ├── pesan.php
│   ├── uji-include.php
│   ├── uji-require.php
│   └── uji-once.php
└── assets/
    └── css/
        └── style.css
```

## 4. Cara instalasi dan menjalankan
1. Ekstrak ZIP project.
2. Salin folder `Lab9Web` ke `C:\\xampp\\htdocs\\` (XAMPP) atau folder web root Laragon.
3. Jalankan Apache dan MySQL dari control panel.
4. Buka `http://localhost/phpmyadmin`.
5. Pilih menu **Import**, lalu impor file `database.sql`. Alternatif: buka tab SQL dan jalankan seluruh isi file tersebut.
6. Periksa `config/database.php`. Default XAMPP: host `localhost`, database `db_lab9web`, user `root`, password kosong. Ubah bila konfigurasi MySQL berbeda.
7. Buka `http://localhost/Lab9Web/setup.php` satu kali untuk membuat akun admin demo.
8. Catat akun demo: `admin@lab9.test` / `admin123`.
9. Hapus `setup.php` setelah akun berhasil dibuat.
10. Buka `http://localhost/Lab9Web/`.

## 5. Daftar rute
| URL | Fungsi | Akses |
|---|---|---|
| `index.php` | Dashboard | Umum |
| `index.php?page=home` | Home | Umum |
| `index.php?page=profil` | Profil | Umum |
| `index.php?page=kontak` | Kontak | Umum |
| `index.php?page=functions` | Demo helper function | Umum |
| `index.php?page=login` | Login admin | Umum |
| `index.php?page=logout` | Logout | Login |
| `index.php?page=user/list` | Daftar pengguna | Login |
| `index.php?page=user/add` | Tambah pengguna | Login |
| `index.php?page=user/edit&id=1` | Edit pengguna | Login |
| `index.php?page=user/delete` | Hapus melalui POST | Login |
| `index.php?page=alamat-tidak-ada` | Contoh halaman 404 | Umum |

## 6. Langkah penyelesaian praktikum

### A. Identitas dan capaian
Praktikum berfokus pada pemisahan program menjadi file dengan tanggung jawab jelas: konfigurasi, tampilan, helper, modul fitur, dan aset. Tujuannya agar kode dapat digunakan ulang, lebih mudah diuji, dan dirawat.

### B. Pengantar modularisasi
Tanpa modularisasi, header/footer, koneksi, dan proses yang sama berpotensi ditulis berulang. Dengan modularisasi, bagian bersama diletakkan dalam satu file. Perubahan navigasi cukup dilakukan pada `views/header.php`; perubahan fungsi umum cukup dilakukan pada `helpers/functions.php`.

### C. Pengujian include dan require
1. Buka `include-test/pesan.php`; file ini mencetak pesan sederhana.
2. Jalankan `http://localhost/Lab9Web/include-test/uji-include.php`.
3. Jalankan `http://localhost/Lab9Web/include-test/uji-require.php`.
4. Untuk menguji file hilang, ubah nama `pesan.php` sementara, lalu muat ulang kedua halaman. `include` memberi warning dan biasanya melanjutkan baris berikutnya. `require` menghasilkan error fatal dan menghentikan eksekusi.
5. Kembalikan nama file menjadi `pesan.php`.
6. Jalankan `uji-once.php`. File yang sama dimuat satu kali walaupun `require_once` dipanggil dua kali.
7. `include_once` bekerja seperti `include`, tetapi mencegah pemuatan berulang. `require_once` bekerja seperti `require`, sekaligus mencegah pemuatan berulang.
8. Gunakan `require_once` untuk konfigurasi inti yang wajib tersedia. Gunakan `__DIR__` agar path mengacu pada direktori file saat ini.

### D. Template multi-halaman
1. `views/header.php` berisi awal HTML, judul, navigasi, dan pembuka `<main>`.
2. `views/footer.php` menutup `<main>`, menampilkan footer, dan menutup dokumen.
3. `views/home.php`, `profil.php`, dan `kontak.php` hanya berisi konten khusus.
4. Jalankan halaman melalui `index.php?page=home`, `index.php?page=profil`, dan `index.php?page=kontak`.
5. Bandingkan: header, navigasi, dan footer sama; konten utama berbeda.
6. Ubah teks navigasi pada `header.php`; perubahan akan terlihat di semua halaman yang menggunakan template tersebut.
7. Halaman tidak meletakkan seluruh konten dalam header karena header adalah komponen bersama, sedangkan isi setiap halaman memiliki tujuan berbeda.

### E. Function PHP
Function adalah blok kode bernama yang dapat dipanggil berulang.
- Tanpa parameter: `tampilkanSalam()` tidak menerima data.
- Dengan parameter: parameter adalah variabel pada definisi function; argumen adalah nilai saat function dipanggil.
- `return` mengembalikan nilai untuk diproses lagi; `echo` langsung menampilkan keluaran.
- Type declaration menetapkan tipe parameter/nilai balik. Nilai default digunakan bila argumen opsional tidak diberikan.

Latihan function sudah disimpan dalam `helpers/functions.php`:
1. `konversiCelciusKeFahrenheit($c)`: rumus `(C × 9/5) + 32`.
2. `tentukanStatusNilai($nilai)`: A ≥ 85, B ≥ 70, C ≥ 55, D ≥ 40, E di bawah 40; di luar 0–100 dianggap tidak valid.
3. `hitungTotal($harga, $jumlah)`: mengalikan harga dengan jumlah.
4. Helper tambahan: `formatRupiah()`, `hitungDiskon()`, `validasiEmail()`, dan `ringkasTeks()`.
5. Semua function dipanggil dari halaman demo dan dapat digunakan dari modul lain dengan memuat helper melalui `require_once`.

Cara menguji: buka menu **Demo Function**. Ubah nilai contoh di `views/functions-demo.php` untuk mencoba hasil lain.

### F. Struktur direktori
- `index.php`: titik masuk dan router.
- `config/`: konfigurasi koneksi database.
- `views/`: template dan halaman tampilan.
- `helpers/`: function umum.
- `modules/`: fitur aplikasi, dipisahkan menurut domain.
- `assets/`: CSS dan JavaScript.
Pemisahan ini membuat lokasi file mudah ditemukan dan setiap file memiliki tanggung jawab lebih jelas.

### G. Routing aman
1. `index.php` membaca `$_GET['page']`, default-nya `dashboard`.
2. Router memeriksa nilai tersebut terhadap array `$routes`.
3. Hanya file yang sudah didaftarkan yang dapat dimuat.
4. Jika rute tidak dikenal atau parameter bukan string, status HTTP 404 dikirim dan `views/404.php` ditampilkan.
5. Uji `index.php?page=user/list`, `index.php?page=user/add`, dan `index.php?page=admin/rahasia`.
6. Jangan menggunakan `require $_GET['page'] . '.php'`. Input URL yang langsung dijadikan path dapat menyebabkan path traversal atau pemanggilan file yang tidak seharusnya.
7. Contoh ini memiliki lebih dari lima rute dan halaman 404.

### H. URL ringkas dengan .htaccess (opsional)
File `.htaccess` mengaktifkan rewrite. `RewriteCond` memeriksa bahwa permintaan bukan file/folder fisik yang sudah ada. `RewriteRule` meneruskan URL lain ke `index.php?page=...`.
1. Pastikan Apache mengaktifkan `mod_rewrite`.
2. Pastikan konfigurasi Apache mengizinkan `AllowOverride All`.
3. Restart Apache.
4. Uji `http://localhost/Lab9Web/user/list`.
5. Jika tidak berfungsi, gunakan URL query biasa dan periksa konfigurasi Apache. Fitur ini opsional.

### I. Integrasi CRUD database
Project contoh menggunakan PDO dan database `db_lab9web`.
1. Database dibuat dari `database.sql`.
2. Koneksi dipusatkan pada `config/database.php`.
3. Header/footer berada pada `views/`.
4. Function validasi, format, CSRF, dan notifikasi berada pada `helpers/functions.php`.
5. CRUD pengguna berada pada `modules/user/`.
6. Router mendaftarkan semua halaman pada `$routes`.
7. Operasi tambah, edit, dan hapus menggunakan POST untuk perubahan data; input divalidasi di server dan token CSRF diperiksa.
8. Query menggunakan prepared statement untuk mengurangi risiko SQL injection.
9. Menu CRUD memerlukan login. Buat akun admin dengan `setup.php`, lalu hapus file setup tersebut setelah dipakai.
10. Uji tambah data, daftar data, edit data, dan hapus data. Pastikan hasil berubah pada tabel.

### J. Latihan terstruktur
- **Latihan 1 — Template multi-halaman:** selesai melalui Home, Profil, Kontak dengan header/footer bersama.
- **Latihan 2 — Library function:** selesai dengan empat function minimal yang diminta, ditambah function latihan E.
- **Latihan 3 — Router aman:** selesai dengan whitelist, lebih dari lima rute, dan 404.
- **Latihan 4 — Refactoring CRUD:** tersedia contoh CRUD modular. Untuk mengintegrasikan project CRUD lama, salin project lama terlebih dahulu, pindahkan koneksi ke config, tampilan ke views, helper ke helpers, fitur ke modules, lalu daftarkan rute dan sesuaikan query berdasarkan skema database lama.

### Tantangan mandiri
- Menu aktif: class `active` ditentukan berdasarkan `$page` di `views/header.php`.
- Pesan sukses/gagal: `setFlash()` dan `tampilkanFlash()` ada di helper.
- Pembatasan akses: `wajibLogin()` melindungi modul pengguna.
- URL rewrite: contoh konfigurasi ada di `.htaccess`.

### K. Debugging
| Gejala | Penyebab umum | Solusi |
|---|---|---|
| Failed opening required | Path salah/file tidak ada | Periksa folder dan gunakan `__DIR__` |
| Function already declared | Helper dimuat berulang | Gunakan `require_once` |
| CSS tidak tampil | URL aset salah | Periksa `assets/css/style.css` |
| Router 404 | Rute tidak ada di whitelist | Periksa parameter dan array `$routes` |
| Rewrite tidak bekerja | `mod_rewrite`/`AllowOverride` belum aktif | Periksa konfigurasi Apache |
| Konten ganda | Header/footer dipanggil berulang | Panggil layout hanya dari router |

## 7. Jawaban pertanyaan pemahaman

1. **Apa pengertian modularisasi program dan minimal tiga manfaatnya?**  
   Modularisasi adalah teknik membagi program menjadi bagian kecil berdasarkan tanggung jawab tertentu. Manfaatnya: mengurangi pengulangan kode, memudahkan pemeliharaan, memudahkan pengujian, meningkatkan penggunaan ulang function/template, serta memudahkan pembagian pekerjaan tim.

2. **Apa perbedaan include dan require ketika file tidak ditemukan?**  
   `include` menghasilkan peringatan dan eksekusi program umumnya berlanjut. `require` menghasilkan error fatal sehingga eksekusi dihentikan. Karena itu `require` dipakai untuk file yang wajib tersedia.

3. **Mengapa require_once sesuai untuk konfigurasi database?**  
   Koneksi database merupakan bagian inti yang harus tersedia. `require_once` menghentikan proses jika file tidak ditemukan dan mencegah file yang sama dimuat berulang kali, sehingga mengurangi risiko deklarasi atau inisialisasi ganda.

4. **Jelaskan perbedaan parameter, argumen, dan nilai return pada function.**  
   Parameter adalah variabel yang ditulis pada definisi function. Argumen adalah nilai yang diberikan ketika function dipanggil. Return adalah nilai yang dikirim kembali oleh function kepada pemanggil agar dapat disimpan atau dihitung lagi.

5. **Mengapa header dan footer dipisahkan dari konten halaman?**  
   Header dan footer merupakan bagian tampilan yang digunakan bersama. Pemisahan membuat tampilan konsisten dan perubahan cukup dilakukan satu kali. Konten tetap terpisah karena setiap halaman memiliki informasi berbeda.

6. **Apa fungsi index.php pada pola routing?**  
   `index.php` menjadi pintu masuk aplikasi. File ini membaca parameter `page`, memeriksa rute yang diizinkan, memuat header, modul/halaman yang sesuai, lalu footer.

7. **Mengapa router sebaiknya menggunakan whitelist rute?**  
   Whitelist membatasi halaman yang dapat dipanggil hanya pada daftar yang ditentukan pengembang. Ini membuat alur aplikasi lebih terkontrol dan mencegah input URL menentukan file secara bebas.

8. **Apa risiko jika input page langsung digabung menjadi path file yang di-require?**  
   Penyerang dapat mencoba path traversal atau meminta file yang tidak dimaksudkan untuk diakses. Akibatnya file internal berpotensi terpanggil. Gunakan pemetaan whitelist dari nama rute ke path file yang tetap.

9. **Apa fungsi RewriteCond dan RewriteRule pada .htaccess?**  
   `RewriteCond` menetapkan kondisi sebelum aturan dijalankan, misalnya mengecualikan file dan direktori yang benar-benar ada. `RewriteRule` menentukan pola URL dan tujuan pengalihan internal, misalnya meneruskan `/user/list` ke `index.php?page=user/list`.

10. **Bagian aplikasi CRUD apa yang tepat dipindahkan ke config, views, helpers, dan modules?**  
    `config`: koneksi database dan konfigurasi aplikasi. `views`: header, footer, dashboard, serta komponen tampilan. `helpers`: validasi, format data, escaping, dan function umum. `modules`: proses fitur CRUD seperti daftar, tambah, edit, hapus, serta autentikasi.

## 8. Pengujian yang harus dilakukan
- [ ] Dashboard tampil.
- [ ] Home, Profil, Kontak memakai header/footer yang sama.
- [ ] Uji include dan require saat file tersedia.
- [ ] Uji include dan require saat file sementara tidak ditemukan, lalu pulihkan nama file.
- [ ] Demo function menampilkan hasil yang benar.
- [ ] Rute valid tampil.
- [ ] Rute tidak dikenal menampilkan 404.
- [ ] Login dan logout berjalan.
- [ ] CRUD tambah, tampil, edit, dan hapus berjalan.
- [ ] Navigasi aktif dan notifikasi tampil.
- [ ] CSS tampil pada semua rute.
- [ ] `.htaccess` diuji jika konfigurasi Apache mendukungnya.

## 9. Screenshot laporan
Sesuai modul, ambil screenshot asli dari komputer setelah menjalankan project. Simpan misalnya pada folder `screenshots/`:
1. `01-struktur-folder.png` — struktur direktori di VS Code.
2. `02-template-home.png` — halaman Home.
3. `03-template-profil-kontak.png` — halaman Profil/Kontak.
4. `04-include-require.png` — pengujian include dan require.
5. `05-function.png` — halaman Demo Function.
6. `06-routing.png` — rute valid.
7. `07-404.png` — rute tidak dikenal.
8. `08-login.png` — halaman login.
9. `09-crud-list.png` — daftar pengguna.
10. `10-crud-form.png` — tambah/edit data dan hasilnya.

Screenshot harus diambil dari hasil program sendiri; jangan mengganti dengan gambar contoh yang tidak berasal dari pengujian.

## 10. Repository GitHub
Buat repository bernama **Lab9Web**. Dari terminal pada folder project:
```bash
git init
git add .
git commit -m "Praktikum 9 PHP Modular"
git branch -M main
git remote add origin https://github.com/USERNAME/Lab9Web.git
git push -u origin main
```
Ganti `USERNAME` dengan username GitHub sendiri. Setelah berhasil, salin URL repository dan kirim melalui e-learning sesuai instruksi dosen.

## 11. Catatan penyesuaian
- Jika MySQL menggunakan password, ubah `$pass` pada `config/database.php`.
- Jika PHP tidak memiliki `mbstring`, aktifkan ekstensi tersebut di konfigurasi PHP atau sesuaikan fungsi pemotongan teks.
- Jika project lama memakai MySQLi, pertahankan MySQLi secara konsisten saat memindahkan koneksi dan query. Jangan mencampur PDO dengan MySQLi tanpa alasan.
- Untuk penerapan nyata, gunakan HTTPS, password kuat, pembatasan percobaan login, dan konfigurasi server yang aman.
