<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$mysqli = new mysqli("localhost", "root", "", "dbudms");
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

$user_id = $_SESSION['user_id'];

// Fetch user info
$stmt = $mysqli->prepare("SELECT * FROM users WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_array(MYSQLI_ASSOC);
$FirstName = isset($row['FNAME']) ? $row['FNAME'] : 'N/A';
$middleName = isset($row['mNAME']) ? $row['mNAME'] : 'N/A';
$stmt->close();

// Fetch block info
$stmt1 = $mysqli->prepare("SELECT * FROM block WHERE user_id = ?");
$stmt1->bind_param("i", $user_id);
$stmt1->execute();
$result1 = $stmt1->get_result();
$row1 = $result1->fetch_array(MYSQLI_ASSOC);
if (!$row1) {
    echo "No block data found! Please assign a block.";
    exit();
}
$block = $row1['block_no'];
$sex = $row1['sexcategory'];
$faculty = $row1['faculty'];
$norooms = $row1['norooms'];
$stmt1->close();

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    $rno = isset($_POST['room']) ? intval($_POST['room']) : 0;
    $block_no = $_POST['block'];
    $nobed = intval($_POST['nobed']);
    $success = true;
    $error_msgs = [];

    for ($i = 1; $i <= $rno; $i++) {
        $room_no = str_pad($i, 3, '0', STR_PAD_LEFT);

        $check_sql = "SELECT COUNT(*) FROM room WHERE block_no = ? AND room_no = ?";
        $check_stmt = mysqli_prepare($mysqli, $check_sql);
        mysqli_stmt_bind_param($check_stmt, "ss", $block_no, $room_no);
        mysqli_stmt_execute($check_stmt);
        mysqli_stmt_bind_result($check_stmt, $room_count);
        mysqli_stmt_fetch($check_stmt);
        mysqli_stmt_close($check_stmt);

        if ($room_count > 0) {
            $error_msgs[] = "Room $room_no already exists in block $block_no.";
            continue;
        }

        $insert_sql = "INSERT INTO room (block_no, room_no, nobed) VALUES (?, ?, ?)";
        $stmt = mysqli_prepare($mysqli, $insert_sql);
        mysqli_stmt_bind_param($stmt, "ssi", $block_no, $room_no, $nobed);
        if (!mysqli_stmt_execute($stmt)) {
            $success = false;
            $error_msgs[] = "Error inserting room $room_no: " . mysqli_error($mysqli);
            break;
        }
        mysqli_stmt_close($stmt);
    }

    $result_status = $success ? "success" : "error";
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

        <!-- Main Content -->
        <div class="col-md-9">
            <div class="card shadow">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <strong>Room Registration</strong>
                    <a href="proctor.php" class="btn btn-light btn-sm">Close</a>
                </div>
                <div class="card-body">
                    <?php
                    if (isset($result_status)) {
                        if ($result_status === "success") {
                            echo '<div class="alert alert-success">Rooms successfully registered!</div>';
                        } else {
                            foreach ($error_msgs as $msg) {
                                echo '<div class="alert alert-danger">' . htmlspecialchars($msg) . '</div>';
                            }
                        }
                    }
                    ?>
                    <form method="POST" action="registerrooms.php">
                        <div class="form-group mb-3">
                            <label for="block">Block No. <span class="text-danger">*</span></label>
                            <input type="text" name="block" id="block" class="form-control" value="<?php echo $block; ?>" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="room">Total No. of Rooms <span class="text-danger">*</span></label>
                            <input type="text" name="room" id="room" class="form-control" value="<?php echo $norooms; ?>" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="nobed">No. of Beds per Dorm <span class="text-danger">*</span></label>
                            <input type="text" name="nobed" id="nobed" class="form-control" required>
                        </div>
                        <button type="submit" name="submit" class="btn btn-primary w-100 mt-3">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


<!-- Footer -->
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
<!-- Bootstrap JS (matching Bootstrap 5.3.3) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<?php mysqli_close($mysqli); ?>
</body>
</html>
