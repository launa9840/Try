<?php
session_start();
require 'db.php';
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// Fetch bookings with user and bus details
$sql = "SELECT b.id, u.name as user_name, b.booking_date, b.seat_number, b.booking_status, bu.bus_number, r.route_name
        FROM bookings b
        JOIN users u ON b.user_id = u.id
        JOIN buses bu ON b.bus_id = bu.id
        JOIN routes r ON bu.route_id = r.id
        ORDER BY b.booking_date DESC";

$bookings = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<title>View Bookings | NepBus</title>
<link rel="stylesheet" href="styles.css" />
</head>
<body>
<?php include 'navbar.php'; ?>

<div class="sidebar">
    <div class="sidebar-menu">
        <a href="admin_dashboard.php">Dashboard</a>
        <a href="manage_buses.php">Manage Buses</a>
        <a href="manage_routes.php">Manage Routes</a>
        <a href="manage_users.php">Manage Users</a>
        <a href="view_bookings.php" class="active">View Bookings</a>
        <a href="upload_photos.php">Upload Photos</a>
    </div>
    <form action="logout.php" method="POST">
        <button type="submit" class="logout">Logout</button>
    </form>
</div>

<div class="main-content">
    <h2>All Bookings</h2>
    <table border="1" cellpadding="5" cellspacing="0">
        <thead>
            <tr>
                <th>ID</th>
                <th>User</th>
                <th>Bus Number</th>
                <th>Route</th>
                <th>Booking Date</th>
                <th>Seat Number</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($booking = $bookings->fetch_assoc()): ?>
                <tr>
                    <td><?= $booking['id'] ?></td>
                    <td><?= htmlspecialchars($booking['user_name']) ?></td>
                    <td><?= htmlspecialchars($booking['bus_number']) ?></td>
                    <td><?= htmlspecialchars($booking['route_name']) ?></td>
                    <td><?= $booking['booking_date'] ?></td>
                    <td><?= $booking['seat_number'] ?></td>
                    <td><?= htmlspecialchars($booking['booking_status']) ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>
</body>
</html>
