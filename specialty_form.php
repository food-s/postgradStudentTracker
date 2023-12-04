<?php
include('db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Process form data
    $name = $_POST['name'];
    $description = $_POST['description'];

    // Insert data into the specialties table
    $insertQuery = "INSERT INTO specialties (name, description) VALUES (?, ?)";
    $stmt = $conn->prepare($insertQuery);
    $stmt->bind_param("ss", $name, $description);

    if ($stmt->execute()) {
        echo "Specialty data inserted successfully!";
    } else {
        echo "Error inserting specialty data: " . $stmt->error;
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insert Specialty Data</title>
</head>
<body>
    <h2>Insert Specialty Data</h2>
    
    <form method="post" action="specialty_form.php">
        <label for="name">Name:</label>
        <input type="text" name="name" required>

        <label for="description">Description:</label>
        <textarea name="description" rows="4" required></textarea>

        <button type="submit">Insert Specialty Data</button>
    </form>
</body>
</html>
