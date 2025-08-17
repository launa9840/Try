<?php
session_start();
require 'db.php';

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];

    // Check if email exists in database
    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        // Normally, here you'd generate a token and send an email with a reset link.
        // For simplicity, we will just allow user to reset password here.

        $_SESSION['reset_email'] = $email;
        header("Location: reset_password.php");
        exit();
    } else {
        $message = "Email address not found.";
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Forgot Password | NepBus</title>
<link rel="stylesheet" href="styles.css" />
</head>
<body>

<?php include 'navbar.php'; ?>

<div class="login-container">
    <h2>Forgot Password</h2>
    <?php if ($message) echo "<p style='color: red;'>$message</p>"; ?>
    <form method="POST" action="">
        <label>Enter your email address:</label>
        <input type="email" name="email" required />
        <button type="submit">Submit</button>
    </form>
    <p><a href="login.php" style="color: rgb(7, 113, 219);">Back to login</a></p>
</div>

</body>
</html>
