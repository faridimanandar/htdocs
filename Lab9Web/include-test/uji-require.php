<?php
echo "Sebelum pemanggilan require.<br>";
require __DIR__ . '/pesan.php';
echo "Sesudah pemanggilan require. Baris ini tidak dijalankan jika file wajib tidak ditemukan.<br>";
