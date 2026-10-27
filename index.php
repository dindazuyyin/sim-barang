<?php
session_start();

// Mengecek apakah pengguna sudah login
if (!isset($_SESSION["login"])) {
    header("Location: login.php");
    exit;
}

// Menghubungkan ke database
require_once "koneksi.php";

// Mengambil data barang dan kategori
$sql = "SELECT barang.*, kategori.nama_kategori
        FROM barang
        JOIN kategori ON barang.id_kategori = kategori.id_kategori";

$query = $pdo->query($sql);
$dataBarang = $query->fetchAll();

// Mengambil daftar kategori
$queryKategori = $pdo->query("SELECT * FROM kategori");
$dataKategori = $queryKategori->fetchAll();
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

<!-- Header halaman -->
<header>
    <h1>SIM-Barang</h1>
    <p>Sistem Inventaris Barang Jurusan</p>
</header>

<!-- Menu navigasi -->
<nav>
    <a href="#inventaris">Inventaris</a>
    <a href="#form">Tambah Barang</a>
    <a href="logout.php">Logout</a>
</nav>

<main>

    <!-- Menampilkan data inventaris -->
    <section id="inventaris">
        <h2>Data Inventaris Barang</h2>

        <!-- Notifikasi berhasil atau gagal -->
        <?php if (isset($_SESSION["pesan"])): ?>
            <div class="notifikasi <?= htmlspecialchars($_SESSION["jenis_pesan"] ?? "success") ?>">
                <?= htmlspecialchars($_SESSION["pesan"]) ?>
            </div>
            <?php
            unset($_SESSION["pesan"]);
            unset($_SESSION["jenis_pesan"]);
            ?>
        <?php endif; ?>

        <!-- Pencarian barang -->
        <input type="text" id="cari" placeholder="Cari barang...">

        <table id="daftarBarang">
            <tr>
                <th>Kode</th>
                <th>Nama</th>
                <th>Kategori</th>
                <th>Jumlah</th>
                <th>Kondisi</th>
                <th>Harga Satuan</th>
                <th>Total Harga</th>
                <th>Aksi</th>
            </tr>

            <?php if (count($dataBarang) > 0): ?>
                <?php foreach ($dataBarang as $barang): ?>
                    <tr>
                        <td><?= htmlspecialchars($barang["kode_barang"]) ?></td>
                        <td><?= htmlspecialchars($barang["nama_barang"]) ?></td>
                        <td><?= htmlspecialchars($barang["nama_kategori"]) ?></td>
                        <td><?= $barang["jumlah"] ?></td>
                        <td><?= htmlspecialchars($barang["kondisi"]) ?></td>

                        <!-- Harga satuan -->
                        <td>
                            Rp <?= number_format($barang["harga_satuan"], 0, ',', '.') ?>
                        </td>

                        <!-- Total harga -->
                        <td>
                            Rp <?= number_format(
                                $barang["jumlah"] * $barang["harga_satuan"],
                                0,
                                ',',
                                '.'
                            ) ?>
                        </td>

                        <td>
                            <a href="edit.php?kode=<?= urlencode($barang["kode_barang"]) ?>">Edit</a> |
                            <a href="hapus.php?kode=<?= urlencode($barang["kode_barang"]) ?>"
                               onclick="return confirm('Yakin ingin menghapus barang?')">
                                Hapus
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="8">Belum ada data barang.</td>
                </tr>
            <?php endif; ?>
        </table>
    </section>

    <!-- Form untuk menambah barang -->
    <section id="form">
        <h2>Form Input Barang</h2>
        <div id="toast" style="display:none;"></div>

        <form id="barangForm" action="simpan.php" method="POST">

            <label>Kode Barang</label>
            <input type="text" name="kode" id="kode" placeholder="BRG-003" required>

            <label>Nama Barang</label>
            <input type="text" name="nama" id="nama" required>

            <label>Kategori</label>
            <select name="kategori" required>
                <option value="">Pilih Kategori</option>
                <?php foreach ($dataKategori as $kategori): ?>
                    <option value="<?= $kategori["id_kategori"] ?>">
                        <?= htmlspecialchars($kategori["nama_kategori"]) ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <label>Jumlah</label>
            <input type="number" name="jumlah" id="jumlah" min="1" required>

            <label>Kondisi</label>
            <select name="kondisi" required>
                <option value="">Pilih Kondisi</option>
                <option value="Baik">Baik</option>
                <option value="Rusak Ringan">Rusak Ringan</option>
                <option value="Rusak Berat">Rusak Berat</option>
            </select>

            <label>Harga Satuan</label>
            <input type="number" name="harga_satuan" min="0" required>

            <button type="submit">Simpan Barang</button>
        </form>
    </section>

</main>

<!-- Footer halaman -->
<footer>
    <p>&copy; 2026 SIM-Barang - Politeknik Negeri Sriwijaya</p>
</footer>

<!-- Memanggil file JavaScript -->
<script src="main.js" defer></script>

</body>
</html>
