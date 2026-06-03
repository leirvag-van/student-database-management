<?php
require_once 'config.php';

function studentExists(mysqli $conn, int $id): bool {
    $stmt = $conn->prepare("SELECT id FROM students WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->store_result();
    $exists = $stmt->num_rows > 0;
    $stmt->close();
    return $exists;
}

function deleteStudent(mysqli $conn, int $id): string {
    if (!studentExists($conn, $id)) {
        return "Error: Student with ID $id does not exist.";
    }

    $stmt = $conn->prepare("DELETE FROM students WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        $stmt->close();
        return "Student with ID $id has been successfully deleted.";
    } else {
        $stmt->close();
        return "Error: Could not delete student. " . $conn->error;
    }
}
