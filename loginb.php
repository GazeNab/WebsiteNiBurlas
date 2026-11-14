<?php
require_once "config/db.php";

$message = "";
$isSuccess = false;

if (isset($_GET["registered"])) {
    $message = "Registration successful. Please log in.";
    $isSuccess = true;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST["username"]);
    $password = $_POST["password"];

    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    $stmt->close();

    if ($user && password_verify($password, $user["password"])) {
        $message = "Login successful. Welcome, " . htmlspecialchars($user["full_name"]) . "!";
        $isSuccess = true;
    } else {
        $message = "Wrong username or password.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <link rel="stylesheet" href="css/styleb.css">
</head>
<body>
  <div class="box">
    <h2>Login</h2>

    <?php if ($message): ?>
      <p class="<?= $isSuccess ? 'success' : 'message' ?>"><?= $message ?></p>
    <?php endif; ?>

    <form method="POST" action="">
      <input type="text" name="username" placeholder="Username" required>
      <input type="password" name="password" placeholder="Password" required>
      <button type="submit">Login</button>
    </form>

    <p class="switch">No account yet? <a href="registerb.php">Register</a></p>
  </div>
</body>
</html>