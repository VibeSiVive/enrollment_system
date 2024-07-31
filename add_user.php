<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_name'])) {
    header("Location: index.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_name = $_POST['user_name'];
    $full_name = $_POST['full_name'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    // Prepare statement
    $stmt = $conn->prepare("INSERT INTO User (user_name, full_name, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $user_name, $full_name, $password);

    if ($stmt->execute()) {
        echo "New user created successfully";
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add User</title>
</head>
<body>
    <h2>Add User</h2>
    <form method="post" action="">
        <label for="user_name">Username:</label><br>
        <input type="text" id="user_name" name="user_name" required><br>
        <label for="full_name">Full Name:</label><br>
        <input type="text" id="full_name" name="full_name" required><br>
        <label for="password">Password:</label><br>
        <input type="password" id="password" name="password" required><br><br>
        <input type="submit" value="Add User">
    </form>
</body>
</html>
