<?php
include("connection.php");  
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    echo "<script>
            alert('You Are Not Logged In !! Please Login to access this page');
            window.location='login.php';
          </script>";
    exit(); // Stop further execution
}

// Get the user ID from the session
$user_id = $_SESSION['user_id'];

// Create connection
$conn = new mysqli("localhost", "root", "", "dbudms");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Prepare and bind
$stmt = $conn->prepare("SELECT * FROM users WHERE user_id = ?");
$stmt->bind_param("i", $user_id); // "i" means the parameter is an integer

// Execute the statement
$stmt->execute();
$result = $stmt->get_result();

// Check if a row was returned
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $FirstName = $row['FNAME'];
    $middleName = $row['mNAME'];
} else {
    echo "<script>alert('User  not found.'); window.location='login.php';</script>";
    exit();
}

// Close the statement and connection
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Dire Dawa University Online Dormitory Management System</title>
  <link rel="icon" type="image/png" href="img/dbuicon.png"/>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="logstyl.css" rel="stylesheet" type="text/css" media="screen" />
  <link href="a.css" rel="stylesheet" type="text/css" media="screen" />
  <script src="aa.js" type="text/javascript"></script>
</head>
<body class="bg-light">

<div class="container py-4">
  <!-- Header -->
  <div class="d-flex justify-content-between align-items-center mb-3">
    <img src="img/logo.png" width="150" height="120" alt="Logo">
    <img src="img/proctor.png" width="490" height="120" alt="Proctor">
    <div>
      <img src="img/people.png" width="40" height="30" alt="User">
      <span class="text-dark fs-5">
                <?php echo htmlspecialchars($FirstName)." ".htmlspecialchars($middleName); ?>
            </span>
      <a href="logout.php" class="btn btn-danger btn-sm ms-2">Logout</a>
    </div>
  </div>

  <!-- Main Navigation -->
  <nav class="nav nav-pills bg-primary p-2 rounded mb-4">
    <a class="nav-link text-white" href="proctor.php">Home</a>
    <a class="nav-link text-white" href="registerrooms.php">Register Rooms</a>
  </nav>

  <!-- Main Content Area -->
  <div class="row">
    <!-- Sidebar -->
    <div class="col-md-4 mb-4">
      <div class="card mb-3">
        <div class="card-header bg-primary text-white text-center">DDU-DMS</div>
        <div class="card-body text-center">
          <img src="slideshow/images/DSC01751.JPG" class="img-fluid" alt="Dormitory">
        </div>
      </div>

      <div class="card mb-3">
        <div class="card-header bg-primary text-white text-center">Manage Record</div>
        <ul class="list-group list-group-flush">
          <li class="list-group-item"><img src="img/Picture2.png" width="10"> <a href="assign.php">Assign Student</a></li>
          <li class="list-group-item"><img src="img/Picture2.png" width="10"> <a href="viewstu.php">View Student Info</a></li>
        </ul>
      </div>

      <div class="card">
        <div class="card-header bg-primary text-white text-center">Related Links</div>
        <ul class="list-group list-group-flush">
          <li class="list-group-item"><img src="img/Picture2.png" width="10"> <a href="changepassword.php">Change Password</a></li>
          <li class="list-group-item"><img src="img/Picture2.png" width="10"> <a href="greporta.php">Generate Report</a></li>
        </ul>
      </div>
    </div>

    <!-- Main Section -->
    <div class="col-md-8">
      <div class="p-4 bg-white shadow rounded">
        <p class="fs-5">Proctor page......</p>
      </div>
    </div>
  </div>

  <!-- Footer -->
  <footer class="mt-5 bg-dark text-white text-center py-4 rounded">
    <div>
      <a href="#top"><img src="img/arrow_up.png" width="40" title="Scroll Back to Top"></a>
    </div>
    <p class="mb-1">&copy; 2014 Dire Dawa University ODMS. All rights reserved.</p>
    <div>
      <a href="proctor.php" class="text-white">Home</a> |
      <a href="registerrooms.php" class="text-white">Register Rooms</a> |
      <a href="comments.php" class="text-white">Comment</a>
    </div>
  </footer>
</div>

<!-- Bootstrap JS (Optional) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
