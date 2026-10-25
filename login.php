
<?php
session_start();

// Data pengguna
$users = [
    "admin" => "password123"
];

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST["username"] ?? "");
    $password = $_POST["password"] ?? "";

    if (isset($users[$username]) && $users[$username] === $password) {
        session_regenerate_id(true);
        $_SESSION["login"] = true;
        $_SESSION["username"] = $username;

        header("Location: index.php");
        exit;
    } else {
        $error = "Username atau password salah!";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login SIM-Barang</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<header>
    <h1>SIM-Barang</h1>
    <p>Login Pengguna</p>
</header>

<main>
    <section>
        <h2>Masuk ke Sistem</h2>

        <?php if ($error): ?>
            <p style="color:red;">
                <?= htmlspecialchars($error) ?>
            </p>
        <?php endif; ?>

        <form method="POST" action="login.php">
            <label>Username</label>
            <input type="text" name="username"
                   placeholder="Masukkan username" required>

            <label>Password</label>
            <input type="password" name="password"
                   placeholder="Masukkan password" required>

            <button type="submit">Login</button>
        </form>
    </section>
</main>

<footer>
    <p>&copy; 2026 SIM-Barang - Politeknik Negeri Sriwijaya</p>
</footer>

</body>
</html>
