<?php
// Include the database connection file
include("connection.php");

// Start the session
session_start();

// Check if the user is logged in
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    echo "<script>
            alert('You Are Not Logged In !! Please Login to access this page');
            window.location='login.php';
          </script>";
    exit();
}

// Create a MySQLi connection
$mysqli = new mysqli("localhost", "root", "", "dbudms"); // Replace with your actual database credentials

// Check for connection errors
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Prepare a statement to avoid SQL injection
$stmt = $mysqli->prepare("SELECT * FROM users WHERE user_id = ?");
$stmt->bind_param("i", $user_id); // Bind the user_id as an integer
$stmt->execute();

// Get the result of the query
$result = $stmt->get_result();

// Fetch the user data if it exists
if ($row = $result->fetch_assoc()) {
    $FirstName = $row['FNAME']; // Assuming 'FNAME' is the column name in your database
    $middleName = $row['mNAME']; // Assuming 'mNAME' is the column name in your database
} else {
    echo "No user data found!";
    exit();
}

// Close the statement and connection
$stmt->close();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dire Dawa University Online Dormitory Management System</title>
    <link rel="icon" type="image/png" href="img/dbuicon.png"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="logstyl.css" rel="stylesheet">
    <link href="a.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container py-4">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <img src="img/logo.png" width="150" height="120" alt="Logo">
        <img src="img/proctor.png" width="490" height="120" alt="Proctor">
        <div>
            <img src="img/people.png" width="40" height="30" alt="User">
            <span class="text-dark fs-5"><?php echo htmlspecialchars($FirstName)." ".htmlspecialchars($middleName); ?></span>
            <a href="logout.php" class="btn btn-danger btn-sm ms-2">Logout</a>
        </div>
    </div>

    <!-- Navigation -->
    <nav class="nav nav-pills bg-primary p-2 rounded mb-4">
        <a class="nav-link text-white" href="proctor.php">Home</a>
        <a class="nav-link text-white" href="registerrooms.php">Register Rooms</a>
    </nav>

<!-- Main Content Section -->
<div class="row">
        <!-- Sidebar -->
        <div class="col-md-3">
            <div class="list-group">
                <div class="list-group-item bg-primary text-white text-center">DDU-DMS</div>
                <div class="list-group-item text-center">
                    <img src="slideshow/images/DSC01751.JPG" class="img-fluid" width="150px" height="100px">
                </div>
                <div class="list-group-item bg-primary text-white text-center">Manage Record</div>
                <a href="assign.php" class="list-group-item">Assign Student</a>
                <a href="viewstu.php" class="list-group-item">View Student Info</a>
                <div class="list-group-item bg-primary text-white text-center">Related Links</div>
                <a href="changepassword.php" class="list-group-item">Change Password</a>
                <a href="greporta.php" class="list-group-item">Generate Report</a>
            </div>
        </div>
        
        <!-- Main Content -->
        <div class="col-md-9">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <strong>Search for Student</strong>
                </div>
                <div class="card-body">
                    <form action="viewstu.php" method="POST">
                        <div class="mb-3">
                            <label for="searchs" class="form-label">Enter Student ID No:</label>
                            <input type="text" name="searchs" id="searchs" class="form-control" placeholder="Enter Student ID" required>
                        </div>
                        <button type="submit" name="search" class="btn btn-primary">Search</button>
                    </form>
                </div>
            </div>

            <?php
            if (isset($_POST['search'])) {
                $idno = $_POST['searchs'];

                // Create a MySQLi connection
                $mysqli = new mysqli("localhost", "root", "", "dbudms"); // Replace with your database credentials

                // Check for connection errors
                if ($mysqli->connect_error) {
                    die("Connection failed: " . $mysqli->connect_error);
                }

                // Prepare the SQL query to search for the student by ID
                $stmt = $mysqli->prepare("SELECT * FROM students WHERE stud_id = ?");
                $stmt->bind_param("s", $idno); // Bind the student ID as a string parameter
                $stmt->execute();
                $result = $stmt->get_result();

                // Check if no results were found
                if ($result->num_rows < 1) {
                    echo('<div class="alert alert-danger mt-3">This ID Number is not found</div>');
                } else {
                    echo "<div class='mt-4'>";
                    echo "<table class='table table-striped'>
                            <thead class='thead-dark'>
                                <tr>
                                    <th>Name</th>
                                    <th>ID</th>
                                    <th>Sex</th>
                                    <th>Batch</th>
                                    <th>Faculty</th>
                                    <th>Block</th>
                                    <th>Room</th>
                                </tr>
                            </thead>
                            <tbody>";
                    // Fetch and display student data
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>" . $row['fname'] . ' ' . $row['mname'] . "</td>
                                <td>" . $row['stud_id'] . "</td>
                                <td>" . $row['sex'] . "</td>
                                <td>" . $row['batch'] . "</td>
                                <td>" . $row['faculty'] . "</td>
                                <td>" . $row['block_no'] . "</td>
                                <td>" . $row['room_no'] . "</td>
                              </tr>";
                    }
                    echo "</tbody>
                          </table>";
                    echo "</div>";
                }

                // Close the prepared statement and the connection
                $stmt->close();
                $mysqli->close();
            }
            ?>
        </div>
    </div>


<!-- Footer -->
<footer class="bg-dark text-white text-center py-3 mt-4">
    <a href="#top" class="text-white">
        <img src="img/arrow_up.png" width="40px" title="Scroll Back to Top">
    </a>
    <p class="mb-0">&copy; 2025 Dire Dawa University ODMS. All rights reserved.</p>
    <p>
        <a href="proctor.php" class="text-white">Home</a> |
        <a href="registerrooms.php" class="text-white">Register Rooms</a> |
        <a href="comments.php" class="text-white">Comment</a>
    </p>
</footer>
</div>
<!-- Bootstrap JS and dependencies -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
