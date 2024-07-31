<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}

include('db.php');

// Handle Add, Edit, Delete operations for users
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['add_user'])) {
        $user_name = $_POST['user_name'];
        $full_name = $_POST['full_name'];
        $password = $_POST['password'];

        $stmt = $conn->prepare("INSERT INTO user (user_name, full_name, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $user_name, $full_name, $password);
        $stmt->execute();
    } elseif (isset($_POST['edit_user'])) {
        $user_name = $_POST['user_name'];
        $full_name = $_POST['full_name'];
        $password = $_POST['password'];

        $stmt = $conn->prepare("UPDATE user SET full_name=?, password=? WHERE user_name=?");
        $stmt->bind_param("sss", $full_name, $password, $user_name);
        $stmt->execute();
    } elseif (isset($_POST['delete_user'])) {
        $user_name = $_POST['user_name'];

        $stmt = $conn->prepare("DELETE FROM user WHERE user_name=?");
        $stmt->bind_param("s", $user_name);
        $stmt->execute();
    }
}

// Handle Add, Edit, Delete operations for students
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['add_student'])) {
        $student_code = $_POST['student_code'];
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $programme = $_POST['programme'];

        $stmt = $conn->prepare("INSERT INTO student (student_code, first_name, last_name, programme) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $student_code, $first_name, $last_name, $programme);
        $stmt->execute();
    } elseif (isset($_POST['edit_student'])) {
        $student_code = $_POST['student_code'];
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $programme = $_POST['programme'];

        $stmt = $conn->prepare("UPDATE student SET first_name=?, last_name=?, programme=? WHERE student_code=?");
        $stmt->bind_param("ssss", $first_name, $last_name, $programme, $student_code);
        $stmt->execute();
    } elseif (isset($_POST['delete_student'])) {
        $student_code = $_POST['student_code'];

        $stmt = $conn->prepare("DELETE FROM student WHERE student_code=?");
        $stmt->bind_param("s", $student_code);
        $stmt->execute();
    }
}

// Handle Add, Edit, Delete operations for courses
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['add_course'])) {
        $course_number = $_POST['course_number'];
        $course_description = $_POST['course_description'];
        $units = $_POST['units'];

        $stmt = $conn->prepare("INSERT INTO course (course_number, course_description, units) VALUES (?, ?, ?)");
        $stmt->bind_param("ssi", $course_number, $course_description, $units);
        $stmt->execute();
    } elseif (isset($_POST['edit_course'])) {
        $course_number = $_POST['course_number'];
        $course_description = $_POST['course_description'];
        $units = $_POST['units'];

        $stmt = $conn->prepare("UPDATE course SET course_description=?, units=? WHERE course_number=?");
        $stmt->bind_param("sis", $course_description, $units, $course_number);
        $stmt->execute();
    } elseif (isset($_POST['delete_course'])) {
        $course_number = $_POST['course_number'];

        $stmt = $conn->prepare("DELETE FROM course WHERE course_number=?");
        $stmt->bind_param("s", $course_number);
        $stmt->execute();
    }
}

// Handle adding course to student
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['add_student_course'])) {
        $student_code = $_POST['student_code'];
        $course_number = $_POST['course_number'];

        // Check if the course is already assigned to the student
        $check = $conn->prepare("SELECT * FROM student_courses WHERE student_code=? AND course_number=?");
        $check->bind_param("ss", $student_code, $course_number);
        $check->execute();
        $result = $check->get_result();

        if ($result->num_rows == 0) {
            $stmt = $conn->prepare("INSERT INTO student_courses (student_code, course_number) VALUES (?, ?)");
            $stmt->bind_param("ss", $student_code, $course_number);
            if ($stmt->execute()) {
                echo "Course added successfully.";
            } else {
                echo "Error: " . $stmt->error;
            }
        } else {
            echo "This course is already assigned to the student.";
        }
        $stmt->close();
    }
}

