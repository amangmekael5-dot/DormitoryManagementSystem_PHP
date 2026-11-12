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
<section class="container my-4">
  <div class="slider rounded shadow-sm overflow-hidden">
    <div id="slider">
      <img src="slideshow/images/image-slider-1.jpg" class="img-fluid" alt="Building One">
      <img src="slideshow/images/image-slider-2.jpg" class="img-fluid" alt="Photo Two">
      <img src="slideshow/images/image-slider-3.jpg" class="img-fluid" alt="Photo Three">
      <img src="slideshow/images/image-slider-4.jpg" class="img-fluid" alt="Photo Four">
      <img src="slideshow/images/image-slider-5.jpg" class="img-fluid" alt="Photo Five">
    </div>
  </div>
</section>

<!-- Main Content -->
<div class="container bg-white rounded shadow-sm p-4 mb-4">
  <div class="row">
    <!-- Sidebar -->
    <aside class="col-md-4 mb-4 mb-md-0">
      <h3>DDU-DMS</h3>
      <div class="text-center my-3">
        <img src="slideshow/images/DSC01751.JPG" class="img-thumbnail" width="150" height="100">
      </div>

      <h4>Related Links</h4>
      <ul class="list-unstyled">
        <li><img src="img/Picture2.png" width="12">&nbsp;<a href="http://www.dbu.edu.et" target="_blank">DBU Site</a></li>
        <li><img src="img/Picture2.png" width="12">&nbsp;<a href="site.php">Site Map</a></li>
        <li><img src="img/Picture2.png" width="12">&nbsp;<a href="https://mail.google.com/a/dbu.edu.et" target="_blank">Web Mail</a></li>
      </ul>
    </aside>

    <!-- Main Section -->
    <main class="col-md-8">
      <h2 class="text-success text-center mb-4">About Dire Dawa University</h2>
      <p>Dire Dawa University (DDU) is one of the public universities established by the Ethiopian government (Ministry of Education) in 1999 E.C (2007 G.C). Located in the eastern part of Ethiopia, within the Dire Dawa City Administration, DDU is approximately 515 kilometers east of Addis Ababa.</p>

      <p>The foundation stone for the university was laid in 1999 E.C, and DDU officially commenced its academic activities in 2001 E.C (2009 G.C) with an initial enrollment of 754 students across two faculties: the Faculty of Natural and Computational Sciences and the Faculty of Social Sciences and Humanities.</p>

      <p>Over the years, Dire Dawa University has experienced remarkable growth. By 2007 E.C, the student population had exceeded 5,000. Currently, the university offers more than 35 undergraduate programs, 20 master's programs, and is preparing to launch several Ph.D. programs. It serves a diverse student body of over 12,000.</p>

      <p>In addition to its academic offerings, Dire Dawa University provides comprehensive student services including modern dining facilities, well-equipped health care services, spacious dormitories, sports complexes, and active community engagement programs benefiting both students and the wider Dire Dawa community.</p>

      <h4 class="text-success mt-5">University Mission & Vision</h4>
      <p>Dire Dawa University is committed to academic excellence, innovation, and social responsibility. Its vision is to become one of the top universities in Ethiopia and East Africa by delivering high-quality education, conducting cutting-edge research, and fostering sustainable community development. DDU is known for its dynamic campus life, professional training programs, vibrant research culture, and strong partnerships with industries, government bodies, and international institutions.</p>

      <div class="alert alert-primary mt-4" role="alert">
        <h5 class="mb-2">Announcements</h5>
        <p>Dear Regular Students of Dire Dawa University:</p>
        <p>You can view your dormitory information by clicking <a href="viewdorm.php" class="alert-link">Here</a>.</p>
      </div>
    </main>
  </div>
</div>

<!-- Footer -->
<footer class="bg-primary text-white text-center py-4">
  <a href="#top"><img src="img/arrow_up.png" width="40" alt="Back to Top" title="Scroll Back to Top"></a>
  <p class="mt-2 mb-0">© 2025 Dire Dawa University Dormitory Management System. All rights reserved.</p>
  <div class="mt-2">
    <a href="index.php" class="text-white me-2">Home</a> |
    <a href="about.php" class="text-white mx-2">About Us</a> |
    <a href="contact.php" class="text-white ms-2">Contact Us</a>
  </div>
</footer>

<!-- Bootstrap JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
