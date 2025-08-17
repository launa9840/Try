<?php
session_start();
require 'db.php';
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

$message = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] == 0) {
        $uploadDir = 'uploads/';
        if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);
        $fileName = time() . '_' . basename($_FILES['photo']['name']);
        $uploadFile = $uploadDir . $fileName;
        if (move_uploaded_file($_FILES['photo']['tmp_name'], $uploadFile)) {
            $message = "Photo uploaded successfully!";
            // Here, optionally, save to database table for gallery if you want.
        } else {
            $message = "Failed to upload photo.";
        }
    } else {
        $message = "No file selected.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<title>Upload Photos | NepBus</title>
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
        <a href="view_bookings.php">View Bookings</a>
        <a href="upload_photos.php" class="active">Upload Photos</a>
    </div>
    <form action="logout.php" method="POST">
        <button type="submit" class="logout">Logout</button>
    </form>
</div>

<div class="main-content">
    <h2>Upload Promotional Photo</h2>
    <?php if ($message) echo "<p>$message</p>"; ?>
    <form method="POST" enctype="multipart/form-data">
        <input type="file" name="photo" accept="image/*" required />
        <button type="submit">Upload</button>
    </form>
</div>
</body>
</html>
