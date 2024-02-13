<?php
include('config.php');


// Fetching supervisors data with specialty information
$supervisors_query = "SELECT supervisors.id, supervisor_name, specialties.specialty_name 
                    FROM supervisors 
                    LEFT JOIN specialties ON supervisors.specialty_id = specialties.id";
$supervisors_result = $conn->query($supervisors_query);

// Count the number of supervisors
$num_supervisors_query = "SELECT COUNT(*) as num_supervisors FROM supervisors";
$num_supervisors_result = $conn->query($num_supervisors_query);
$num_supervisors = ($num_supervisors_result->num_rows > 0) ? $num_supervisors_result->fetch_assoc()['num_supervisors'] : 0;
$cosupervisors_query = "SELECT cosupervisors.id, cosupervisor_name, specialties.specialty_name 
                        FROM cosupervisors 
                        LEFT JOIN specialties ON cosupervisors.specialty_id = specialties.id";

// Fetching cosupervisors data with specialty information                        
$cosupervisors_result = $conn->query($cosupervisors_query);
$students_query = "SELECT students.id, students.student_name, students.programme_duration, students.current_semester, 
                            supervisors.supervisor_name, cosupervisors.cosupervisor_name, programmes.programme_name
                    FROM students
                    LEFT JOIN supervisors ON students.supervisor_id = supervisors.id
                    LEFT JOIN cosupervisors ON students.cosupervisor_id = cosupervisors.id
                    LEFT JOIN programmes ON students.programme_id = programmes.id";

// Count the number of co-supervisors
$num_co_supervisors_query = "SELECT COUNT(*) as num_co_supervisors FROM cosupervisors";
$num_co_supervisors_result = $conn->query($num_co_supervisors_query);
$num_co_supervisors = ($num_co_supervisors_result->num_rows > 0) ? $num_co_supervisors_result->fetch_assoc()['num_co_supervisors'] : 0;
$students_result = $conn->query($students_query);

// Count the number of students
$num_students_query = "SELECT COUNT(*) as num_students FROM students";
$num_students_result = $conn->query($num_students_query);
$num_students = ($num_students_result->num_rows > 0) ? $num_students_result->fetch_assoc()['num_students'] : 0;

// Fetch programmes data
$programmes_query = "SELECT id, programme_name FROM programmes";
$programmes_result = $conn->query($programmes_query);

// Count the number of programmes
$num_programmes_query = "SELECT COUNT(*) as num_programmes FROM programmes";
$num_programmes_result = $conn->query($num_programmes_query);
$num_programmes = ($num_programmes_result->num_rows > 0) ? $num_programmes_result->fetch_assoc()['num_programmes'] : 0;

// Fetching specialties data
$specialties_query = "SELECT id, specialty_name FROM specialties";
$specialties_result = $conn->query($specialties_query);

// Fetching specialties count
$count_specialties_query = "SELECT COUNT(*) as count FROM specialties";
$count_specialties_result = $conn->query($count_specialties_query);
$count_specialties = $count_specialties_result->fetch_assoc()['count'];

