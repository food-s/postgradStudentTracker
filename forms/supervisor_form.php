<?php
include('../config.php');

// Fetching specialties for dropdown
$specialties_query = "SELECT id, specialty_name FROM specialties";
$specialties_result = $conn->query($specialties_query);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Process the form data and insert into the Supervisors table
    $supervisor_name = $_POST['supervisor_name'];
    $specialty_name = $_POST['specialty_name'];

    // Fetching the corresponding specialty_id based on the selected specialty_name
    $specialty_id_query = "SELECT id FROM specialties WHERE specialty_name = '$specialty_name'";
    $specialty_id_result = $conn->query($specialty_id_query);

    if ($specialty_id_result->num_rows > 0) {
        $row = $specialty_id_result->fetch_assoc();
        $specialty_id = $row['id'];

        // Inserting into the Supervisors table
        $insert_query = "INSERT INTO supervisors (supervisor_name, specialty_id, specialty_name)
                        VALUES ('$supervisor_name', '$specialty_id', '$specialty_name')";

        if ($conn->query($insert_query) === TRUE) {
            echo "Record added successfully";
        } else {
            echo "Error: " . $insert_query . "<br>" . $conn->error;
        }
    } else {
        echo "Error: Specialty not found.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
    <title>Add Supervisor</title>
</head>
<body>
    <div class="container mt-4">
        <h2>Add Supervisor</h2>
        <form method="POST" action="">
            <div class="form-group">
                <label for="supervisor_name">Supervisor Name:</label>
                <input type="text" class="form-control" name="supervisor_name" required>
            </div>
            <div class="form-group">
                <label for="specialty_name">Specialty:</label>
                <select class="form-control" name="specialty_name" required>
                    <?php
                    while ($specialty = $specialties_result->fetch_assoc()) {
                        echo "<option value='{$specialty['specialty_name']}'>{$specialty['specialty_name']}</option>";
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
