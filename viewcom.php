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
        exit();  // Make sure to stop further execution if the user is not logged in
    }

    // Get the user_id from the session
    $user_id = $_SESSION['user_id'];

    // Fetch first and middle name from the users table
    $sql_user = "SELECT FNAME, mNAME FROM users WHERE user_id = ?";
    if ($stmt_user = $conn->prepare($sql_user)) {
        $stmt_user->bind_param("s", $user_id);
        $stmt_user->execute();
        $stmt_user->bind_result($FirstName, $middleName);
        
        if ($stmt_user->fetch()) {
            // Successfully fetched first and middle names
        } else {
            echo "User not found!";
        }
        
        $stmt_user->close();
    } else {
        echo "Error preparing user query: " . $conn->error;
    }

    // Prepare the SQL query to get the comments for the logged-in user
    $sql = "SELECT id, fname, message FROM comment WHERE email = ?";
    
    if ($stmt = $conn->prepare($sql)) {
        // Bind parameters (s means string)
        $stmt->bind_param("s", $user_id);

        // Execute the query
        $stmt->execute();

        // Store the result
        $stmt->store_result();

        // Bind the result to variables (id, fname, message)
        $stmt->bind_result($comment_id, $fname, $message);

        // Fetch the result and display the data
        while ($stmt->fetch()) {
            echo "Comment ID: " . $comment_id . "<br>";
            echo "Name: " . $fname . "<br>";
            echo "Message: " . $message . "<br><br>";
        }

        // Close the statement
        $stmt->close();
    } else {
        echo "Error preparing statement: " . $conn->error;
    }

    // Close the connection
    $conn->close();
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<title>Dire Dawa University Online Dormitory management system</title>
<link rel="icon" type="image/png" href="img/dbuicon.png"/>
<link href="adminstyle.css" rel="stylesheet" type="text/css" media="screen" />
<link href="aa.css" rel="stylesheet" type="text/css" media="screen" />
<script src="aa.js" type="text/javascript"></script>
<script>
  function isdelete() {
   var d = confirm('Are you sure you want to Delete !!');
   if(!d) {
        alert(window.location='viewcom.php');
   } else {
        return false;
   }
  }
</script>
</head>
<body>
<table  border="0" align="center" width="750px">
<!--Header-->
<tr>
<td width="600px"></td>
<td><?php 
    echo '<img src="img/people.png" width="40px" height="30px">&nbsp;'.'<font face="times new roman" color="white" size="3">'.$FirstName."&nbsp;".$middleName." ".'</font>';
?></td>
<td id="logoutlink" align="center"><a href="logout.php" id="log">Logout</a></td>
</tr>
<tr>
<td width="750px" colspan="3" height="100px">
<p><a href="admin.php"><img src="img/logo.png" align="left" width="150px" height="120px"></a>
<img src="img/admin.png" align="center" width="490px" height="120px"></p>
</td>
</tr>
<!--End Of Header-->
<!--Main menus-->
<tr>
<td colspan="3">
<div id="sse2">
        <div id="sses2"  >
         <ul>
         <li><a href="admin.php">Home</a></li>
         <li><a href="viewcom.php">View Comment</a></li>
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
<td width="25%" height="500px" valign="top" id="insides">
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
<td><img src="img/Picture2.png" width="10px">&nbsp;<a href="viewstudent.php">View Student</a></td>
</tr>
</table>
<br>
<br>
<table border="0">
<tr>
<th width="300px" bgcolor="#336699" height="25px"><font face="arial" color="white" size="2">Manage Account</font></th>
</tr>
<tr>
<td><img src="img/Picture2.png" width="10px">&nbsp;<a href="cua.php">Create User Account</a></td>
</tr>
<tr>
<td><img src="img/Picture2.png" width="10px">&nbsp;<a href="raccount.php">Edit User Account</a></td>
</tr>
</table>
<br>
<br>
</td>
<!--End Of Sub menus-->
<!--Body section-->                   
<td valign="top">
<br>
<br>
<font face="Arial" size="2px">Our Home page......</font>
<?php
    include("connection.php");  

    // Prepare the SQL query using mysqli to avoid SQL injection
    $sql = "SELECT * FROM comment";
    if ($result = $conn->query($sql)) {
        echo '<table style="width:500px;border:1px solid #336699;border-radius:10px;" id="vtable">';
        echo '<tr>';
        echo '<th bgcolor="#336699"><font color="white" size="2">Names</th><th bgcolor="#336699" ><font color="white" size="2">Message</th><th bgcolor="#336699"><font color="white" size="2">Delete</th></tr>';

        $rowcolor = 0;
        $intt = $result->num_rows; // Get the number of rows
        echo "<br><br>";
        echo "<font face='times new roman' size='2px' color='red'>";
        echo 'There are &nbsp;' . $intt . '&nbsp; new messages.';
        echo "</font>";
        echo "<br><br>";

        // Loop through the result set and display the comments
        while ($row = $result->fetch_assoc()) {
            $ctrl = $row['id']; // Get the comment ID
            echo "<tr>";
            echo "<td><font size='2'>" . $row['fname'] . "</td>";
            echo "<td><font size='2'>" . $row['message'] . "</td>";        
            echo "<td align='center' width='1'><a href='deletecomm.php?key=" . $ctrl . "'><img width='15px' height='15px' src='img/actions-delete.png' title='Delete' onclick='isdelete();'></a></td>";
            echo "</tr>";
        }

        echo "</table>";

        // Free the result set
        $result->free();
    } else {
        echo "Error executing query: " . $conn->error;
    }

    // Close the connection
    $conn->close();
?>
   
</td>

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
		<a href="admin.php">Home</a>&nbsp;|&nbsp;<a href="viewcom.php">View Comment</a>&nbsp;|&nbsp;<a href="Postinfo.php">Post Info</a>&nbsp;</font>
		</div>

      </footer>
</div>

<!--End of Footer-->
</body>
</html>
