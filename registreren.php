<?php
// Auteur: 

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

$qrCodeUrl = "";
$secret = "";
$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST["username"]);
    $password = trim($_POST["password"]);

    if (empty($username) || empty($password)) {
        $error = "Vul alle velden in!";
    } else {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $secret = $ga->createSecret(); // 2FA Secret key genereren

        try {
            $pdo = new PDO($dsn, $user, $pass, $options);
            $stmt = $pdo->prepare("INSERT INTO users (username, password, 2fa_secret) VALUES (?, ?, ?)");

            $stmt->execute([$username, $hashedPassword, $secret]);

            // Genereer QR-code URL
            $qrCodeUrl = $ga->getQRCodeGoogleUrl("TCRHELDEN", $secret);
        } catch (PDOException $e) {
            $error = "Fout bij registratie: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registreren</title>
</head>
<body>
    <h1>Registreren</h1>

    <?php if (!empty($error)): ?>
        <p style="color: red;"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <form method="post">
        <label>Gebruikersnaam:</label>
        <input type="text" name="username" required><br>

        <label>Wachtwoord:</label>
        <input type="password" name="password" required><br>

        <button type="submit">Registreer</button>
    </form>

    <?php if (!empty($qrCodeUrl)): ?>
        <h3>Registratie succesvol! Scan deze QR-code met Google Authenticator:</h3>
        <img src="<?= htmlspecialchars($qrCodeUrl) ?>" alt="QR Code"><br>
        <p>Sla de geheime sleutel op: <strong><?= htmlspecialchars($secret) ?></strong></p>
    <?php endif; ?>

    <a href="login.php">Login</a>
</body>
</html>
