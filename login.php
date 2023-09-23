<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Replace with your database connection logic
    $conn = new mysqli('localhost', 'username', 'password', 'your_database');
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $email = $_POST['email'];
    $password = $_POST['password'];

    // Replace with your actual database query for user authentication
    $sql = "SELECT id, name FROM users WHERE email = '$email' AND password = '$password'";
    $result = $conn->query($sql);

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        $_SESSION['user_id'] = $row['id'];
        $_SESSION['user_name'] = $row['name'];
        header("Location: dashboard.html");
    } else {
        // Login failed
        header("Location: login.php");
    }

    $conn->close();
}
?>
