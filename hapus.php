
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

header("Location: index.php");
exit;
?>
