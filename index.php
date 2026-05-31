<?php
include 'config.php';

$stmt = $pdo->query("SELECT * FROM students");
$students = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Student Database Management System</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">

    <h1>Student Database Management System</h1>

    <p>Welcome to the Student Academic Portal.</p>

    <a href="add_student.php">Add Student</a>

    <h2>Student List</h2>

    <table>
        <tr>
            <th>Student ID</th>
            <th>Name</th>
            <th>Department</th>
            <th>GPA</th>
        </tr>

        <?php foreach ($students as $student): ?>
        <tr>
            <td><?= $student['student_id'] ?></td>
            <td><?= $student['name'] ?></td>
            <td><?= $student['department'] ?></td>
            <td><?= $student['gpa'] ?></td>
        </tr>
        <?php endforeach; ?>

    </table>

</div>

</body>
</html>
