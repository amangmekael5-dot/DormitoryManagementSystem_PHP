
<?php
include("connection.php");
session_start();

if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('You Are Not Logged In !! Please Login to access this page'); window.location = 'login.php';</script>";
    exit();
}

$user_id = $_SESSION['user_id'];
$sql = "SELECT FNAME, mNAME FROM users WHERE user_id = ?";
if ($stmt = $conn->prepare($sql)) {
    $stmt->bind_param("s", $user_id);
    $stmt->execute();
    $stmt->bind_result($FirstName, $middleName);
    $stmt->fetch();
    $stmt->close();
}
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
    <div class="col-md-9">
      <h5>Select category:</h5>
      <select class="form-select mb-4" id="cboOptions" onchange="showDiv('div', this)">
        <option value="1">...</option>
        <option value="2">Registered Rooms</option>
        <option value="4">General Assignation</option>
        <option value="5">Assigned Students</option>
      </select>

      <div id="div1" style="display:none;"></div>
      <div id="div2" style="display:none;">
        <h4 class="text-center">Rooms:</h4>
        <div class="text-end mb-3">
          <button class="btn btn-success" onclick="window.print();">Print</button>
        </div>
        <?php
        include("connection.php");
        $sel = mysqli_query($conn, "SELECT * FROM room");
        echo '<p>There are <span class="text-danger">' . mysqli_num_rows($sel) . '</span> rooms registered.</p>';
        echo '<table class="table table-bordered" id="vtable">
                <thead class="table-primary">
                  <tr>
                    <th>Block No.</th>
                    <th>Room No.</th>
                    <th>Capacity</th>
                  </tr>
                </thead><tbody>';
        while ($row = mysqli_fetch_array($sel)) {
          echo "<tr>
                  <td>{$row['block_no']}</td>
                  <td>{$row['room_no']}</td>
                  <td>{$row['nobed']}</td>
                </tr>";
        }
        echo '</tbody></table>';
        ?>
      </div>
      <div id="div4" style="display:none;">
        <h4 class="text-center">General Assignation</h4>
        <div class="text-end mb-3">
          <button class="btn btn-success" onclick="window.print();">Print</button>
        </div>
        <?php
        include("connection.php");
        $sel = mysqli_query($conn, "SELECT * FROM block");
        echo '<table class="table table-bordered" id="vtable">
                <thead class="table-primary">
                  <tr>
                    <th>Block No.</th>
                    <th>Sex</th>
                    <th>Faculty</th>
                  </tr>
                </thead><tbody>';
        while ($row = mysqli_fetch_array($sel)) {
          echo "<tr>
                  <td>{$row['block_no']}</td>
                  <td>{$row['sexcategory']}</td>
                  <td>{$row['faculty']}</td>
                </tr>";
        }
        echo '</tbody></table>';
        ?>
      </div>
      <div id="div5" style="display:none;">
        <h4 class="text-center">Assigned Students</h4>
        <div class="text-end mb-3">
          <button class="btn btn-success" onclick="window.print();">Print</button>
        </div>
        <?php
include("connection.php");
$sel = mysqli_query($conn, "SELECT * FROM students");

echo '<table class="table table-bordered table-striped" id="vtable">
        <thead class="table-primary">
          <tr>
            <th>Fname</th>
             <th>Mname</th>
              <th>Lname</th>
            <th>ID NO</th>
            <th>Sex</th>
            <th>Batch</th>
            <th>Faculty</th>
            <th>Block No</th>
            <th>Room No</th>
          </tr>
        </thead><tbody>';

while ($row = mysqli_fetch_array($sel, MYSQLI_ASSOC)) {
  $fname = $row['fname' ] ?? 'N/A';
  $mname = $row['mname' ] ?? 'N/A';
  $lname = $row['lname' ] ?? 'N/A';
  $idno = $row['stud_id'] ?? 'N/A';
  $sex = $row['sex'] ?? 'N/A';
  $batch = $row['batch'] ?? 'N/A';
  $faculty = $row['faculty'] ?? 'N/A';
  $block_no = $row['block_no'] ?? 'N/A';
  $room_no = $row['room_no'] ?? 'N/A';

  echo "<tr>
  <td>$fname</td>
  <td>$mname</td>
  <td>$lname</td>
  <td>$idno</td>
  <td>$sex</td>
  <td>$batch</td>
  <td>$faculty</td>
  <td>$block_no</td>
  <td>$room_no</td>
</tr>";

}

echo '</tbody></table>';
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

<script>
function showDiv(prefix, chooser) {
  document.querySelectorAll('[id^="' + prefix + '"]').forEach(el => el.style.display = 'none');
  let selected = chooser.value;
  if (["1", "2", "4", "5"].includes(selected)) {
    document.getElementById(prefix + selected).style.display = 'block';
  }
}
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
