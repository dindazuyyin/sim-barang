<?php
session_start();

if (!isset($_SESSION["login"])) {
    header("Location: login.php");
    exit;
}

require_once "koneksi.php";

$kode = $_GET["kode"] ?? "";

$stmt = $pdo->prepare("DELETE FROM barang WHERE kode_barang = ?");
$stmt->execute([$kode]);

if ($stmt->rowCount() > 0) {
    $_SESSION["pesan"] = "Barang berhasil dihapus!";
    $_SESSION["jenis_pesan"] = "success";
} else {
    $_SESSION["pesan"] = "Barang tidak ditemukan!";
    $_SESSION["jenis_pesan"] = "error";
}

header("Location: index.php");
exit;
