<?php
include("connection.php");
session_start();

if (isset($_SESSION['user_id'])) {
    $mail = $_SESSION['user_id'];
} else {
    echo "<script>
            alert('You Are Not Logged In !! Please Login to access this page');
            window.location='login.php';
          </script>";
    exit();
}

$user_id = $_SESSION['user_id'];

$sexcategory = '';
$batch = '';
$faculty = '';
$block = '';
$norooms = 0;
$bed = 0;

$stmt = $conn->prepare("SELECT * FROM users WHERE user_id = ?");
$stmt->bind_param("s", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

if ($row) {
    $FirstName = $row['FNAME'];
    $middleName = $row['mNAME'];

    $stmt1 = $conn->prepare("SELECT * FROM block WHERE user_id = ?");
    $stmt1->bind_param("s", $user_id);
    $stmt1->execute();
    $result1 = $stmt1->get_result();
    $row1 = $result1->fetch_assoc();

    if ($row1) {
        $block = $row1['block_no'];
        $norooms = $row1['norooms'];
        $sexcategory = $row1['sexcategory'];
        $batch = $row1['batch'];
        $faculty = $row1['faculty'];

        $stmt2 = $conn->prepare("SELECT * FROM room WHERE block_no = ?");
        $stmt2->bind_param("s", $block);
        $stmt2->execute();
        $result2 = $stmt2->get_result();
        $rooms = [];

        while ($row2 = $result2->fetch_assoc()) {
            $rooms[] = $row2;
        }

        if (count($rooms) > 0) {
            $bed = $rooms[0]['nobed'];
        } else {
            echo "No room details found for block: $block.";
        }
        $stmt2->close();
    } else {
        echo "No block details found for user ID: $user_id.";
    }
} else {
    echo "No user details found for user ID: $user_id.";
}

$stmt->close();
$stmt1->close();
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
    <img src="img/proctor.png" width="490" height="120" alt="Proctor">
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
    <a class="nav-link text-white" href="proctor.php">Home</a>
    <a class="nav-link text-white" href="registerrooms.php">Register Rooms</a>
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
                    <li class="list-group-item"><a href="assign.php">Assign Student</a></li>
                    <li class="list-group-item"><a href="viewstu.php">View Student Info</a></li>
                </ul>
            </div>

            <div class="card">
                <div class="card-header bg-primary text-white text-center">Related Links</div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item"><a href="changepassword.php">Change Password</a></li>
                    <li class="list-group-item"><a href="greporta.php">Generate Report</a></li>
                </ul>
            </div>
        </div>

        <!-- Main Content -->
        <div class="col-md-9">
            <h5>Room Assignation</h5>
            <div class="card shadow-sm">
                <div class="card-body">
                    <form method="POST" action="assign.php" class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label"><strong>First Name</strong></label>
                            <input type="text" name="fname" class="form-control" value="<?php echo htmlspecialchars($FirstName); ?>" readonly />
                        </div>
                        <div class="col-md-6">
                            <label class="form-label"><strong>Middle Name</strong></label>
                            <input type="text" name="mname" class="form-control" value="<?php echo htmlspecialchars($middleName); ?>" readonly />
                        </div>
                        <div class="col-md-6">
                            <label class="form-label"><strong>Block</strong></label>
                            <input type="text" name="block" class="form-control" value="<?php echo htmlspecialchars($block); ?>" readonly />
                        </div>
                        <div class="col-md-6">
                            <label class="form-label"><strong>Number of Rooms</strong></label>
                            <input type="text" name="norooms" class="form-control" value="<?php echo htmlspecialchars($norooms); ?>" readonly />
                        </div>
                        <div class="col-md-6">
                            <label class="form-label"><strong>Enter Student ID</strong></label>
                            <input type="text" name="stud_id" class="form-control" required />
                        </div>
                        <div class="col-md-6">
                            <label class="form-label"><strong>Sex Category</strong></label>
                            <input type="text" name="sex" class="form-control" value="<?php echo htmlspecialchars($sexcategory); ?>" readonly />
                        </div>
                        <div class="col-md-6">
                            <label class="form-label"><strong>Batch</strong></label>
                            <select name="batch" class="form-select">
                                <option value="3rdyear" <?php echo ($batch == "3rdyear") ? "selected" : ""; ?>>3rd Year</option>
                                <option value="4thyear" <?php echo ($batch == "4thyear") ? "selected" : ""; ?>>4th Year</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label"><strong>Faculty</strong></label>
                            <input type="text" name="faculty" class="form-control" value="<?php echo htmlspecialchars($faculty); ?>" readonly />
                        </div>
                        <div class="col-md-6">
                            <label class="form-label"><strong>Number of Beds</strong></label>
                            <input type="text" name="nobed" class="form-control" value="<?php echo htmlspecialchars($bed); ?>" readonly />
                        </div>
                        <div class="col-md-6">
                            <label class="form-label"><strong>Enter Room Number</strong></label>
                            <input type="text" name="room_no" class="form-control" required />
                        </div>
                        <div class="col-12 text-center">
                            <input type="submit" name="save" class="btn btn-success" value="Submit" />
                        </div>
                    </form>

                    <!-- PHP alert output -->
                    
                        <?php
                        if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['save'])) {
                            include "connection.php";
                        
                            $sex = $_POST['sex'];
                            $batch = $_POST['batch'];
                            $faculty = $_POST['faculty'];
                            $block = $_POST['block'];
                            $stud_id = trim($_POST['stud_id']);
                        
                            // 1. Check if student exists in registrar
                            $stmt = $conn->prepare("SELECT * FROM registrar WHERE stud_id = ? AND LOWER(sex) = LOWER(?) AND LOWER(batch) = LOWER(?) AND LOWER(faculty) = LOWER(?)");
                            $stmt->bind_param("ssss", $stud_id, $sex, $batch, $faculty);
                            $stmt->execute();
                            $result = $stmt->get_result();
                            $student = $result->fetch_assoc();
                            $stmt->close();
                        
                            if (!$student) {
                                echo "<p class='wrong'>Student ID not found or does not match the provided criteria.</p>";
                                return;
                            }
                        
                            // 2. Check if already assigned
                            $stmt = $conn->prepare("SELECT 1 FROM students WHERE stud_id = ?");
                            $stmt->bind_param("s", $stud_id);
                            $stmt->execute();
                            if ($stmt->get_result()->num_rows > 0) {
                                echo "<p class='wrong'>This student is already assigned.</p>";
                                $stmt->close();
                                return;
                            }
                            $stmt->close();
                        
                            // 3. Find available rooms
                            $stmt = $conn->prepare("SELECT room_no, nobed FROM room WHERE block_no = ?");
                            $stmt->bind_param("s", $block);
                            $stmt->execute();
                            $room_result = $stmt->get_result();
                        
                            $available_room = null;
                            while ($room = $room_result->fetch_assoc()) {
                                $room_no = $room['room_no'];
                                $total_beds = (int)$room['nobed'];
                        
                                // Count already assigned students
                                $count_stmt = $conn->prepare("SELECT COUNT(*) AS count FROM students WHERE block_no = ? AND room_no = ?");
                                $count_stmt->bind_param("ss", $block, $room_no);
                                $count_stmt->execute();
                                $count = $count_stmt->get_result()->fetch_assoc()['count'];
                                $count_stmt->close();
                        
                                if ($count < $total_beds) {
                                    $available_room = $room_no;
                                    break;
                                }
                            }
                            $stmt->close();
                        
                            if (!$available_room) {
                                echo "<p class='wrong'>No available beds in the block.</p>";
                                return;
                            }
                        
                            // 4. Assign student
                            $insert = $conn->prepare("INSERT INTO students (fname, mname, lname, stud_id, sex, batch, faculty, block_no, room_no) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
                            $insert->bind_param(
                                "sssssisss",
                                $student['fname'],
                                $student['mname'],
                                $student['lname'],
                                $student['stud_id'],
                                $student['sex'],
                                $student['batch'],
                                $student['faculty'],
                                $block,
                                $available_room
                            );
                            $insert->execute();
                            $insert->close();
                        echo "<div class='alert alert-success mt-4'>Student <b>{$stud_id}</b> has been assigned to <b>Room {$available_room}</b> in Block <b>{$block}</b>.</div>";
                    }
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

<!-- Bootstrap Bundle JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>


    

