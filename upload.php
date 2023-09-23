<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Handle file upload
if ($_FILES['file']['error'] === UPLOAD_ERR_OK) {
    $user_id = $_SESSION['user_id'];
    $filename = $_FILES['file']['name'];
    $temp_filepath = $_FILES['file']['tmp_name'];

    // Define your upload directory
    $upload_directory = 'uploads/';
    $filepath = $upload_directory . $filename;

    if (move_uploaded_file($temp_filepath, $filepath)) {
        // Store metadata in the database
        $conn = new mysqli('localhost', 'username', 'password', 'your_database');
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $sql = "INSERT INTO documents (user_id, filename, filepath) VALUES ('$user_id', '$filename', '$filepath')";
        if ($conn->query($sql) === TRUE) {
            header("Location: dashboard.php");
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

        $conn->close();
    } else {
        echo "Error uploading the file.";
    }
} else {
    echo "Error: " . $_FILES['file']['error'];
}
?>
