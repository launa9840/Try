
<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'user') {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>User Dashboard | NepBus</title>
<link rel="stylesheet" href="styles.css" />
</head>
<body>

<div class="sidebar">
  <div class="sidebar-menu">
    <a href="user_dashboard.php" class="active">Home</a>
    <a href="book_tickets.php">Book Tickets</a>
    <a href="my_bookings.php">My Bookings</a>
    <a href="routes.php">Routes/Services</a>
    <a href="contact.php">Contact/Support</a>
  </div>

  <form action="logout.php" method="POST">
    <button type="submit" class="logout">Logout</button>
  </form>
</div>


<div class="main-content">
  <h1>Welcome, <?= htmlspecialchars($_SESSION['user_name']); ?>!</h1>
  <p>This is your user dashboard where you can manage your bookings and profile.</p>
</div>

</body>
</html>
