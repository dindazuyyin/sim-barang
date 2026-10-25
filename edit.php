
<?php
session_start();

if (!isset($_SESSION["login"])) {
    header("Location: login.php");
    exit;
}

require_once "koneksi.php";

$kode = $_GET["kode"] ?? "";

$stmt = $pdo->prepare("SELECT * FROM barang WHERE kode_barang = ?");
$stmt->execute([$kode]);
$barang = $stmt->fetch();

if (!$barang) {
    die("Barang tidak ditemukan!");
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nama = trim($_POST["nama"]);
    $kategori = (int) $_POST["kategori"];
    $jumlah = (int) $_POST["jumlah"];
    $kondisi = $_POST["kondisi"];
    $harga = (float) $_POST["harga_satuan"];

    if ($nama === "" || $kategori <= 0 || $jumlah <= 0 || $harga < 0) {
        die("Data tidak valid!");
    }

    $sql = "UPDATE barang SET nama_barang=?, id_kategori=?,
            jumlah=?, kondisi=?, harga_satuan=?
            WHERE kode_barang=?";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([$nama, $kategori, $jumlah, $kondisi, $harga, $kode]);

    header("Location: index.php");
    exit;
}

$kategori = $pdo->query("SELECT * FROM kategori")->fetchAll();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Barang</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<header>
    <h1>Edit Barang</h1>
</header>

<main>
<section>
    <form method="POST">
        <label>Nama Barang</label>
        <input type="text" name="nama"
            value="<?= htmlspecialchars($barang["nama_barang"]) ?>" required>

        <label>Kategori</label>
        <select name="kategori" required>
            <?php foreach ($kategori as $k): ?>
                <option value="<?= $k["id_kategori"] ?>"
                    <?= $barang["id_kategori"] == $k["id_kategori"] ? "selected" : "" ?>>
                    <?= htmlspecialchars($k["nama_kategori"]) ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label>Jumlah</label>
        <input type="number" name="jumlah"
            value="<?= $barang["jumlah"] ?>" min="1" required>

        <label>Kondisi</label>
        <select name="kondisi">
            <?php foreach (["Baik", "Rusak Ringan", "Rusak Berat"] as $k): ?>
                <option value="<?= $k ?>"
                    <?= $barang["kondisi"] == $k ? "selected" : "" ?>>
                    <?= $k ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label>Harga Satuan</label>
        <input type="number" name="harga_satuan"
            value="<?= $barang["harga_satuan"] ?>" min="0" required>

        <button type="submit">Simpan Perubahan</button>
        <a href="index.php">Batal</a>
    </form>
</section>
</main>

</body>
</html>
