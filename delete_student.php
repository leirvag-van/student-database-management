<?php
include 'config.php';

if (isset($_GET['id'])) {

    $id = $_GET['id'];

    // Check if student exists
    $stmt = $pdo->prepare("SELECT id FROM students WHERE id = ?");
    $stmt->execute([$id]);

    if ($stmt->fetch()) {

        // Delete student
        $stmt = $pdo->prepare("DELETE FROM students WHERE id = ?");
        $stmt->execute([$id]);

        // Return to main page
        header("Location: index.php");
        exit();

    } else {
        echo "Student not found.";
    }
}
?>
