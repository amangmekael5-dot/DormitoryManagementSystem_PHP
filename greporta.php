<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
if (!isset($_SESSION['user_id'])) {
    echo "<script>
            alert('You Are Not Logged In !! Please Login to access this page');
            window.location='login.php';
          </script>";
    exit();
}
$user_id = $_SESSION['user_id'];
$conn = new mysqli("localhost", "root", "", "dbudms");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$stmt = $conn->prepare("SELECT * FROM users WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $FirstName = $row['FNAME'];
    $middleName = $row['mNAME'];
} else {
    echo "<script>alert('User not found.'); window.location='login.php';</script>";
    exit();
}
$stmt1 = $conn->prepare("SELECT * FROM block WHERE user_id = ?");
$stmt1->bind_param("i", $user_id);
$stmt1->execute();
$result1 = $stmt1->get_result();
if ($result1->num_rows > 0) {
    $row1 = $result1->fetch_assoc();
    $block = $row1['block_no'];
    $norooms = $row1['norooms'];
} else {
    $block = null;
    echo "<script>alert('Block information not found.');</script>";
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
        body {
            background-color: #f4f4f4;
        }
        .navbar {
            background-color: #004080;
        }
        .navbar-nav a {
            color: white;
        }
        .navbar-nav a:hover {
            color: #ffcc00;
        }
        footer {
            background-color: #003366;
            color: white;
            padding: 15px;
            text-align: center;
            margin-top: 40px;
        }
        footer a {
            color: #aaddff;
            margin: 0 8px;
            text-decoration: none;
        }
        footer a:hover {
            text-decoration: underline;
        }
        #print_content {
            background-color: #fff;
            padding: 20px;
            border-radius: 6px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .table th, .table td {
            text-align: center;
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


            <div class="col-lg-9 col-md-8 col-sm-12">
                <div id="print_content">
                    <h3>Select Report Type</h3>
                    <select name="portal" id="cboOptions" class="form-select" onChange="showDiv('div', this)">
                        <option value="1">-- Select Report --</option>
                        <option value="2">Registered Rooms</option>
                        <option value="4">General Assignation</option>
                    </select>
                    <br><br>
                    <div id="div1" style="display:none;"></div>
                    <div id="div2" style="display:none;">
                        <?php if ($block): ?>
                            <h3>Rooms in Block <?= htmlspecialchars($block); ?></h3>
                            <p><button class="btn btn-primary" onclick="Clickheretoprint();">Print</button></p>
                            <?php
                            $roomQuery = $conn->prepare("SELECT * FROM room WHERE block_no = ?");
                            $roomQuery->bind_param("s", $block);
                            $roomQuery->execute();
                            $result = $roomQuery->get_result();
                            echo "<p><strong>There are </strong><span class='text-danger'>{$result->num_rows}</span><strong> rooms registered in block {$block}</strong></p>";
                            echo "<table class='table table-bordered'><thead><tr><th>Block No.</th><th>Room No.</th><th>Capacity</th></tr></thead><tbody>";
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr><td>{$row['block_no']}</td><td>{$row['room_no']}</td><td>{$row['nobed']}</td></tr>";
                            }
                            echo "</tbody></table>";
                            ?>
                        <?php else: ?>
                            <p class="text-danger">Block information not available.</p>
                        <?php endif; ?>
                    </div>
                    <div id="div4" style="display:none;">
                        <h2>General Assignation</h2>
                        <p><button class="btn btn-primary" onclick="Clickheretoprint();">Print</button></p>
                        <?php
                        $assignQuery = $conn->query("SELECT * FROM block");
                        echo "<table class='table table-bordered'><thead><tr><th>Block No.</th><th>Sex</th><th>Faculty</th></tr></thead><tbody>";
                        while ($row = $assignQuery->fetch_assoc()) {
                            echo "<tr><td>{$row['block_no']}</td><td>{$row['sexcategory']}</td><td>{$row['faculty']}</td></tr>";
                        }
                        echo "</tbody></table>";
                        ?>
                    </div>
                </div>
            </div>
        </div>
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


    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function Clickheretoprint() {
            var disp_setting = "toolbar=yes,location=no,directories=yes,menubar=yes,scrollbars=yes,width=900, height=400, left=100, top=25";
            var content_value = document.getElementById("print_content").innerHTML;
            var docprint = window.open("", "", disp_setting);
            docprint.document.open();
            docprint.document.write('<html><head><title>Lists</title></head><body onLoad="setTimeout(function(){window.print();}, 500)" style="font-size:16px; font-family:arial;">');
            docprint.document.write(content_value);
            docprint.document.write('</body></html>');
            docprint.document.close();
            docprint.focus();
        }

        function showDiv(prefix, chooser) {
            for (var i = 0; i < chooser.options.length; i++) {
                var div = document.getElementById(prefix + chooser.options[i].value);
                if (div) div.style.display = 'none';
            }
            var selectedOption = chooser.options[chooser.selectedIndex].value;
            if (selectedOption) {
                var selectedDiv = document.getElementById(prefix + selectedOption);
                if (selectedDiv) selectedDiv.style.display = 'block';
            }
        }
    </script>
</body>
</html>
