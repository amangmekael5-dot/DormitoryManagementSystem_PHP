<?php
    include("connection.php");
    session_start();
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

<div class="container">
    <div class="row">
        <!-- Sidebar -->
        <aside class="col-md-3 mb-4">
            <h4>DDU-DMS</h4>
            <div class="text-center mb-3">
                <img src="slideshow/images/DSC01751.JPG" class="img-fluid rounded shadow" width="150">
            </div>
            <h5>Related Links</h5>
            <ul class="list-unstyled">
                <li><a href="http://www.dbu.edu.et" target="_blank">📎 DBU Site</a></li>
                <li><a href="site.php">📎 Site Map</a></li>
                <li><a href="https://mail.google.com/a/dbu.edu.et" target="_blank">📎 Web Mail</a></li>
            </ul>
        </aside>

        <!-- Main Content -->
        <section class="col-md-9">
            <div class="card shadow">
                <div class="card-body">
                    <h4 class="card-title text-primary">Dormitory Placement Info</h4>
                    <p class="card-text">You can see your dormitory placement information by entering your ID or registration number.</p>

                    <form method="POST" action="viewdorm.php">
                        <div class="mb-3">
                            <label for="idno" class="form-label">Student ID No. <span class="text-danger">*</span></label>
                            <input type="text" name="idno" id="idno" class="form-control" required placeholder="Enter your ID number">
                        </div>
                        <button type="submit" name="submitlogin" class="btn btn-primary">Submit</button>
                    </form>

                    <!-- PHP Result -->
                    <div class="mt-4">
                        <?php
                        if (isset($_POST['submitlogin'])) {
                            $idno = $_POST['idno'];
                            $conn = mysqli_connect("localhost", "root", "", "dbudms");

                            if (!$conn) {
                                echo "<div class='alert alert-danger'>Database connection failed.</div>";
                            } else {
                                $idno = mysqli_real_escape_string($conn, $idno);
                                $view = mysqli_query($conn, "SELECT * FROM students WHERE stud_id='$idno'");
                                $rowCheck = mysqli_num_rows($view);

                                if ($rowCheck < 1) {
                                    echo "<div class='alert alert-warning'>The ID number was not found. Redirecting...</div>";
                                    echo '<meta content="5;viewdorm.php" http-equiv="refresh" />';
                                } else {
                                    $row = mysqli_fetch_array($view);
                                    $fname = $row['fname'];
                                    $mname = $row['mname'];
                                    $dorm = $row['room_no'];
                                    $block = $row['block_no'];

                                    echo "
                                    <div class='card mt-3 border-primary'>
                                        <div class='card-header bg-primary text-white'>
                                            {$fname} {$mname}
                                            <a href='viewdorm.php' class='btn btn-sm btn-light float-end'>✖</a>
                                        </div>
                                        <div class='card-body'>
                                            <p><strong>Block No:</strong> $block</p>
                                            <p><strong>Room No:</strong> $dorm</p>
                                        </div>
                                    </div>";
                                }
                                mysqli_close($conn);
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>

<!-- Footer -->
<footer class="bg-primary text-white mt-5 py-4 text-center">
    <a href="#top"><img src="img/arrow_up.png" width="40" alt="Back to Top" title="Back to Top"></a>
    <p class="mt-2 mb-1">&copy; 2025 Dire Dawa University Dormitory Management System. All rights reserved.</p>
    <div>
        <a href="index.php" class="text-white text-decoration-none mx-2">Home</a> |
        <a href="about.php" class="text-white text-decoration-none mx-2">About Us</a> |
        <a href="contact.php" class="text-white text-decoration-none mx-2">Contact</a> |
        <a href="dev.php" class="text-white text-decoration-none mx-2">Developers</a> |
        <a href="comment.php" class="text-white text-decoration-none mx-2">Comment</a>
    </div>
</footer>
</body>
</html>

