<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Replace with your database connection logic
    $conn = new mysqli('localhost', 'username', 'password', 'your_database');
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Replace with your actual database query to insert a new user
    $sql = "INSERT INTO users (name, email, password) VALUES ('$name', '$email', '$password')";
    if ($conn->query($sql) === TRUE) {
        $_SESSION['user_id'] = $conn->insert_id;
        $_SESSION['user_name'] = $name;
        header("Location: login.html");
    } else {
        // Signup failed
        header("Location: signup.html");
    }

    $conn->close();
}
?>
