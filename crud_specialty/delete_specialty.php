<?php
include('../config.php');

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $specialty_id = $_GET['id'];

    // Delete the specialty from the database
    $delete_query = "DELETE FROM specialties WHERE id = $specialty_id";

    if ($conn->query($delete_query) === TRUE) {
        header("Location: ../dashboard.php");
        exit();
    } else {
        echo "Error: " . $delete_query . "<br>" . $conn->error;
        exit();
    }
}
?>
