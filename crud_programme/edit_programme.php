<!-- edit_programme.php -->
<?php
include('../config.php');
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check if the id parameter is set
// if (isset($_GET['id'])) {
//     $specialty_id = $_GET['id'];

//     // Fetch existing specialty data
//     $select_query = "SELECT id, specialty_name FROM specialties WHERE id = $specialty_id";
//     $result = $conn->query($select_query);

//     if ($result->num_rows > 0) {
//         $row = $result->fetch_assoc();
//         $specialty_name = $row['specialty_name'];
//     } else {
//         echo "Specialty not found.";
//         exit();
//     }
// } else {
//     echo "Invalid request. Please provide a valid ID.";
//     exit();
// }
$programme_id = null;

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $programme_id = $_GET['id'];

    $select_query = "SELECT id, programme_name, programme_duration FROM programmes WHERE id = $programme_id";
    $result = $conn->query($select_query);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $programme_name = $row['programme_name'];
        $programme_duration = $row['programme_duration'];
    } else {
        echo "Programme not found.";
        exit();
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['new_programme_name'])) {
    // Process POST request
    $programme_id = $_POST['programme_id']; // Add this line to retrieve the programme_id
    $new_programme_name = $_POST['new_programme_name'];
    $new_programme_duration = $_POST['new_programme_duration'];

    $update_query = "UPDATE programmes 
                     SET programme_name = '$new_programme_name', 
                         programme_duration = '$new_programme_duration' 
                     WHERE id = $programme_id";

    if ($conn->query($update_query) === TRUE) {
        header("Location: ../dashboard.php");
        exit();
    } else {
        echo "Error: " . $update_query . "<br>" . $conn->error;
        exit();
    }
} else {
    echo "Invalid request.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <title>Edit Programme</title>
</head>
<body>
    <div class="container mt-4">
        <h2>Edit Programme</h2>
        <form method="post" action="">
            <input type="hidden" name="programme_id" value="<?php echo $programme_id; ?>"> <!-- Add this hidden field to send programme_id in the POST request -->
            <div class="form-group">
                <label for="new_programme_name">New Programme Name:</label>
                <input type="text" class="form-control" id="new_programme_name" name="new_programme_name" value="<?php echo $programme_name; ?>" required>
            </div>
            <div class="form-group">
                <label for="new_programme_duration">New Programme Duration:</label>
                <input type="text" class="form-control" id="new_programme_duration" name="new_programme_duration" value="<?php echo $programme_duration; ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Update Programme</button>
        </form>
    </div>
</body>
</html>
