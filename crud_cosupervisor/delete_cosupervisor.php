<?php
include('../config.php');

// Check if the record ID is provided
if (isset($_GET['id'])) {
    // Process the record deletion
    $cosupervisor_id = $_GET['id'];

    $delete_query = "DELETE FROM cosupervisors WHERE id = '$cosupervisor_id'";
    $conn->query($delete_query);

    echo "Co-Supervisor deleted successfully";
} else {
    echo "Error: Co-Supervisor ID not provided.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <title>Delete Co-Supervisor</title>
</head>
<body>
    <!-- You may include a confirmation message or additional details here if needed -->
</body>
</html>

<?php
// Close the database connection
$conn->close();
?>
