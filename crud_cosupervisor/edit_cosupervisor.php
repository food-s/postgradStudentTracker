<?php
include('../config.php');

// Fetching specialties for dropdown
$specialties_query = "SELECT id, specialty_name FROM specialties";
$specialties_result = $conn->query($specialties_query);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $cosupervisor_id = $_POST['cosupervisor_id'];
    $cosupervisor_name = $_POST['cosupervisor_name'];
    $specialty_id = $_POST['specialty_id'];

    $update_query = "UPDATE cosupervisors 
                     SET cosupervisor_name = '$cosupervisor_name', specialty_id = '$specialty_id' 
                     WHERE id = '$cosupervisor_id'";

    if ($conn->query($update_query) === TRUE) {
        echo "Co-Supervisor updated successfully";
    } else {
        echo "Error: " . $update_query . "<br>" . $conn->error;
    }
}

// Fetching co-supervisor data for pre-filling the form
$cosupervisor_id = $_GET['id'];
$cosupervisor_query = "SELECT * FROM cosupervisors WHERE id = '$cosupervisor_id'";
$cosupervisor_result = $conn->query($cosupervisor_query);
$cosupervisor_data = $cosupervisor_result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <title>Edit Co-Supervisor</title>
</head>
<body>
    <div class="container mt-4">
        <h2>Edit Co-Supervisor</h2>
        <form method="POST" action="">
            <input type="hidden" name="cosupervisor_id" value="<?php echo $cosupervisor_data['id']; ?>">
            <div class="form-group">
                <label for="cosupervisor_name">Co-Supervisor Name:</label>
                <input type="text" class="form-control" name="cosupervisor_name" value="<?php echo $cosupervisor_data['cosupervisor_name']; ?>" required>
            </div>
            <div class="form-group">
                <label for="specialty_id">Specialty:</label>
                <select class="form-control" name="specialty_id" required>
                    <?php
                    while ($specialty = $specialties_result->fetch_assoc()) {
                        $selected = ($specialty['id'] == $cosupervisor_data['specialty_id']) ? 'selected' : '';
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
