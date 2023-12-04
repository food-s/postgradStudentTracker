<?php
include('db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Process form data
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $supervisor_id = $_POST['supervisor_id'];  // Assuming a dropdown for selecting supervisor
    $assessor_id = $_POST['assessor_id'];  // Assuming a dropdown for selecting assessor

    // Insert data into the students table
    $insertQuery = "INSERT INTO students (name, email, password, supervisor_id, assessor_id) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($insertQuery);
    $stmt->bind_param("sssii", $name, $email, $password, $supervisor_id, $assessor_id);

    if ($stmt->execute()) {
        echo "Student data inserted successfully!";
    } else {
        echo "Error inserting student data: " . $stmt->error;
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insert Student Data</title>
</head>
<body>
    <h2>Insert Student Data</h2>
    
    <form method="post" action="student_form.php">
        <label for="name">Name:</label>
        <input type="text" name="name" required>

        <label for="email">Email:</label>
        <input type="email" name="email" required>

        <label for="password">Password:</label>
        <input type="password" name="password" required>

        <label for="supervisor_id">Supervisor:</label>
        <!-- Assume a dropdown for selecting supervisor -->
        <select name="supervisor_id" required>
            <!-- Populate options based on supervisors in the database -->
            <option value="1">Supervisor 1</option>
            <option value="2">Supervisor 2</option>
            <!-- Add more options as needed -->
        </select>

        <label for="assessor_id">Assessor:</label>
        <!-- Assume a dropdown for selecting assessor -->
        <select name="assessor_id" required>
            <!-- Populate options based on assessors in the database -->
            <option value="1">Assessor 1</option>
            <option value="2">Assessor 2</option>
            <!-- Add more options as needed -->
        </select>

        <button type="submit">Insert Student Data</button>
    </form>
</body>
</html>
