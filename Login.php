<?php
session_start();
require_once 'database.php';

$feedback = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    $dbh = db_connect();
    if (!$dbh) {
        die("Database connection failed");
    }

    $stmt = $dbh->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $row = $stmt->fetch();

    if ($row && password_verify($password, $row['password'])) {
        $_SESSION['username'] = $username;
        header("Location: index.php"); // Redirect to homepage
        exit;
    } else {
        $feedback = "Invalid username or password.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
<body>

<h1>Login</h1>

<?php if ($feedback): ?>
    <p style="color:red;"><?= htmlspecialchars($feedback) ?></p>
<?php endif; ?>

<form action="Login.php" method="post">
    <label for="username">Username</label><br>
    <input type="text" id="username" name="username" required><br>
    <label for="password">Password</label><br>
    <input type="password" id="password" name="password" required><br><br>
    <input type="submit" value="Submit">
</form>

    <p>Don't have an account? <a href="CreateAccount.php">Create one here</a></p>

</body>
</html>
