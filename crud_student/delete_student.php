<!-- delete_student.php -->
<?php
include('../config.php');

if (isset($_GET['id'])) {
    // Handle student deletion
    $student_id = $_GET['id'];
    $delete_query = "DELETE FROM students WHERE id = '$student_id'";

    if ($conn->query($delete_query)) {
        header("Location: ../dashboard.php");
        exit();
    } else {
        echo "Error: " . $conn->error;
    }
} else {
    echo "Error: Student ID not provided.";
    exit();
}
?>