// Check for errors in the cosupervisors query
if (!$cosupervisors_result) {
    die("Error in cosupervisors query: " . $conn->error);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styling.css">
    <link href="https://fonts.googleapis.com/css2?family=Rubik:wght@500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    
    
    <title>Dashboard</title>
</head>
<body>
<div role="navigation">
	      <div class="">
	        <div class="brand-logo">
	          <a href=""><img src="./images/UniKL_seal.png" /></a>
	        </div>
	        <div class="brand-phone">
	          <a href="#"><i class="fa fa-phone me-3"></i></a>
	        </div>
	        <div class="text-center">
	          <nav class="top-bar-wrap">
	            <ul class="top-bar">
	              <li class="nav-item">
	                <a href="add_entries.php" class="nav-link"><span class="inner-link">Add Entries</span></a>
	              </li>
	              <li class="nav-item">
	                <a href="https://formsubmit.co/el/nopizu" class="nav-link"><span class="inner-link">Contact</span></a>
	              </li>
	              <li class="nav-item">
	                <a href="https://github.com/food-s" class="nav-link"><span class="inner-link">About</span></a>
	              </li>
	            </ul>
	          </nav>
	          <nav class="main-nav-wrap">
	            <ul class="main-nav">
	              <li class="nav-item">
	                <a href="./dashboard.php" class="nav-link"><span class="inner-link">Dashboard</span></a>
	              </li>
	            </ul>
	          </nav>
	        </div>
	      </div>
	    </div>
<div class="container mt-4">

<!-- <img src="./Images/unikl.jpg" alt=""> -->
<style>
    /* body {
        background-image: url("./Images/unikl.jpg");
        background-repeat: no-repeat;
        background-position: center; 
        height: 1000px;
    } */
    body {
  width: 100vw;
  height: 100vh;
  background-image: url("./Images/unikl.jpg");
  background-repeat: no-repeat;
  background-size: cover;
}
</style>
    </div>
    <div class="container mt-4">
        <h2>Supervisors</h2>

        <!-- Create Button -->
        <a href='./crud_supervisor/create_supervisor.php' class='btn btn-success mb-2'>Add Supervisor</a>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Supervisor Name</th>
                    <th>Specialty Name</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($row = $supervisors_result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>{$row['id']}</td>";
                    echo "<td>{$row['supervisor_name']}</td>";
                    echo "<td>{$row['specialty_name']}</td>";
                    echo "<td>
                            <a href='./crud_supervisor/edit_supervisor.php?id={$row['id']}' class='btn btn-primary btn-sm mr-2'>Edit</a>
                            <a href='./crud_supervisor/delete_supervisor.php?id={$row['id']}' class='btn btn-danger btn-sm'>Delete</a>
                          </td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
        <p>Total Supervisors: <?php echo $num_supervisors; ?></p>
    </div>

    <div class="container mt-4">
        <h2>Co-Supervisors</h2>

        <!-- Create Button -->
        <a href='./crud_cosupervisor/create_cosupersivor.php' class='btn btn-success mb-2'>Add Co-Supervisor</a>

        <?php
        if ($cosupervisors_result->num_rows > 0) {
            echo "<table class='table table-bordered'>";
            echo "<thead>";
            echo "<tr>";
            echo "<th>ID</th>";
            echo "<th>CoSupervisor Name</th>";
            echo "<th>Specialty Name</th>";
            echo "<th>Actions</th>";
            echo "</tr>";
            echo "</thead>";
            echo "<tbody>";

            while ($row = $cosupervisors_result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>{$row['id']}</td>";
                echo "<td>{$row['cosupervisor_name']}</td>";
                echo "<td>{$row['specialty_name']}</td>";
                echo "<td>
                        <a href='./crud_cosupervisor/edit_cosupervisor.php?id={$row['id']}' class='btn btn-primary btn-sm mr-2'>Edit</a>
                        <a href='./crud_cosupervisor/delete_cosupervisor.php?id={$row['id']}' class='btn btn-danger btn-sm'>Delete</a>
                      </td>";
                echo "</tr>";
            }

            echo "</tbody>";
            echo "</table>";
        } else {
            echo "<p>No CoSupervisors found.</p>";
        }
        ?>
            </tbody>
        </table>
        <p>Total Co-Supervisors: <?php echo $num_co_supervisors; ?></p>
    </div>

    <div class="container mt-4">
        <h2>Students</h2>

        <!-- Create Button for Student -->
        <a href='./forms/student_form.php' class='btn btn-success mb-2'>Add Student</a>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Student Name</th>
                    <th>Supervisor</th>
                    <th>Co-Supervisor</th>
                    <th>Programme</th>
                    <th>Programme Duration</th>
                    <th>Current Semester</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($row = $students_result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>{$row['id']}</td>";
                    echo "<td>{$row['student_name']}</td>";
                    echo "<td>{$row['supervisor_name']}</td>";
                    echo "<td>{$row['cosupervisor_name']}</td>";
                    echo "<td>{$row['programme_name']}</td>";
                    echo "<td>{$row['programme_duration']}</td>";
                    echo "<td>{$row['current_semester']}</td>";
                    echo "<td>
                            <a href='./crud_student/edit_student.php?id={$row['id']}' class='btn btn-primary btn-sm mr-2'>Edit</a>
                            <a href='./crud_student/delete_student.php?id={$row['id']}' class='btn btn-danger btn-sm'>Delete</a>
                          </td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
        <p>Total Students: <?php echo $num_students; ?></p>
    </div>

    <div class="container mt-4">
        <h2>Programmes</h2>

        <!-- Create Button for Programme -->
        <a href='./forms/programme_form.php' class='btn btn-success mb-2'>Add Programme</a>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Programme Name</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($row = $programmes_result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>{$row['id']}</td>";
                    echo "<td>{$row['programme_name']}</td>";
                    echo "<td>
                            <a href='./crud_programme/edit_programme.php?id={$row['id']}' class='btn btn-primary btn-sm mr-2'>Edit</a>
                            <a href='./crud_programme/delete_programme.php?id={$row['id']}' class='btn btn-danger btn-sm'>Delete</a>
                          </td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>

        <p>Total Programmes: <?php echo $num_programmes; ?></p>
    </div>

    <div class="container mt-4">
        <h2>Specialties</h2>

        <!-- Create Button for Specialty -->
        <a href='./forms/speciality_form.php' class='btn btn-success mb-2'>Add Specialty</a>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Specialty Name</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($row = $specialties_result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>{$row['id']}</td>";
                    echo "<td>{$row['specialty_name']}</td>";
                    echo "<td>
                            <a href='./crud_specialty/edit_specialty.php?id={$row['id']}' class='btn btn-primary btn-sm mr-2'>Edit</a>
                            <a href='./crud_specialty/delete_specialty.php?id={$row['id']}' class='btn btn-danger btn-sm'>Delete</a>
                          </td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
        <p>Total Number of Specialties: <?php echo $count_specialties; ?></p>
    </div>
    
</body>
</html>


<?php
// Close the database connection
$conn->close();
?>
