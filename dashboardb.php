<?php
session_start();
require_once "config/db.php";

if (!isset($_SESSION["user_id"])) {
    header("Location: loginb.php");
    exit;
}

$result = $conn->query("SELECT id, username, email, created_at FROM users ORDER BY id");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Members</title>
  <link rel="stylesheet" href="css/styleb.css">
</head>
<body>
  <video class="bg-video" autoplay muted loop playsinline>
    <source src="videos/vid.mp4" type="video/mp4">
  </video>

  <div class="box" style="width: 600px;">
    <h2>Welcome, <?= htmlspecialchars($_SESSION["username"]) ?></h2>

    <table>
      <tr>
        <th>ID</th>
        <th>Username</th>
        <th>Email</th>
        <th>Joined</th>
      </tr>
      <?php while ($row = $result->fetch_assoc()): ?>
      <tr>
        <td><?= $row["id"] ?></td>
        <td><?= htmlspecialchars($row["username"]) ?></td>
        <td><?= htmlspecialchars($row["email"]) ?></td>
        <td><?= $row["created_at"] ?></td>
      </tr>
      <?php endwhile; ?>
    </table>

    <p class="out"><a href="logoutb.php" class="logout-btn">Logout</a></p>
  </div>
</body>
</html>