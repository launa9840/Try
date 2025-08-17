<?php
session_start();
require 'db.php';
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// Fetch stats
$userCount = $conn->query("SELECT COUNT(*) as count FROM users")->fetch_assoc()['count'];
$busCount = $conn->query("SELECT COUNT(*) as count FROM buses")->fetch_assoc()['count'];
$routeCount = $conn->query("SELECT COUNT(*) as count FROM routes")->fetch_assoc()['count'];
$bookingCount = $conn->query("SELECT COUNT(*) as count FROM bookings")->fetch_assoc()['count'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Admin Dashboard | NepBus</title>
<link rel="stylesheet" href="styles.css" />
</head>
<body>
<?php include 'navbar.php'; ?>

<div class="sidebar">
    <div class="sidebar-menu">
        <a href="admin_dashboard.php" class="active">Dashboard</a>
        <a href="manage_buses.php">Manage Buses</a>
        <a href="manage_routes.php">Manage Routes</a>
        <a href="manage_users.php">Manage Users</a>
        <a href="view_bookings.php">View Bookings</a>
        <a href="upload_photos.php">Upload Photos</a>
    </div>
    <form action="logout.php" method="POST">
        <button type="submit" class="logout">Logout</button>
    </form>
</div>

<div class="main-content">
    <h1>Welcome, <?= htmlspecialchars($_SESSION['user_name']); ?>!</h1>
    <h2>System Overview</h2>
    <ul>
        <li>Total Users: <?= $userCount ?></li>
        <li>Total Buses: <?= $busCount ?></li>
        <li>Total Routes: <?= $routeCount ?></li>
        <li>Total Bookings: <?= $bookingCount ?></li>
    </ul>
</div>

</body>
</html>
