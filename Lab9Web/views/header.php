<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Lab 9 - PHP Modular</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<div class="container">
    <header class="site-header">
        <div>
            <h1>Praktikum 9: PHP Modular</h1>
            <p>Modularisasi Program, Function, Template, dan Routing</p>
        </div>
        <div class="account">
            <?php if (!empty($_SESSION['user'])): ?>
                Login: <strong><?= e($_SESSION['user']['nama']) ?></strong>
                <a href="index.php?page=logout">Keluar</a>
            <?php else: ?>
                <a href="index.php?page=login">Login admin</a>
            <?php endif; ?>
        </div>
    </header>
    <nav>
        <a class="<?= e(isActive($page, 'dashboard')) ?>" href="index.php">Dashboard</a>
        <a class="<?= e(isActive($page, 'home')) ?>" href="index.php?page=home">Home</a>
        <a class="<?= e(isActive($page, 'profil')) ?>" href="index.php?page=profil">Profil</a>
        <a class="<?= e(isActive($page, 'kontak')) ?>" href="index.php?page=kontak">Kontak</a>
        <a class="<?= e(isActive($page, 'functions')) ?>" href="index.php?page=functions">Demo Function</a>
        <a class="<?= str_starts_with($page, 'user/') ? 'active' : '' ?>" href="index.php?page=user/list">Data Pengguna</a>
    </nav>
    <main>
        <?php tampilkanFlash(); ?>
