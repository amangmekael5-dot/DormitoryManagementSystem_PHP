<?php
include("connection.php");  // Make sure this is included

// Assuming you're using a POST request to update a record
if (isset($_POST['update'])) {
    // Get the comment ID and updated message
    $comment_id = $_POST['comment_id'];
    $updated_message = $_POST['updated_message'];

    // Prepare the SQL query
    $sql = "UPDATE comment SET message = ? WHERE comment_id = ?";

    // Prepare the statement
    if ($stmt = $conn->prepare($sql)) {
        // Bind parameters (message as string and comment_id as integer)
        $stmt->bind_param("si", $updated_message, $comment_id);

        // Execute the query
        if ($stmt->execute()) {
            echo "Comment updated successfully!";
        } else {
            echo "Error updating comment: " . $conn->error;
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


<form method="POST">
    <input type="hidden" name="comment_id" value="1">  <!-- This should be dynamic -->
    <textarea name="updated_message" placeholder="Update your message"></textarea>
    <input type="submit" name="update" value="Update Comment">
</form>
