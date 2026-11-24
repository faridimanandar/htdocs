<section class="card">
    <h2>Demo Library Function</h2>
    <p>Semua function berikut dimuat dari <code>helpers/functions.php</code>.</p>
    <table>
        <tr><th>Function</th><th>Contoh pemanggilan</th><th>Hasil</th></tr>
        <tr><td>formatRupiah()</td><td>formatRupiah(150000)</td><td><?= e(formatRupiah(150000)) ?></td></tr>
        <tr><td>hitungDiskon()</td><td>hitungDiskon(200000, 15)</td><td><?= e(formatRupiah(hitungDiskon(200000, 15))) ?></td></tr>
        <tr><td>validasiEmail()</td><td>validasiEmail('farid@example.com')</td><td><?= validasiEmail('farid@example.com') ? 'Email valid' : 'Email tidak valid' ?></td></tr>
        <tr><td>ringkasTeks()</td><td>ringkasTeks(teks, 25)</td><td><?= e(ringkasTeks('Praktikum PHP modular membuat kode lebih terstruktur dan mudah dirawat.', 25)) ?></td></tr>
        <tr><td>konversiCelciusKeFahrenheit()</td><td>konversiCelciusKeFahrenheit(25)</td><td><?= e((string) konversiCelciusKeFahrenheit(25)) ?> °F</td></tr>
        <tr><td>tentukanStatusNilai()</td><td>tentukanStatusNilai(88)</td><td><?= e(tentukanStatusNilai(88)) ?></td></tr>
        <tr><td>hitungTotal()</td><td>hitungTotal(5000, 3)</td><td><?= e(formatRupiah(hitungTotal(5000, 3))) ?></td></tr>
    </table>
</section>
