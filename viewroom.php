<?php
include("connection.php");  
session_start();

// Check if user is logged in
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    // Redirect if not logged in
    echo "<script>
        alert('You Are Not Logged In !! Please Login to access this page');
        window.location = 'login.php';
    </script>";
    exit();
}

// Fetch user details from the database
$stmt = $conn->prepare("SELECT FNAME, mNAME FROM users WHERE user_id = ?");
$stmt->bind_param("s", $user_id); // Bind the user_id as a string
$stmt->execute();
$stmt->bind_result($FirstName, $middleName);
$stmt->fetch();
$stmt->close();
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
<td><img src="img/Picture2.png" width="10px">&nbsp;<a href="viewst.php">View student info</a></td>
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
<font face="Arial" size="2px">View Room page......</font>
   <br><br><br>
<table align="center" style="border-radius:15px;border:1px solid #336699;box-shadow:1px 1px 10px black;">
			<tr>
				<td>
						<form action="viewroom.php" onsubmit='return formValidator()' method='POST'>
						<table>
							<tr>
								<td class="search">Enter Block No:</td>
								<td><input type="text" name="searchs" size="40px" placeholder="Provide Here..." required x-moz-errormessage="Please enter the block no"/></td>
								<td><input type="submit" value="Search" name="search" style="cursor:pointer;" class="button_example"/></td>
							</tr>
						</table>
					</form>
					<?php
if (isset($_POST['search'])) {
    $block = $_POST['searchs'];
    // Prepare the SQL query with a parameterized statement
    $sql = "SELECT * FROM room WHERE block_no = ?";
    
    // Use prepared statements for security
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("s", $block); // "s" means the parameter is a string
        $stmt->execute();
        $result = $stmt->get_result();
        
        $count = $result->num_rows;
        if ($count < 1) {
            echo '<p class="wrong">The room is not registered with this block no</p>';
            echo '<meta content="5;viewroom.php" http-equiv="refresh" />';
        } else {
            echo "<center>";
            echo "<br><br><br><br>";
            echo "<table style='width:450px;height:50px;border-radius:10px;' border='1' align='center'>
                <tr>
                    <th bgcolor='#336699'><font color='white'>Block No</font></th>
                    <th bgcolor='#336699'><font color='white'>Room No</font></th>
                    <th bgcolor='#336699'><font color='white'>Capacity</font></th>
                </tr>";
            
            // Fetch the results and display them
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['block_no'] . "</td>";
                echo "<td>" . $row['room_no'] . "</td>";
                echo "<td>" . $row['nobed'] . "</td>";
                echo "</tr>";
            }
            
            echo "</table>";
            echo "</center>";
        }
        $stmt->close(); // Close the prepared statement
    } else {
        echo "<p class='wrong'>Error preparing query.</p>";
    }
}

// Close the database connection
mysqli_close($conn);
?>


</td></tr></table> 





   


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
		<a href="pro_manager.php">Home</a>&nbsp;|&nbsp;<a href="rblock.php">Register Blocks</a>&nbsp;</font>
		</div>

      </footer>
</div>

<!--End of Footer-->
</body>
</html>
