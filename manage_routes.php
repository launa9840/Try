<?php
session_start();
require 'db.php';
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

$message = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $route_name = $_POST['route_name'];
    $origin = $_POST['origin'];
    $destination = $_POST['destination'];
    $description = $_POST['description'];

    $stmt = $conn->prepare("INSERT INTO routes (route_name, origin, destination, description) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $route_name, $origin, $destination, $description);

    if ($stmt->execute()) {
        $message = "Route added successfully!";
    } else {
        $message = "Error adding route: " . $conn->error;
    }
    $stmt->close();
}

$routes = $conn->query("SELECT * FROM routes");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<title>Manage Routes | NepBus</title>
<link rel="stylesheet" href="styles.css" />
</head>
<body>
<?php include 'navbar.php'; ?>

<div class="sidebar">
    <div class="sidebar-menu">
        <a href="admin_dashboard.php">Dashboard</a>
        <a href="manage_buses.php">Manage Buses</a>
        <a href="manage_routes.php" class="active">Manage Routes</a>
        <a href="manage_users.php">Manage Users</a>
        <a href="view_bookings.php">View Bookings</a>
        <a href="upload_photos.php">Upload Photos</a>
    </div>
    <form action="logout.php" method="POST">
        <button type="submit" class="logout">Logout</button>
    </form>
</div>

<div class="main-content">
    <h2>Add New Route</h2>
    <?php if ($message) echo "<p>$message</p>"; ?>
    <form method="POST">
        <label>Route Name:</label>
        <input type="text" name="route_name" required />

        <label>Origin:</label>
        <input type="text" name="origin" required />

        <label>Destination:</label>
        <input type="text" name="destination" required />

        <label>Description:</label>
        <textarea name="description"></textarea>

        <button type="submit">Add Route</button>
    </form>

    <h2>Existing Routes</h2>
    <table border="1" cellpadding="5" cellspacing="0">
        <thead>
            <tr>
                <th>ID</th>
                <th>Route Name</th>
                <th>Origin</th>
                <th>Destination</th>
                <th>Description</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($route = $routes->fetch_assoc()): ?>
                <tr>
                    <td><?= $route['id'] ?></td>
                    <td><?= htmlspecialchars($route['route_name']) ?></td>
                    <td><?= htmlspecialchars($route['origin']) ?></td>
                    <td><?= htmlspecialchars($route['destination']) ?></td>
                    <td><?= htmlspecialchars($route['description']) ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>
</body>
</html>
