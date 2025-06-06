<?php
// Database credentials
$host = "localhost"; // Server name
$username = "root"; // Default username for phpMyAdmin
$password = ""; // Default password (empty for XAMPP)
$dbname = "booking_movie"; // Database name

// Create a connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $user_name = isset($_POST['name']) ? $conn->real_escape_string($_POST['name']) : '';
    $user_email = isset($_POST['email']) ? $conn->real_escape_string($_POST['email']) : '';
    $user_password = isset($_POST['password']) ? $conn->real_escape_string($_POST['password']) : '';
    $user_gender = isset($_POST['gender']) ? $conn->real_escape_string($_POST['gender']) : '';
    $user_location = isset($_POST['location']) ? $conn->real_escape_string($_POST['location']) : '';

    // Hash the password for security
    $hashed_password = password_hash($user_password, PASSWORD_DEFAULT);

    // Ensure your column names match the actual table structure
    // Replace `username`, `email`, `password`, `gender`, `location` with the correct column names in your `form` table
    $sql = "INSERT INTO form (username, email, password, gender, location) 
            VALUES ('$user_name', '$user_email', '$hashed_password', '$user_gender', '$user_location')";

    // Execute the query
    if ($conn->query($sql) === TRUE) {
        echo "Registration successful! <a href='home.html'>Login here</a>";
    } else {
        // Display a detailed error message
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
} else {
    echo "Invalid request method.";
}

// Close the connection
$conn->close();
?>
