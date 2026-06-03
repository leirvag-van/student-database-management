<?php
include 'config.php';

if (isset($_POST['add'])) {
    $student_id = $_POST['student_id'];
    $name       = $_POST['name'];
    $department = $_POST['department'];
    $gpa        = $_POST['gpa'];

    // Determine academic status
    if ($gpa >= 3.5) {
        $status = 'Excellent';
    } elseif ($gpa >= 2.0) {
        $status = 'Good';
    } else {
        $status = 'Warning';
    }

    $stmt = $pdo->prepare("INSERT INTO students (student_id, name, department, gpa, status)
                           VALUES (?, ?, ?, ?, ?)");
 
    if ($stmt->execute([$student_id, $name, $department, $gpa, $status])) {
        echo "Student added successfully. Status: $status";
    } else {
        echo "Error inserting record.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Student</title>
</head>
<body>

<h2>Add New Student</h2>

<form method="POST">
    <label>Student ID:</label><br>
    <input type="text" name="student_id" required><br><br>

    <label>Name:</label><br>
    <input type="text" name="name" required><br><br>

    <label>Department:</label><br>
    <input type="text" name="department" required><br><br>

    <label>GPA:</label><br>
    <input type="number" name="gpa" step="0.01" min="0" max="4.00" required><br><br>

    <button type="submit" name="add">Add Student</button>
</form>

</body>
</html>
