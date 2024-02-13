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

        // Check if form is submitted for editing
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['edit_specialty'])) {
            // Validate and sanitize inputs
            $specialty_name = mysqli_real_escape_string($conn, $_POST['specialty_name']);

            // Update the specialty in the database
            $update_query = "UPDATE specialties SET specialty_name = '$specialty_name' WHERE id = $specialty_id";

            if ($conn->query($update_query)) {
                echo "Specialty updated successfully!";
            } else {
                echo "Error updating specialty: " . $conn->error;
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
    <title>Edit Specialty</title>
</head>
<body>
    <div class="container mt-4">
        <h2>Edit Specialty</h2>

        <form action="edit_specialty.php?id=<?php echo $specialty_id; ?>" method="POST">
            <div class="form-group">
                <label for="specialty_name">Specialty Name:</label>
                <input type="text" class="form-control" id="specialty_name" name="specialty_name" value="<?php echo $specialty_name; ?>">
            </div>

            <button type="submit" class="btn btn-primary" name="edit_specialty">Update Specialty</button>
        </form>
    </div>
</body>
</html>

<?php
// Close the database connection
$conn->close();
?>
