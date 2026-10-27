<?php
session_start();

if (!isset($_SESSION["login"])) {
    header("Location: login.php");
    exit;
}

require_once "koneksi.php";
require_once "Barang.php";

if ($_SERVER["REQUEST_METHOD"] != "POST") {
    header("Location: index.php");
    exit;
}

$kode = strtoupper(trim($_POST["kode"] ?? ""));
$nama = trim($_POST["nama"] ?? "");
$kategori = (int) ($_POST["kategori"] ?? 0);
$jumlah = (int) ($_POST["jumlah"] ?? 0);
$kondisi = $_POST["kondisi"] ?? "";
$harga = (float) ($_POST["harga_satuan"] ?? -1);

if (!preg_match('/^BRG-\d+$/', $kode) || $nama == "" || $kategori <= 0 || $jumlah <= 0 || $harga < 0) {
    $_SESSION["pesan"] = "Data barang tidak valid!";
    $_SESSION["jenis_pesan"] = "error";
    header("Location: index.php");
    exit;
}

$cek = $pdo->prepare("SELECT COUNT(*) FROM barang WHERE kode_barang = ?");
$cek->execute([$kode]);

if ($cek->fetchColumn() > 0) {
    $_SESSION["pesan"] = "Kode barang sudah digunakan!";
    $_SESSION["jenis_pesan"] = "error";
    header("Location: index.php");
    exit;
}

$barang = new Barang($nama, $jumlah, $harga);
$total = $barang->hitungTotal();

$stmt = $pdo->prepare("INSERT INTO barang
(kode_barang, nama_barang, id_kategori, jumlah, kondisi, harga_satuan)
VALUES (?, ?, ?, ?, ?, ?)");

$stmt->execute([$kode, $nama, $kategori, $jumlah, $kondisi, $harga]);

$namaKategori = $pdo->prepare("SELECT nama_kategori FROM kategori WHERE id_kategori = ?");
$namaKategori->execute([$kategori]);
$hasilKategori = $namaKategori->fetchColumn();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Pemrosesan Data Barang</title>
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
        <tr><th>Keterangan</th><th>Hasil</th></tr>
        <tr><td>Kode Barang</td><td><?= htmlspecialchars($kode) ?></td></tr>
        <tr><td>Nama Barang</td><td><?= htmlspecialchars($nama) ?></td></tr>
        <tr><td>Kategori</td><td><?= htmlspecialchars($hasilKategori) ?></td></tr>
        <tr><td>Jumlah</td><td><?= $jumlah ?></td></tr>
        <tr><td>Kondisi</td><td><?= htmlspecialchars($kondisi) ?></td></tr>
        <tr><td>Harga Satuan</td><td>Rp <?= number_format($harga, 0, ',', '.') ?></td></tr>
        <tr>
            <th>Total Estimasi Aset</th>
            <th>Rp <?= number_format($total, 0, ',', '.') ?></th>
        </tr>
    </table>

    <p>Data barang berhasil diproses oleh PHP.</p>
    <a href="index.php">Kembali ke SIM-Barang</a>
</section>
</main>

<footer>
    <p>&copy; 2026 SIM-Barang - Politeknik Negeri Sriwijaya</p>
</footer>
</body>
</html>
```