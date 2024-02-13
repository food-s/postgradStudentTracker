<?php
include('../config.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $supervisor_id = $_POST['supervisor_id'];
    $supervisor_name = $_POST['supervisor_name'];
    $specialty_id = $_POST['specialty_id'];

    $update_query = "UPDATE supervisors 
                     SET supervisor_name = '$supervisor_name', specialty_id = '$specialty_id' 
                     WHERE id = '$supervisor_id'";

    if ($conn->query($update_query) === TRUE) {
        echo "Supervisor updated successfully";
    } else {
        echo "Error: " . $update_query . "<br>" . $conn->error;
    }
}

// Fetching supervisor data for pre-filling the form
$supervisor_id = $_GET['id'];
$supervisor_query = "SELECT * FROM supervisors WHERE id = '$supervisor_id'";
$supervisor_result = $conn->query($supervisor_query);
$supervisor_data = $supervisor_result->fetch_assoc();

// Fetching specialties for dropdown
$specialties_query = "SELECT id, specialty_name FROM specialties";
$specialties_result = $conn->query($specialties_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <title>Edit Supervisor</title>
</head>
<body>
    <div class="container mt-4">
        <h2>Edit Supervisor</h2>
        <form method="POST" action="">
            <input type="hidden" name="supervisor_id" value="<?php echo $supervisor_data['id']; ?>">
            <div class="form-group">
                <label for="supervisor_name">Supervisor Name:</label>
                <input type="text" class="form-control" name="supervisor_name" value="<?php echo $supervisor_data['supervisor_name']; ?>" required>
            </div>
            <div class="form-group">
                <label for="specialty_id">Specialty:</label>
                <select class="form-control" name="specialty_id" required>
                    <?php
                    while ($specialty = $specialties_result->fetch_assoc()) {
                        $selected = ($specialty['id'] == $supervisor_data['specialty_id']) ? 'selected' : '';
                        echo "<option value='{$specialty['id']}' $selected>{$specialty['specialty_name']}</option>";
                    }
                    ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
</body>
</html>

<?php
// Close the database connection
$conn->close();
?>
