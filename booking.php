<?php
// Database connection
$host = 'localhost';
$username = 'root';
$password = '';
$dbname = 'booking_movie';

$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}

// Check if form data is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve and sanitize input data
    $movie_name = $conn->real_escape_string($_POST['movie_name']);
    $selected_seats = $conn->real_escape_string($_POST['selected_seats']);
    $number_of_tickets = (int)$_POST['tickets'];
    $refreshments = isset($_POST['refreshments']) ? $_POST['refreshments'] : 'None';
    $total_amount = $conn->real_escape_string($_POST['total_amount']);

    // Validation
    if (empty($selected_seats) || $number_of_tickets <= 0) {
        echo 'Error: Please select at least one seat and ensure the ticket count is valid.';
    } else {
        // Insert into the database
        $stmt = $conn->prepare("INSERT INTO movies (movie_name, seats, numberoftickets, refreshments, total_amount) 
                                VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("ssiss", $movie_name, $selected_seats, $number_of_tickets, $refreshments, $total_amount);

        if ($stmt->execute()) {
            // Booking successful, now save details to a text file

            // Prepare the ticket details as a string
            $ticketDetails = "
                Movie: $movie_name
                Selected Seats: $selected_seats
                Number of Tickets: $number_of_tickets
                Refreshments: $refreshments
                Total Amount: $total_amount
                -------------------------------------
            ";

            // Define the path to the text file
            $filePath = 'booking_details.txt';

            // Write the ticket details to the text file
            file_put_contents($filePath, $ticketDetails, FILE_APPEND);
            
            echo 'Booking confirmed!';
        } else {
            echo 'Error: ' . $stmt->error;
        }

        $stmt->close();
    }
}

$conn->close();
?>
