<?php
include('db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $studentId = $_POST['student_id'];
    $assessorId = $_POST['assessor_id'];

    // Perform the update in the database
    $updateQuery = "UPDATE students SET assessor_id = $assessorId WHERE id = $studentId";
    $result = $conn->query($updateQuery);

    if ($result) {
        // Redirect back to the dashboard
        header('Location: dashboard.php');
        exit();
    } else {
        // Handle the error, such as logging or displaying an error message
        $error = $conn->error;
        echo "Error assigning assessor: $error";
    }
} else {
    // Redirect to the dashboard if accessed directly
    header('Location: dashboard.php');
    exit();
}
?>
