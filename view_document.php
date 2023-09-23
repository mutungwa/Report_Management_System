<?php
session_start();

// Check if the user is logged in (you can use your authentication logic here)
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Replace with your database connection logic
$conn = new mysqli('localhost', 'username', 'password', 'your_database');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve the document information based on document_id (replace with your database query)
if (isset($_GET['document_id'])) {
    $document_id = $_GET['document_id'];
    $sql = "SELECT filename, filepath FROM documents WHERE id = $document_id";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $document_filename = $row['filename'];
        $document_path = $row['filepath'];
    } else {
        // Document not found
        header("Location: dashboard.php");
        exit;
    }
} else {
    // Invalid request
    header("Location: dashboard.php");
    exit;
}

// Handle adding comments
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['comment'])) {
    $comment = $_POST['comment'];
    $user_id = $_SESSION['user_id'];

    // Insert the comment into the database (replace with your database query)
    $sql = "INSERT INTO comments (document_id, user_id, comment) VALUES ('$document_id', '$user_id', '$comment')";
    if ($conn->query($sql) !== TRUE) {
        echo "Error adding comment: " . $conn->error;
    }
}

// Fetch comments for the document (replace with your database query)
$sql = "SELECT users.username, comments.comment FROM comments
        JOIN users ON comments.user_id = users.id
        WHERE comments.document_id = '$document_id'";
$comments_result = $conn->query($sql);

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Document</title>
    <!-- Add your CSS styles here -->
    <style>
        /* Your custom CSS styles here */
    </style>
</head>
<body>
    <!-- Navigation Bar (similar to your other pages) -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <a class="navbar-brand" href="#">Document Management System</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="dashboard.php">Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="logout.php">Logout</a>
                </li>
            </ul>
        </div>
    </nav>

    <!-- Document Viewer Section -->
    <div class="container mt-5">
        <h2>View Document: <?php echo $document_filename; ?></h2>
        <div class="embed-responsive embed-responsive-16by9">
            <!-- Display the document based on its type (PDF, Word, etc.) -->
            <iframe class="embed-responsive-item" src="<?php echo $document_path; ?>"></iframe>
        </div>

        <!-- Add Comment Section -->
        <h3>Add Comment</h3>
        <form action="view_document.php?document_id=<?php echo $document_id; ?>" method="post">
            <div class="form-group">
                <textarea name="comment" class="form-control" rows="3" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Submit Comment</button>
        </form>

        <!-- Display Comments -->
        <h3>Comments</h3>
        <ul class="list-group">
            <?php
            if ($comments_result->num_rows > 0) {
                while ($comment_row = $comments_result->fetch_assoc()) {
                    $username = $comment_row['username'];
                    $comment_text = $comment_row['comment'];

                    echo '<li class="list-group-item">';
                    echo '<strong>' . $username . ':</strong> ' . $comment_text;
                    echo '</li>';
                }
            } else {
                echo '<li class="list-group-item">No comments yet.</li>';
            }
            ?>
        </ul>

        <!-- Email Document Section -->
        <h3>Email Document</h3>
        <form action="email_document.php" method="post">
            <input type="hidden" name="document_id" value="<?php echo $document_id; ?>">
            <div class="form-group">
                <label for="recipient_email">Recipient Email:</label>
                <input type="email" name="recipient_email" id="recipient_email" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-success">Send Email</button>
        </form>
    </div>

    <!-- Include your JavaScript and Bootstrap scripts here -->
    <!-- Add your JavaScript code here if needed -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
