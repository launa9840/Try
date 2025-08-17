<?php
session_start();
require 'db.php';

if (!isset($_SESSION['reset_email'])) {
    header("Location: forgot_password.php");
    exit();
}

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if ($password !== $confirm_password) {
        $message = "Passwords do not match.";
    } else {
        $hashedPass = password_hash($password, PASSWORD_DEFAULT);
        $email = $_SESSION['reset_email'];

        $stmt = $conn->prepare("UPDATE users SET password = ? WHERE email = ?");
        $stmt->bind_param("ss", $hashedPass, $email);
        if ($stmt->execute()) {
            unset($_SESSION['reset_email']);
            $_SESSION['success'] = "Password reset successful. You can now login.";
            header("Location: login.php");
            exit();
        } else {
            $message = "Failed to update password.";
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Reset Password | NepBus</title>
<link rel="stylesheet" href="styles.css" />
</head>
<body>

<?php include 'navbar.php'; ?>

<div class="login-container">
    <h2>Reset Password</h2>
    <?php if ($message) echo "<p style='color: red;'>$message</p>"; ?>
    <form method="POST" action="">
        <label>New Password:</label>
        <input type="password" name="password" required />
        <label>Confirm Password:</label>
        <input type="password" name="confirm_password" required />
        <button type="submit">Reset Password</button>
    </form>
</div>

</body>
</html>
