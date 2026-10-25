
<?php
session_start();

if (!isset($_SESSION["login"])) {
    header("Location: login.php");
    exit;
}

require_once "koneksi.php";
require_once "Barang.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: index.php");
    exit;
}

$kode = strtoupper(trim($_POST["kode"]));
$nama = trim($_POST["nama"]);
$kategori = (int) $_POST["kategori"];
$jumlah = (int) $_POST["jumlah"];
$kondisi = $_POST["kondisi"];
$harga = (float) $_POST["harga_satuan"];

if (!preg_match('/^BRG-\d+$/', $kode) || $nama == "" || $kategori <= 0 || $jumlah <= 0 || $harga < 0) {
    die("Data tidak valid!");
}

$barang = new Barang($nama, $jumlah, $harga);
$total = $barang->hitungTotal();

$sql = "INSERT INTO barang
(kode_barang, nama_barang, id_kategori, jumlah, kondisi, harga_satuan)
VALUES (?, ?, ?, ?, ?, ?)";

$stmt = $pdo->prepare($sql);
$stmt->execute([$kode, $nama, $kategori, $jumlah, $kondisi, $harga]);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Barang Tersimpan</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <main>
        <section>
            <h2>Barang Berhasil Disimpan!</h2>
            <p>Kode Barang: <?= htmlspecialchars($kode) ?></p>
            <p>Nama Barang: <?= htmlspecialchars($nama) ?></p>
            <p>Jumlah: <?= $jumlah ?></p>
            <p>Total Aset: Rp <?= number_format($total, 0, ',', '.') ?></p>
            <a href="index.php">Kembali ke SIM-Barang</a>
        </section>
    </main>
</body>
</html>
