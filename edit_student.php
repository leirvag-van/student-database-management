	<?php
include 'db.php';

// Check if ID is provided
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Fetch existing student data
    $sql = "SELECT * FROM students WHERE id = '$id'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $student = mysqli_fetch_assoc($result);
    } else {
        echo "Student not found.";
        exit();
    }
}

// Update student record
if (isset($_POST['update'])) {

    $name = $_POST['name'];
    $student id = $_POST['student_id'];
    $department = $_POST['department'];
	$gpa = $_POST['gpa'];

    $update_sql = "UPDATE students 
                   SET name='$name', student id='$student_id', department='$department', gpa='$gpa'; 
                   WHERE id='$id'";

    if (mysqli_query($conn, $update_sql)) {
        echo "Student record updated successfully.";
    } else {
        echo "Error updating record: " . mysqli_error($conn);
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
	<label>Student ID:</label><br>
    <input type="text" name="student id" value="<?php echo $student['student_id']; ?>" required><br><br>

    <label>Name:</label><br>
    <input type="text" name="name" value="<?php echo $student['name']; ?>" required><br><br>

    <label>Department:</label><br>
    <input type="text" name="deparment" value="<?php echo $student['department']; ?>" required><br><br>
	
    <label>GPA:</label><br>
	<input type="text" name="gpa" value="<?php echo $student['gpa']; ?>" required><br><br>

    <button type="submit" name="update">Update Student</button>
</form>

</body>
</html><?php
include 'db.php';
