<?php
include 'config.php';

// GET student data
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $stmt = $pdo->prepare("SELECT * FROM students WHERE id = ?");
    $stmt->execute([$id]);
    $student = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$student) {
        echo "Student not found.";
        exit();
    }
}

// UPDATE student
if (isset($_POST['update'])) {

    $id = $_POST['id'];
    $name = $_POST['name'];
    $student_id = $_POST['student_id'];
    $department = $_POST['department'];
    $gpa = $_POST['gpa'];

    $stmt = $pdo->prepare("
        UPDATE students 
        SET name = ?, student_id = ?, department = ?, gpa = ?
        WHERE id = ?
    ");

    if ($stmt->execute([$name, $student_id, $department, $gpa, $id])) {
        echo "Student record updated successfully.";
    } else {
        echo "Update failed.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Student</title>
</head>
<body>

<h2>Edit Student Record</h2>

<form method="POST">

    <input type="hidden" name="id" value="<?= $student['id'] ?>">

    <label>Student ID:</label><br>
    <input type="text" name="student_id" value="<?= $student['student_id'] ?>"><br><br>

    <label>Name:</label><br>
    <input type="text" name="name" value="<?= $student['name'] ?>"><br><br>

    <label>Department:</label><br>
    <input type="text" name="department" value="<?= $student['department'] ?>"><br><br>

    <label>GPA:</label><br>
    <input type="text" name="gpa" value="<?= $student['gpa'] ?>"><br><br>

    <button type="submit" name="update">Update Student</button>

</form>

</body>
</html>
