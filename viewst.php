<?php
include("connection.php");  
session_start();

if (isset($_SESSION['user_id'])) {
    $mail = $_SESSION['user_id'];
} else {
    echo "<script>
        alert('You Are Not Logged In !! Please Login to access this page');
        window.location.href = 'login.php';
    </script>";
    exit;
}

$user_id = $_SESSION['user_id'];

// Updated query using mysqli
$sql = "SELECT * FROM users WHERE user_id = ?";
if ($stmt = $conn->prepare($sql)) {
    $stmt->bind_param("s", $user_id); // "s" means the parameter is a string
    $stmt->execute();
    $result = $stmt->get_result();
    
    // Fetch the result
    if ($row = $result->fetch_assoc()) {
        $FirstName = $row['FNAME'];
        $middleName = $row['mNAME'];
    } else {
        // In case no user is found
        echo "User not found.";
        exit;
    }
    $stmt->close();
} else {
    echo "Error preparing statement: " . $conn->error;
    exit;
}
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
    <style>
    #vtable th, #vtable td {
        text-align: center;
        vertical-align: middle;
    }
    .nav-link.active {
        font-weight: bold;
    }
    @media (max-width: 768px) {
      .logout-btn {
        margin-top: 10px;
      }
    }
  </style>
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
<!--End Of Sub menus-->
<!--Body section-->
<div class="container mt-5">
    <div class="card shadow-lg border-0 rounded-4">
        <div class="card-body">
            <form action="viewst.php" onsubmit='return formValidator()' method='POST'>
                <div class="row mb-3 justify-content-center align-items-center">
                    <label for="searchs" class="col-sm-3 col-form-label fw-bold text-end">Enter Student ID NO:</label>
                    <div class="col-sm-5">
                        <input type="text" name="searchs" id="searchs" class="form-control" placeholder="Provide Here..." required>
                    </div>
                    <div class="col-sm-2">
                        <button type="submit" name="search" class="btn btn-primary w-100">Search</button>
                    </div>
                </div>
            </form>

            <?php
            if (isset($_POST['search'])) {
                $idno = $_POST['searchs'];

                $sql = "SELECT * FROM students WHERE stud_id = ?";
                if ($stmt = $conn->prepare($sql)) {
                    $stmt->bind_param("s", $idno);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    $count = $result->num_rows;

                    if ($count < 1) {
                        echo '<div class="alert alert-danger text-center" role="alert">This ID Number is not found</div>';
                        echo '<meta content="5;viewst.php" http-equiv="refresh" />';
                    } else {
                        echo '<div class="table-responsive mt-4">';
                        echo '<table class="table table-bordered table-hover align-middle text-center table-striped">';
                        echo '<thead class="table-primary">';
                        echo '<tr>
                                <th>Name</th>
                                <th>ID</th>
                                <th>Sex</th>
                                <th>Batch</th>
                                <th>Faculty</th>
                                <th>Block</th>
                                <th>Room</th>
                              </tr>';
                        echo '</thead><tbody>';

                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row['fname'] . ' ' . $row['mname'] . "</td>";
                            echo "<td>" . $row['stud_id'] . "</td>";
                            echo "<td>" . $row['sex'] . "</td>";
                            echo "<td>" . $row['batch'] . "</td>";
                            echo "<td>" . $row['faculty'] . "</td>";
                            echo "<td>" . $row['block_no'] . "</td>";
                            echo "<td>" . $row['room_no'] . "</td>";
                            echo "</tr>";
                        }
                        echo '</tbody></table></div>';
                    }
                    $stmt->close();
                } else {
                    echo '<div class="alert alert-danger" role="alert">Error: ' . $conn->error . '</div>';
                }
                $conn->close();
            }
            ?>
        </div>
    </div>
</div>

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

<!--End of Footer-->
</body>
</html>
