<?php
session_start();
include("connection.php");

if (!isset($_SESSION['user_id'])) {
    echo "<script>
        alert('You Are Not Logged In !! Please Login to access this page');
        window.location.href = 'login.php';
    </script>";
    exit();
}

$user_id = $_SESSION['user_id'];

$stmt = $conn->prepare("SELECT FNAME, mNAME FROM users WHERE user_id = ?");
$stmt->bind_param("s", $user_id);
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
<table border="0" align="center" width="750px">
<tr>
<td width="600px"></td>
<td><?php 
echo '<img src="img/people.png" width="40px" height="30px">&nbsp;<font face="times new roman" color="white" size="3">'.$FirstName."&nbsp;".$middleName." ".'</font>';?></td>
<td id="logoutlink" align="center"><a href="logout.php" id="log">Logout</a></td>
</tr>
<tr>
<td width="750px" colspan="3" height="100px">
<p><a href="pro_manager.php"><img src="img/logo.png" align="left" width="150px" height="120px"></a>
<img src="img/promanager.png" align="center" width="490px" height="120px"></p>
</td>
</tr>
<tr>
<td colspan="3">
<div id="sse2">
    <div id="sses2">
        <ul>
        <li><a href="pro_manager.php">Home</a></li>
        <li><a href="rblock.php">Register Block</a></li>
        </ul>
    </div>
</div>
</td>
</tr>
<table align="center" id="insides" width="850px">
<tr>
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
<td><img src="img/Picture2.png" width="10px">&nbsp;<a href="viewst.php">View Student info</a></td>
</tr>
<tr>
<td><img src="img/Picture2.png" width="10px">&nbsp;<a href="viewroom.php">View Rooms</a></td>
</tr>
</table>
<br><br>
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
<td valign="top">
<br><br>
<font face="Arial" size="2px">Change Password.......</font>
<div style="width:420px; height:330px; margin:0 auto; position:relative; border:2px solid rgba(0,0,0,0); border-radius:25px; box-shadow:0 0 18px rgba(0,0,0,0.4); margin-top:20px; color:#000000;">

  <form method="POST" action="pmchangepassword.php">
    <div style="background-color:#336699;border-radius:5px;font-family:Arial; color:#000000; padding:5px; height:22px;"> 
        <div style="float:left;"><strong><font color="white" size="2px">Change Password</font></strong></div>
        <div style="float:right; margin-right:20px; background-color:#cccccc; width:25px;  text-align:center; border-radius:10px; height:12px;"><a href="pro_manager.php" title="Close"><img src="img/close_icon.gif"></a></div> 
    </div>

<?php
if (isset($_POST['changepassword'])) {
    $oldpass = $_POST['old_password'];
    $newpass = $_POST['new_password'];
    $confirmpass = $_POST['confirm_password'];

    if ($newpass !== $confirmpass) {
        echo '<p class="wrong">New Password and Confirm Password do not match!</p>';
        echo '<meta content="5;pmchangepassword.php" http-equiv="refresh" />';
    } else {
        $stmt = $conn->prepare("SELECT password FROM users WHERE user_id = ?");
        $stmt->bind_param("s", $user_id);
        $stmt->execute();
        $stmt->bind_result($db_password);
        if ($stmt->fetch()) {
            if ($oldpass === $db_password) { // Plain text comparison
                $stmt->close();
                $update = $conn->prepare("UPDATE users SET password = ? WHERE user_id = ?");
                $update->bind_param("ss", $newpass, $user_id);
                $update->execute();

                echo '<p class="success">Your password has been changed successfully!</p>';
                echo '<meta content="5;pmchangepassword.php" http-equiv="refresh" />';
            } else {
                echo '<p class="wrong">Wrong old password!</p>';
                echo '<meta content="5;pmchangepassword.php" http-equiv="refresh" />';
            }
        } else {
            echo '<p class="wrong">User not found!</p>';
            echo '<meta content="5;pmchangepassword.php" http-equiv="refresh" />';
        }
        $stmt->close();
    }
}
?>

    <table width="350" align="center" height="150px">
        <tr>
            <td class='para1_text' width="220px"><font color="red">*</font> Old Password:</td>
            <td><input type="password" name="old_password" required></td>
        </tr>
        <tr>
            <td class='para1_text'><font color="red">*</font> New Password:</td>
            <td><input type="password" name="new_password" required></td>
        </tr>
        <tr>
            <td class='para1_text'><font color="red">*</font> Confirm Password:</td>
            <td><input type="password" name="confirm_password" required></td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td><input type="submit" name="changepassword" value="Change Password" class="button_example"/></td>
        </tr>
    </table>
  </form>
</div>
</td>
</tr>
</table>
<div id="sample">
    <footer>
    <br>
    <div align="right">
        <a href="#top"><img src="img/arrow_up.png" width="40px" title="Scroll Back to Top"></a>
    </div>
    <p align="center"><font face="Times New Roman" color="white" size="2">Copyright &copy; 2014 Debre Berhan University ODMS. All rights reserved.</font></p>
    <br><br>
    <div class="pull-right_foot" align="center">
        &nbsp;&nbsp;&nbsp;<font face="Times New Roman" color="white" size="3">
        <a href="pro_manager.php">Home</a>&nbsp;|&nbsp;<a href="rblock.php">Register Blocks</a>&nbsp;</font>
    </div>
    </footer>
</div>
</body>
</html>
