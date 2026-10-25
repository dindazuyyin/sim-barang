<?php

session_start();

if (!isset($_SESSION["login"])) {
    header("Location: login.php");
    exit;
}

// Memeriksa pengiriman formulir
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: index.php");
    exit;
}

// Mengambil data dari formulir
$kode = trim($_POST["kode"] ?? "");
$nama = trim($_POST["nama"] ?? "");
$kategori = trim($_POST["kategori"] ?? "");
$jumlah = (int) ($_POST["jumlah"] ?? 0);
$kondisi = trim($_POST["kondisi"] ?? "");
$harga = (float) ($_POST["harga_satuan"] ?? 0);

// Fungsi menghitung total aset
function hitungTotalAset($jumlah, $harga) {
    return $jumlah * $harga;
}

// Validasi data
if (
    !preg_match('/^BRG-\d+$/', $kode) ||
    $nama === "" ||
    $kategori === "" ||
    $jumlah <= 0 ||
    $kondisi === "" ||
    $harga < 0
) {
    die("Data tidak valid. Silakan kembali dan periksa formulir.");
}

// Menghitung total aset
$total = hitungTotalAset($jumlah, $harga);

// Mengamankan tampilan teks
function aman($data) {
    return htmlspecialchars($data, ENT_QUOTES, "UTF-8");
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Input Barang - SIM-Barang</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<header>
    <h1>SIM-Barang</h1>
    <p>Hasil Pemrosesan Data Barang</p>
</header>

<main>
    <section>
        <h2>Ringkasan Barang Berhasil Diproses</h2>

        <table>
            <tr>
                <th>Keterangan</th>
                <th>Hasil</th>
            </tr>
            <tr>
                <td>Kode Barang</td>
                <td><?= aman($kode) ?></td>
            </tr>
            <tr>
                <td>Nama Barang</td>
                <td><?= aman($nama) ?></td>
            </tr>
            <tr>
                <td>Kategori</td>
                <td><?= aman($kategori) ?></td>
            </tr>
            <tr>
                <td>Jumlah</td>
                <td><?= $jumlah ?></td>
            </tr>
            <tr>
                <td>Kondisi</td>
                <td><?= aman($kondisi) ?></td>
            </tr>
            <tr>
                <td>Harga Satuan</td>
                <td>Rp <?= number_format($harga, 0, ',', '.') ?></td>
            </tr>
            <tr>
                <th>Total Estimasi Aset</th>
                <th>Rp <?= number_format($total, 0, ',', '.') ?></th>
            </tr>
        </table>

        <p>Data barang berhasil diproses oleh PHP.</p>

        <a href="index.html">Kembali ke SIM-Barang</a>
    </section>
</main>

<footer>
    <p>&copy; 2026 SIM-Barang - Politeknik Negeri Sriwijaya</p>
</footer>
<a href="index.php">Kembali ke SIM-Barang</a>

</body>
</html>
