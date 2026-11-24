<?php
echo "Sebelum pemanggilan include.<br>";
include __DIR__ . '/pesan.php';
echo "Sesudah pemanggilan include. Baris ini tetap dijalankan jika file tidak ditemukan.<br>";
