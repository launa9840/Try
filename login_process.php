<?php
session_start();
require 'db.php';

// Fetch inputs
$email = $_POST['email'];
$password = $_POST['password'];
$role = $_POST['role'];

// Fetch user
$stmt = $conn->prepare("SELECT * FROM users WHERE email = ? AND role = ?");
$stmt->bind_param("ss", $email, $role);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if ($user && password_verify($password, $user['password'])) {
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['user_name'] = $user['name'];
    $_SESSION['role'] = $user['role'];

    if ($role == 'admin') {
        header("Location: admin_dashboard.php");
    } else {
        header("Location: user_dashboard.php");
    }
    exit();
} else {
    $_SESSION['error'] = "Invalid login credentials!";
    header("Location: login.php");
    exit();
}
?>
<?php include 'navbar.php'; ?>
