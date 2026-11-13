<?php
session_start();
require_once "config/db.php";

$message = "";

if (isset($_GET["registered"])) {
    $message = "Registration successful. Please log in.";
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = trim($_POST["email"]);
    $password = $_POST["password"];

    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    $stmt->close();

    if ($user && password_verify($password, $user["password"])) {
        $_SESSION["user_id"] = $user["id"];
        $_SESSION["username"] = $user["username"];
        header("Location: dashboardb.php");
        exit;
    } else {
        $message = "Wrong email or password.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sign In</title>
  <link rel="stylesheet" href="css/styleb.css">
</head>
<body>
  <div class="box">
    <h2>Sign In</h2>

    <?php if ($message): ?>
      <p class="<?= isset($_GET['registered']) ? 'success' : 'message' ?>"><?= htmlspecialchars($message) ?></p>
    <?php endif; ?>

    <form method="POST" action="">
      <input type="email" name="email" placeholder="Email" required>
      <input type="password" name="password" placeholder="Password" required>
      <button type="submit">Sign In</button>
    </form>

    <p class="switch">New here? <a href="registerb.php">Create an account</a></p>
  </div>
</body>
</html>
