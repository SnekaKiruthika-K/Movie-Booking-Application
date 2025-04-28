<?php
// Database credentials
$host = "localhost";
$username = "root"; // Default username for phpMyAdmin
$password = ""; // Default password for phpMyAdmin (empty by default in XAMPP)
$dbname = "booking_movie";

// Create connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch movies from the `movies` table
$sql = "SELECT * FROM movies";
$result = $conn->query($sql);

// Check if the table has records
if ($result->num_rows > 0) {
    echo "<h1>Available Movies</h1>";
    echo "<ul>";
    while ($row = $result->fetch_assoc()) {
        echo "<li>";
        echo "Movie ID: " . $row['id'] . "<br>";
        echo "Movie Name: " . $row['name'] . "<br>";
        echo "Release Date: " . $row['release_date'] . "<br>";
        echo "Category: " . $row['category'] . "<br>";
        echo "</li><hr>";
    }
    echo "</ul>";
} else {
    echo "No movies found in the database.";
}

// Close connection
$conn->close();
?>
