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

<!-- Slideshow -->
<div class="container mb-4">
  <div class="card shadow-sm overflow-hidden">
    <div class="slider" id="sliderFrame">
      <div id="slider">
        <img src="slideshow/images/image-slider-1.jpg" class="img-fluid" alt="Building One">
        <img src="slideshow/images/image-slider-2.jpg" class="img-fluid" alt="Photo Two">
        <img src="slideshow/images/image-slider-3.jpg" class="img-fluid" alt="Photo Three">
        <img src="slideshow/images/image-slider-4.jpg" class="img-fluid" alt="Photo Four">
        <img src="slideshow/images/image-slider-5.jpg" class="img-fluid" alt="Photo Five">
      </div>
    </div>
  </div>
</div>

<!-- Main Content -->
<div class="container mb-5">
  <div class="row g-4">
    <!-- Sidebar -->
    <aside class="col-lg-4">
      <div class="card shadow-sm p-3">
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

    <!-- Main Section -->
    <main class="col-lg-8">
      <div class="card shadow-sm p-4">
        <h2 class="text-success text-center mb-4">Dire Dawa University</h2>
        <p>Dire Dawa University (DDU) is one of the public universities established by the Ethiopian government in 1999 E.C (2007 G.C). Located in Dire Dawa, it lies approximately 515 kilometers east of Addis Ababa.</p>
        <p>DDU began academic activities in 2001 E.C (2009 G.C) with 754 students across two faculties. Now, it offers 35+ undergraduate and 20+ master's programs, preparing for Ph.D. offerings and serving 12,000+ students.</p>
        <p>Facilities include modern dining halls, health services, dormitories, sports complexes, and community programs.</p>
        <h4 class="text-success mt-4">About Dire Dawa University</h4>
        <p>DDU aims to be a top institution in Ethiopia and East Africa. It is known for excellence in education, research, and social responsibility—fostering integrity, innovation, and community service.</p>

        <hr>
        <p class="fw-bold text-primary">Announcements</p>
        <p>Dear Regular Students of Dire Dawa University:</p>
        <p>You can view your dormitory information by clicking <a href="viewdorm.php">Here</a>.</p>
      </div>
    </main>
  </div>
</div>

<!-- Footer -->
<footer class="bg-primary text-white text-center py-4">
  <div>
    <a href="#top"><img src="img/arrow_up.png" width="40" alt="Back to Top"></a>
  </div>
  <p class="mt-2 mb-0">&copy; 2025 Dire Dawa University Dormitory Management System</p>
  <div class="mt-2">
    <a href="index.php" class="text-white mx-2">Home</a> |
    <a href="about.php" class="text-white mx-2">About Us</a> |
    <a href="contact.php" class="text-white mx-2">Contact Us</a>
  </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
