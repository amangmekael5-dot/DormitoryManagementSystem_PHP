<?php
// Search form and result handling
if (isset($_POST['search'])) {
    $search_term = $_POST['search_term'];  // Get search term from user input
    $sql = "SELECT * FROM comment WHERE fname LIKE ? OR email LIKE ? OR message LIKE ?";
    if ($stmt = $conn->prepare($sql)) {
        $search_term = "%" . $search_term . "%";  // Adding wildcards for LIKE query
        $stmt->bind_param("sss", $search_term, $search_term, $search_term); // "sss" means all parameters are strings
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<div>";
                echo "<strong>Full Name:</strong> " . $row['fname'] . "<br>";
                echo "<strong>Email:</strong> " . $row['email'] . "<br>";
                echo "<strong>Message:</strong> " . $row['message'] . "<br><br>";
                echo "</div>";
            }
        } else {
            echo "No records found!";
        }
        $stmt->close();
    } else {
        die('Error: ' . mysqli_error($conn));  // Error handling
    }
}
?>

<form method="POST">
    <input type="text" name="search_term" placeholder="Search comments...">
    <input type="submit" name="search" value="Search">
</form>
