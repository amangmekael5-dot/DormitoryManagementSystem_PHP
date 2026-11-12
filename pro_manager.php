<?php
session_start();

// Dummy values for demonstration. Replace with actual session or DB values.
$FirstName = $_SESSION['FirstName'] ?? 'Proctor';
$middleName = $_SESSION['middleName'] ?? '';
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
    <img src="img/promanager.png" width="490" height="120" alt="Proctor">
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
    <a class="nav-link text-white" href="pro_manager.php">Home</a>
    <a class="nav-link text-white" href="rblock.php">Register Block</a>
  </nav>

    <div class="row">
        <!-- Sidebar -->
        <div class="col-md-3 mb-4">
            <div class="card mb-3">
                <div class="card-header bg-primary text-white text-center">DDU-DMS</div>
                <div class="card-body text-center">
                    <img src="slideshow/images/DSC01751.JPG" class="img-fluid" style="max-height:100px;">
                </div>
            </div>

            <div class="card mb-3">
                <div class="card-header bg-primary text-white text-center">Manage Record</div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item"><a href="viewst.php">View Student info</a></li>
                    <li class="list-group-item"><a href="viewroom.php">View Rooms</a></li>
                </ul>
            </div>

            <div class="card">
                <div class="card-header bg-primary text-white text-center">Related Links</div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item"><a href="changepassword.php">Change Password</a></li>
                    <li class="list-group-item"><a href="viewcoms.php">View Comment</a></li>
                    <li class="list-group-item"><a href="greporta.php">Generate Report</a></li>
                </ul>
            </div>
        </div>
    <!-- Main Content -->
    <div class="col-md-9">
      <h4 class="my-4">Proctor Information</h4>
      <div class="card p-4" style="border-radius: 25px;">
        <p class="fs-6">Proctor page......</p>
      </div>
    </div>
  </div>

  <!-- Footer -->
  <footer class="mt-5 bg-dark text-white text-center py-4 rounded">
    <div>
      <a href="#top"><img src="img/arrow_up.png" width="40" title="Scroll Back to Top"></a>
    </div>
    <p class="mb-1">&copy; 2025 Dire Dawa University ODMS. All rights reserved.</p>
    <div>
      <a href="proctor.php" class="text-white">Home</a> |
      <a href="registerrooms.php" class="text-white">Register Rooms</a> |
      
    </div>
  </footer>
</div>

<!-- Bootstrap JS, Popper.js, and jQuery -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
