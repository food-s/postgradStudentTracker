<?php
session_start();

include('db.php');

// if (!isset($_SESSION['user'])) {
//     header('Location: login.php');
//     exit();
// }

// $user = $_SESSION['user'];

// Fetch all students, supervisors, and assessors from the database
$resultStudents = $conn->query("SELECT * FROM students");
$resultSupervisors = $conn->query("SELECT * FROM supervisors");
$resultAssessors = $conn->query("SELECT * FROM assessors");

// Check if the queries were successful
if ($resultStudents && $resultSupervisors && $resultAssessors) {
    // Fetch associative arrays
    $students = $resultStudents->fetch_all(MYSQLI_ASSOC);
    $supervisors = $resultSupervisors->fetch_all(MYSQLI_ASSOC);
    $assessors = $resultAssessors->fetch_all(MYSQLI_ASSOC);
} else {
    // Handle the error, such as logging or displaying an error message
    $error = $conn->error;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .assign-dropdown {
            display: inline-block;
        }
    </style>
</head>
<body>
    <!-- <h1>Welcome, <?php echo $user['name']; ?>!</h1> -->
    <p>This is your dashboard.</p>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Supervisor ID</th>
                <th>Assessor ID</th>
                <th>Created At</th>
                <th>Updated At</th>
            </tr>
        </thead>
        <tbody>
            <?php if (isset($students) && is_array($students)) : ?>
                <?php foreach ($students as $student) : ?>
                    <tr>
                        <td><?php echo $student['id']; ?></td>
                        <td><?php echo $student['name']; ?></td>
                        <td><?php echo $student['email']; ?></td>
                        <td><?php echo $student['supervisor_id']; ?></td>
                        <td><?php echo $student['assessor_id']; ?></td>
                        <td><?php echo $student['created_at']; ?></td>
                        <td><?php echo $student['updated_at']; ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else : ?>
                <tr>
                    <td colspan="7">No students found</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <h2>Assign Supervisors and Assessors</h2>
    <?php foreach ($students as $student) : ?>
        <div class="assign-dropdown">
            <p><?php echo $student['name']; ?> - Supervisor:</p>
            <form method="post" action="assign_supervisor.php">
                <select name="supervisor_id">
                    <option value="">Select Supervisor</option>
                    <?php foreach ($supervisors as $supervisor) : ?>
                        <option value="<?php echo $supervisor['id']; ?>"><?php echo $supervisor['name']; ?></option>
                    <?php endforeach; ?>
                </select>
                <input type="hidden" name="student_id" value="<?php echo $student['id']; ?>">
                <button type="submit">Assign Supervisor</button>
            </form>
        </div>

        <div class="assign-dropdown">
            <p><?php echo $student['name']; ?> - Assessor:</p>
            <form method="post" action="assign_assessor.php">
                <select name="assessor_id">
                    <option value="">Select Assessor</option>
                    <?php foreach ($assessors as $assessor) : ?>
                        <option value="<?php echo $assessor['id']; ?>"><?php echo $assessor['name']; ?></option>
                    <?php endforeach; ?>
                </select>
                <input type="hidden" name="student_id" value="<?php echo $student['id']; ?>">
                <button type="submit">Assign Assessor</button>
            </form>
        </div>
    <?php endforeach; ?>

    <h2>Insert Data</h2>
    
    <button onclick="location.href='assessor_form.php'">Insert Assessor Data</button>
    <button onclick="location.href='student_form.php'">Insert Student Data</button>
    <button onclick="location.href='supervisor_form.php'">Insert Supervisor Data</button>
    <button onclick="location.href='specialty_form.php'">Insert Specialty Data</button>

    <a href="logout.php">Logout</a>
</body>
</html>
