<?php
include('db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Process form data
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Fetch specialties from the database
    $resultSpecialties = $conn->query("SELECT id, name FROM specialties");

    // Check if the query was successful
    if ($resultSpecialties) {
        // Fetch associative array
        $specialties = $resultSpecialties->fetch_all(MYSQLI_ASSOC);
    } else {
        // Handle the error, such as logging or displaying an error message
        $error = $conn->error;
    }

    // Insert data into the assessors table
    $insertQuery = "INSERT INTO assessors (name, email, password, specialty_id) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($insertQuery);

    // Bind parameters
    $stmt->bind_param("sssi", $name, $email, $password, $_POST['specialty_id']);

    if ($stmt->execute()) {
        echo "Assessor data inserted successfully!";
    } else {
        echo "Error inserting assessor data: " . $stmt->error;
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insert Assessor Data</title>
</head>
<body>
    <h2>Insert Assessor Data</h2>
    
    <form method="post" action="assessor_form.php">
        <label for="name">Name:</label>
        <input type="text" name="name" required>

        <label for="email">Email:</label>
        <input type="email" name="email" required>

        <label for="password">Password:</label>
        <input type="password" name="password" required>

        <label for="specialty_id">Specialty:</label>
        <!-- Populate options based on specialties in the database -->
        <select name="specialty_id" required>
            <?php if (isset($specialties) && is_array($specialties)) : ?>
                <?php foreach ($specialties as $specialty) : ?>
                    <option value="<?php echo $specialty['id']; ?>"><?php echo $specialty['name']; ?></option>
                <?php endforeach; ?>
            <?php else : ?>
                <option value="">No specialties found</option>
            <?php endif; ?>
        </select>

        <button type="submit">Insert Assessor Data</button>
    </form>
</body>
</html>
