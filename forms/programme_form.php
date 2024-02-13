<?php
include('../config.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Process the form data and insert into the Programmes table
    $programme_name = $_POST['programme_name'];
    $programme_duration = $_POST['programme_duration'];

    $insert_query = "INSERT INTO programmes (programme_name, programme_duration)
                    VALUES ('$programme_name', '$programme_duration')";

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
    <title>Add Programme</title>
</head>
<body>
    <div class="container mt-4">
        <h2>Add Programme</h2>
        <form method="POST" action="">
            <div class="form-group">
                <label for="programme_name">Programme Name:</label>
                <input type="text" class="form-control" name="programme_name" required>
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
