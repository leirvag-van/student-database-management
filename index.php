<?php
include 'config.php';

$stmt = $pdo->query("SELECT * FROM students");
$students = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Database Management System</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">
    <h1>Student Database Management System</h1>

    <p>Welcome to the Student Academic Portal.</p>

    <a href="add_student.php">Add Student</a>

    <h2>Student List</h2>

    <table border="1">
        <tr>
            <th>Student ID</th>
            <th>Name</th>
            <th>Department</th>
            <th>GPA</th>
            <th>Status</th>
        </tr>

        <?php foreach ($students as $student): ?>
        <tr>
            <td><?= $student['student_id']; ?></td>
            <td><?= $student['name']; ?></td>
            <td><?= $student['department']; ?></td>
            <td><?= $student['gpa']; ?></td>
            <td><?= $student['status']; ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
</div>

</body>
</html>
