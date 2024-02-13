<?php
include('../config.php');

// Fetching specialties for dropdown
$specialties_query = "SELECT id, specialty_name FROM specialties";
$specialties_result = $conn->query($specialties_query);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $cosupervisor_name = $_POST['cosupervisor_name'];
    $specialty_id = $_POST['specialty_id'];

    $insert_query = "INSERT INTO cosupervisors (cosupervisor_name, specialty_id) VALUES ('$cosupervisor_name', '$specialty_id')";

    if ($conn->query($insert_query) === TRUE) {
        echo "Co-Supervisor added successfully";
    } else {
        echo "Error: " . $insert_query . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <title>Add Co-Supervisor</title>
</head>
<body>
    <div class="container mt-4">
        <h2>Add Co-Supervisor</h2>
        <form method="POST" action="">
            <div class="form-group">
                <label for="cosupervisor_name">Co-Supervisor Name:</label>
                <input type="text" class="form-control" name="cosupervisor_name" required>
            </div>
            <div class="form-group">
                <label for="specialty_id">Specialty:</label>
                <select class="form-control" name="specialty_id" required>
                    <?php
                    while ($specialty = $specialties_result->fetch_assoc()) {
                        echo "<option value='{$specialty['id']}'>{$specialty['specialty_name']}</option>";
                    }
                    ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</body>
</html>

<?php
// Close the database connection
$conn->close();
?>
