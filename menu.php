<?php
session_start();
if(!isset($_SESSION['username'])) {
    header("location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #002147; 
            color: white; 
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .menu-container {
            background-color: rgba(255, 255, 255, 0.9);
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            width: 400px;
            text-align: center;
        }
        .menu-container h2 {
            margin-bottom: 20px;
            font-size: 24px;
            color: #002147; 
        }
        .menu-container ul {
            list-style-type: none;
            padding: 0;
        }
        .menu-container ul li {
            margin: 10px 0;
        }
        .menu-container ul li a {
            text-decoration: none;
            color: #002147; 
            font-size: 18px;
        }
        .menu-container ul li a:hover {
            text-decoration: underline;
        }
        .menu-container a.logout {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #f44336;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }
        .menu-container a.logout:hover {
            background-color: #d32f2f;
        }
    </style>
</head>
<body>

<div class="menu-container">
    <h2>Menu</h2>
    <ul>
        <li><a href="students.php">Students</a></li>
        <li><a href="courses.php">Courses</a></li>
        <li><a href="users.php">Users</a></li>
    </ul>
    <a href="logout.php" class="logout">Logout</a>
</div>

</body>
</html>
