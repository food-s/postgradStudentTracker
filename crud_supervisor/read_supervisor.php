<?php
include('../config.php');

// Fetching supervisors data
$supervisors_query = "SELECT supervisors.id, supervisors.supervisor_name, specialties.specialty_name 
                     FROM supervisors 
                     LEFT JOIN specialties ON supervisors.specialty_id = specialties.id";
$supervisors_result = $conn->query($supervisors_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <title>Supervisors</title>
</head>
<body>
    <div class="container mt-4">
        <h2>Supervisors</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Supervisor Name</th>
                    <th>Specialty</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($row = $supervisors_result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>{$row['id']}</td>";
                    echo "<td>{$row['supervisor_name']}</td>";
                    echo "<td>{$row['specialty_name']}</td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>

<?php
// Close the database connection
$conn->close();
?>
