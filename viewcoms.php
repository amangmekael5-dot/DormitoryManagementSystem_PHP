<?php
include("connection.php");  
session_start();

if (isset($_SESSION['user_id'])) {
    $mail = $_SESSION['user_id'];
} else {
    echo "<script>
        alert('You Are Not Logged In !! Please Login to access this page');
        window.location = 'login.php';
    </script>";
    exit();
}

$user_id = $_SESSION['user_id'];

// Use specific column names instead of SELECT *
$sql = "SELECT FNAME, mNAME FROM users WHERE user_id = ?";

if ($stmt = $conn->prepare($sql)) {
    $stmt->bind_param("s", $user_id); // "s" means the parameter is a string
    $stmt->execute();
    $stmt->bind_result($FirstName, $middleName); // Bind the result to variables

    if ($stmt->fetch()) {
        // Successfully fetched data
        // $FirstName and $middleName are already assigned from the query
    } else {
        echo "User not found!";
    }

    $stmt->close();
} else {
    echo "Error in preparing statement: " . $conn->error;
}

// Don't forget to close the connection
$conn->close();
?>


<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<title>DBU-DMS</title>
<link rel="icon" type="image/png" href="img/dbuicon.png"/>
<link href="logstyle.css" rel="stylesheet" type="text/css" media="screen" />
<link href="aa.css" rel="stylesheet" type="text/css" media="screen" />
<script src="aa.js" type="text/javascript"></script>
</head>
<body>
<table  border="0" align="center" width="750px">
<!--Header-->
<tr>
<td width="600px"></td>
<td><?php 
echo '<img src="img/people.png" width="40px" height="30px">&nbsp;'.'<font face="times new roman" color="white" size="3">'.$FirstName."&nbsp;".$middleName." ".'</font>';?></td>
<td id="logoutlink" align="center"><a href="logout.php" id="log">Logout</a></td>
</tr>
<tr>
<td width="750px" colspan="3" height="100px">
<p><a href="pro_manager.php"><img src="img/logo.png" align="left" width="150px" height="120px"></a>
<img src="img/promanager.png" align="center" width="490px" height="120px"></p>
</td>
</tr>
<!--End Of Header-->
<!--Main menus-->
<tr>
<td colspan="3">
<div id="sse2">
        <div id="sses2"  >
         <ul>
         <li><a href="pro_manager.php">Home</a></li>
         <li><a href="rblock.php">Register Block</a></li>
         </ul>
         </div>
    </div>

</td>
</tr>
<!--End of main menus-->
<!--Slide shows-->
<!--End of Slide shows-->
<table align="center" id="insides" width="850px">
<tr>
<!--Sub menus-->
<td width="25%" height="400px" valign="top" id="insides">
<table>
<tr>
<th align="center" width="250px" height="25px" bgcolor="#336699"><font face="arial" color="white" size="2">DBU-DMS</font></th>
</tr>
<tr>
<td><br><br><center><img src="slideshow/images/DSC01751.JPG" width="150px" height="100px"></center></td>
</tr>
</table>
<table>
<tr>
<th align="center" width="450px" height="25px" bgcolor="#336699"><font face="arial" color="white" size="2">Manage Record</font></th>
</tr>
<tr>
<td><img src="img/Picture2.png" width="10px">&nbsp;<a href="#">Viewstudent info</a></td>
</tr>
<tr>
<td><img src="img/Picture2.png" width="10px">&nbsp;<a href="viewroom.php">View Rooms</a></td>
</tr>
</table>
<br>
<br>
<table border="0">
<tr>
<th align="center" width="300px" bgcolor="#336699" height="25px"><font face="arial" color="white" size="2">Related Links</font></th>
</tr>
<tr>
<td><img src="img/Picture2.png" width="10px">&nbsp;<a href="pmchangepassword.php">Change Password</a></td>
</tr>
<tr>
<td><img src="img/Picture2.png" width="10px">&nbsp;<a href="viewcoms.php">View Comment</a></td>
</tr>
<tr>
<td><img src="img/Picture2.png" width="10px">&nbsp;<a href="report.php">Generate Report</a></td>
</tr>
</table>
</td>
<!--End Of Sub menus-->
<!--Body section-->
<td valign="top">
<br>
<br>
<font face="Arial" size="2px">View Comment......</font>
    
<?php
// Assuming $conn is the MySQLi connection object from "connection.php"
include("connection.php");

// Query to select all comments
$sql = "SELECT * FROM comment";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo '<table style="width:500px;border:1px solid #336699;border-radius:10px;" id="vtable">';
    echo '<tr>';
    echo '<th bgcolor="#336699"><font color="white" size="2">Names</th>';
    echo '<th bgcolor="#336699"><font color="white" size="2">Message</th>';
    echo '<th bgcolor="#336699"><font color="white" size="2">Delete</th>';
    echo '</tr>';

    $intt = $result->num_rows; // Get the total number of rows
    echo "<br><br>";
    echo "<font face='times new roman' size='2px' color='red'>";
    echo 'There are &nbsp;' . $intt . '&nbsp; new messages.';
    echo "</font>";
    echo "<br><br>";

    // Loop through the results and display them in the table
    while ($row = $result->fetch_assoc()) {
        $ctrl = $row['fname'];
        echo "<tr>";
        echo "<td><font size='2'>" . $row['fname'] . "</td>";
        echo "<td><font size='2'>" . $row['message'] . "</td>";
        echo "<td align='center' width='1'>
            <a href='deletecomm.php?key=" . $ctrl . "'>
                <img width='15px' height='15px' src='img/actions-delete.png' title='Delete' onclick='isdelete();'>
            </a>
        </td>";
        echo "</tr>";
    }

    echo "</table>";
} else {
    echo "No comments found.";
}

// Close the connection
$conn->close();
?>
   	
</td>
</tr>
</table>
<!--End Body of section-->
</table>
<!--Footer-->

<div id="sample">
      <footer>
	  <br>
	  <div align="right">
<a href="#top"><img src="img/arrow_up.png" width="40px" title="Scroll Back to Top"></a>
</div>
        <p align="center"><font face="Times New Roman" color="white" size="2">Copyright &copy 2014 Debre Berhan University  ODMS. All rights reserved.</font></p>
		<br><br>
		<div class="pull-right_foot" align="center">
		&nbsp;&nbsp;&nbsp;<font face="Times New Roman" color="white" size="3">
		<a href="pro_manager.php">Home</a>&nbsp;|&nbsp;<a href="registerrooms.php">Register Rooms</a>&nbsp;</font>
		</div>

      </footer>
</div>

<!--End of Footer-->
</body>
</html>
