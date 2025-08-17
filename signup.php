<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Sign Up | NepBus</title>
<link rel="stylesheet" href="styles.css" />
</head>
<body>

<?php include 'navbar.php'; ?>
<div class="login-container">
    <h2>Sign Up</h2>
    <?php
    if (isset($_SESSION['error'])) {
        echo "<p style='color:red'>" . $_SESSION['error'] . "</p>";
        unset($_SESSION['error']);
    }
    if (isset($_SESSION['success'])) {
        echo "<p style='color:green'>" . $_SESSION['success'] . "</p>";
        unset($_SESSION['success']);
    }
    ?>
    <form action="signup_process.php" method="POST">
        <label>Full Name:</label>
        <input type="text" name="name" required />

        <label>Email:</label>
        <input type="email" name="email" required />

        <label>Password:</label>
        <input type="password" name="password" required />

        <label>Role:</label>
        <select name="role" required>
            <option value="user">User</option>
            <option value="admin">Admin</option>
        </select>

        <button type="submit">Sign Up</button>
    </form>

    <p style="margin-top: 15px; text-align: center; font-size: 0.9rem; color: white;">
        Already have an account? 
        <a href="login.php" style="color: rgb(7, 113, 219); text-decoration: none; font-weight: 600;">Login</a>
    </p>
</div>
</body>
</html>
