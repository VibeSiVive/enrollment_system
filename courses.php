<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}

include('db.php');


$courses = $conn->query("SELECT * FROM course");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Courses</title>
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
        .courses-container {
            background-color: rgba(255, 255, 255, 0.9);
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            width: 80%;
            max-width: 800px;
        }
        .courses-container h2, .courses-container h3 {
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
    <div class="courses-container">
        <h2>Courses</h2>
        <h3>List of Courses</h3>
        <table>
            <tr>
                <th>Course Number</th>
                <th>Course Description</th>
                <th>Units</th>
            </tr>
            <?php while($row = $courses->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo $row['course_number']; ?></td>
                    <td><?php echo $row['course_description']; ?></td>
                    <td><?php echo $row['units']; ?></td>
                </tr>
            <?php } ?>
        </table>
    </div>
</body>
</html>
