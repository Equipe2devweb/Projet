<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the form data
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Connect to the MySQL database
    $servername = "localhost";
    $dbUsername = "your_username";
    $dbPassword = "your_password";
    $dbName = "your_database_name";

    $conn = new mysqli($servername, $dbUsername, $dbPassword, $dbName);

    // Check the connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Create a SQL query to fetch the user from the database
    $sql = "SELECT * FROM users WHERE username = '$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // User found, verify password
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            // Password is correct, start the session and redirect to the main menu
            $_SESSION['username'] = $username;
            header("Location: main_menu.php");
            exit();
        } else {
            // Password is incorrect
            $errorMessage = "Désolé, le nom d'utilisateur ou le mot de passe est incorrect!";
        }
    } else {
        // User not found
        $errorMessage = "Désolé, le nom d'utilisateur ou le mot de passe est incorrect!";
    }

    // Close the database connection
    $conn->close();
}
?>