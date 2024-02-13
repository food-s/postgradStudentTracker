<!-- edit_student.php -->
<?php
include('../config.php');

// Fetch supervisors, cosupervisors, programmes, and student data
$supervisors_query = "SELECT id, supervisor_name FROM supervisors";
$supervisors_result = $conn->query($supervisors_query);

$cosupervisors_query = "SELECT id, cosupervisor_name FROM cosupervisors";
$cosupervisors_result = $conn->query($cosupervisors_query);

$programmes_query = "SELECT id, programme_name FROM programmes";
$programmes_result = $conn->query($programmes_query);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle form submission and update data in the students table
    // Adjust this part based on your form fields and data structure
    $student_id = $_POST['student_id'];
    $student_name = $_POST['student_name'];
    $supervisor_id = $_POST['supervisor_id'];
    $cosupervisor_id = $_POST['cosupervisor_id'];
    $programme_id = $_POST['programme_id'];
    $programme_duration = $_POST['programme_duration'];
    $current_semester = $_POST['current_semester'];

    $update_query = "UPDATE students
                     SET student_name = '$student_name',
                         supervisor_id = '$supervisor_id',
                         cosupervisor_id = '$cosupervisor_id',
                         programme_id = '$programme_id',
                         programme_duration = '$programme_duration',
                         current_semester = '$current_semester'
                     WHERE id = '$student_id'";

    if ($conn->query($update_query)) {
        header("Location: ../dashboard.php");
        exit();
    } else {
        echo "Error: " . $conn->error;
    }
} elseif (isset($_GET['id'])) {
    // Fetch student data for pre-filling the form
    $student_id = $_GET['id'];
    $fetch_student_query = "SELECT * FROM students WHERE id = '$student_id'";
    $fetch_student_result = $conn->query($fetch_student_query);

    if ($fetch_student_result->num_rows > 0) {
        $row = $fetch_student_result->fetch_assoc();
        $student_name = $row['student_name'];
        $supervisor_id = $row['supervisor_id'];
        $cosupervisor_id = $row['cosupervisor_id'];
        $programme_id = $row['programme_id'];
        $programme_duration = $row['programme_duration'];
        $current_semester = $row['current_semester'];
    } else {
        echo "Error: Student not found.";
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <title>Edit Student</title>
</head>
<body>
    <div class="container mt-4">
        <h2>Edit Student</h2>

        <!-- Form for editing a student -->
        <form method="POST" action="edit_student.php">
            <input type="hidden" name="student_id" value="<?php echo $student_id; ?>">
            <div class="form-group">
                <label for="student_name">Student Name:</label>
                <input type="text" class="form-control" name="student_name" value="<?php echo $student_name; ?>" required>
            </div>
            <div class="form-group">
                <label for="supervisor_id">Supervisor:</label>
                <select class="form-control" name="supervisor_id" required>
                    <?php
                    while ($row = $supervisors_result->fetch_assoc()) {
                        $selected = ($row['id'] == $supervisor_id) ? 'selected' : '';
                        echo "<option value='{$row['id']}' $selected>{$row['supervisor_name']}</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="cosupervisor_id">Co-Supervisor:</label>
                <select class="form-control" name="cosupervisor_id" required>
                    <?php
                    while ($row = $cosupervisors_result->fetch_assoc()) {
                        $selected = ($row['id'] == $cosupervisor_id) ? 'selected' : '';
                        echo "<option value='{$row['id']}' $selected>{$row['cosupervisor_name']}</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="programme_id">Programme:</label>
                <select class="form-control" name="programme_id" required>
                    <?php
                    while ($row = $programmes_result->fetch_assoc()) {
                        $selected = ($row['id'] == $programme_id) ? 'selected' : '';
                        echo "<option value='{$row['id']}' $selected>{$row['programme_name']}</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="programme_duration">Programme Duration (in semesters):</label>
                <input type="number" class="form-control" name="programme_duration" value="<?php echo $programme_duration; ?>" required>
            </div>
            <div class="form-group">
                <label for="current_semester">Current Semester:</label>
                <input type="number" class="form-control" name="current_semester" value="<?php echo $current_semester; ?>" required>
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
