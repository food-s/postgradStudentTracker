<?php
include('../config.php');

// Fetching supervisors, co-supervisors, and programs for dropdowns
$supervisors_query = "SELECT id, supervisor_name FROM supervisors";
$co_supervisors_query = "SELECT id, cosupervisor_name FROM cosupervisors";
$programs_query = "SELECT id, programme_name FROM programmes";

$supervisors_result = $conn->query($supervisors_query);
$co_supervisors_result = $conn->query($co_supervisors_query);
$programs_result = $conn->query($programs_query);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Process the form data and insert into the Students table
    $student_name = $_POST['student_name'];
    $supervisor_id = $_POST['supervisor_id'];
    $cosupervisor_id = $_POST['cosupervisor_id'];
    $programme_id = $_POST['programme_id'];
    $current_semester = $_POST['current_semester'];
    $programme_duration = $_POST['programme_duration'];

    $insert_query = "INSERT INTO students (student_name, supervisor_id, cosupervisor_id, programme_id, current_semester, programme_duration)
                    VALUES ('$student_name', '$supervisor_id', '$cosupervisor_id', '$programme_id', '$current_semester', '$programme_duration')";

    if ($conn->query($insert_query) === TRUE) {
        echo "Record added successfully";
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
    <link rel="stylesheet" href="style.css">
    <title>Add Student</title>
</head>
<body>
    <div class="container mt-4">
        <h2>Add Student</h2>
        <form method="POST" action="">
            <div class="form-group">
                <label for="student_name">Student Name:</label>
                <input type="text" class="form-control" name="student_name" required>
            </div>
            <div class="form-group">
                <label for="supervisor_id">Main Supervisor:</label>
                <select class="form-control" name="supervisor_id" required>
                    <?php
                    while ($supervisor = $supervisors_result->fetch_assoc()) {
                        echo "<option value='{$supervisor['id']}'>{$supervisor['supervisor_name']}</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="cosupervisor_id">Co-Supervisor:</label>
                <select class="form-control" name="cosupervisor_id" required>
                    <?php
                    while ($co_supervisor = $co_supervisors_result->fetch_assoc()) {
                        echo "<option value='{$co_supervisor['id']}'>{$co_supervisor['cosupervisor_name']}</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="programme_id">Programme:</label>
                <select class="form-control" name="programme_id" required>
                    <?php
                    while ($program = $programs_result->fetch_assoc()) {
                        echo "<option value='{$program['id']}'>{$program['programme_name']}</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="current_semester">Current Semester:</label>
                <input type="text" class="form-control" name="current_semester" required>
            </div>
            <div class="form-group">
                <label for="programme_duration">Programme Duration:</label>
                <input type="text" class="form-control" name="programme_duration" required>
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
