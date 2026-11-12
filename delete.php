<?php
if (isset($_POST['delete'])) {
    $comment_id = $_POST['comment_id'];  // Get comment ID to delete

    $sql = "DELETE FROM comment WHERE comment_id = ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("i", $comment_id);  // "i" means integer
        if ($stmt->execute()) {
            echo "Comment deleted successfully!";
        } else {
            echo "Error deleting comment: " . mysqli_error($conn);
        }
        $stmt->close();
    } else {
        die('Error: ' . mysqli_error($conn));  // Error handling
    }
}
?>

<!-- Example Delete Form -->
<form method="POST">
    <input type="hidden" name="comment_id" value="1">  <!-- This should be dynamic -->
    <input type="submit" name="delete" value="Delete Comment">
</form>
