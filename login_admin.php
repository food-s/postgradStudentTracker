<?php
session_start();

include('db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $selectQuery = "SELECT id, username, password FROM admin WHERE username = ?";
    $stmt = $conn->prepare($selectQuery);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->bind_result($adminId, $dbUsername, $dbPassword);

    if ($stmt->fetch() && password_verify($password, $dbPassword)) {
        $_SESSION['admin'] = ['id' => $adminId, 'username' => $dbUsername];
        header('Location: dashboard.php');
        exit();
    } else {
        echo "Invalid username or password";
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
</head>
<body>
    <h1>Admin Login</h1>
    
    <form method="post" action="login_admin.php">
        <label for="username">Username:</label>
        <input type="text" name="username" required>

        <label for="password">Password:</label>
        <input type="password" name="password" required>

        <button type="submit">Login</button>
    </form>
</body>
</html>
