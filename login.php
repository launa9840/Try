<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Login | NepBus</title>
<?php include 'navbar.php'; ?>
<link rel="stylesheet" href="styles.css" />
</head>
<body>
<div class="login-container">
    <h2>Login</h2>
    <?php
    if (isset($_SESSION['error'])) {
        echo "<p style='color:red; margin-bottom: 15px;'>" . $_SESSION['error'] . "</p>";
        unset($_SESSION['error']);
    }
    ?>
    <form action="login_process.php" method="POST">
        <label>Email:</label>
        <input type="email" name="email" required />

        <label>Password:</label>
        <input type="password" name="password" required />

        <label>Role:</label>
        <select name="role" required>
            <option value="user">User</option>
            <option value="admin">Admin</option>
        </select>

        <button type="submit">Login</button>
    </form>

    <p style="margin-top: 15px; text-align: center; font-size: 0.9rem; color: white;">
        Don't have an account? 
        <a href="signup.php" style="color: rgb(7, 113, 219); text-decoration: none; font-weight: 600;">Sign Up</a>
    </p>
    <p style="text-align: center; font-size: 0.9rem; margin-top: 8px;">
        <a href="reset_password.php" style="color: rgb(7, 113, 219); text-decoration: none; font-weight: 600;">Forgot Password?</a>
    </p>
</div>






















