<?php
    include("connection.php");  
    session_start();

    if (isset($_SESSION['user_id'])) {
        $mail = $_SESSION['user_id'];
    } else {
        ?>
        <script>
            alert('You Are Not Logged In !! Please Login to access this page');
            window.location = 'login.php';
        </script>
        <?php
        exit(); // Ensure no further code is executed after the redirect
    }

    // Using mysqli to get user data from the database
    $user_id = $_SESSION['user_id'];
    
    // Prepare and execute a query
    $sql = "SELECT * FROM users WHERE user_id = ?";
    
    // Prepare the statement
    if ($stmt = $conn->prepare($sql)) {
        // Bind the user_id parameter
        $stmt->bind_param("s", $user_id);
        
        // Execute the statement
        $stmt->execute();
        
        // Bind result variables
        $stmt->bind_result($FNAME, $mNAME, $lname, $user_id, $sex, $level, $phone_no, $username, $password, $confirmpassword, $status);
        
        // Fetch the result
        if ($stmt->fetch()) {
            // Store the data into variables
            $FirstName = $FNAME;
            $middleName = $mNAME;
        } else {
            echo "Error: User not found.";
        }

        // Close the statement
        $stmt->close();
    } else {
        echo "Error preparing statement: " . $conn->error;
    }

    // Close the connection
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>DDU-DMS</title>
  <link rel="icon" type="image/png" href="img/dbuicon.png" />
  <link href="logstyl.css" rel="stylesheet" />
  <link href="a.css" rel="stylesheet" />
  <script src="aa.js"></script>

  <!-- Bootstrap 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body class="bg-light">

<div class="container-fluid">
  <!-- Header -->
  <div class="row py-3 bg-primary text-white align-items-center">
  <div class="col-md-8 d-flex align-items-center">
    <img src="img/people.png" width="40" height="30" alt="User Icon" class="me-2">
    <?php echo $FirstName . " " . $middleName; ?>
  </div>
  <div class="col-md-4 d-flex justify-content-end pe-4">
    <a href="logout.php" id="log" class="btn btn-danger">Logout</a>
</div>


</div>


  </div>

  <div class="row">
    <!-- Logo and Title -->
    <div class="col-12 text-center py-4">
      <a href="pro_manager.php"><img src="img/logo.png" width="150px" height="120px" alt="Logo"></a>
      <img src="img/promanager.png" align="center" width="490px" height="120px" alt="Pro Manager">
    </div>
  </div>

  <!-- Navigation Menu -->
  <div class="row">
    <div class="col-12">
      <div class="nav">
        <ul class="nav nav-pills">
          <li class="nav-item"><a class="nav-link" href="pro_manager.php">Home</a></li>
          <li class="nav-item"><a class="nav-link" href="rblock.php">Register Block</a></li>
         
        </ul>
      </div>
    </div>
  </div>

  <!-- Content Row -->
  <div class="row">
    <!-- Sidebar -->
    <div class="col-md-3">
      <div class="card mt-4">
        <div class="card-header bg-primary text-white">DBU-DMS</div>
        <div class="card-body">
          <img src="slideshow/images/DSC01751.JPG" class="img-fluid" alt="Slideshow Image">
        </div>
      </div>

      <div class="card mt-4">
        <div class="card-header bg-primary text-white">Manage Record</div>
        <div class="card-body">
          <ul class="list-group">
            <li class="list-group-item"><a href="viewst.php">View Student info</a></li>
            <li class="list-group-item"><a href="viewroom.php">View Rooms</a></li>
            
          </ul>
        </div>
      </div>

      <div class="card mt-4">
        <div class="card-header bg-primary text-white">Related Links</div>
        <div class="card-body">
          <ul class="list-group">
            <li class="list-group-item"><a href="pmchangepassword.php">Change Password</a></li>
            <li class="list-group-item"><a href="viewcoms.php">View Comment</a></li>
            <li class="list-group-item"><a href="report.php">Generate Report</a></li>
          </ul>
        </div>
      </div>
    </div>

        <!-- Main Content -->
        <div class="col-md-9">
            <h4 class="my-4">Block Registration</h4>
            <div class="card p-4" style="border-radius: 25px;">
                <form id="form1" name="login" method="POST" action="rblock.php" onsubmit="return validateForm()">
                    <div class="form-group">
                        <label for="bno"><font color="red">*</font> Block No:</label>
                        <input type="text" class="form-control" name="bno" id="bno" required x-moz-errormessage="Enter Block No">
                    </div>

                    <div class="form-group">
                        <label for="nor"><font color="red">*</font> No Of Rooms:</label>
                        <input type="text" class="form-control" name="nor" id="nor" required x-moz-errormessage="Enter number of rooms">
                    </div>

                    <div class="form-group">
                        <label for="fac"><font color="red">*</font> Faculty:</label>
                        <input type="text" class="form-control" name="fac" id="fac" required x-moz-errormessage="Enter Faculty">
                    </div>

                    <div class="form-group">
                        <label for="sexc"><font color="red">*</font> Sex Category</label><br>
                        <input type="radio" name="sexc" value="male" required /> Male
                        <input type="radio" name="sexc" value="female" required /> Female
                    </div>

                    <h5 class="my-4">Proctor Information</h5>

                    <div class="form-group">
                        <label for="user_id"><font color="red">*</font> Proctor ID:</label>
                        <input type="text" class="form-control" name="user_id" id="user_id" required x-moz-errormessage="Enter Proctor ID">
                    </div>

                    <div class="form-group">
                        <label for="phone"><font color="red">*</font> Phone No:</label>
                        <input type="text" class="form-control" name="phone" id="phone" onKeyPress="return isNumberKey(event)" required x-moz-errormessage="Enter Phone">
                    </div>

                    <div class="form-group text-center">
                        <button type="submit" name="submit" class="btn btn-success">Submit</button>
                        <button type="reset" class="btn btn-danger">Cancel</button>
                    </div>

                    <?php
                    if (isset($_POST['submit'])) {
                        // Using mysqli prepared statements to prevent SQL injection
                        $sql = "INSERT INTO block (block_no, norooms, faculty, sexcategory, user_id, phone) 
                                VALUES (?, ?, ?, ?, ?, ?)";
                        
                        if ($stmt = $conn->prepare($sql)) {
                            // Bind the POST data to the prepared statement
                            $stmt->bind_param("ssssss", $_POST['bno'], $_POST['nor'], $_POST['fac'], $_POST['sexc'], $_POST['user_id'], $_POST['phone']);
                            
                            // Execute the statement
                            if ($stmt->execute()) {
                                echo '<p class="success">Success</p>';
                                echo '<meta content="5;rblock.php" http-equiv="refresh" />';
                            } else {
                                echo '<p class="wrong">Proctor is not registered</p>';
                                echo '<meta content="5;rblock.php" http-equiv="refresh" />';
                            }
                            
                            // Close the statement
                            $stmt->close();
                        } else {
                            echo "Error preparing statement: " . $conn->error;
                        }
                    }

                    // Close the connection
                    $conn->close();
                    ?>
                </form>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-dark text-white text-center py-4">
        <p>&copy; 2014 Debre Berhan University ODMS. All rights reserved.</p>
        <div>
            <a href="pro_manager.php" class="text-white">Home</a> | 
            <a href="rblock.php" class="text-white">Register Blocks</a>
        </div>
    </footer>
</div>

<!-- Bootstrap JS, Popper.js, and jQuery -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
