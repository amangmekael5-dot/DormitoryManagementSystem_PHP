<?php
$servername = "localhost"; // your server
$username = "root"; // your database username
$password = ""; // your database password
$dbname = "dbudms"; // your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Start session
session_start();

// Check if the user is logged in
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id']; // Get user ID from session

    // Prepare SQL query to fetch user information
    $sql = "SELECT FNAME, mNAME FROM users WHERE user_id = ?";
    
    // Prepare and bind the query
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("s", $user_id); // "s" means the parameter is a string
        $stmt->execute();
        $stmt->store_result();
        
        if ($stmt->num_rows > 0) {
            // Bind the result to variables
            $stmt->bind_result($FirstName, $middleName);
            $stmt->fetch();
        } else {
            // If no user is found, set default values for variables
            $FirstName = "Unknown";
            $middleName = "Unknown";
        }
        
        $stmt->close();
    } else {
        // Handle error if the query preparation fails
        echo "Error in preparing statement: " . $conn->error;
    }
} else {
    // If the user is not logged in, redirect to login page
    echo "<script>
            alert('You Are Not Logged In !! Please Login to access this page');
            window.location = 'login.php';
          </script>";
    exit();
}

// Close connection
$conn->close();
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

        <!-- Change Password Form -->
        <div class="col-md-9">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <strong>Change Password</strong>
                    <a href="proctor.php" class="btn btn-light btn-sm float-right">Close</a>
                </div>
                <div class="card-body">
                    <form method="POST" action="changepassword.php" onsubmit="return validateForm()">
                        <?php
                        if (isset($_POST['changepassword'])) {
                            // Handle password change logic
                            // ... (same as your original PHP code)
                        }
                        ?>
                        <div class="form-group">
                            <label for="old_password">Old Password <font color="red">*</font></label>
                            <input type="password" name="old_password" id="old_password" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="new_password">New Password <font color="red">*</font></label>
                            <input type="password" name="new_password" id="new_password" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="confirm_password">Confirm Password <font color="red">*</font></label>
                            <input type="password" name="confirm_password" id="confirm_password" class="form-control" required>
                        </div>
                        <div class="form-group text-center">
                            <button type="submit" name="changepassword" class="btn btn-primary">Change Password</button>
                        </div>
                    </form>
                </div>
            </div>
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

<!-- Bootstrap JS & jQuery -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
