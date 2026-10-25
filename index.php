
<?php
session_start();

if (!isset($_SESSION["login"])) {
    header("Location: login.php");
    exit;
}

require_once "koneksi.php";

$stmtBarang = $pdo->query("
    SELECT barang.*, kategori.nama_kategori
    FROM barang
    INNER JOIN kategori ON barang.id_kategori = kategori.id_kategori
    ORDER BY barang.id_barang DESC
");
$dataBarang = $stmtBarang->fetchAll();

$dataKategori = $pdo->query(
    "SELECT * FROM kategori ORDER BY nama_kategori ASC"
)->fetchAll();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIM-Barang</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<header>
    <h1>SIM-Barang</h1>
    <p>Sistem Inventaris Barang Jurusan</p>
</header>

<nav>
    <a href="#beranda">Beranda</a>
    <a href="#inventaris">Inventaris</a>
    <a href="#form">Tambah Barang</a>
    <a href="logout.php">Logout</a>
</nav>

<main id="beranda">

    <section id="inventaris">
        <h2>Data Inventaris Barang</h2>

        <input type="text" id="cari" placeholder="Cari nama atau kode barang...">

        <table>
            <thead>
                <tr>
                    <th>Kode</th>
                    <th>Nama Barang</th>
                    <th>Kategori</th>
                    <th>Jumlah</th>
                    <th>Kondisi</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody id="daftarBarang">
                <?php if ($dataBarang): ?>
                    <?php foreach ($dataBarang as $barang): ?>
                    <tr>
                        <td><?= htmlspecialchars($barang["kode_barang"]) ?></td>
                        <td><?= htmlspecialchars($barang["nama_barang"]) ?></td>
                        <td><?= htmlspecialchars($barang["nama_kategori"]) ?></td>
                        <td><?= htmlspecialchars($barang["jumlah"]) ?></td>
                        <td><?= htmlspecialchars($barang["kondisi"]) ?></td>
                        <td>
                            <a href="edit.php?kode=<?= urlencode($barang["kode_barang"]) ?>">Edit</a> |
                            <a href="hapus.php?kode=<?= urlencode($barang["kode_barang"]) ?>"
                               onclick="return confirm('Yakin ingin menghapus barang ini?')">Hapus</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6">Belum ada data barang.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </section>

    <section id="form">
        <h2>Form Input Barang</h2>

        <form id="barangForm" action="simpan.php" method="POST">
            <label for="kode">Kode Barang</label>
            <input type="text" id="kode" name="kode" placeholder="BRG-003" required>

            <label for="nama">Nama Barang</label>
            <input type="text" id="nama" name="nama" placeholder="Nama barang" required>

            <label for="kategori">Kategori</label>
            <select id="kategori" name="kategori" required>
                <option value="">Pilih Kategori</option>
                <?php foreach ($dataKategori as $kategori): ?>
                    <option value="<?= $kategori["id_kategori"] ?>">
                        <?= htmlspecialchars($kategori["nama_kategori"]) ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <label for="jumlah">Jumlah</label>
            <input type="number" id="jumlah" name="jumlah" min="1" required>

            <label for="kondisi">Kondisi</label>
            <select id="kondisi" name="kondisi" required>
                <option value="">Pilih Kondisi</option>
                <option value="Baik">Baik</option>
                <option value="Rusak Ringan">Rusak Ringan</option>
                <option value="Rusak Berat">Rusak Berat</option>
            </select>

            <label for="harga_satuan">Harga Satuan (Rp)</label>
            <input type="number" id="harga_satuan" name="harga_satuan" min="0" required>

            <button type="submit">Simpan Barang</button>
        </form>

        <div id="toast"></div>
    </section>

</main>

<footer>
    <p>&copy; 2026 SIM-Barang - Politeknik Negeri Sriwijaya</p>
</footer>

<script src="main.js" defer></script>

</body>
</html>
