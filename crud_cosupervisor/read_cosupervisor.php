<?php
include('../config.php');

// Fetching co-supervisors data
$cosupervisors_query = "SELECT id, cosupervisor_name, specialties.specialty_name 
                        FROM cosupervisors 
                        LEFT JOIN specialties ON cosupervisors.specialty_id = specialties.id";
$cosupervisors_result = $conn->query($cosupervisors_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <title>Co-Supervisors</title>
</head>
<body>
    <div class="container mt-4">
        <h2>Co-Supervisors</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Co-Supervisor Name</th>
                    <th>Specialty</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($row = $cosupervisors_result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>{$row['id']}</td>";
                    echo "<td>{$row['cosupervisor_name']}</td>";
                    echo "<td>{$row['specialty_name']}</td>";
                    echo "<td>
                            <a href='edit_cosupervisor.php?id={$row['id']}' class='btn btn-primary btn-sm mr-2'>Edit</a>
                            <a href='delete_cosupervisor.php?id={$row['id']}' class='btn btn-danger btn-sm'>Delete</a>
                          </td>";
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
