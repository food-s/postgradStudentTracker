<?php
include('../config.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Process the form data and insert into the Specialties table
    $specialty_name = $_POST['specialty_name'];

    $insert_query = "INSERT INTO specialties (specialty_name)
                    VALUES ('$specialty_name')";

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
    <title>Add Specialty</title>
</head>
<body>
    <div class="container mt-4 ">
        <h2>Add Specialty</h2>
        <form method="POST" action="">
            <div class="form-group row">
                <label for="specialty_name">Specialty Name:</label>
                <input type="text" class="form-control" name="specialty_name" required >
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
