<?php
session_start();
require 'db.php';
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

$users = $conn->query("SELECT id, name, email, role FROM users");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<title>Manage Users | NepBus</title>
<link rel="stylesheet" href="styles.css" />
</head>
<body>
<?php include 'navbar.php'; ?>

<div class="sidebar">
    <div class="sidebar-menu">
        <a href="admin_dashboard.php">Dashboard</a>
        <a href="manage_buses.php">Manage Buses</a>
        <a href="manage_routes.php">Manage Routes</a>
        <a href="manage_users.php" class="active">Manage Users</a>
        <a href="view_bookings.php">View Bookings</a>
        <a href="upload_photos.php">Upload Photos</a>
    </div>
    <form action="logout.php" method="POST">
        <button type="submit" class="logout">Logout</button>
    </form>
</div>

<div class="main-content">
    <h2>Users List</h2>
    <table border="1" cellpadding="5" cellspacing="0">
        <thead>
            <tr><th>ID</th><th>Name</th><th>Email</th><th>Role</th></tr>
        </thead>
        <tbody>
            <?php while ($user = $users->fetch_assoc()): ?>
                <tr>
                    <td><?= $user['id'] ?></td>
                    <td><?= htmlspecialchars($user['name']) ?></td>
                    <td><?= htmlspecialchars($user['email']) ?></td>
                    <td><?= htmlspecialchars($user['role']) ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>
</body>
</html>
