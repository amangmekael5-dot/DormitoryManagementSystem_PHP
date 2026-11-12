<?php
$conn = mysqli_connect("localhost", "root", "", "dbudms"); // Change "dbudms" to your database name

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
