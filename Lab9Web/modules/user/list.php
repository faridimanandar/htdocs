<?php
wajibLogin();
$stmt = $pdo->query('SELECT id, nama, email, created_at FROM users ORDER BY id DESC');
$users = $stmt->fetchAll();
?>
<section class="card">
    <div class="section-heading">
        <h2>Data Pengguna</h2>
        <a class="button" href="index.php?page=user/add">+ Tambah Pengguna</a>
    </div>
    <?php if (!$users): ?>
        <p>Belum ada data pengguna.</p>
    <?php else: ?>
    <div class="table-wrap">
    <table>
        <tr><th>No.</th><th>Nama</th><th>Email</th><th>Dibuat</th><th>Aksi</th></tr>
        <?php foreach ($users as $i => $user): ?>
        <tr>
            <td><?= $i + 1 ?></td>
            <td><?= e($user['nama']) ?></td>
            <td><?= e($user['email']) ?></td>
            <td><?= e($user['created_at']) ?></td>
            <td class="actions">
                <a href="index.php?page=user/edit&id=<?= (int) $user['id'] ?>">Edit</a>
                <form method="post" action="index.php?page=user/delete" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                    <input type="hidden" name="csrf_token" value="<?= e(csrfToken()) ?>">
                    <input type="hidden" name="id" value="<?= (int) $user['id'] ?>">
                    <button class="link-button danger-text" type="submit">Hapus</button>
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
    </div>
    <?php endif; ?>
</section>
