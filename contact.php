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

<!-- Main Content -->
<main class="container my-5">
    <div class="card shadow mx-auto" style="max-width: 700px;">
        <div class="card-header bg-primary text-white text-center">
            <h2 class="mb-0">Contact Us</h2>
        </div>
        <div class="card-body">
            <form action="contact_form_handler.php" method="POST">
                <div class="mb-3">
                    <label for="name" class="form-label">Full Name:</label>
                    <input type="text" id="name" name="name" required class="form-control" placeholder="Enter your full name">
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email Address:</label>
                    <input type="email" id="email" name="email" required class="form-control" placeholder="Enter your email address">
                </div>

                <div class="mb-3">
                    <label for="message" class="form-label">Your Message:</label>
                    <textarea id="message" name="message" rows="4" required class="form-control" placeholder="Write your message here..."></textarea>
                </div>

                <div class="text-center">
                    <button type="submit" class="btn btn-primary px-4">Submit</button>
                </div>
            </form>
        </div>
    </div>

    <div class="text-center mt-4">
        <h5>Alternatively, you can reach us at:</h5>
        <p>Email: <a href="mailto:info@ddu.edu.et">info@ddu.edu.et</a></p>
        <p>Phone: <a href="tel:+251912345678">+251 91 234 5678</a></p>
    </div>
</main>

<!-- Footer -->
<footer class="bg-primary text-white text-center py-4 mt-5">
    <div class="mb-2">
        <a href="#top"><img src="img/arrow_up.png" width="40" alt="Back to Top" title="Scroll Back to Top"></a>
    </div>
    <p class="mb-1">&copy; 2025 Dire Dawa University Dormitory Management System. All rights reserved.</p>
    <div>
        <a href="index.php" class="text-white mx-2">Home</a> |
        <a href="about.php" class="text-white mx-2">About Us</a> |
        <a href="contact.php" class="text-white mx-2">Contact Us</a>
    </div>
</footer>

</body>
</html>
