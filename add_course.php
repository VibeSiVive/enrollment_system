<!-- add_course.php -->
<?php
session_start();
include('db.php');

if (!isset($_SESSION['loggedin'])) {
    header('Location: index.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $student_id = $_POST['student_id'];
    $course_id = $_POST['course_id'];

    // Check for duplicate entry
    $sql = "SELECT * FROM student_courses WHERE student_id='$student_id' AND course_id='$course_id'";
    $result = $conn->query($sql);

    if ($result->num_rows == 0) {
        $sql = "INSERT INTO student_courses (student_id, course_id) VALUES ('$student_id', '$course_id')";
        $conn->query($sql);
        $message = "Course added successfully.";
    } else {
        $message = "This course is already assigned to the student.";
    }
}

$students = $conn->query("SELECT * FROM students");
$courses = $conn->query("SELECT * FROM courses");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Course to Student</title>
</head>
<body>
    <h2>Add Course to Student</h2>
    <form method="POST" action="">
        <label for="student_id">Student:</label>
        <select name="student_id" required>
            <?php while($row = $students->fetch_assoc()) { ?>
                <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
            <?php } ?>
        </select><br>

        <label for="course_id">Course:</label>
        <select name="course_id" required>
            <?php while($row = $courses->fetch_assoc()) { ?>
                <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
            <?php } ?>
        </select><br>

        <input type="submit" value="Add Course">
    </form>
    <?php if(isset($message)) { echo "<p>$message</p>"; } ?>
    <a href="menu.php">Back to Menu</a>
</body>
</html>
