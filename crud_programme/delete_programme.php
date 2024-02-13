<?php
include('../config.php');

// Display errors
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check if ID parameter is set
if (isset($_GET['id'])) {
    $specialty_id = $_GET['id'];

    // Fetch existing specialty data
    $select_query = "SELECT id, specialty_name FROM specialties WHERE id = $specialty_id";
    $result = $conn->query($select_query);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $specialty_name = $row['specialty_name'];

        // Check if form is submitted for deletion
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_specialty'])) {
            // Delete the specialty from the database
            $delete_query = "DELETE FROM specialties WHERE id = $specialty_id";

            if ($conn->query($delete_query)) {
                echo "Specialty deleted successfully!";
                header("Location: ../dashboard.php");
                exit();
            } else {
                echo "Error deleting specialty: " . $conn->error;
            }
        }
    } else {
        echo "Specialty not found.";
        exit();
    }
} else {
    echo "Invalid request. Please provide a valid ID.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <title>Delete Specialty</title>
</head>
<body>
    <div class="container mt-4">
        <h2>Delete Specialty</h2>
        <p>Are you sure you want to delete the specialty: <?php echo $specialty_name; ?>?</p>

        <form action="delete_specialty.php?id=<?php echo $specialty_id; ?>" method="POST">
            <button type="submit" class="btn btn-danger" name="delete_specialty">Yes, Delete Specialty</button>
        </form>
    </div>
</body>
</html>

<?php
// Close the database connection
$conn->close();
?>
