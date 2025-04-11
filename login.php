<?php
session_start(); // Start sessie

// Databaseverbinding
$dsn = "mysql:host=localhost;dbname=login2fa;charset=utf8mb4";
$user = "root";
$pass = "";

$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
];

include "GoogleAuthenticator.php"; // Inclusie van 2FA class

use PHPGangsta\GoogleAuthenticator;

$ga = new GoogleAuthenticator();

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST["username"]);
    $password = trim($_POST["password"]);
    $code = trim($_POST["code"]);

    if (empty($username) || empty($password) || empty($code)) {
        $error = "Vul alle velden in!";
    } else {
        try {
            $pdo = new PDO($dsn, $user, $pass, $options);
            $stmt = $pdo->prepare("SELECT id, password, 2fa_secret FROM users WHERE username = ?");
            $stmt->execute([$username]);
            $user = $stmt->fetch();

            if ($user && password_verify($password, $user["password"])) {
                // Controleer de 2FA-code
                if ($ga->verifyCode($user["2fa_secret"], $code, 2)) {
                    $_SESSION["user_id"] = $user["id"];
                    header("Location: index.php");
                    exit;
                } else {
                    $error = "Ongeldige 2FA-code!";
                }
            } else {
                $error = "Ongeldige gebruikersnaam of wachtwoord!";
            }
        } catch (PDOException $e) {
            $error = "Fout bij inloggen: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <h2>Login</h2>

    <?php if (!empty($error)): ?>
        <p style="color: red;"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <form method="post">
        <label for="username">Gebruikersnaam</label>
        <input type="text" id="username" name="username" required><br>

        <label for="password">Wachtwoord</label>
        <input type="password" id="password" name="password" required><br>

        <label for="code">2FA-code</label>
        <input type="text" id="code" name="code" required><br>

        <button type="submit">Login</button>
    </form>

    <a href="registreren.php">Registreren</a>
</body>
</html>
