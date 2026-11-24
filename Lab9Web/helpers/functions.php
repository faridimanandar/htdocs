<?php
declare(strict_types=1);

function e(string $value): string
{
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}

function formatRupiah(float $angka): string
{
    return 'Rp ' . number_format($angka, 0, ',', '.');
}

function hitungDiskon(float $harga, float $persen = 10): float
{
    return $harga * ($persen / 100);
}

function validasiEmail(string $email): bool
{
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}

function ringkasTeks(string $teks, int $batas = 50): string
{
    $teks = trim($teks);
    if (mb_strlen($teks, 'UTF-8') <= $batas) {
        return $teks;
    }
    return mb_substr($teks, 0, max(0, $batas - 3), 'UTF-8') . '...';
}

function konversiCelciusKeFahrenheit(float $c): float
{
    return ($c * 9 / 5) + 32;
}

function tentukanStatusNilai(float $nilai): string
{
    if ($nilai < 0 || $nilai > 100) {
        return 'Nilai tidak valid';
    }
    if ($nilai >= 85) return 'A';
    if ($nilai >= 70) return 'B';
    if ($nilai >= 55) return 'C';
    if ($nilai >= 40) return 'D';
    return 'E';
}

function hitungTotal(float $harga, int $jumlah): float
{
    return max(0, $harga) * max(0, $jumlah);
}

function setFlash(string $type, string $message): void
{
    $_SESSION['flash'] = ['type' => $type, 'message' => $message];
}

function tampilkanFlash(): void
{
    if (!empty($_SESSION['flash'])) {
        $flash = $_SESSION['flash'];
        $class = $flash['type'] === 'success' ? 'success' : 'error';
        echo '<div class="alert ' . $class . '">' . e($flash['message']) . '</div>';
        unset($_SESSION['flash']);
    }
}

function csrfToken(): string
{
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function validasiCsrf(): void
{
    $token = $_POST['csrf_token'] ?? '';
    if (!is_string($token) || !hash_equals($_SESSION['csrf_token'] ?? '', $token)) {
        http_response_code(403);
        exit('Permintaan ditolak: token keamanan tidak valid.');
    }
}

function wajibLogin(): void
{
    if (empty($_SESSION['user'])) {
        setFlash('error', 'Silakan login terlebih dahulu untuk membuka menu pengguna.');
        header('Location: index.php?page=login');
        exit;
    }
}

function isActive(string $current, string $target): string
{
    return $current === $target ? 'active' : '';
}
