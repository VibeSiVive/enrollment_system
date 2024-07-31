<?php
include('db.php');
session_start();
if (!isset($_SESSION['username'])) {
    header("location: index.php");
    exit();
}


$students = $conn->query("SELECT * FROM student");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Students</title>
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
            padding: 20px;
        }
        .students-container {
            background-color: rgba(255, 255, 255, 0.9);
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            width: 80%;
            max-width: 800px;
        }
        .students-container h2, .students-container h3 {
            text-align: center;
            color: #002147;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #ccc;
        }
        th, td {
            padding: 10px;
            text-align: left;
            color: #002147;
        }
        th {
            background-color: #e0e0e0;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
    </style>
</head>
<body>
    <div class="students-container">
        <h2>Students</h2>
        <h3>List of Students</h3>
        <table>
            <tr>
                <th>Student Code</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Programme</th>
            </tr>
            <?php while($row = $students->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo $row['student_code']; ?></td>
                    <td><?php echo $row['first_name']; ?></td>
                    <td><?php echo $row['last_name']; ?></td>
                    <td><?php echo $row['programme']; ?></td>
                </tr>
            <?php } ?>
        </table>
    </div>
</body>
</html>
