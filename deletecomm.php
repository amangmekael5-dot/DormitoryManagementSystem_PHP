<?php
session_start();
include 'connection.php';

// Optional: add a real login check if needed
// For now, we'll skip $log check since it's undefined

// Check if the key is set and is a valid number
if (isset($_GET['key']) && is_numeric($_GET['key'])) {
    $ctrl = intval($_GET['key']);

    // Prepare and execute the delete statement
    $stmt = $conn->prepare("DELETE FROM comment WHERE id = ?");
    $stmt->bind_param("i", $ctrl);

    if ($stmt->execute()) {
        // Redirect after successful delete
        echo "<script>location.href = 'viewcom.php';</script>";
        exit();
    } else {
        echo "Error deleting comment: " . $conn->error;
    }

    $stmt->close();
} else {
    echo "Invalid request.";
}

$conn->close();
?>
