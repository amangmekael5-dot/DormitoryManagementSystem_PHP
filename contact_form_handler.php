<?php
// Start the session
session_start();

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and validate inputs
    $name = htmlspecialchars(trim($_POST["name"]));
    $email = filter_var(trim($_POST["email"]), FILTER_VALIDATE_EMAIL);
    $message = htmlspecialchars(trim($_POST["message"]));

    if ($name && $email && $message) {
        // You can add email or database logic here.
        // For now, we'll just confirm the data received.
        echo "<h2>Thank you, $name!</h2>";
        echo "<p>Your message has been received:</p>";
        echo "<p><strong>Email:</strong> $email</p>";
        echo "<p><strong>Message:</strong> $message</p>";
    } else {
        echo "<h2>Error</h2>";
        echo "<p>Please fill in all required fields correctly.</p>";
    }
} else {
    // Redirect if accessed directly
    header("Location: contact.php");
    exit();
}
?>
