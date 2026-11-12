<?php
session_start();
include("connection.php");

if (isset($_POST['submitlogin'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = mysqli_prepare($conn, "SELECT * FROM users WHERE username=?");
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($result)) {
        if ($password === $row['password']) {
            if ($row['status'] == 1) {
                $_SESSION['user_id'] = $row['user_id'];

                switch ($row['level']) {
                    case 1:
                        header("Location: admin.php");
                        exit();
                    case 2:
                        header("Location: pro_manager.php");
                        exit();
                    case 3:
                        header("Location: proctor.php");
                        exit();
                    default:
                        echo "<p class='wrong'>Invalid user level.</p>";
                }
            } else {
                echo "<p class='wrong'>Your account is not active. Please contact the system admin.</p>";
            }
        } else {
            echo "<p class='wrong'>Incorrect password.</p>";
        }
    } else {
        echo "<p class='wrong'>User not found.</p>";
    }

    mysqli_close($conn);
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>DDU Dormitory Management System</title>
  <link rel="icon" href="img/dbuicon.png" type="image/png" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="styl.css">
  <link rel="stylesheet" href="slideshow/imageslider.css">
  <link rel="stylesheet" href="src/facebox.css">
  <script src="lib/jquery.js" defer></script>
  <script src="src/facebox.js" defer></script>
  <script src="slideshow/imageslider.js" defer></script>
  <script>
    document.addEventListener('DOMContentLoaded', function() {
        jQuery('a[rel*=facebox]').facebox({
            loadingImage: 'src/loading.gif',
            closeImage: 'src/closelabel.png'
        });
    });
  </script>
  <style>
    body {
      background-color: #f0f2f5;
    }
    .navbar-nav .nav-link {
      font-weight: 600;
      font-size: 16px;
    }
    .related-links img {
      width: 14px;
      margin-right: 5px;
    }
    footer a {
      color: #fff;
      text-decoration: none;
    }
    footer a:hover {
      text-decoration: underline;
    }
  </style>
</head>

<body>

<!-- Header -->
<header class="bg-white shadow-sm py-3 mb-3">
  <div class="container d-flex justify-content-between align-items-center">
    <a href="index.php"><img src="img/logo.png" alt="DDU Logo" height="80" class="rounded shadow-sm"></a>
    <a href="login.php" class="btn btn-outline-primary fw-bold">Login</a>
  </div>
  <div class="text-center mt-3">
    <img src="img/dbudms.png" alt="DDU Dormitory Management" class="img-fluid" style="max-width: 470px;" />
  </div>
</header>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-primary mb-4">
  <div class="container">
    <ul class="navbar-nav mx-auto">
      <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
      <li class="nav-item"><a class="nav-link" href="about.php">About Us</a></li>
      <li class="nav-item"><a class="nav-link" href="contact.php">Contact Us</a></li>
      <li class="nav-item"><a class="nav-link" href="viewdorm.php">View Dorm</a></li>
      <li class="nav-item"><a class="nav-link" href="admin.php">Admin Login</a></li>
    </ul>
  </div>
</nav>
      

<!-- Main Content -->
<div class="container my-5">
  <div class="row">
    <!-- Sidebar -->
    <aside class="col-md-4 mb-4">
      <div class="bg-white p-3 rounded shadow-sm">
        <h4 class="text-center">DDU-DMS</h4>
        <div class="text-center my-3">
          <img src="slideshow/images/DSC01751.JPG" class="img-fluid rounded" alt="Dorm" style="max-height: 150px;" />
        </div>

        <h5>Related Links</h5>
        <ul class="list-unstyled related-links">
          <li><img src="img/Picture2.png"><a href="http://www.dbu.edu.et" target="_blank"> DBU Site</a></li>
          <li><img src="img/Picture2.png"><a href="site.php"> Site Map</a></li>
          <li><img src="img/Picture2.png"><a href="https://mail.google.com/a/dbu.edu.et" target="_blank"> Web Mail</a></li>
        </ul>
      </div>
    </aside>

    <!-- Login Card -->
    <main class="col-md-8 d-flex align-items-center justify-content-center">
      <div class="card login-card w-100" style="max-width: 500px;">
        <div class="login-header d-flex justify-content-between align-items-center">
          <h5 class="mb-0">Member Login</h5>
          <a href="index.php"><img src="img/close_icon.gif" alt="Close" width="20"></a>
        </div>
        <div class="card-body">
          <form action="login.php" method="POST" onsubmit="return validateForm()">
            <div class="text-center mb-3">
              <img src="img/login_icon1.gif" alt="Login Icon" width="80">
            </div>
            <div class="mb-3">
              <label for="username" class="form-label">Username <span class="text-danger">*</span></label>
              <input type="text" name="username" id="username" class="form-control" required />
            </div>
            <div class="mb-3">
              <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
              <input type="password" name="password" id="password" class="form-control" required />
            </div>
            <div class="mb-3 text-end">
              <a href="forget.php" class="small text-muted">Forget Your Password? <img src="img/help.png" alt="Help" width="14"></a>
            </div>
            <div class="d-grid">
              <button type="submit" name="submitlogin" class="btn btn-primary">Login</button>
            </div>
          </form>
        </div>
      </div>
    </main>
  </div>
</div>

<!-- Footer -->
<footer class="bg-primary text-white text-center py-4 mt-5">
  <div>
    <a href="#top"><img src="img/arrow_up.png" width="40" alt="Back to Top"></a>
  </div>
  <p class="mt-2 mb-0">&copy; 2025 Dire Dawa University Dormitory Management System</p>
  <div class="mt-2">
    <a href="index.php" class="text-white mx-2">Home</a> |
    <a href="about.php" class="text-white mx-2">About Us</a> |
    <a href="contact.php" class="text-white mx-2">Contact Us</a> |
   
    <a href="comment.php" class="text-white mx-2">Comment</a>
  </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
function validateForm() {
  // Add your validation logic if needed
  return true;
}
</script>
</body>
</html>