// Fetch lists
$users = $conn->query("SELECT * FROM user");
$students = $conn->query("SELECT * FROM student");
$courses = $conn->query("SELECT * FROM course");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Users</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #002147; 
            color: #ffffff; 
            display: flex;
            justify-content: center;
            align-items: flex-start;
            height: 100vh;
            margin: 0;
            padding: 20px;
        }
        .container {
            background-color: rgba(255, 255, 255, 0.9);
            color: #002147; 
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            width: 80%;
            max-width: 1000px;
            overflow-y: auto;
            margin-top: 20px;
        }
        .container h2, .container h3 {
            text-align: center;
            color: #002147; 
        }
        form {
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin: 10px 0 5px;
        }
        input[type="text"], input[type="password"], input[type="number"] {
            width: calc(100% - 20px);
            padding: 10px;
            margin: 5px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }
        input[type="submit"] {
            padding: 10px 20px;
            background-color: #002147;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 10px;
        }
        input[type="submit"]:hover {
            background-color: #001B33; 
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
        }
        th {
            background-color: #e0e0e0; 
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .actions {
            display: flex;
            gap: 10px;
        }
        .actions input[type="submit"] {
            width: auto;
            padding: 5px 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Users</h2>
        <form method="POST" action="">
            <label for="user_name">Username:</label>
            <input type="text" name="user_name" required>
            <label for="full_name">Full Name:</label>
            <input type="text" name="full_name" required>
            <label for="password">Password:</label>
            <input type="password" name="password" required>
            <input type="submit" name="add_user" value="Add User">
        </form>

        <h3>List of Users</h3>
        <table>
            <tr>
                <th>Username</th>
                <th>Full Name</th>
                <th>Actions</th>
            </tr>
            <?php while($row = $users->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo $row['user_name']; ?></td>
                    <td><?php echo $row['full_name']; ?></td>
                    <td>
                        <form method="POST" action="" class="actions">
                            <input type="hidden" name="user_name" value="<?php echo $row['user_name']; ?>">
                            <input type="text" name="full_name" value="<?php echo $row['full_name']; ?>" required>
                            <input type="password" name="password" placeholder="New Password" required>
                            <input type="submit" name="edit_user" value="Edit">
                            <input type="submit" name="delete_user" value="Delete">
                        </form>
                    </td>
                </tr>
            <?php } ?>
        </table>

        <h2>Students</h2>
        <form method="POST" action="">
            <label for="student_code">Student Code:</label>
            <input type="text" name="student_code" required>
            <label for="first_name">First Name:</label>
            <input type="text" name="first_name" required>
            <label for="last_name">Last Name:</label>
            <input type="text" name="last_name" required>
            <label for="programme">Programme:</label>
            <input type="text" name="programme" required>
            <input type="submit" name="add_student" value="Add Student">
        </form>

        <h3>List of Students</h3>
        <table>
            <tr>
                <th>Student Code</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Programme</th>
                <th>Actions</th>
            </tr>
            <?php while($row = $students->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo $row['student_code']; ?></td>
                    <td><?php echo $row['first_name']; ?></td>
                    <td><?php echo $row['last_name']; ?></td>
                    <td><?php echo $row['programme']; ?></td>
                    <td>
                        <form method="POST" action="" class="actions">
                            <input type="hidden" name="student_code" value="<?php echo $row['student_code']; ?>">
                            <input type="text" name="first_name" value="<?php echo $row['first_name']; ?>" required>
                            <input type="text" name="last_name" value="<?php echo $row['last_name']; ?>" required>
                            <input type="text" name="programme" value="<?php echo $row['programme']; ?>" required>
                            <input type="submit" name="edit_student" value="Edit">
                            <input type="submit" name="delete_student" value="Delete">
                        </form>
                    </td>
                </tr>
            <?php } ?>
        </table>

        <h2>Courses</h2>
        <form method="POST" action="">
            <label for="course_number">Course Number:</label>
            <input type="text" name="course_number" required>
            <label for="course_description">Course Description:</label>
            <input type="text" name="course_description" required>
            <label for="units">Units:</label>
            <input type="number" name="units" required>
            <input type="submit" name="add_course" value="Add Course">
        </form>

        <h3>List of Courses</h3>
        <table>
            <tr>
                <th>Course Number</th>
                <th>Course Description</th>
                <th>Units</th>
                <th>Actions</th>
            </tr>
            <?php while($row = $courses->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo $row['course_number']; ?></td>
                    <td><?php echo $row['course_description']; ?></td>
                    <td><?php echo $row['units']; ?></td>
                    <td>
                        <form method="POST" action="" class="actions">
                            <input type="hidden" name="course_number" value="<?php echo $row['course_number']; ?>">
                            <input type="text" name="course_description" value="<?php echo $row['course_description']; ?>" required>
                            <input type="number" name="units" value="<?php echo $row['units']; ?>" required>
                            <input type="submit" name="edit_course" value="Edit">
                            <input type="submit" name="delete_course" value="Delete">
                        </form>
                    </td>
                </tr>
            <?php } ?>
        </table>

        <h2>Add Course to Student</h2>
        <form method="POST" action="">
            <label for="student_code">Student Code:</label>
            <input type="text" id="student_code" name="student_code" required><br>
            <label for="course_number">Course Number:</label>
            <input type="text" id="course_number" name="course_number" required><br><br>
            <input type="submit" name="add_student_course" value="Add Course">
        </form>
    </div>
</body>
</html>
