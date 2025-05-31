<?php
session_start(); // Make sure to start the session

require_once 'user.php';

// Optional: Redirect if not logged in
if (!isset($_SESSION['username'])) {
    header("Location: Login.php");
    exit;
}

$user = new User();
$user_list = $user->get_all_users();

?>

<!DOCTYPE html>
<html>
<head>
    <title>COSC 4806</title>
</head>
<body>
    <h1>Assignment 2</h1>

    <p>Welcome, <?= htmlspecialchars($_SESSION['username']) ?></p>

    <h2>All Users</h2>
    <pre>
<?php print_r($user_list); ?>
    </pre>

</body>

  <footer>
     <p> <a href="logout.php">Click here to logout</a></p>
  </footer>
</html>
