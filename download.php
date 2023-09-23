<?php
// Handle document download logic
if (isset($_GET['document_id'])) {
    $document_id = $_GET['document_id'];

    // Connect to your database (replace with your database connection logic)
    $conn = new mysqli('localhost', 'username', 'password', 'your_database');
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Fetch the document filename and path from the database based on $document_id
    $sql = "SELECT filename, filepath FROM documents WHERE id = $document_id";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $document_filename = $row['filename'];
        $document_path = $row['filepath'];

        // Check if the file exists
        if (file_exists($document_path)) {
            // Set appropriate headers for file download
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="' . $document_filename . '"');
            header('Content-Length: ' . filesize($document_path));

            // Output the file content
            readfile($document_path);
        } else {
            echo "File not found.";
        }
    } else {
        echo "Document not found.";
    }

    // Close the database connection
    $conn->close();
} else {
    echo "Invalid request.";
}
?>
