<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

if (isset($_GET['query'])) {
    // Get the search query from the form
    $searchQuery = $_GET['query'];

    // Replace with your database connection logic
    $conn = new mysqli('localhost', 'your_username', 'your_password', 'your_database');
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Retrieve documents matching the search query
    $user_id = $_SESSION['user_id'];
    $sql = "SELECT id, filename FROM documents WHERE user_id = '$user_id' AND filename LIKE '%$searchQuery%'";
    $result = $conn->query($sql);

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document Search Results</title>
    <!-- Add Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <!-- Navigation Bar (Similar to dashboard.php) -->

    <!-- Search Results Section -->
    <div class="container mt-5">
        <h2>Search Results</h2>
        <ul class="list-group">
            <?php
            if (isset($result) && $result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $document_id = $row['id'];
                    $document_filename = $row['filename'];

                    echo '<li class="list-group-item">';
                    echo '<span>' . $document_filename . '</span>';
                    echo '<a href="download.php?document_id=' . $document_id . '" class="btn btn-success btn-sm float-right">Download</a>';
                    echo '<a href="delete.php?document_id=' . $document_id . '" class="btn btn-danger btn-sm float-right ml-2">Delete</a>';
                    echo '</li>';
                }
            } else {
                echo '<li class="list-group-item">No documents found.</li>';
            }
            ?>
        </ul>
    </div>

    <!-- Bootstrap JS (Popper.js and jQuery) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
