<?php
session_start();
require 'db.php';
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

$message = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $bus_number = $_POST['bus_number'];
    $bus_name = $_POST['bus_name'];
    $route_id = $_POST['route_id'];
    $departure_time = $_POST['departure_time'];
    $seats = $_POST['seats'];

    // Photo upload handling
    $photoPath = NULL;
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] == 0) {
        $uploadDir = 'uploads/';
        if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);
        $fileName = time() . '_' . basename($_FILES['photo']['name']);
        $uploadFile = $uploadDir . $fileName;
        if (move_uploaded_file($_FILES['photo']['tmp_name'], $uploadFile)) {
            $photoPath = $uploadFile;
        }
    }

    $stmt = $conn->prepare("INSERT INTO buses (bus_number, bus_name, route_id, departure_time, seats, photo) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssiss", $bus_number, $bus_name, $route_id, $departure_time, $seats, $photoPath);
    if ($stmt->execute()) {
        $message = "Bus added successfully!";
    } else {
        $message = "Error adding bus: " . $conn->error;
    }
    $stmt->close();
}

// Fetch buses
$buses = $conn->query("SELECT b.*, r.route_name FROM buses b LEFT JOIN routes r ON b.route_id = r.id");
$routes = $conn->query("SELECT id, route_name FROM routes");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<title>Manage Buses | NepBus</title>
<link rel="stylesheet" href="styles.css" />
</head>
<body>
<?php include 'navbar.php'; ?>

<div class="sidebar">
    <div class="sidebar-menu">
        <a href="admin_dashboard.php">Dashboard</a>
        <a href="manage_buses.php" class="active">Manage Buses</a>
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
    <h2>Add New Bus</h2>
    <?php if ($message) echo "<p>$message</p>"; ?>
    <form method="POST" enctype="multipart/form-data">
        <label>Bus Number:</label>
        <input type="text" name="bus_number" required />

        <label>Bus Name:</label>
        <input type="text" name="bus_name" required />

        <label>Route:</label>
        <select name="route_id" required>
            <?php while ($row = $routes->fetch_assoc()): ?>
                <option value="<?= $row['id'] ?>"><?= htmlspecialchars($row['route_name']) ?></option>
            <?php endwhile; ?>
        </select>

        <label>Departure Time:</label>
        <input type="time" name="departure_time" required />

        <label>Seats:</label>
        <input type="number" name="seats" min="1" required />

        <label>Bus Photo:</label>
        <input type="file" name="photo" accept="image/*" />

        <button type="submit">Add Bus</button>
    </form>

    <h2>Existing Buses</h2>
    <table border="1" cellpadding="5" cellspacing="0">
        <thead>
            <tr>
                <th>ID</th>
                <th>Bus Number</th>
                <th>Bus Name</th>
                <th>Route</th>
                <th>Departure Time</th>
                <th>Seats</th>
                <th>Photo</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($bus = $buses->fetch_assoc()): ?>
                <tr>
                    <td><?= $bus['id'] ?></td>
                    <td><?= htmlspecialchars($bus['bus_number']) ?></td>
                    <td><?= htmlspecialchars($bus['bus_name']) ?></td>
                    <td><?= htmlspecialchars($bus['route_name']) ?></td>
                    <td><?= $bus['departure_time'] ?></td>
                    <td><?= $bus['seats'] ?></td>
                    <td>
                        <?php if ($bus['photo']): ?>
                            <img src="<?= htmlspecialchars($bus['photo']) ?>" width="80" alt="Bus Photo" />
                        <?php else: ?>
                            N/A
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>
</body>
</html>
